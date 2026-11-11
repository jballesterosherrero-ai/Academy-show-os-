# SHOW OS CAMPUS — Beta pública · Tutor IA (IONOS)

Aplicación web responsive para capacitación operativa de técnicos de vídeo y pantallas LED. El frontend utiliza un endpoint PHP que llama a OpenAI Responses API sin exponer la clave al navegador.

## Archivos

- `index.html`: interfaz del campus.
- `api/tutor.php`: backend PHP del tutor IA.
- `api/config.example.php`: plantilla de configuración privada.
- `api/.htaccess`: bloquea el acceso web directo a `config.php`.
- `.gitignore`: impide añadir por error la clave privada al repositorio.

## Publicación en IONOS Web Hosting

1. En el panel IONOS asigna el dominio o subdominio al espacio web.
2. Selecciona PHP 8.2 o superior (se recomienda una versión PHP actual disponible en tu contrato).
3. Sube el contenido de este proyecto a la raíz del dominio con IONOS Webspace Explorer o SFTP. Deben quedar `index.html` y la carpeta `api` en la raíz.
4. Comprueba que la extensión PHP cURL está disponible en tu paquete. El tutor la necesita para llamar a OpenAI.
5. En el servidor, dentro de `/api`, copia `config.example.php` con el nombre `config.php`.
6. Edita `api/config.php` en el espacio web de IONOS y sustituye `PEGA_AQUI_TU_CLAVE_API` por la clave de OpenAI. No subas nunca ese archivo a GitHub ni lo envíes por chat.
7. Mantén `api/.htaccess` en el servidor para denegar la descarga directa de `config.php`.
8. Abre tu dominio y prueba el simulador. La llamada del frontend se dirige a `/api/tutor.php`.

## Seguridad de la beta pública

- El repositorio GitHub puede ser público; `api/config.php` debe existir únicamente en el servidor IONOS.
- La API aplica un límite básico de 30 consultas por 10 minutos y 100 por hora por dirección IP. Configura además límites de gasto y alertas en OpenAI Platform.
- Comparte la URL de prueba con compañeros de confianza. Un sitio totalmente público puede ser visitado por terceros; el límite por IP reduce, pero no elimina, el riesgo de abuso.
- No subas capturas con la clave ni la pegues en ChatGPT.
- Los avances siguen guardándose en el navegador (`localStorage`); todavía no se sincronizan entre dispositivos.
- El diploma es una acreditación privada SHOW OS de formación evaluada; no equivale a una titulación oficial homologada.

## Modelo de IA

Por defecto se utiliza `gpt-6.1-sol`. Puedes cambiarlo en `api/config.php` por otro modelo habilitado para tu proyecto de OpenAI.