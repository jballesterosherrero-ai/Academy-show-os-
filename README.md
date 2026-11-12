# SHOW OS CAMPUS — Tutor IA en Cloudflare Workers

La web sigue alojada en IONOS. Este Worker actúa únicamente como backend seguro del tutor y realiza llamadas a OpenAI Responses API.

## Publicar desde el panel web

1. Crea/inicia sesión en una cuenta Cloudflare y abre Workers & Pages.
2. Create application → Create Worker → Deploy (nombre sugerido: `show-os-tutor`).
3. Abre Edit code, sustituye el ejemplo completo por `cloudflare/worker.js` y guarda/deploy.
4. En Settings → Variables and Secrets, crea estos valores:
   - `OPENAI_API_KEY`: Secret. Pega aquí la clave API de OpenAI, no en el HTML ni GitHub.
   - `SHOWOS_BETA_CODE`: Secret. Crea un código de acceso aleatorio de al menos 16 caracteres y compártelo solo con compañeros de prueba.
   - `OPENAI_MODEL`: Text, valor `gpt-6.1-sol` (opcional; es el valor por defecto del código).
   - `ALLOWED_ORIGIN`: Text, valor exacto del origen de IONOS, por ejemplo `https://campus.tudominio.es` (opcional pero recomendado; sin ruta ni barra final).
5. Guarda los secretos y vuelve a desplegar si el panel lo solicita.
6. Copia la URL `workers.dev` y añádele `/api/tutor`, por ejemplo `https://show-os-tutor.usuario.workers.dev/api/tutor`.
7. En el campus de IONOS, dentro del panel del Tutor IA, pega esa URL y el código beta. Pulsa Guardar conexión.
8. Prueba el primer caso.

## Seguridad

- La clave OpenAI vive como Secret del Worker y nunca llega al navegador.
- `SHOWOS_BETA_CODE` es un segundo secreto para controlar la beta. No lo pongas en el repositorio ni en un mensaje público.
- Configura `ALLOWED_ORIGIN` con el origen exacto de la web IONOS. El código incluye además un limitador básico por IP en memoria para pruebas; no sustituye un control de abuso persistente ni un sistema completo de autenticación.
- La web puede ser pública, pero comparte el código beta solo con las personas invitadas. Rótalo si deja de ser privado.
- Cloudflare Workers Free tiene límites de uso (consulta la documentación vigente). El uso de OpenAI API se factura por separado según modelo y tokens.
- El progreso del estudiante permanece en el navegador; aún no se sincroniza entre dispositivos.
- La certificación es privada de SHOW OS, no una titulación oficial homologada.