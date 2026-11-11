# SHOW OS CAMPUS — Beta pública · Tutor IA (IONOS)

Aplicación web responsive para capacitación operativa de técnicos de vídeo y pantallas LED. El frontend utiliza un endpoint PHP que llama a OpenAI Responses API sin exponer la clave al navegador.

## Archivos

- `index.html`: interfaz del campus.
- `api/tutor.php`: backend PHP del tutor IA.
- `api/config.example.php`: plantilla de configuración privada.
- `api/.htaccess`: bloquea el acceso web directo a `config.php`.
- `.gitignore`: impide añadir por error la clave privada.

## Publicación segura en IONOS Web Hosting

Para no sobrescribir una web que ya tengas publicada, crea una carpeta nueva llamada `show-os-campus` dentro de la carpeta web asignada a tu dominio. Sube dentro de ella el contenido de este repositorio, de forma que quede:
```
show-os-campus/
  index.html
  .gitignore
  api/
    tutor.php
    .htaccess
    config.example.php
``

En ese caso abre el campus en `https://TU-DOMINIO/show-os-campus/`. El frontend utiliza la ruta relativa `api/tutor.php`, por lo que el backend funciona también dentro de esa subcarpeta.

1. En el panel IONOS asigna el dominio o subdominio al espacio web.
2. Selecciona PHP 8.2 o superior (o la versión actual disponible en tu contrato) y comprueba que PHP cURL esté activo.
3. En IONOS abre Menú > Hosting > Espacio web: Usar espacio web. Crea la carpeta `show-os-campus`.
4. Extrae el ZIP en tu dispositivo y sube el contenido de la carpeta `SHOW_OS_CAMPUS_IONOS` a `show-os-campus`. No subas una carpeta extra anidada.
5. En el servidor, dentro de `show-os-campus/api`, copia `config.example.php` con el nombre `config.php`.
6. Edita `show-os-campus/api/config.php` en IONOS y sustituye `PEGA_AQUI_TU_CLAVE_API` por tu clave de OpenAI. Este archivo debe existir únicamente en IONOS; no lo subas a GitHub ni lo compartas.
7. Mantén `api/.htaccess` en el servidor para denegar la descarga directa de `config.php`.
8. Abre `https://TU-DOMINIO/show-os-campus/` y prueba el simulador. La llamada del frontend se dirige a `api/tutor.php`.

## Seguridad de la beta pública

- El repositorio GitHub puede ser público; `api/config.php` debe existir únicamente en el servidor IONOS.
- El endpoint aplica un límite básico de 30 consultas por 10 minutos y 100 por hora por dirección IP. Configura también límites de gasto y alertas en OpenAI Platform.
- Comparte la URL de prueba con compañeros de confianza. Un sitio público puede ser visitado por terceros; el límite por IP reduce, pero no elimina, el riesgo de abuso.
- No subas capturas con la clave ni la pegues en ChatGPT.
- Los avances se guardan en el navegador (`localStorage)); todavía no se sincronizan entre dispositivos.
- El diploma es una acreditación privada SHOW OS de formación evaluada; no equivale a una titulación oficial homologada.

## Modelo de IA

Por defecto se utiliza `gpt-6.1-sol`. Puedes cambiarlo en `api/config.php` por otro modelo habilitado para tu proyecto.
