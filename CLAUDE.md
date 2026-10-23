# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview
 
"Ser" es un sistema de gestión de clínica/consultorio médico (pacientes, citas, consultas, caja/facturación y farmacia) escrito en PHP procedural puro con backend MySQL/MariaDB. No hay proceso de build, gestor de paquetes ni framework para el código de la aplicación — las páginas son archivos `.php` servidos directamente por Apache y renderizados del lado del servidor con HTML/PHP inline. La única dependencia externa (vendored) es `lib/dompdf` (usada para generación de PDF, por ejemplo recibos y reportes), gestionada vía Composer únicamente dentro de esa subcarpeta.
 
El estilo/JS del frontend proviene de Materialize CSS + jQuery, cargados desde `static/` (`static/css`, `static/js`, `static/icons`, `static/bootstrap`).
 
## Ejecutar la aplicación
 
No hay servidor de desarrollo ni punto de entrada por CLI — esto corre bajo Apache (el proyecto vive en `C:\ApacheServer\htdocs\Ser`, es decir, servido desde `http://localhost/Ser/`). No hay pruebas automatizadas, linters ni comandos de build configurados en este repositorio.
 
Los archivos de conexión a base de datos están en `.gitignore` y deben existir localmente para que la aplicación funcione:
- `app/logic/conn.php` — base de datos principal (`mysqli`), usada por la mayoría de los módulos.
- `app/logic/conn_recovery.php` — una segunda base de datos, legacy/de solo lectura en su mayor parte, usada únicamente por las pantallas de "recovery" (datos históricos).
- `recep/config.php` — configuración del módulo de recepción.
Si estos archivos faltan, la mayoría de las páginas fallarán (fatal error) en el `include_once`. Nunca subir credenciales reales a ninguna de estas rutas.

`.gitignore` también excluye `/.claude`, `/.serena` y `/specs` — este último se usa para notas/specs de trabajo en curso que no deben versionarse (ver "Integraciones pendientes" más abajo).
 
## Arquitectura
 
### Distribución de módulos (por rol/área de URL)
 
La aplicación está dividida en carpetas de nivel superior, cada una correspondiente a un rol de inicio de sesión (`niveles.id` en la BD) y su propia ruta de redirección de login:
 
| Carpeta | Rol (`nivel`) | Propósito |
|---|---|---|
| `recep/` | 1 (recepción), también 7 (admin) | Pacientes, citas/agenda, recetas (`receta/`) |
| `consulta/` | 1 o 2 (recepción/médico) | Pantallas de consulta médica, historial clínico |
| `caja/` | 3 (caja), también 7 (admin) | Caja: cobros, recibos, cortes de caja (`corte_caja`), reembolsos |
| `farma/` | 5 (farmacia), también 7 (admin) | Farmacia: etiquetas, medicamentos homeopáticos |
| `adm/` | 7 (admin) | Administración de usuarios/catálogos, reportes de corte de caja y recovery |
| `app/` | — | Lógica compartida/transversal (`app/logic/`): sesión, conexiones a BD, contadores de citas |
| `lib/dompdf` | — | Librería de PDF vendored (tiene su propio composer.json/vendor — no editar a mano) |
| `bd/` | — | Dumps/esquema SQL (`ser.sql` es la referencia canónica del esquema) |
| `specs/` | — | Especificaciones de integraciones pendientes (ignorado por git salvo el propio archivo local; ver sección de integraciones pendientes) |
 
Los roles referenciados en `niveles` pero sin carpeta correspondiente todavía (`terapias`=4, `almacen`=6) no están implementados. El nav de `adm/index.php` ya tiene un enlace placeholder "Inventarios" (`href=""`) para un sistema externo aún no conectado (ver "Integraciones pendientes" más abajo).
 
Cada carpeta de módulo típicamente contiene:
- Un gate `index.php` que hace `session_start()`, verifica `$_SESSION['nivel']`, y redirige a `../index.php` (login) si no está autorizado.
- Un archivo `*_sections.php` (p. ej. `recep_sections.php`, `caja_sections.php`) que define fragmentos HTML compartidos (nav/footer) como variables de cadena PHP (`$nav_recep`, `$footer_recep`, etc.), incluido por las páginas de ese módulo.
- Una subcarpeta `logic*/` o `logic_*` (p. ej. `recep/logic_recep`, `caja/logic_caja`, `adm/logic`) que contiene endpoints de procesamiento de formularios/AJAX (manejadores de guardar/actualizar/buscar) invocados vía `<form action="...">` o AJAX de jQuery desde la página correspondiente.

### Patrón de autenticación
 
El login (`index.php` en la raíz del repositorio) hace POST a `app/logic/session.php`, que consulta `user` unida con `niveles` por igualdad en texto plano (sin hash de contraseña) y establece variables de sesión: `$_SESSION['id']`, `name_usuario`, `nivel`, `agenda`, `hist_clin_med`. Una contraseña por defecto (`12345678`) fuerza una redirección a `update_password.php`. Cada página protegida vuelve a verificar `$_SESSION['nivel']` por sí misma (no hay middleware/router compartido) — al agregar una página nueva, copiar el bloque de guardia de un archivo hermano en el mismo módulo en lugar de inventar un patrón nuevo.
 
Los endpoints AJAX bajo carpetas `logic*/` repiten la misma verificación de sesión/rol y devuelven `json_encode(['success' => ..., 'mensaje' => ...])` en lugar de redirigir.
 
### Acceso a datos
 
Todo el acceso a BD es `mysqli` puro (sin query builder/ORM). Las consultas se construyen mediante interpolación de cadenas; el código existente a veces escapa la entrada con `mysqli_real_escape_string`/`real_escape_string` y a veces no. Al tocar código de construcción de consultas, usar `mysqli_real_escape_string` (o sentencias preparadas con `mysqli::prepare`) para cualquier entrada de usuario interpolada — seguir los ejemplos más defensivos que ya existen en el código (p. ej. `recep/logic_recep/busca_pacientes_ajax.php`) en lugar de los más antiguos y sin escapar.
 
Hay dos bases de datos:
- BD principal (vía `conn.php`) — datos operativos en vivo: `paciente`, `cita`, `consulta`, `caja`, `cortes_caja`, `user`, `niveles`, `sueros`, `terapias`, `med_homeopaticos`, `med_orales`, `rec_*` (tablas de línea de artículos recetados), etc. Esquema completo en `bd/ser.sql`.
- BD de recovery (vía `conn_recovery.php`, BD `ser_recovery`) — un conjunto de datos separado y más antiguo, expuesto de forma mayormente de solo lectura a través de pantallas de "recovery" para consultar registros históricos migrados de un sistema anterior.

### Módulo "Recovery" (datos históricos)

El flujo de recovery está duplicado en tres módulos, cada uno con sus propias pantallas y su propio endpoint de búsqueda AJAX (no hay un helper compartido — al modificar la lógica de búsqueda/detalle de recovery, replicar el cambio en los tres):

- `recep/`: `busca_paciente.php` → `detalle_paciente.php`/`detalle_paciente_recovery.php` → `detalle_cita_recep_recovery.php`, con búsqueda AJAX en `recep/logic_recep/busca_pacientes_ajax.php`.
- `consulta/`: `busca_paciente_recovery.php` → `detalle_paciente_recovery.php` → `detalle_consulta_recovery.php`, con búsqueda AJAX en `consulta/logic_consulta/busca_pacientes_recovery.php`.
- `adm/reports/`: `corte_caja_recovery.php` → `detalle_corte_recovery.php` (listados en `adm/reports/reports.php` junto a los reportes de corte de caja "en vivo").

Todos estos endpoints consultan la tabla `busca_pacientes` (u homólogas) contra `conn_recovery.php`, exigen `strlen($busqueda) >= 3`, escapan con `real_escape_string`, y devuelven `json_encode(['success' => ..., ...])`. Sigue este patrón (guardia de sesión/rol + validación de longitud + escape + JSON) al tocar o extender estas pantallas.

## Integración SSO con Ser-Inventarios

El enlace "Inventarios" del nav de `adm/index.php` (solo visible/accesible para `nivel == 7`) apunta a `adm/logic/open_session_inventarios.php`, implementado según `specs/open_session_ser_inventarios.md` (no versionado). El handler:
1. Verifica sesión activa y `nivel == 7` (sin destruirla ni tocarla — solo lectura).
2. Consulta `user.usuario` vía `conn.php` (la sesión solo guarda el nombre completo, no el usuario de login).
3. Genera un token opaco (`bin2hex(random_bytes(32))`, 64 hex chars) e inserta una fila en `sso_tokens` (BD `ser_inventario`, vía la tercera conexión `app/logic/conn_inventario.php`) con `erp_user_id`, `username`, `nombre_completo`, `rol = 'Administrador'` y `expires_at = NOW() + INTERVAL 60 SECOND`.
4. Redirige (302) a `http://{$_SERVER['SERVER_NAME']}:8080/Ser-Inventarios/auth/sso?token=...` — el host se toma dinámicamente de la petición porque ambos sistemas viven en el mismo servidor (local: `localhost`; producción: `192.168.68.88`) y solo cambia el puerto.

`app/logic/conn_inventario.php` sigue el mismo patrón que `conn.php`/`conn_recovery.php` (gitignored, debe existir localmente). En este entorno usa las mismas credenciales que `conn.php` apuntando a la BD `ser_inventario`; en producción el host de esa conexión se ajusta manualmente si el servidor de BD de inventarios no es el mismo.

### PDF/impresión
 
Los recibos, reportes de "corte de caja" y etiquetas de farmacia se renderizan a PDF vía `lib/dompdf` (ver `caja/print_corte_caja.php`, `adm/reports/detalle_corte.php`, `farma/logic/print_pdf_etiquetas.php`).
 
## Convenciones a seguir
 
- El texto de la UI, nombres de variables y comentarios están en español — mantener esta consistencia.
- Las páginas nuevas en un módulo deben hacer `include_once` del `*_sections.php` de ese módulo para nav/footer, y `include_once '../app/logic/conn.php'` (o `conn_recovery.php` para pantallas de recovery) para el acceso a BD, siguiendo el patrón de archivos hermanos existentes.
- Mantener explícita la guardia de sesión/rol por página (como se describió arriba) en lugar de introducir un include de autenticación compartido, para mantener consistencia con el resto del código base.
 
> [NOTE]
> ERP Ser es un proyecto legacy, mismo que en un futuro se estará renovando bajo un stack y prácticas de desarrollo actualizadas, así como en la actualización y unificación de diversos modulos externos (Recursos Humanos, Firma de documentos digitales, Signos Vitales y aplicación de terapias e Inventarios) ya desarrollados con el fin de generar un sistema integral.
