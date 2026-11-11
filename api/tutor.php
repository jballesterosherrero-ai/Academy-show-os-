<?php
declare(strict_types=1);

ini_set('display_errors', '0');
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, max-age=0');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');

function showos_json(int $status, array $payload): never {
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
function showos_cut(string $value, int $limit): string {
    return function_exists('mb_substr') ? mb_substr($value, 0, $limit, 'UTF-8') : substr($value, 0, $limit);
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST');
    showos_json(405, ['error' => 'Método no permitido. Utiliza POST.']);
}

// Bloquea llamadas de navegador desde otros dominios.
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$host = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
if ($origin !== '') {
    $originHost = strtolower((string)(parse_url($origin, PHP_URL_HOST) ?: ''));
    $requestHost = strtolower((string)(preg_replace('/:\d+$/', '', $host) ?? $host));
    if ($originHost === '' || !hash_equals($requestHost, $originHost)) {
        showos_json(403, ['error' => 'Origen no permitido.']);
    }
}

// El fichero api/config.php se crea solo en IONOS. Nunca se versiona en GitHub.
$privateConfig = [];
$configPath = __DIR__ . '/config.php';
if (is_file($configPath)) {
    $loaded = require $configPath;
    if (is_array($loaded)) $privateConfig = $loaded;
}
$apiKey = (string)($_SERVER['OPENAI_API_KEY'] ?? '');
if ($apiKey === '') $apiKey = (string)(getenv('OPENAI_API_KEY') ?: '');
if ($apiKey === '') $apiKey = (string)($privateConfig['OPENAI_API_KEY'] ?? '');
$model = (string)($_SERVER['OPENAI_MODEL'] ?? '');
if ($model === '') $model = (string)(getenv('OPENAI_MODEL') ?: '');
if ($model === '') $model = (string)($privateConfig['OPENAI_MODEL'] ?? 'gpt-6.1-sol');

if ($apiKey === '' || str_contains($apiKey, 'PEGA_AQUI')) {
    showos_json(503, ['error' => 'Falta configurar la clave OPENAI_API_KEY en /api/config.php en IONOS.']);
}
if (!function_exists('curl_init')) {
    showos_json(503, ['error' => 'La extensión PHP cURL no está disponible en este hosting. Contacta con IONOS.']);
}

$raw = file_get_contents('php://input');
if ($raw === false || strlen($raw) > 30000) {
    showos_json(413, ['error' => 'La solicitud supera el tamaño permitido.']);
}
$body = json_decode($raw, true);
if (!is_array($body)) showos_json(400, ['error' => 'Solicitud JSON no válida.']);

$level = max(1, min(5, (int)($body['level'] ?? 1)));
$message = trim((string)($body['message'] ?? ''));
if (strlen($message) < 15) showos_json(400, ['error' => 'Explica con más detalle tu actuación (mínimo 15 caracteres).']);
$message = showos_cut($message, 12000);
$caseTitle = showos_cut((string)($body['caseTitle'] ?? ''), 200);
$scenario = showos_cut((string)($body['scenario'] ?? ''), 5000);
$history = [];
if (isset($body['history']) && is_array($body['history'])) {
    foreach (array_slice($body['history'], -10) as $item) {
        if (!is_array($item)) continue;
        $role = (($item['role'] ?? '') === 'assistant') ? 'assistant' : 'user';
        $content = showos_cut((string)($item['content'] ?? ''), 4000);
        if ($content !== '') $history[] = ['role' => $role, 'content' => $content];
    }
}

// Límite básico para la beta pública: 30 solicitudes/10 minutos y 100/hora por IP.
$ip = (string)($_SERVER['REMOTE_ADDR'] ?? 'unknown');
$rateFile = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'showos-rate-' . hash('sha256', $ip) . '.json';
$handle = @fopen($rateFile, 'c+');
if ($handle === false || !flock($handle, LOCK_EX)) {
    if (is_resource($handle)) fclose($handle);
    showos_json(503, ['error' => 'No se pudo inicializar el control de uso del tutor.']);
}
$now = time();
$times = json_decode(stream_get_contents($handle) ?: '[]', true);
if (!is_array($times)) $times = [];
$times = array_values(array_filter($times, static fn($t) => is_numeric($t) && (int)$t > $now - 3600));
$recent = count(array_filter($times, static fn($t) => (int)$t > $now - 600));
if ($recent >= 30 || count($times) >= 100) {
    flock($handle, LOCK_UN); fclose($handle);
    header('Retry-After: 600');
    showos_json(429, ['error' => 'Límite temporal de consultas alcanzado. Espera unos minutos.']);
}
$times[] = $now;
rewind($handle); ftruncate($handle, 0); fwrite($handle, json_encode($times)); fflush($handle);
flock($handle, LOCK_UN); fclose($handle);

$instructions = <<<'PROMPT'
Eres el Jefe Técnico de Giras y Festivales de SHOW OS By Muelle, con 20 años de experiencia operativa. Hablas español de España. Eres exigente, directo, práctico y didáctico.
Evalúas a un técnico de vídeo y pantallas LED en escenarios reales.
REGLAS:
- Evalúa solo lo demostrado; no supongas conocimientos no expresados.
- La seguridad es excluyente. Si propone trabajar en circuitos energizados sin procedimiento, puentear protecciones, abrir equipos con tensión, mirar el haz de fibra óptica activa, superar límites del fabricante o ejecutar una maniobra crítica sin autorización y plan de reversión, safety_pass=false y approved=false.
- No inventes pinouts, tensiones, potencias, límites térmicos, refresh rate, clock, EDID, compatibilidades ni procedimientos propietarios. Pide modelo, firmware, manual/datasheet y condiciones cuando falten.
- Distingue hipótesis de hechos. Exige aislar variables, comprobar señal, alimentación y ruta, validar y documentar.
- En directo prioriza continuidad, cambios no disruptivos, comunicación con realización y rollback. Nunca recomiendes cambiar parámetros críticos a ciegas.
- En cálculos eléctricos/ópticos declara supuestos y datos que faltan. No certifiques un diseño sin fichas técnicas y revisión competente.
- Conversación socrática: si faltan evidencias, formula 1-3 preguntas y no apruebes todavía.
- Para aprobar exige score >=80, safety_pass=true y evidencia suficiente en los cuatro criterios.
- No afirmes que esto es una titulación oficial ni sustituye una evaluación presencial.
PONDERACIÓN: safety 0-30; diagnosis 0-25; procedure 0-25; validation 0-20. feedback incluye análisis, fallos y preguntas. next_step indica la acción concreta.
PROMPT;

$schema = [
    'type' => 'object', 'additionalProperties' => false,
    'properties' => [
        'feedback' => ['type' => 'string'],
        'score' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 100],
        'safety_pass' => ['type' => 'boolean'],
        'approved' => ['type' => 'boolean'],
        'criteria' => [
            'type' => 'object', 'additionalProperties' => false,
            'properties' => [
                'safety' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 30],
                'diagnosis' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 25],
                'procedure' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 25],
                'validation' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 20],
            ],
            'required' => ['safety', 'diagnosis', 'procedure', 'validation'],
        ],
        'next_step' => ['type' => 'string'],
    ],
    'required' => ['feedback', 'score', 'safety_pass', 'approved', 'criteria', 'next_step'],
];

$input = array_merge(
    [[
        'role' => 'user',
        'content' => "NIVEL {$level}: {$caseTitle}\nESCENARIO: {$scenario}\nEvalúa la última intervención dentro de la conversación. Si falta evidencia, no apruebes: pregunta.",
    ]],
    $history,
    [['role' => 'user', 'content' => $message]]
);
$requestData = [
    'model' => $model,
    'instructions' => $instructions,
    'input' => $input,
    'text' => ['format' => [
        'type' => 'json_schema', 'name' => 'showos_assessment', 'strict' => true, 'schema' => $schema,
    ]],
    'max_output_tokens' => 1200,
    'store' => false,
];

$ch = curl_init('https://api.openai.com/v1/responses');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey, 'Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode($requestData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_FOLLOWLOCATION => false,
]);
$response = curl_exec($ch);
$error = curl_error($ch);
$http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false) {
    error_log('SHOW OS tutor cURL error: ' . $error);
    showos_json(502, ['error' => 'No se pudo contactar con OpenAI. Comprueba la conexión del servidor.']);
}
$decoded = json_decode($response, true);
if ($http < 200 || $http >= 300) {
    $detail = is_array($decoded) ? (string)($decoded['error']['message'] ?? '') : '';
    error_log('SHOW OS OpenAI API HTTP ' . $http . ': ' . $detail);
    showos_json(502, ['error' => 'OpenAI no pudo completar la evaluación. Revisa el saldo y el modelo habilitado en tu proyecto.']);
}
$output = null;
foreach (($decoded['output'] ?? []) as $item) {
    foreach (($item['content'] ?? []) as $part) {
        if (($part['type'] ?? '') === 'output_text' && isset($part['text'])) {
            $output = $part['text'];
            break 2;
        }
    }
}
$evaluation = is_string($output) ? json_decode($output, true) : null;
if (!is_array($evaluation)) showos_json(502, ['error' => 'El tutor no devolvió una evaluación estructurada.']);
$evaluation['approved'] = (bool)($evaluation['approved'] ?? false)
    && (bool)($evaluation['safety_pass'] ?? false)
    && (int)($evaluation['score'] ?? 0) >= 80;
showos_json(200, ['evaluation' => $evaluation]);
