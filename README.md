# SHOW OS CAMPUS — Academia técnica beta · v1.1

Plataforma de formación operativa para técnicos de vídeo, pantallas LED, procesado, playback, fibra óptica, redes y reparación electrónica.

## Arquitectura
- Frontend `index.html` alojado en IONOS: `/show-os-campus/index.html`.
- Tutor IA `cloudflare/worker.js` desplegado en Cloudflare Workers.
- El Worker llama a OpenAI Responses API y devuelve una rúbrica estructurada.
- Las claves y códigos privados se guardan exclusivamente como secretos de Cloudflare.

## Mejoras v1.1
- Buscador por especialidad, equipos y competencias en los siete cursos.
- Resumen global de cursos, lecciones y progreso.
- Conservación del curso abierto al marcar lecciones.
- Exportación e importación de copia de seguridad del progreso.
- Comprobación de salud del Worker desde el campus.
- Validación de tipo, forma y tamaño de las peticiones al Worker.
- Evaluación local solo de práctica; ya no aprueba niveles ni modifica el expediente.
- Diploma marcado como vista previa no verificable.
- Mejoras de accesibilidad, foco de teclado y movimiento reducido.

## Catálogo
7 cursos, 34 unidades y 102 lecciones; carga horaria propuesta de 348 horas. Los 1.500 € son un precio objetivo de diseño, no una tarifa comercial publicada. Para justificar ese precio hacen falta docencia, prácticas supervisadas, equipos/laboratorio, revisión individual y evaluación real.

## Publicación
Sigue [DEPLOY.md](DEPLOY.md). El archivo para IONOS debe quedar directamente en `show-os-campus/index.html`, sin carpetas intermedias. Actualizar GitHub no publica automáticamente ni el Worker ni el sitio.

## Seguridad y límites
- Configura `ALLOWED_ORIGIN` como `https://muelleaudiovisuales.com`.
- `OPENAI_API_KEY` y `SHOWOS_BETA_CODE` deben ser Secrets del Worker; nunca introducirlos en el HTML o el repositorio.
- El límite por IP actual es básico y en memoria; no reemplaza autenticación individual ni limitación persistente.
- El progreso permanece local al navegador, con copia manual exportar/importar.
- La acreditación SHOW OS es privada, no oficial y no sustituye certificaciones de fabricante.
- El catálogo no contiene aún las clases completas, vídeos, profesor, equipos ni sesiones prácticas contratadas.
- No se ha verificado en esta actualización el despliegue en IONOS o Cloudflare.
