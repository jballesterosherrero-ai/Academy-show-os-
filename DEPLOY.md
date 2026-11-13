# Publicación SHOW OS CAMPUS (pasos de panel)

## En Cloudflare

Desde Workers & Pages → show-os-tutor → Settings → Builds → Connect:
- Git account: jballesterosherrero-ai
- Repository: Academy-show-os-
- Branch: main
- Root directory: /
- Build command: dejar vacío
- Deploy command: npx wrangler deploy

Guardar y esperar a que el despliegue termine.

## Secretos

En show-os-tutor → Settings → Variables and Secrets, añadir:
- OPENAI_API_KEY (Secret): clave de OpenAI Platform.
- SHOWOS_BETA_CODE (Secret): código beta privado.
- OPENAI_MODEL (Text): gpt-6.1-sol.
- ALLOWED_ORIGIN (Text): origen del dominio IONOS, sin ruta.

Pulsar Deploy si se solicita.

## En IONOS

Reemplazar show-os-campus/index.html por el index.html actualizado de la raíz del repositorio.

## En el campus

Configurar en el simulador la dirección https://NOMBRE-DEL-WORKER.USUARIO.workers.dev/api/tutor y el código beta.
