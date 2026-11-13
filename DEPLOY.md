# Guía operativa de publicación — SHOW OS CAMPUS

## A. Publicar Worker (manual, sin GitHub Builds)

1. Entrar en Cloudflare Dashboard.
2. Workers & Pages → show-os-tutor.
3. Abrir Edit code / Quick edit.
4. Sustituir el código del ejemplo por el contenido de `cloudflare/worker.js` del repositorio.
5. Save and Deploy.

## B. Crear secretos

En show-os-tutor → Settings → Variables and Secrets:

- `OPENAI_API_KEY`: Secret, clave de OpenAI Platform.
- `SHOWOS_BETA_CODE`: Secret, código aleatorio privado para los alumnos invitados.
- `OPENAI_MODEL`: Text, `gpt-6.1-sol`.
- `ALLOWED_ORIGIN`: Text, origen público del campus IONOS (esquema + dominio, sin ruta).

No incluir claves en GitHub, HTML, este documento o conversaciones. Desplegar de nuevo si Cloudflare lo solicita al guardar secretos.

## C. Actualizar la web IONOS

1. En GitHub, pulsa Code → Download ZIP.
2. Extrae el ZIP en tu ordenador/móvil.
3. Sube el `index.html` de la raíz al directorio `show-os-campus/` de IONOS, reemplazando el anterior.
4. No es necesario cambiar DNS.

## D. Conectar

En el simulador del campus:
- URL: `https://NOMBRE-WORKER.USUARIO.workers.dev/api/tutor`
- Código: el mismo contenido que guardaste como secreto `SHOWOS_BETA_CODE`.

Guardar conexión y probar un caso. Un error 401 indica código beta ausente/incorrecto; 403 suele indicar origen no permitido; 503 indica secreto OpenAI no configurado; 502 indica error al contactar OpenAI (revisar modelo/saldo/servicio).

## E. Prueba de aceptación

- GET a la ruta `/api/tutor` debe devolver JSON de estado online.
- Enviar una respuesta de prueba desde la página IONOS debe generar feedback y rúbrica.
- Probar un segundo dispositivo con la misma URL y código (el progreso personal permanece local en cada navegador).
- Revisar límites y alertas de gasto OpenAI.

## No abrir venta todavía

La beta dispone de un catálogo detallado de 7 cursos, pero el precio objetivo de 1.500 € exige clases completas, instructor, prácticas supervisadas en equipo/laboratorio, feedback individual y evaluación presencial o equivalente. El diploma actual es una acreditación privada de formación, no una titulación oficial.
