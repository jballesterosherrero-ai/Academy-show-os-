# SHOW OS CAMPUS — academia técnica beta

Plataforma web de capacitación para técnicos de vídeo y pantallas LED. El frontend se aloja en IONOS; el tutor IA se ejecuta en Cloudflare Workers y utiliza OpenAI Responses API.

## Estado comprobado del código (13-11-2026)

- Repositorio público: `jballesterosherrero-ai/Academy-show-os-`.
- Frontend `index.html`: JavaScript validado sintácticamente.
- Backend `cloudflare/worker.js`: JavaScript validado sintácticamente.
- Configuración de Worker: `wrangler.jsonc`.
- Catálogo académico premium: 7 cursos, 34 unidades, 102 lecciones marcables y 16 referencias de fabricantes.
- Modelo predeterminado del tutor: `gpt-6.1-sol` (modelo de OpenAI disponible en Responses API; la organización debe tener acceso y facturación habilitada).
- No se ha verificado aún un despliegue activo de Cloudflare ni la configuración de secretos; tampoco se ha comprobado la URL pública del sitio IONOS. No anunciar la beta como operativa hasta completar la prueba extremo a extremo.

## Contenido académico

El catálogo de 7 especializaciones está en el menú **Cursos profesionales** de `index.html`. El programa detallado para dirección académica e instructores está en [ACADEMIA-CURRICULUM-PREMIUM.md](ACADEMIA-CURRICULUM-PREMIUM.md).

Cada curso tiene una carga propuesta de 36 a 64 horas, objetivos, unidades, práctica, evidencias, proyecto final y rúbrica. Los 1.500 € son un precio objetivo de diseño, no una tarifa publicada: para justificarlo es necesario incluir prácticas supervisadas, acceso a equipos o laboratorio, corrección individual, tutoría humana y evaluación real. La beta actual contiene el programa y el seguimiento de lecciones, no todas las clases completas ni esos servicios de instructor.

## Publicar el tutor en Cloudflare

No necesitas conectar GitHub ni localizar el apartado Builds para publicar manualmente el Worker existente:

1. Cloudflare Dashboard → **Workers & Pages** → selecciona `show-os-tutor`.
2. Abre **Edit code** / **Quick edit**.
3. Sustituye el ejemplo por el contenido completo de [cloudflare/worker.js](cloudflare/worker.js).
4. Pulsa **Save and Deploy**.
5. En **Settings → Variables and Secrets**, añade los secretos descritos más abajo.
6. Comprueba la URL `workers.dev`; la ruta del tutor es `/api/tutor`.

También existe `wrangler.jsonc` para una futura publicación por Git. La beta no depende de activar esa integración.

## Variables y secretos

En Cloudflare → `show-os-tutor` → Settings → Variables and Secrets:

| Nombre | Tipo | Valor |
|---|---|---|
| `OPENAI_API_KEY` | Secret | Clave de OpenAI Platform |
| `SHOWOS_BETA_CODE` | Secret | Código aleatorio privado para compañeros de prueba (mínimo 16 caracteres) |
| `OPENAI_MODEL` | Text | `gpt-6.1-sol` |
| `ALLOWED_ORIGIN` | Text | Origen exacto del sitio IONOS, por ejemplo `https://campus.ejemplo.es`, sin ruta ni barra final |

Nunca guardar `OPENAI_API_KEY` o `SHOWOS_BETA_CODE` en GitHub, HTML o capturas públicas. Después de añadir/modificar secretos, vuelve a desplegar si el panel lo solicita.

## Publicar la web actualizada en IONOS

1. Descarga el ZIP de GitHub: **Code → Download ZIP**.
2. Extrae y toma el `index.html` de la raíz del repositorio.
3. En IONOS, reemplaza `show-os-campus/index.html` por ese archivo.
4. No cambies DNS ni elimines el resto del hosting.

## Conectar el campus con el Worker

1. Copia la URL `workers.dev` que muestra Cloudflare y añade `/api/tutor`, por ejemplo `https://show-os-tutor.usuario.workers.dev/api/tutor`.
2. Abre SHOW OS CAMPUS → Simulador IA.
3. Pega la URL del Worker y el código beta compartido solo con los compañeros invitados.
4. Pulsa **Guardar conexión** y envía una respuesta de prueba.
5. Verifica que el estado indique tutor conectado y que aparezca una evaluación estructurada. Si hay error, revisa secretos, modelo, saldo y el origen permitido.

## Límites y seguridad de la beta

- El Worker tiene un límite en memoria por IP para reducir abuso; no sustituye autenticación por usuario ni limitación persistente.
- El código beta es compartido; cada persona que lo conozca puede usar la API. No publicar el código en redes.
- El gasto de OpenAI API se factura aparte de ChatGPT y del plan Free de Cloudflare. Configura límites y alertas de consumo.
- El progreso se guarda en `localStorage` del navegador: no sincroniza entre móviles y ordenadores.
- El certificado actual es vista previa privada de formación SHOW OS. No tiene firma digital verificada ni QR permanente y no equivale a titulación oficial homologada ni a una certificación de fabricante.

## Pendiente antes de abrir al público o vender

- Despliegue verificado de Worker y secretos.
- Prueba real desde la URL IONOS con una llamada IA real.
- Autenticación individual, registro de alumnos y protección antiabuso más fuerte.
- Sincronización de progreso, persistencia y expediente por alumno.
- Cursos completos: apuntes desarrollados, vídeos, diagramas, descargables, soluciones de prácticas y revisión humana.
- Acceso planificado a equipos reales/laboratorios, calendario, instructores y política comercial para una matrícula de 1.500 €.
- Sistema de certificados con identidad, firma autorizada, registro y página real de verificación.
