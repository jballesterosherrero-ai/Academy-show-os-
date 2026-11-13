# SHOW OS CAMPUS — beta pública

La página del campus se aloja en IONOS. El tutor IA se ejecuta en un Cloudflare Worker y llama a OpenAI Responses API desde el servidor. La clave de OpenAI no se envía al navegador.

## Estado del proyecto

- Frontend: `index.html`
- Backend IA: `cloudflare/worker.js`
- Configuración de despliegue: `wrangler.jsonc`
- Worker esperado: `show-os-tutor`
- Rama de GitHub: `main`

## Conectar el Worker existente con GitHub

1. Abre Cloudflare Dashboard → Workers & Pages.
2. Selecciona el Worker existente `show-os-tutor` (no entres en Edit code).
3. Abre **Settings → Builds**.
4. Pulsa **Connect** y autoriza la aplicación GitHub de Cloudflare si lo solicita.
5. Selecciona cuenta `jballesterosherrero-ai`, repositorio `Academy-show-os-` y rama `main`.
6. Configuración:
   - Root directory: `/` (raíz).
   - Build command: vacío.
   - Deploy command: `npx wrangler deploy`.
7. Guarda la configuración e inicia el despliegue. Los siguientes commits a `main` publicarán el Worker automáticamente.

La configuración `wrangler.jsonc` ya especifica el nombre `show-os-tutor` y el archivo `cloudflare/worker.js`. El nombre debe coincidir con el Worker existente.

## Configurar los secretos del Worker

En Cloudflare, abre `show-os-tutor` → **Settings → Variables and Secrets** y crea:

| Nombre | Tipo | Valor |
|---|---|---|
| `OPENAI_API_KEY` | Secret | Tu clave de OpenAI Platform |
| `SHOWOS_BETA_CODE` | Secret | Un código aleatorio de al menos 16 caracteres para tus compañeros |
| `OPENAI_MODEL` | Text | `gpt-6.1-sol` |
| `ALLOWED_ORIGIN` | Text | El origen exacto de IONOS, por ejemplo `https://tudominio.es` (sin ruta ni barra final) |

No escribas estos secretos en GitHub ni en el HTML. Después de guardarlos, pulsa Deploy si Cloudflare lo solicita.

## Actualizar la página en IONOS

El frontend actualizado se encuentra en `index.html`. Súbelo a la carpeta `show-os-campus/` de IONOS y reemplaza el index anterior. No hace falta modificar DNS ni cambiar de hosting.

## Conectar el campus con el tutor

1. Copia la URL `workers.dev` que muestra Cloudflare.
2. Añade `/api/tutor` al final. Ejemplo: `https://show-os-tutor.usuario.workers.dev/api/tutor`.
3. Abre el campus IONOS, entra en el simulador y pega la URL en **URL del tutor IA**.
4. Introduce el mismo código guardado en el secreto `SHOWOS_BETA_CODE`.
5. Pulsa **Guardar conexión** y prueba el caso de Nivel 1.

## Seguridad y límites

- La clave OpenAI permanece como Secret de Cloudflare y nunca llega al navegador.
- El código beta permite el uso a compañeros invitados; compártelo solo con ellos y rótalo si se filtra.
- El Worker aplica un límite básico por IP en memoria para la beta; no sustituye autenticación completa ni protección persistente contra abuso.
- Cloudflare Workers Free tiene límites de uso y puede cambiar. OpenAI API se factura aparte según el modelo y tokens consumidos. Configura límites y alertas de gasto en OpenAI Platform.
- El progreso del alumno se guarda en el navegador; todavía no se sincroniza entre dispositivos.
- El diploma es una acreditación privada de formación SHOW OS By Muelle, no una titulación oficial homologada.
