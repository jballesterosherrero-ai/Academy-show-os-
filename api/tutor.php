<?php
declare(strict_types=1);

/*
 * SHOW OS CAMPUS — Tutor IA
 * PHP 8.1+; usa cURL si está disponible o HTTPS nativo (allow_url_fopen) como alternativa.
 * La clave API se lee exclusivamente de /api/config.php o de una variable de entorno.
 */
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
function showos_level_guide(int $level): string {
    $guides = [
        1 => <<<'GUIDE'
NIVEL 1 — DIAGNÓSTICO BÁSICO Y SEGURIDAD LED.
Exige: delimitar el alcance del fallo; inspección visual/indicadores sin manipulación peligrosa; separar hipótesis de alimentación y datos; aislamiento y verificación de ausencia de tensión antes de pruebas de continuidad/resistencia; medición en tensión solo por personal habilitado con procedimiento; comprobación por segmentos; sustitución por referencia compatible; prueba con patrón y registro.
FALLOS CRÍTICOS: medir resistencia/continuidad con el circuito energizado; abrir fuentes/cuadros energizados sin habilitación; puentear protecciones; inventar tensiones esperadas.
GUIDE,
        2 => <<<'GUIDE'
NIVEL 2 — NOVASTAR H9 / NOVALCT / .RCFGX.
Exige: identificar chasis H9 y tarjetas instaladas; identificar módulo LED, driver IC, scan, receiving card y firmware exactos; comprobar procedencia/compatibilidad .rcfgx; conservar configuración previa; inspeccionar topología, cableado y mapping; ensayar en banco/zona limitada; parámetros refresh/clock solo con especificación verificable; rollback, patrón y registro.
No aceptes como diagnóstico automático que unas líneas diagonales verdes significan refresh o clock incorrectos. Puede haber incompatibilidad de fichero, scan, mapeo, cadena o hardware. El alumno debe comprobar antes de concluir.
FALLOS CRÍTICOS: enviar configuración no verificada a toda la pantalla; cambiar refresh/clock/scan por tanteo en show; no disponer de copia o reversión.
GUIDE,
        3 => <<<'GUIDE'
NIVEL 3 — AQUILON C+ / CADENCIA Y CONTINUIDAD.
Exige diferenciar fps del contenido, frecuencia de salida de GPU y timing de entrada/salida del procesador; determinar si el tirón existe en el portátil, en Preview/Multiviewer o solo en LED; considerar judder de conversión 24p a 50/59.94/60, capacidad de decodificación del portátil, EDID y formato realmente negociado; mantener salida de programa estable; probar cambios fuera de programa; recurrir a fuente/clip de backup probado cuando la solución en directo no sea segura.
Aquilon C+ dispone de gestión EDID y formatos de salida independientes, pero no supongas que cualquier configuración elimina todo judder. La funcionalidad concreta depende de tarjetas, firmware y configuración.
FALLOS CRÍTICOS: cambiar EDID global o output activo a ciegas durante la ponencia; asegurar que el procesador corrige cualquier cadencia sin comprobar origen y modo.
GUIDE,
        4 => <<<'GUIDE'
NIVEL 4 — WATCHOUT / WATCHPAX / REDUNDANCIA ÓPTICA.
Exige distinguir fallo de nodo/servicios/GPU/almacenamiento, red, sincronía, conversor, SFP, fibra y receptor; identificar versión de WATCHOUT y modelo exacto de WATCHPAX/CVT4K; diferenciar temperatura ambiente de interna y consultar ficha de la variante; comprobar indicadores/contadores, ruta, limpieza y presupuesto óptico con instrumentos compatibles; confirmar que Main y Backup son independientes extremo a extremo, están sincronizados y contienen el mismo show/media/mapping; conmutar solo con procedimiento ensayado, autorización, monitorización y plan de retorno.
Dato de referencia acotado: la ficha oficial CVT4K-M V1.0.0 indica temperatura de operación de −20 a +60 °C. Este dato no se puede extrapolar a otras variantes ni prueba que el conjunto funcione correctamente a 41 °C. WATCHOUT requiere revisar nodos, servicios, versiones, sincronía y red.
FALLOS CRÍTICOS: afirmar que 41 °C demuestra sobretemperatura sin identificar modelo/sensor; desconectar fibra activa o retirar ópticas sin comprobar la política del fabricante; prometer conmutación imperceptible sin arquitectura y ensayo.
GUIDE,
        5 => <<<'GUIDE'
NIVEL 5 — DISEÑO INTEGRAL DE FESTIVAL.
Datos confirmados: central 14×5 m = 70 m²; laterales 2×(4×6 m) = 48 m²; área total = 118 m². Exige: declarar pitch y dimensiones reales de cabinet antes de calcular resolución/píxeles; listar consumos típicos/máximos, tensión, factor de potencia, corriente, arranque, límites por línea y fichas de cada equipo; calcular potencia/corriente con unidades y explicar equilibrio de fases, caída de tensión, protecciones y factores de instalación para revisión por electricista competente; presupuesto óptico usando Tx mínima, sensibilidad Rx, atenuación, conectores, empalmes y margen; diagrama de señal Main/Backup que identifique puntos únicos de fallo; patch, red/IP, sincronía, pruebas, rollback, recursos y aceptación.
FALLOS CRÍTICOS: inventar potencia, sección de cable, magnetotérmico/diferencial o presupuesto óptico sin datos de placa; llamar redundancia pura a dos rutas que comparten una dependencia crítica; presentar el cálculo como autorización de instalación eléctrica.
GUIDE
    ];
    return $guides[$level] ?? $guides[1];
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Allow: POST');
    showos_json(405, ['error' => 'Método no permitido. Utiliza POST.']);
}

// Solo acepta llamadas desde el mismo host web. No sustituye autenticación ni control de abuso.
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$host = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
if ($origin !== '') {
    $originHost = strtolower((string)(parse_url($origin, PHP_URL_HOST) ?: ''));
    $requestHost = strtolower((string)(preg_replace('/:\d+$/', '', $host) ?? $host));
    if ($originHost === '' || !hash_equals($requestHost, $originHost)) {
        showos_json(403, ['error' => 'Origen no permitido.']);
    }
}

// La clave se configura solo en IONOS. config.php está excluido de Git y bloqueado por .htaccess.
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
    showos_json(503, ['error' => 'Falta configurar la clave API en /api/config.php dentro de IONOS.']);
}

$hasCurl = function_exists('curl_init');
$allowUrlFopen = filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOLEAN);
if (!$hasCurl && !$allowUrlFopen) {
    showos_json(503, ['error' => 'Este hosting no tiene cURL ni HTTPS nativo (allow_url_fopen). Solicita a IONOS que habilite una de las dos opciones.']);
}

$raw = file_get_contents('php://input');
if ($raw === false || strlen($raw) > 20000) {
    showos_json(413, ['error' => 'La solicitud supera el tamaño permitido.']);
}
$body = json_decode($raw, true);
if (!is_array($body)) showos_json(400, ['error' => 'Solicitud JSON no válida.']);

$level = max(1, min(5, (int)($body['level'] ?? 1)));
$mode = (($body['mode'] ?? 'coach') === 'assess') ? 'assess' : 'coach';
$message = trim((string)($body['message'] ?? ''));
if (strlen($message) < 30) showos_json(400, ['error' => 'Explica con más detalle tu razonamiento (mínimo 30 caracteres).']);
$message = showos_cut($message, 7000);
$caseTitle = showos_cut((string)($body['caseTitle'] ?? ''), 200);
$scenario = showos_cut((string)($body['scenario'] ?? ''), 3000);

$history = [];
if (isset($body['history']) && is_array($body['history'])) {
    foreach (array_slice($body['history'], -8) as $item) {
        if (!is_array($item)) continue;
        $role = (($item['role'] ?? '') === 'assistant') ? 'assistant' : 'user';
        $content = showos_cut((string)($item['content'] ?? ''), 2500);
        if ($content !== '') $history[] = ['role' => $role, 'content' => $content];
    }
}

// Limitación básica de beta pública por IP: 15 peticiones/10 minutos y 40/hora.
// No equivale a autenticación y puede ser evadida distribuyendo peticiones entre IPs.
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
if ($recent >= 15 || count($times) >= 40) {
    flock($handle, LOCK_UN); fclose($handle);
    header('Retry-After: 600');
    showos_json(429, ['error' => 'Límite temporal de consultas alcanzado. Espera unos minutos.']);
}
$times[] = $now;
rewind($handle); ftruncate($handle, 0); fwrite($handle, json_encode($times)); fflush($handle);
flock($handle, LOCK_UN); fclose($handle);

$modeInstructions = $mode === 'coach'
    ? "MODO PRÁCTICA: no puntúes, no declares APTO/NO APTO y no cierres la evaluación. Entrega feedback didáctico, identifica el siguiente hueco de conocimiento y formula entre 1 y 3 preguntas concretas. En la salida estructurada usa score=0, safety_pass=false, approved=false y todos los criterios a 0. No marques progreso."
    : "MODO EVALUACIÓN FORMAL: analiza toda la conversación del caso, no solo la última frase. Puntúa exclusivamente evidencias demostradas según la rúbrica del nivel. Si falta información, seguridad o verificación, no apruebes: explica qué falta y formula preguntas. La seguridad es criterio excluyente. Nunca otorgues un APTO por longitud, vocabulario o seguridad aparente sin procedimiento verificable.";

$instructions = <<<'PROMPT'
Eres el Jefe Técnico de Giras y Festivales de SHOW OS By Muelle, con 20 años de experiencia operativa. Hablas español de España. Eres exigente, directo, preciso y didáctico.
Tu función es formar y evaluar técnicos de vídeo y pantallas LED en situaciones reales de trabajo.
REGLAS GENERALES:
- Evalúa solo lo que el alumno demuestra. No supongas datos, experiencia ni competencias no descritas.
- No inventes pinouts, tensiones, potencias, límites térmicos, refresh rate, clock, EDID, compatibilidades, menús o procedimientos propietarios. Cuando falte un dato, pide el modelo/revisión/firmware y manual/datasheet.
- Distingue hechos, hipótesis y pruebas. El método esperado es observar, aislar variables, comprobar, intervenir con autorización, validar y documentar.
- La seguridad eléctrica es excluyente. Rechaza mediciones en tensión o intervención eléctrica sin formación, habilitación y procedimiento. Continuidad/resistencia solo con circuito aislado y ausencia de tensión verificada.
- Nunca recomiendes puentear protecciones, mirar el extremo de fibra activa, manipular ópticas/fibra activa fuera del procedimiento, abrir fuentes energizadas ni exceder límites del fabricante.
- En directo prioriza la continuidad, comunicación con realización, cambios probados, Preview/Program, fuente de backup y rollback. No cambies parámetros globales a ciegas.
- En diseño eléctrico/óptico muestra fórmulas, unidades, hipótesis y datos faltantes; no autorices instalación ni cálculo definitivo sin revisión de profesional competente.
- No presentes SHOW OS como titulación oficial ni sustituyas prácticas presenciales o evaluación laboral.
- Modo conversación: feedback concreto, sin halagos vacíos. Cuando la respuesta sea incompleta, explica exactamente qué evidencia falta.
PONDERACIÓN OBLIGATORIA EN EVALUACIÓN: seguridad 0-30; diagnóstico 0-25; procedimiento 0-25; validación 0-20. Para APTO exige total >=80, seguridad >=24, diagnóstico >=18, procedimiento >=18 y validación >=14, sin errores críticos. El servidor recalcula la suma. En modo práctica todos los campos numéricos deben ser 0 y approved=false.
PROMPT;

$instructions .= "\n\n" . showos_level_guide($level) . "\n\n" . $modeInstructions;
$schema = [
    'type' => 'object',
    'additionalProperties' => false,
    'properties' => [
        'feedback' => ['type' => 'string'],
        'score' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 100],
        'safety_pass' => ['type' => 'boolean'],
        'approved' => ['type' => 'boolean'],
        'criteria' => [
            'type' => 'object',
            'additionalProperties' => false,
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
        'content' => "NIVEL {$level}: {$caseTitle}\nESCENARIO: {$scenario}\nRÚBRICA ESPECÍFICA: utiliza las competencias y errores críticos del nivel indicados en las instrucciones. Evalúa la conversación que sigue.",
    ]],
    $history,
    [['role' => 'user', 'content' => $message]]
);
$requestData = [
    'model' => $model,
    'instructions' => $instructions,
    'input' => $input,
    'text' => ['format' => [
        'type' => 'json_schema',
        'name' => 'showos_assessment',
        'strict' => true,
        'schema' => $schema,
    ]],
    'max_output_tokens' => 1400,
    'store' => false,
];
$requestJson = json_encode($requestData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($requestJson === false) showos_json(500, ['error' => 'No se pudo preparar la solicitud del tutor.']);

$apiUrl = 'https://api.openai.com/v1/responses';
$response = false;
$http = 0;
$transportError = '';

if ($hasCurl) {
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey, 'Content-Type: application/json'],
        CURLOPT_POSTFIELDS => $requestJson,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ]);
    $response = curl_exec($ch);
    $transportError = curl_error($ch);
    $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
} else {
    // Alternativa para hosting compartido sin extensión cURL: wrapper HTTPS de PHP.
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Authorization: Bearer {$apiKey}\r\nContent-Type: application/json\r\nAccept: application/json\r\n",
            'content' => $requestJson,
            'timeout' => 60,
            'ignore_errors' => true,
            'protocol_version' => 1.1,
        ],
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
            'allow_self_signed' => false,
        ],
    ]);
    $response = @file_get_contents($apiUrl, false, $context);
    $headers = $http_response_header ?? [];
    if (isset($headers[0]) && preg_match('/\s(\d{3})\s/', $headers[0], $matches)) {
        $http = (int)$matches[1];
    }
    if ($response === false) $transportError = 'La conexión HTTPS nativa de PHP no pudo completarse.';
}

if ($response === false) {
    error_log('SHOW OS tutor transport error: ' . $transportError);
    showos_json(502, ['error' => 'No se pudo conectar con OpenAI desde IONOS. Comprueba HTTPS saliente y la extensión cURL o allow_url_fopen.']);
}
$decoded = json_decode((string)$response, true);
if ($http < 200 || $http >= 300) {
    $detail = is_array($decoded) ? (string)($decoded['error']['message'] ?? '') : '';
    error_log('SHOW OS OpenAI API HTTP ' . $http . ': ' . $detail);
    showos_json(502, ['error' => 'OpenAI no pudo completar la solicitud. Revisa el modelo habilitado, permisos de clave y facturación API.']);
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

if ($mode === 'coach') {
    // Modo práctica nunca puede producir un aprobado ni guardar nota.
    $evaluation['score'] = 0;
    $evaluation['safety_pass'] = false;
    $evaluation['approved'] = false;
    $evaluation['criteria'] = ['safety' => 0, 'diagnosis' => 0, 'procedure' => 0, 'validation' => 0];
} else {
    $criteria = $evaluation['criteria'] ?? [];
    $safety = max(0, min(30, (int)($criteria['safety'] ?? 0)));
    $diagnosis = max(0, min(25, (int)($criteria['diagnosis'] ?? 0)));
    $procedure = max(0, min(25, (int)($criteria['procedure'] ?? 0)));
    $validation = max(0, min(20, (int)($criteria['validation'] ?? 0)));
    // La puntuación total la calcula el servidor a partir de la rúbrica ponderada.
    $score = $safety + $diagnosis + $procedure + $validation;
    $safetyPass = ($safety >= 24) && (($evaluation['safety_pass'] ?? false) === true);
    $approved = $safetyPass && $score >= 80
        && $diagnosis >= 18 && $procedure >= 18 && $validation >= 14
        && (($evaluation['approved'] ?? false) === true);
    $evaluation['criteria'] = ['safety' => $safety, 'diagnosis' => $diagnosis, 'procedure' => $procedure, 'validation' => $validation];
    $evaluation['score'] = $score;
    $evaluation['safety_pass'] = $safetyPass;
    $evaluation['approved'] = $approved;
}
showos_json(200, ['evaluation' => $evaluation]);
