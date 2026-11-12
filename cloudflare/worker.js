const rateBuckets = new Map();

const SYSTEM_PROMPT = `Eres el Jefe Técnico de Giras y Festivales de SHOW OS By Muelle, con 20 años de experiencia operativa. Hablas español de España. Eres exigente, directo, práctico y didáctico.
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
PONDERACIÓN: safety 0-30; diagnosis 0-25; procedure 0-25; validation 0-20. feedback incluye análisis, fallos y preguntas. next_step indica la acción concreta.`;

const schema = {
  type: "object",
  additionalProperties: false,
  properties: {
    feedback: { type: "string" },
    score: { type: "integer", minimum: 0, maximum: 100 },
    safety_pass: { type: "boolean" },
    approved: { type: "boolean" },
    criteria: {
      type: "object",
      additionalProperties: false,
      properties: {
        safety: { type: "integer", minimum: 0, maximum: 30 },
        diagnosis: { type: "integer", minimum: 0, maximum: 25 },
        procedure: { type: "integer", minimum: 0, maximum: 25 },
        validation: { type: "integer", minimum: 0, maximum: 20 }
      },
      required: ["safety", "diagnosis", "procedure", "validation"]
    },
    next_step: { type: "string" }
  },
  required: ["feedback", "score", "safety_pass", "approved", "criteria", "next_step"]
};

function json(data, status = 200, headers = {}) {
  return new Response(JSON.stringify(data), {
    status,
    headers: { "Content-Type": "application/json; charset=utf-8", "Cache-Control": "no-store", "X-Content-Type-Options": "nosniff", ...headers }
  });
}

function corsHeaders(origin, env) {
  const allowed = (env.ALLOWED_ORIGIN || "").trim();
  const allowOrigin = allowed ? (origin === allowed ? allowed : "") : "*";
  return {
    "Access-Control-Allow-Origin": allowOrigin,
    "Access-Control-Allow-Methods": "POST, OPTIONS",
    "Access-Control-Allow-Headers": "Content-Type, X-SHOWOS-BETA-CODE",
    "Access-Control-Max-Age": "86400",
    "Vary": "Origin"
  };
}

function allowByRateLimit(ip) {
  const now = Date.now();
  const windowMs = 10 * 60 * 1000;
  const maxRequests = 12;
  const previous = (rateBuckets.get(ip) || []).filter(t => now - t < windowMs);
  if (previous.length >= maxRequests) return false;
  previous.push(now);
  rateBuckets.set(ip, previous);
  if (rateBuckets.size > 2000) {
    for (const [key, times] of rateBuckets) {
      if (!times.length || now - times[times.length - 1] > windowMs) rateBuckets.delete(key);
    }
  }
  return true;
}

export default {
  async fetch(request, env) {
    const origin = request.headers.get("Origin") || "";
    const cors = corsHeaders(origin, env);
    if (env.ALLOWED_ORIGIN && origin !== env.ALLOWED_ORIGIN) return json({ error: "Origen no autorizado." }, 403, cors);
    const url = new URL(request.url);
    if (request.method === "GET" && (url.pathname === "/" || url.pathname === "/api/tutor")) {
      return json({ service: "SHOW OS CAMPUS Tutor IA", status: "online", endpoint: "/api/tutor", method: "POST" }, 200, cors);
    }
    if (request.method === "OPTIONS") return new Response(null, { status: 204, headers: cors });
    if (url.pathname !== "/api/tutor") return json({ error: "Ruta no encontrada." }, 404, cors);
    if (request.method !== "POST") return json({ error: "Método no permitido. Utiliza POST." }, 405, { ...cors, Allow: "POST, OPTIONS" });

    const betaCode = env.SHOWOS_BETA_CODE || "";
    if (!betaCode || request.headers.get("X-SHOWOS-BETA-CODE") !== betaCode) {
      return json({ error: "Código de acceso beta incorrecto o no configurado." }, 401, cors);
    }
    if (!env.OPENAI_API_KEY) return json({ error: "Falta configurar OPENAI_API_KEY como secreto del Worker." }, 503, cors);

    const ip = request.headers.get("CF-Connecting-IP") || "unknown";
    if (!allowByRateLimit(ip)) return json({ error: "Demasiadas consultas seguidas. Espera diez minutos." }, 429, { ...cors, "Retry-After": "600" });

    const contentLength = Number(request.headers.get("Content-Length") || 0);
    if (contentLength > 30000) return json({ error: "La solicitud supera el tamaño permitido." }, 413, cors);

    let body;
    try { body = await request.json(); }
    catch { return json({ error: "Solicitud JSON no válida." }, 400, cors); }

    const level = Math.max(1, Math.min(5, Number.parseInt(body.level, 10) || 1));
    const message = String(body.message || "").trim().slice(0, 12000);
    if (message.length < 15) return json({ error: "Explica con más detalle tu actuación (mínimo 15 caracteres)." }, 400, cors);
    const caseTitle = String(body.caseTitle || "").slice(0, 200);
    const scenario = String(body.scenario || "").slice(0, 5000);
    const history = Array.isArray(body.history) ? body.history.slice(-10).map(item => ({
      role: item && item.role === "assistant" ? "assistant" : "user",
      content: String(item && item.content || "").slice(0, 4000)
    })).filter(item => item.content) : [];

    const input = [
      { role: "user", content: `NIVEL ${level}: ${caseTitle}\nESCENARIO: ${scenario}\nEvalúa la última intervención dentro de la conversación. Si falta evidencia, no apruebes: pregunta.` },
      ...history,
      { role: "user", content: message }
    ];

    let upstream;
    try {
      upstream = await fetch("https://api.openai.com/v1/responses", {
        method: "POST",
        headers: { "Authorization": `Bearer ${env.OPENAI_API_KEY}`, "Content-Type": "application/json" },
        body: JSON.stringify({
          model: env.OPENAI_MODEL || "gpt-6.1-sol",
          instructions: SYSTEM_PROMPT,
          input,
          text: { format: { type: "json_schema", name: "showos_assessment", strict: true, schema } },
          max_output_tokens: 1200,
          store: false
        })
      });
    } catch {
      return json({ error: "No se pudo contactar con OpenAI desde el servicio del tutor." }, 502, cors);
    }

    const data = await upstream.json().catch(() => null);
    if (!upstream.ok) {
      const detail = data?.error?.message || "Error de OpenAI";
      console.error("OpenAI API error", upstream.status, detail.slice(0, 300));
      return json({ error: "OpenAI no pudo completar la evaluación. Comprueba saldo y modelo habilitado en tu proyecto." }, 502, cors);
    }

    const outputText = (data?.output || []).flatMap(item => item.content || []).find(part => part.type === "output_text")?.text;
    let evaluation;
    try { evaluation = JSON.parse(outputText || ""); }
    catch { return json({ error: "El tutor no devolvió una evaluación estructurada." }, 502, cors); }

    evaluation.approved = Boolean(evaluation.approved) && Boolean(evaluation.safety_pass) && Number(evaluation.score) >= 80;
    return json({ evaluation }, 200, cors);
  }
};
