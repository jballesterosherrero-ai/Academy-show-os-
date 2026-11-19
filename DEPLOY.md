# Publicación v1.2 — SHOW OS CAMPUS

## Dirección pública

La dirección objetivo del campus es:

`https://academy.muelleaudiovisuales.com/`

El subdominio debe estar conectado en IONOS a la carpeta `/show-os-campus/`, y el archivo de entrada debe quedar exactamente en `/show-os-campus/index.html`. El destino que has confirmado es esa carpeta.

En IONOS: **Menú → Dominios & SSL → academy.muelleaudiovisuales.com → Destino**. Anota la ruta exacta del directorio. Si el subdominio todavía no está conectado al espacio web, conéctalo primero a una carpeta dedicada al campus y comprueba que el estado figure como Activo. No cambies DNS ni la carpeta de otros dominios.

## IONOS: publicación segura

El flujo de GitHub Actions publica únicamente el archivo `index.html` en el directorio configurado. Antes de sustituir un `index.html` existente, lo guarda como artefacto de respaldo durante 30 días.

1. Comprueba que el destino del subdominio sea una carpeta dedicada al campus.
2. Asegúrate de que la cuenta SFTP puede escribir en esa carpeta.
3. En GitHub, configura los secretos y la variable descritos en la sección «Publicación automática a IONOS desde GitHub».
4. Ejecuta el flujo manual **Actions → Publicar SHOW OS CAMPUS en IONOS → Run workflow**.
5. Solo considera publicada la web cuando el flujo termine en verde y puedas abrir `https://academy.muelleaudiovisuales.com/`.

El flujo comprueba la huella SHA-256 del servidor IONOS y la integridad del archivo transferido. Si el destino no existe, no se publica. Si falla la comprobación después del cambio, intenta restaurar el archivo anterior.

## Mejoras incluidas en v1.1

- Buscador del catálogo y resumen de cursos/lecciones.
- Guarda el curso abierto mientras marcas lecciones.
- Copia de seguridad exportable e importable del progreso.
- La evaluación local es solo orientativa: no aprueba ni modifica el expediente.
- Al abrir v1.1 por primera vez, las notas/aprobados del esquema anterior se guardan como copia local no verificada y se retiran del expediente activo.
- Prueba de salud del Worker desde el simulador.
- Diploma identificado como vista previa no verificable.
- Mejoras de accesibilidad y validación del almacenamiento local.

## Cloudflare: actualizar el tutor

1. Cloudflare Dashboard → Workers & Pages → `show-os-tutor`.
2. Abre Edit code / Quick edit.
3. Sustituye el código completo por `cloudflare/worker.js` de este repositorio.
4. Pulsa Save and Deploy.

## Variables y secretos

En `show-os-tutor` → Settings → Variables and Secrets:

| Nombre | Tipo | Valor |
|---|---|---|
| `OPENAI_API_KEY` | Secret | Clave del proyecto OpenAI |
| `SHOWOS_BETA_CODE` | Secret | Código privado aleatorio de al menos 16 caracteres |
| `OPENAI_MODEL` | Text | `gpt-6.1-sol` |
| `ALLOWED_ORIGIN` | Text | `https://academy.muelleaudiovisuales.com` |

No pegues la clave OpenAI ni el código beta en GitHub, el HTML, capturas o conversaciones.

## Conectar y comprobar

En SHOW OS CAMPUS → Simulador IA:
- Pega la URL real de tu Worker terminada en `/api/tutor`.
- Introduce el código beta guardado como secreto.
- Pulsa Guardar conexión y después Probar conexión.
- La prueba de salud solo comprueba que el Worker responde. Para confirmar la evaluación real se necesita el código beta correcto, el secreto OpenAI y un modelo habilitado.

## Pruebas de aceptación

- La página carga en móvil y ordenador.
- Se muestran los siete cursos y funciona el buscador.
- Se puede marcar una lección y exportar/importar el progreso.
- El Worker responde al GET de salud.
- Una llamada IA real devuelve feedback y rúbrica.
- Un error de conexión nunca cuenta como aprobado.

## Límites conocidos

- El progreso es local al navegador. La copia exportar/importar permite trasladarlo manualmente; no hay sincronización en nube.
- La evaluación local es orientativa y no acredita niveles. La copia de progreso importa/exporta únicamente lecciones marcadas; no transfiere notas ni aprobados. La aprobación del tutor conectado también requiere revisión académica humana.
- El diploma es una acreditación privada, no un título oficial ni una certificación de fabricante.
- El catálogo describe programas; no incluye por sí solo clases completas, docente, equipos, prácticas contratadas ni tutoría individual.


## Publicación automática a IONOS desde GitHub

El repositorio incluye un despliegue manual para publicar la web en IONOS mediante SFTP:

- Dirección pública: `https://academy.muelleaudiovisuales.com/`
- Servidor SFTP: `access-5021514183.webspace-host.com`
- Puerto: `22`
- Protocolo: SFTP
- Archivo que se publica: únicamente `index.html`.
- Destino remoto confirmado: `/show-os-campus/index.html` (el script sube el archivo al directorio `/show-os-campus/`).
- Antes de sustituirlo, el proceso guarda el archivo anterior como artefacto descargable de GitHub Actions durante 30 días.
- La conexión verifica la huella SHA-256 contra las huellas IONOS admitidas. Si no coincide, se rechaza la conexión.

### Configuración inicial

En GitHub, abre el repositorio → **Settings → Secrets and variables → Actions**.

En **Repository secrets**, crea:

| Nombre | Valor |
|---|---|
| `IONOS_SFTP_USER` | Nombre de usuario SFTP de IONOS |
| `IONOS_SFTP_PASSWORD` | Contraseña del usuario SFTP |

El destino confirmado es `/show-os-campus`. El proceso utiliza esa ruta por defecto, por lo que no hace falta crear la variable `IONOS_REMOTE_DIR` si el usuario SFTP puede acceder a esa carpeta desde la raíz del alojamiento. Si la cuenta SFTP está restringida en IONOS para que `/show-os-campus` sea su propia raíz visible, crea en **Variables** `IONOS_REMOTE_DIR` con valor `/`.

No introduzcas contraseñas en archivos del repositorio, incidencias ni conversaciones.

### Ejecutar la publicación

1. Abre la pestaña **Actions** del repositorio.
2. Selecciona **Publicar SHOW OS CAMPUS en IONOS**.
3. Pulsa **Run workflow**, elige la rama `main` y confirma.
4. Comprueba que el resultado aparece en verde y visita `https://academy.muelleaudiovisuales.com/`.

Esta publicación solo actualiza la web estática. No despliega el Worker de Cloudflare.
