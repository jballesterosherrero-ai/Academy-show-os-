# Publicación v1.1 — SHOW OS CAMPUS

## IONOS: actualizar la web

El archivo de entrada debe quedar exactamente aquí:

`/show-os-campus/index.html`

1. En el Administrador de archivos de IONOS, abre la carpeta pública `show-os-campus`.
2. Descarga una copia del `index.html` actual antes de sustituirlo.
3. Sube el `index.html` de la raíz del repositorio directamente dentro de `show-os-campus`.
4. No dejes carpetas intermedias, por ejemplo `show-os-campus/SHOW_OS_CAMPUS_PUBLICACION_IONOS/IONOS/index.html`.
5. Abre `https://muelleaudiovisuales.com/show-os-campus/`. Si aparece una copia antigua, prueba una ventana privada o una recarga completa.

No cambies DNS ni borres otras carpetas del hosting.

## Mejoras incluidas en v1.1

- Buscador del catálogo y resumen de cursos/lecciones.
- Guarda el curso abierto mientras marcas lecciones.
- Copia de seguridad exportable e importable del progreso.
- La evaluación local es solo orientativa: no aprueba ni modifica el expediente.
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
| `ALLOWED_ORIGIN` | Text | `https://muelleaudiovisuales.com` |

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
- La evaluación local es orientativa y no acredita niveles. La aprobación automática solo puede proceder del tutor conectado, y la decisión académica final requiere revisión humana.
- El diploma es una acreditación privada, no un título oficial ni una certificación de fabricante.
- El catálogo describe programas; no incluye por sí solo clases completas, docente, equipos, prácticas contratadas ni tutoría individual.
