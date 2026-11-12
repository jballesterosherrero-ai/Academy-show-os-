# SHOW OS CAMPUS — Beta pública

Academia web responsive de capacitación operativa para técnicos de vídeo y pantallas LED. Incluye ruta docente de cinco niveles, simulador con tutor IA, vocabulario técnico, librería de aparatos y expediente local.

## Estructura del repositorio

- `index.html`: interfaz y navegación.
- `campus-data.js`: temario progresivo, casos, glosario y fichas de aparatos.
- `api/tutor.php`: backend de evaluación y modo práctica con OpenAI Responses API.
- `api/config.example.php`: plantilla de secretos (no contiene la clave real).
- `api/.htaccess`: bloquea acceso HTTP directo a `api/config.php`.
- `.gitignore`: excluye la configuración privada.

## Publicación en IONOS Web Hosting

La beta se puede servir desde una subcarpeta para no sobrescribir la web corporativa:

```
show-os-campus/
  index.html
  campus-data.js
  api/
    tutor.php
    config.example.php
    .htaccess
```

1. En IONOS asigna el dominio o subdominio al espacio web.
2. Selecciona PHP 8.1 o superior (PHP 8.5 es compatible).
3. Comprueba que esté disponible al menos una opción para HTTPS saliente desde PHP: extensión cURL o `allow_url_fopen` activado. El backend usa cURL cuando existe y HTTPS nativo como alternativa.
4. Sube los archivos de la raíz del repositorio a `show-os-campus`. La carpeta `api` debe contener el backend y sus archivos auxiliares.
5. En el servidor, dentro de `show-os-campus/api`, copia `config.example.php` con el nombre `config.php`.
6. Edita `api/config.php` en IONOS y sustituye `PEGA_AQUI_TU_CLAVE_API` por la clave de proyecto OpenAI. El archivo privado debe existir solo en IONOS, nunca en GitHub ni en el navegador.
7. Mantén `api/.htaccess` y verifica que el servidor aplica las reglas Apache. No compartas la URL de `config.php`.
8. Abre `https://TU-DOMINIO/show-os-campus/` y prueba primero el modo práctica. Después prueba una evaluación formal con una respuesta completa.

## Diseño pedagógico

Los niveles suben de forma progresiva:
1. Seguridad, subsistemas LED y diagnóstico básico.
2. NovaStar H9, NovaLCT, receiving cards y .rcfgx.
3. Aquilon C+, EDID, fps/Hz, conversión de cadencia y continuidad de señal.
4. WATCHOUT/WATCHPAX, redes, fibra y redundancia de extremo a extremo.
5. Diseño de festival, rider, cálculo eléctrico y presupuesto óptico.

Cada nivel incluye objetivo, requisito previo, contenido, procedimiento de referencia, evidencias, errores críticos y documentación del fabricante. El tutor distingue modo práctica (sin nota) y evaluación formal. La nota se calcula en el servidor con pesos: seguridad 30, diagnóstico 25, procedimiento 25 y validación 20. Para aprobar exige 80/100, mínimo 24/30 en seguridad y mínimos por criterio; los errores críticos bloquean el aprobado.

## Seguridad y limitaciones de la beta pública

- Repositorio y web públicos significan que cualquier persona puede intentar usar la academia. El límite básico por IP no equivale a autenticación y puede ser eludido; configura límites de gasto y alertas en OpenAI Platform y monitoriza el consumo.
- No se deben publicar claves API, contraseñas ni datos personales de alumnos.
- El progreso se guarda en el navegador (`localStorage`); todavía no hay cuentas ni sincronización real entre dispositivos.
- Una evaluación IA es apoyo formativo. Para una acreditación laboral seria, el operador debe verificar identidad, pruebas prácticas presenciales, versión de equipos y evidencias.
- El diploma es una acreditación privada de formación SHOW OS; no es un título oficial homologado, una habilitación eléctrica ni una certificación emitida por NovaStar, Analog Way o Dataton.

## Documentación técnica de referencia

- NovaStar H9 Video Wall Splicer — [especificaciones oficiales](https://oss.novastar.tech/uploads/2025/06/H9-Video-Wall-Splicer-Specifications-V1.15.0.pdf)
- NovaLCT — [manual de usuario](https://oss.novastar.tech/uploads/2021/10/NovaLCT-LED-Configuration-Tool-for-Synchronous-Control-System-User-Manual-V5.4.3.pdf)
- CVT4K-M — [especificaciones oficiales](https://oss.novastar.tech/uploads/2019/04/Fiber_Converter_CVT4K-M_Specifications-V1.0.0.pdf)
- Aquilon C+ — [producto y documentación](https://www.analogway.com/products/aquilon-cplus)
- WATCHOUT 7 — [guía oficial](https://docs.dataton.com/guide/watchout/index.html)
