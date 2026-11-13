# SHOW OS CAMPUS — Programa académico premium

**Versión de diseño:** 13 de noviembre de 2026  
**Entidad formativa:** SHOW OS By Muelle  
**Precio objetivo de diseño:** 1.500 € por curso (propuesta; no es una tarifa publicada ni una matrícula abierta).

## Estándar que debe justificar 1.500 €

El precio solo sería defendible si el curso contratado ofrece más que vídeos y un chatbot: entre 36 y 64 horas de trabajo guiado; prácticas supervisadas sobre hardware real o laboratorio equivalente; acceso a simuladores y plantillas de producción; corrección individual de entregables por un técnico instructor; tutoría de dudas; evaluación práctica con rúbrica; feedback escrito y una oportunidad de reevaluación. Las horas, el acceso a equipos, las fechas y los servicios incluidos deben aparecer por escrito antes de venderse.

La versión beta actual presenta el plan de estudios y permite marcar lecciones en el navegador. No incluye por sí sola la docencia humana, el préstamo de equipos, las prácticas presenciales, la sincronización entre dispositivos ni el soporte comercial que harían falta para ofrecer cada curso a 1.500 €.

## Catálogo de cursos

### Curso 01 — Ingeniería LED y operación profesional de eventos

- **Nivel:** Fundamentos · Operador
- **Carga lectiva propuesta:** 48 horas
- **Requisitos:** Ninguno. Recomendable experiencia básica en montaje de eventos.
- **Enfoque:** De cero a un montaje documentado: entender cómo viajan la energía, los datos y la imagen desde el control hasta cada gabinete LED.

**Competencias de salida**

- Leer un plano de pantalla y traducirlo a una lista de material y patch.
- Calcular resolución, dimensiones, pitch y distribución de carga con fichas reales.
- Distinguir rutas de alimentación, datos, control y fibra.
- Ejecutar preflight, commissioning, prueba de aceptación y cierre documentado.

**Unidades y prácticas**

#### 1. Fundamentos de imagen y señal

- Resolución, relación de aspecto, píxel, pitch, distancia de visualización y resolución nativa.
- Frecuencia de imagen, frecuencia de refresco, profundidad de bits, submuestreo y formatos de señal.
- Cadena completa: fuente, procesado, envío, recepción, gabinete y módulo. Identificar cada punto de fallo.

**Práctica:** Preparar tres formatos de contenido para una pantalla de resolución no estándar y explicar qué se recorta, escala o convierte.

**Evidencia exigida:** Ficha de señal de entrada/salida y mapa de resolución.

#### 2. Arquitectura de pantalla LED

- Módulos, cabinets, receiving cards, fuentes, HUB y cableado: función y compatibilidad.
- Pitch, dimensiones, número de cabinets, resolución total y orientación.
- Lotes, series, homogeneidad de paneles, etiquetado y trazabilidad.

**Práctica:** Montar en plano una pantalla central y dos laterales; numerar cabinets y crear inventario.

**Evidencia exigida:** Plano de numeración, BOM y registro de lotes.

#### 3. Potencia y seguridad en montaje

- Lectura de placas, potencia nominal/máxima, factor de potencia y condiciones del fabricante.
- Diferencia entre circuito monofásico/trifásico, reparto de cargas, protecciones y coordinación con personal habilitado.
- LOTO, inspección visual, EPI, zonas de paso, altura, estructura y límites de intervención del técnico de vídeo.

**Práctica:** Revisar un cuadro de cargas didáctico y detectar sobrecargas y desequilibrios sin manipular instalación real.

**Evidencia exigida:** Hoja de cargas con supuestos, datos de placa y revisión del responsable eléctrico.

#### 4. Redes y transporte de señal

- IPv4, máscara, gateway, DHCP frente a IP fija, VLAN y plan de direccionamiento.
- Ethernet, switches gestionables, puertos, etiquetado, loop y segmentación de red de show.
- Fibra óptica: limpieza, radios de curvatura, rutas y protección mecánica.

**Práctica:** Crear un plan IP y un mapa de puertos para control, procesado y media servers.

**Evidencia exigida:** IP plan, port map y lista de cables.

#### 5. Documentación y operación de bolo

- Rider, signal flow, patch list, run of show, checklist de carga y control de cambios.
- Prueba de imagen, patrones, uniformidad, aceptación del cliente y registro de incidencias.
- Apagado, desmontaje, inventario, etiquetado de averías y parte de retorno.

**Práctica:** Simular un día de bolo con incidencias, cambio de contenido y entrega de turno.

**Evidencia exigida:** Carpeta técnica de bolo versionada y parte de cierre.

**Proyecto final:** Plan de montaje y puesta en marcha de una pantalla LED de evento: plano de cabinets, resolución, patch de señal, plan IP, inventario, matriz de riesgos, checklists de commissioning y cierre.

**Evaluación:** Cuestionario técnico 15%, documentación 25%, práctica de diagnóstico 30%, defensa final 30%. Seguridad no superada = no apto.

**Servicios que debe incluir la matrícula:** 48 horas guiadas, plantillas profesionales, 2 revisiones del instructor, laboratorio/simulador y evaluación práctica individual.

**Documentación de referencia del fabricante**

- [NovaStar · Academia y talleres](https://www.novastar.tech/video/novastarOnlineWorkshops.html?catid=17) — Vídeos de formación sobre configuración, redundancia, calibración y troubleshooting.
- [Analog Way · Descargas y manuales](https://www.analogway.com/downloads) — Manual, simulador y documentación de los equipos de procesado.

---

### Curso 02 — NovaStar H9 y NovaLCT: configuración, calibración y diagnóstico

- **Nivel:** Operador avanzado · Senior
- **Carga lectiva propuesta:** 52 horas
- **Requisitos:** Curso 1 o experiencia demostrable en montaje y señal LED.
- **Enfoque:** Diseña, configura, respalda y diagnostica una instalación LED real con procesado H Series y herramientas NovaStar sin modificar parámetros a ciegas.

**Competencias de salida**

- Diseñar la arquitectura de entrada/salida según tarjetas realmente instaladas.
- Cargar y validar archivos .rcfgx según receiving card, módulo y firmware compatibles.
- Mapear cabinets, verificar scan y corregir errores mediante un método de diagnóstico.
- Crear backups y una hoja de recuperación antes de intervenir.

**Unidades y prácticas**

#### 1. H9: arquitectura y dimensionamiento

- Chasis modular, tarjetas de entrada/salida y funciones de control: lectura de configuración instalada.
- Capacidad de carga, límites por puerto, resolución y distribución de salidas: consultar modelo, tarjeta, firmware y manual exactos.
- Canvas, layers, presets, mosaicos irregulares y supervisión: planificar antes de cablear.

**Práctica:** Diseñar una distribución de salidas con una ficha H9 concreta; justificar la capacidad y los límites sin extrapolar cifras entre variantes.

**Evidencia exigida:** Diagrama H9 con tarjetas, fuentes, salidas y cálculo de carga de píxeles.

#### 2. NovaLCT y configuración inicial

- Preparar PC, red, permisos, búsqueda de dispositivos y documentación previa.
- Configurar pantalla, receiving card, cabinets y conexión lógica.
- Leer y comparar configuraciones antes de enviar cambios al hardware.

**Práctica:** Crear una pantalla de prácticas en un entorno controlado y registrar el estado inicial antes de cambiar parámetros.

**Evidencia exigida:** Capturas anotadas y copia de la configuración inicial.

#### 3. RCFGX, módulo y compatibilidad

- Qué contiene .rcfgx/.rcfg y qué datos del módulo deben coincidir.
- Verificar receiving card, driver IC, decoder, scan, data groups, firmware y versión del módulo.
- Cargar, comparar, probar en una zona controlada y guardar una copia restaurable.

**Práctica:** Resolver un caso de .rcfgx incompatible: identificar primero el dato que falta y definir una secuencia segura de validación.

**Evidencia exigida:** Matriz de compatibilidad y registro de versión/autor del archivo.

#### 4. Mapeo, calibración y calidad de imagen

- Orden físico, dirección de señal, cabinet mapping, coordenadas y test patterns.
- Brillo, gamma, escala de grises, balance de blancos, uniformidad y costuras según equipos disponibles.
- Guardar presets de referencia y comparar antes/después con método reproducible.

**Práctica:** Diagnosticar una costura, una zona invertida y una diferencia de brillo utilizando patrones y cambios aislados.

**Evidencia exigida:** Mapa final, fotos de patrón y hoja de control de calidad.

#### 5. Redundancia, backup y recuperación

- Rutas de backup de señal y control que permite la arquitectura desplegada.
- Backup de parámetros, lectura de estado, versiones, checksum y control de cambios.
- Procedimiento de rollback; qué no actualizar durante un show y quién autoriza una intervención.

**Práctica:** Ejercicio de pérdida de una ruta en una maqueta o simulador: identificar, conmutar según diseño y demostrar recuperación.

**Evidencia exigida:** Runbook de recuperación y acta de prueba.

**Proyecto final:** Paquete de puesta en marcha H9 para una pantalla multipanel: diseño, archivo de configuración versionado, mapeo, patrones, backup, plan de contingencia y dossier de commissioning.

**Evaluación:** Diseño 20%, laboratorio NovaLCT 30%, diagnóstico 25%, defensa de recuperación 25%. Un error crítico de seguridad o una modificación no respaldada bloquea el aprobado.

**Servicios que debe incluir la matrícula:** 52 horas, prácticas sobre equipo o simulador, revisión del archivo de configuración, tutoría técnica y examen oral.

**Documentación de referencia del fabricante**

- [NovaStar H Series / H9](https://www.novastar.tech/product/detail.html?catid=3&id=39) — Características, tarjetas, manuales, firmware y notas de versión del H9. Comprobar revisión del hardware.
- [Manual oficial NovaLCT V5.6.0](https://oss.novastar.tech/uploads/2024/07/NovaLCT-LED-Configuration-Tool-for-Synchronous-Control-System-User-Manual-V5.6.0.pdf) — Configuración de receiving cards y archivos .rcfgx/.rcfg; contrastar con la versión instalada.
- [NovaStar · NCE y formación](https://nce.novastar.tech/Certificate/detail.html?catid=1&id=4) — Alcance de formación y competencias del programa de ingeniería NovaStar; no equivale a la acreditación SHOW OS.

---

### Curso 03 — Analog Way Aquilon C+: ingeniería de señal y realización en directo

- **Nivel:** Senior · Operador de control
- **Carga lectiva propuesta:** 44 horas
- **Requisitos:** Fundamentos de señal de vídeo y lectura de formatos; curso 1 recomendado.
- **Enfoque:** Domina la preparación de fuentes, EDID, canvas, layers, presets y rutas de respaldo para congresos, corporate y espectáculos multicámara.

**Competencias de salida**

- Preparar una matriz de entradas/salidas según las tarjetas instaladas.
- Diagnosticar problemas de EDID, resolución, frecuencia, HDCP y negociación de señal.
- Construir canvas, layers, presets y multiviewer para una realización limpia.
- Operar Preview/Program y aplicar una contingencia sin improvisar en directo.

**Unidades y prácticas**

#### 1. Arquitectura, tarjetas y flujo de señal

- Chasis, tarjetas de entrada/salida, procesamiento y multiviewer: identificar la configuración real.
- Formatos HDMI, DisplayPort, SDI y ópticos según tarjeta y versión instalada.
- Plan de conectividad, etiquetado, conversiones y puntos de monitorización.

**Práctica:** Dibujar el flujo completo desde portátiles, cámaras y playback hasta LED y monitores de confianza.

**Evidencia exigida:** Signal flow y matriz de I/O.

#### 2. EDID, formatos y negociación

- EDID: qué anuncia, cómo afecta a la fuente y por qué no se debe cambiar globalmente a ciegas.
- Resolución, frame rate, colorimetría, profundidad, chroma y HDCP.
- Diagnóstico: aislar cable, adaptador, fuente, entrada, EDID y configuración de salida.

**Práctica:** Resolver portátil que entrega formato inesperado con un plan de intervención reversible y comunicación con regiduría.

**Evidencia exigida:** Tabla de fuentes con formato esperado, recibido y plan B.

#### 3. Canvas, outputs y layers

- Definir canvas lógico y correspondencia con outputs físicos y procesadores downstream.
- Crear layers, backgrounds, keying, scaling, cropping y transiciones sin exceder capacidades.
- Presets: nomenclatura, orden, pruebas, recall y validación en preview.

**Práctica:** Construir un layout de congreso con ponente, PIP, vídeo, lower third y retorno de confianza.

**Evidencia exigida:** Proyecto de show, mapa de layers y lista de presets.

#### 4. Realización, latencia y sincronía

- Preview/Program, multiviewer, TAKE, transiciones y control de cambios.
- Cadena de latencia, frame rate y conversión: medir/observar antes de corregir.
- Genlock/referencia cuando la arquitectura lo requiere; distinguir sincronía de frame conversion.

**Práctica:** Operar una secuencia de cues y resolver un vídeo con judder sin cortar la ponencia.

**Evidencia exigida:** Cue sheet y registro de medición/observación.

#### 5. Redundancia y show file

- Presets de recuperación, input backup y salidas alternativas compatibles con el montaje.
- Exportar, versionar y restaurar show files; validar después de cada cambio.
- Operación durante show: roles, comunicación, permisos y criterios de rollback.

**Práctica:** Ensayar pérdida de una fuente y conmutar a backup ensayado mientras se mantiene una salida estable.

**Evidencia exigida:** Show file, plan de backup y checklist de preflight.

**Proyecto final:** Proyecto de realización para un congreso de varias fuentes y tres destinos LED: diagrama, matriz EDID/formato, canvas, layers, presets, cue sheet y plan de respaldo.

**Evaluación:** Arquitectura 20%, operación en simulador 35%, resolución de averías 25%, defensa de show 20%.

**Servicios que debe incluir la matrícula:** 44 horas, práctica con AW Aquilon Simulator cuando sea viable, revisión de show file y evaluación operativa.

**Documentación de referencia del fabricante**

- [Analog Way · Aquilon C+](https://www.analogway.com/products/aquilon-cplus) — Arquitectura, tarjetas de entrada/salida y capacidades dependientes de la configuración.
- [Analog Way · Manuales y AW Aquilon Simulator](https://www.analogway.com/downloads) — Manual de usuario, simulador, firmware, quick start y notas de versión.

---

### Curso 04 — Dataton WATCHOUT y WATCHPAX: playback multipantalla y sincronía

- **Nivel:** Senior · Playback operator
- **Carga lectiva propuesta:** 48 horas
- **Requisitos:** Manejo básico de vídeo, formatos y redes IP.
- **Enfoque:** Construye un show multipantalla robusto, prepara medios, coordina displays y comprueba el cluster para que el contenido salga en el momento y destino correctos.

**Competencias de salida**

- Preparar media y timelines con criterios de rendimiento y sincronía.
- Configurar display outputs y organizar un proyecto multipantalla.
- Diagnosticar red, sincronización, media server y reproducción.
- Preparar recuperación, backups y entrega de proyecto.

**Unidades y prácticas**

#### 1. Arquitectura WATCHOUT y entorno de trabajo

- Producer, display servers, WATCHPAX y roles de cada nodo según versión/licencia.
- Estructura del show, assets, media, timelines, cues y convenciones de nombres.
- Inventario de hardware, software, firmware, licencias y compatibilidad.

**Práctica:** Crear un proyecto de entrenamiento y documentar nodos, versiones, licencias y red.

**Evidencia exigida:** Ficha de sistema y estructura de proyecto.

#### 2. Media pipeline y rendimiento

- Códecs, contenedores, resolución, frame rate, bitrate, audio y alpha: distinguir propiedades del archivo.
- Transcodificación, naming, relink, almacenamiento y pruebas de lectura sostenida.
- Optimización de medios y prevención de cuellos de botella de disco, CPU, GPU y red.

**Práctica:** Preparar una librería de medios con varias resoluciones y diagnosticar un archivo que no reproduce de forma fluida.

**Evidencia exigida:** Media report y matriz de compatibilidad.

#### 3. Displays, canvas y composición

- Configuración de displays físicos, superficies, mapping y coordenadas.
- Timeline, capas, cues, transiciones, loops y contenido sincronizado.
- Señales de prueba, geometría, alineación y validación de cada salida.

**Práctica:** Diseñar un show de tres superficies con contenido continuo y cues coordinados.

**Evidencia exigida:** Show file, mapa de displays y cue list.

#### 4. Cluster, red y sincronización

- Topología de red, direccionamiento, NICs, switches y separación de tráfico según diseño.
- Sincronización entre servidores; reloj, referencia y opciones disponibles según la instalación.
- Monitorización de salud, temperatura, almacenamiento, carga y estado de media servers.

**Práctica:** Diagnosticar una pérdida de sincronía simulada y documentar la evidencia antes de intervenir.

**Evidencia exigida:** Diagrama de red y checklist de monitorización.

#### 5. Redundancia y recuperación

- Backups de show, media y configuración; copias verificadas antes de la función.
- Estrategia de failover y límites reales del hardware/versión: qué cambia y qué permanece visible.
- Procedimiento de reinicio/recuperación fuera de directo y plan de continuidad en show.

**Práctica:** Ensayar la caída de un nodo con un plan Main/Backup preparado y registrar el resultado medible.

**Evidencia exigida:** Runbook de continuidad y reporte de test.

**Proyecto final:** Proyecto multipantalla de tres servidores: arquitectura, media pack, timelines, mapping, plan IP, sincronía, recuperación, prueba de estrés y manual de operación.

**Evaluación:** Media 20%, proyecto 25%, laboratorio de sincronización 30%, ejercicio de recuperación 25%.

**Servicios que debe incluir la matrícula:** 48 horas, práctica sobre WATCHOUT/WATCHPAX o simulación reproducible, revisión del show y defensa de operación.

**Documentación de referencia del fabricante**

- [Dataton · Help Center](https://www.dataton.com/help-center) — WATCHOUT User Guides, WATCHPAX manuals, release notes y Dataton Academy.
- [Dataton · WATCHOUT 7 Downloads](https://www.dataton.com/downloads/watchout7) — Descargas, requisitos y versión disponible. Verificar la versión que utiliza el show.
- [Dataton · WATCHOUT](https://www.dataton.com/watchout) — Descripción de producción multipantalla, reproducción y composición de displays.

---

### Curso 05 — Fibra óptica y transporte CVT4K: instalación, medición y diagnóstico

- **Nivel:** Operador avanzado · Especialista de transporte
- **Carga lectiva propuesta:** 36 horas
- **Requisitos:** Fundamentos de señal y redes. Curso 1 recomendado.
- **Enfoque:** Aprende a tratar la fibra como un enlace de ingeniería: inspeccionar, limpiar, identificar, medir y diagnosticar con presupuesto óptico documentado.

**Competencias de salida**

- Distinguir variantes CVT4K y componentes ópticos por referencia exacta.
- Aplicar inspección, limpieza, protección y trazabilidad de conectores.
- Calcular presupuesto óptico solo con parámetros de transmisor, receptor, fibra y conectores de ficha.
- Localizar fallos de enlace con instrumentos y un método de aislamiento.

**Unidades y prácticas**

#### 1. Fundamentos de fibra y componentes

- Singlemode/multimode, longitudes de onda, transceptores, conectores y pulido.
- Diferencias entre variantes de CVT4K, referencias de SFP y compatibilidad: leer etiqueta y datasheet.
- Potencia óptica, pérdida de inserción, retorno y márgenes de enlace.

**Práctica:** Identificar los componentes de un kit real y construir una tabla de compatibilidad basada en modelos y fichas.

**Evidencia exigida:** Lista de materiales y matriz de compatibilidad.

#### 2. Inspección, limpieza y manipulación

- Inspección de extremo con microscopio adecuado y criterio de aceptación.
- Limpieza one-click/swab según conector y procedimiento; inspeccionar de nuevo.
- Tapas, radio de curvatura, tensión mecánica, enrollado, rutas y almacenamiento.

**Práctica:** Ciclo de inspección-limpieza-inspección en latiguillos de práctica; documentar antes y después.

**Evidencia exigida:** Registro de inspección y cadena de custodia del latiguillo.

#### 3. Presupuesto óptico y pruebas

- Presupuesto de potencia en dB: sumar pérdidas de fibra, conectores, empalmes y margen.
- Diferenciar pérdida estimada, medida y sensibilidad/overload del receptor.
- Uso de fuente y medidor de potencia y OTDR cuando aplique y con personal formado.

**Práctica:** Calcular un enlace de laboratorio con fichas reales, medirlo y comparar resultado con el cálculo.

**Evidencia exigida:** Cálculo reproducible con fuentes y medición.

#### 4. CVT4K: despliegue y diagnóstico

- Identificar CVT4K-M/CVT4K-S u otra variante exacta y verificar manual, firmware y módulos.
- Rutas, redundancia, alarmas, temperatura, ventilación y límites especificados por fabricante.
- Diagnóstico por segmentos: sustituir un único elemento cada vez, documentar y restaurar.

**Práctica:** Resolver pérdida intermitente simulada: construir árbol de fallos y aislar patch, transceptor, ruta o equipo.

**Evidencia exigida:** Árbol de diagnóstico y reporte de enlace.

**Proyecto final:** Diseño y aceptación de dos enlaces ópticos de show con BOM, referencias, presupuesto óptico, mediciones, backup y protocolo de avería.

**Evaluación:** Inspección 25%, cálculo 25%, prueba instrumental 25%, diagnóstico/documentación 25%.

**Servicios que debe incluir la matrícula:** 36 horas, prácticas instrumentales, hojas de presupuesto óptico y revisión individual.

**Documentación de referencia del fabricante**

- [NovaStar · Centro de descargas](https://www.novastar.tech/download/data.html?catid=7&typeid=) — Buscar manual, firmware y ficha por referencia CVT4K exacta.
- [Índice técnico CVT4K-M / CVT4K-S](https://www.glmedia.tech/es/ayuda-tecnica/descargas-novastar/) — Índice de documentos. Confirmar siempre con la ficha oficial y la etiqueta del equipo.

---

### Curso 06 — Taller de reparación LED y electrónica SMD

- **Nivel:** Especialista de taller
- **Carga lectiva propuesta:** 56 horas
- **Requisitos:** Experiencia básica en electrónica recomendable. La intervención en fuentes de red y circuitos de potencia queda limitada a personal cualificado.
- **Enfoque:** Aprende a recibir un equipo averiado, reproducir el fallo, aislar la causa, reparar lo que corresponde y devolverlo con trazabilidad y pruebas.

**Competencias de salida**

- Preparar un puesto ESD y seleccionar herramientas de medida y retrabajo.
- Diagnosticar fallos de módulos, conectores y placas con un procedimiento reproducible.
- Ejecutar prácticas SMD en placas didácticas desenergizadas y verificar uniones.
- Redactar un informe de reparación, trazabilidad y control de calidad.

**Unidades y prácticas**

#### 1. Seguridad, ESD y método de taller

- Riesgos eléctricos, energía almacenada, condensadores, aislamiento y límites del técnico.
- Pulsera, alfombrilla, puesta a tierra ESD, almacenamiento y control de humedad.
- Recepción: síntoma, condiciones, número de serie, fotos, historial y autorización de intervención.

**Práctica:** Montar un puesto de trabajo ESD y completar un parte de recepción con evidencia.

**Evidencia exigida:** Checklist ESD y orden de trabajo.

#### 2. Instrumentación y diagnóstico

- Multímetro: continuidad, resistencia, diodo y medidas de baja tensión en prácticas seguras.
- Fuente de laboratorio con límite de corriente, carga electrónica y osciloscopio: usos y límites.
- Árbol de fallos: inspección visual, conectores, alimentación secundaria y señal.

**Práctica:** Localizar fallos introducidos en placas de entrenamiento desenergizadas y de baja tensión.

**Evidencia exigida:** Mapa de medidas y diagnóstico causa-raíz.

#### 3. Soldadura SMD y retrabajo

- Geometría de pads, componentes, polaridad, perfiles térmicos y selección de punta/boquilla.
- Soldadura, desoldado, hot air, flux, limpieza y prevención de levantamiento de pads.
- Inspección con lupa/microscopio y criterios de aceptación de uniones.

**Práctica:** Reemplazar componentes SMD en placa didáctica de baja tensión, inspeccionar y documentar.

**Evidencia exigida:** Registro de práctica y fotos microscópicas.

#### 4. Módulos, conectores y placas LED

- Inspección de diodos, módulos, HUB, flat cables, conectores y pistas.
- Pruebas cruzadas controladas para diferenciar módulo, cable, receiving card y alimentación.
- Reparaciones permitidas, repuesto compatible y registro de componente.

**Práctica:** Resolver una avería de módulo con sustitución controlada y prueba de banco.

**Evidencia exigida:** Informe de diagnóstico y trazabilidad del repuesto.

#### 5. Verificación, burn-in y garantía

- Pruebas funcionales, patrones, temperatura y estabilidad bajo condiciones documentadas.
- Criterios de aceptación, fotografías, versiones y control de calidad.
- Cuándo no reparar en taller y escalar a SAT/fabricante por seguridad o garantía.

**Práctica:** Ejecutar test final en banco y redactar certificado interno de reparación.

**Evidencia exigida:** Hoja QC y reporte de devolución.

**Proyecto final:** Reparación de una placa de entrenamiento con fallo preinstalado: diagnóstico causa-raíz, retrabajo SMD, mediciones seguras, prueba de banco y reporte técnico.

**Evaluación:** Seguridad/ESD 20%, diagnóstico 25%, retrabajo 30%, prueba y trazabilidad 25%.

**Servicios que debe incluir la matrícula:** 56 horas, puesto de soldadura y placas didácticas, consumibles de práctica, tutoría de taller y evaluación de destreza.

**Documentación de referencia del fabricante**

- [IPC · Normas de fabricación y reparación electrónica](https://www.ipc.org/) — Consultar la norma aplicable y la cualificación requerida antes de adoptar criterios de aceptación.

---

### Curso 07 — Diseño técnico integral de festival: rider, redundancia y dirección de vídeo

- **Nivel:** Máster · Proyecto integrador
- **Carga lectiva propuesta:** 64 horas
- **Requisitos:** Cursos 1-5 o experiencia equivalente en pantalla LED, procesado y operación de show.
- **Enfoque:** Convierte un briefing artístico en un diseño técnico ejecutable: pantallas, procesado, playback, fibra, potencia, redundancia, operación y documentación de entrega.

**Competencias de salida**

- Redactar y defender un rider técnico completo.
- Dibujar una topología de señal Main/Backup y definir puntos de conmutación.
- Calcular píxeles, salidas, cargas y presupuesto eléctrico/óptico desde fichas reales.
- Entregar un paquete de producción, commissioning, plan de riesgos y runbook.

**Unidades y prácticas**

#### 1. Briefing, site survey y rider

- Convertir objetivo escénico, contenido y restricciones de venue en requisitos medibles.
- Planos, medidas, visibilidad, estructura y coordinación con rigging, eléctrica, vídeo y producción.
- Rider: equipos, cantidades, referencias, responsabilidades, ventanas de montaje y aceptación.

**Práctica:** Analizar el caso: pantalla central 14×5 m y dos laterales 4×6 m. Identificar datos que faltan antes de dimensionar.

**Evidencia exigida:** Rider v1, lista de preguntas al cliente y site survey.

#### 2. Cálculo LED, procesado y señal

- Área, pitch, resolución por superficie y pixel map; límites de procesador y salidas.
- Matriz de fuentes, formatos, frame rates, EDID, canvas, layers y salidas.
- Dimensionar H9/Aquilon con tarjetas instaladas y fichas del equipo concreto.

**Práctica:** Construir un diagrama de señal con cada conversión, interfaz y punto de monitorización.

**Evidencia exigida:** Signal flow, pixel map y matriz de I/O.

#### 3. Main/Backup y continuidad

- Redundancia de fuente, procesador, transporte, alimentación y playback: distinguir redundancia real de duplicidad parcial.
- Failover: condición de disparo, operador responsable, tiempo esperado, impacto visible y rollback.
- Ensayos de fallo y registro de aceptación con cliente.

**Práctica:** Diseñar un FMEA de fallos y demostrar una conmutación ensayada en maqueta/simulador.

**Evidencia exigida:** Diagrama Main/Backup, FMEA y runbook.

#### 4. Potencia, fibra y red

- Cálculo de cargas por placa, simultaneidad y escenarios de consumo; coordinación con instalador eléctrico autorizado.
- Presupuesto óptico con pérdidas y margen desde datasheets de transmisores/receptores y fibra.
- Plan IP, VLAN, switch, puertos, etiquetado y monitorización.

**Práctica:** Preparar memoria de cálculo con todos los supuestos explicitados y revisión por los responsables competentes.

**Evidencia exigida:** Load schedule, optical budget e IP/port plan.

#### 5. Operación, ensayos y entrega

- Call sheet, run of show, cue sheet, matriz de comunicación y control de versiones.
- Commissioning, pruebas de contenido, lip-sync, sincronía y estrés acordado.
- Desmontaje, reporte QR, handover, inventario y revisión post-evento.

**Práctica:** Presentar una defensa técnica de 20 minutos y responder a tres cambios de última hora del cliente.

**Evidencia exigida:** Dossier final, planos, checklists y presentación de defensa.

**Proyecto final:** Dossier de festival listo para producción: rider, planos, BOM, signal flow, Main/Backup, cálculos con referencias, IP plan, riesgos, cronograma, run of show y plan de aceptación.

**Evaluación:** Ingeniería y cálculos 30%, redundancia/seguridad 25%, paquete documental 20%, defensa oral y simulación de cambios 25%.

**Servicios que debe incluir la matrícula:** 64 horas, dos revisiones del director técnico, defensa de proyecto, plantillas descargables y una repetición de evaluación.

**Documentación de referencia del fabricante**

- [NovaStar · H9 y documentación](https://www.novastar.tech/product/detail.html?catid=3&id=39) — Capacidad y límites según tarjetas y versión instaladas.
- [Analog Way · Aquilon C+](https://www.analogway.com/products/aquilon-cplus) — Capacidades de procesamiento y tarjetas según configuración real.
- [Dataton · Help Center](https://www.dataton.com/help-center) — Manuales WATCHOUT y WATCHPAX para el sistema concreto.

---

## Requisitos académicos comunes

1. Cada lección debe convertirse en material completo: explicación técnica, diagramas, procedimiento, errores frecuentes, checklist y preguntas de comprobación; no basta con el título del tema.
2. Cada práctica debe definir equipo y versión, prerequisitos, entorno seguro, pasos, criterio de aceptación, evidencia que entrega el alumno y rúbrica de corrección.
3. No se inventan cifras ni parámetros. Para NovaStar H9/NovaLCT, CVT4K, Aquilon C+ y WATCHOUT se cita la ficha y manual de la referencia exacta, versión de firmware y configuración instalada.
4. Los cálculos eléctricos y ópticos deben indicar supuestos, fuente de datos, márgenes y persona responsable de validar. La formación no autoriza a intervenir en instalaciones eléctricas o estructurales fuera de la habilitación correspondiente.
5. La evaluación de seguridad es excluyente. Una respuesta que recomiende anular protecciones, intervenir sin aislar, mirar fibra activa o cambiar parámetros críticos en directo sin plan de reversión no puede aprobar.
6. El diploma se describe como acreditación privada de competencias de SHOW OS By Muelle; no como título oficial homologado ni certificación oficial de fabricante.

## Condiciones mínimas para abrir venta

- Completar los apuntes/lecturas de todas las lecciones y revisión editorial técnica.
- Crear recursos de alumno: plantillas, planos, hojas de cálculo, archivos de prácticas y guías de laboratorio.
- Confirmar acceso a equipos reales o simuladores autorizados y reservar horas de instructor.
- Publicar perfil y experiencia de instructores, calendario, política de evaluación, repetición, cancelación y soporte.
- Probar el seguimiento de alumnos, guardado de evidencias y emisión/verificación de certificados.
- Revisar costes reales de hardware, instructor, sala, consumibles, licencias, seguros, impuestos y soporte antes de fijar el margen.
