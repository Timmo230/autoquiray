# AUTOQUIRAY

Aplicacion web de autoescuela construida con Laravel. El proyecto gestiona alumnos, profesores y administradores, con tests teoricos, reserva de clases, consultas entre alumno y profesor y paneles internos de seguimiento.

Este `README` esta pensado como documento de orientacion rapida para mantenimiento. La idea es que cualquier desarrollador o IA pueda abrirlo y saber en pocos minutos:

- que hace el proyecto
- donde estan las piezas importantes
- como arrancarlo
- que rutas y modulos existen
- donde hay decisiones tecnicas o deuda heredada

## Resumen Rapido

- Framework: Laravel 12
- PHP: `^8.2`
- Frontend declarado: Vite + Tailwind 4
- Frontend real en uso: Blade + CSS/JS cargados manualmente desde `resources/` y `public/node_modules`
- Base de datos: relacional, con migraciones y seeders propios
- Autenticacion: `Auth::attempt()` + sesion de rol activo + middleware de roles personalizado
- Roles de negocio:
  - `student`
  - `teacher`
  - `administrator`

## Cambios Recientes Relevantes

- El login ya no depende de elegir el rol en el propio formulario.
- Si un usuario tiene un solo rol asignado, entra directamente a su area.
- Si un usuario tiene varios roles, se le redirige a `GET /seleccionar-rol` para elegir el contexto de sesion.
- Se introdujo [`app/Support/UserRoleManager.php`](./app/Support/UserRoleManager.php) para centralizar roles disponibles, rol activo, limpieza de sesion y redirecciones por rol.
- El middleware de rol ahora valida el `active_role` de sesion y, si hace falta, fuerza la seleccion de rol.
- El alumno dispone de un panel de configuracion mas completo en `GET /alumno/configuracion` con perfil, seguridad, matriculas, examenes y resumen de actividad.
- La interfaz global ya usa mensajes flash animados y eventos de analitica disparados desde Blade y desde backend.

## Que Hace El Proyecto

AUTOQUIRAY es una plataforma para autoescuela con estos flujos principales:

- Landing publica con metricas y acceso a login.
- Login con resolucion automatica de rol o pantalla de seleccion de rol si la cuenta es multirol.
- Alumno:
  - ver tipos de test
  - hacer tests teoricos
  - ver resultados y test corregido
  - reservar y cancelar clases
  - gestionar perfil, matriculas, examenes y seguridad desde configuracion
  - enviar consultas al profesorado
- Profesor:
  - ver dashboard de alumnos
  - ver y responder consultas
  - crear tests
  - crear clases a partir de horarios existentes
- Administrador:
  - ver dashboard de profesores con metricas
  - consultar detalles de actividad
  - crear usuarios
  - crear horarios

## Mapa Del Proyecto

### Directorios importantes

- `app/Http/Controllers`
  Controladores principales de la aplicacion.
- `app/Http/Middleware`
  Middleware de roles.
- `app/Models`
  Modelos Eloquent del dominio.
- `app/Services`
  Consultas agregadas para dashboards internos.
- `resources/views`
  Vistas Blade reales de la app.
- `resources/css`
  CSS del proyecto.
- `resources/js`
  JS del proyecto.
- `routes/web.php`
  Rutas HTTP principales.
- `database/migrations`
  Esquema de base de datos.
- `database/seeders`
  Datos de ejemplo/inicializacion.
- `storage/models`
  Modelos 3D usados en la home.

### Archivos clave para orientarse rapido

- [`routes/web.php`](./routes/web.php)
  Punto de entrada principal para entender modulos y permisos.
- [`app/Http/Middleware/RoleMiddleware.php`](./app/Http/Middleware/RoleMiddleware.php)
  Control de acceso por rol.
- [`app/Http/Controllers/LoginController.php`](./app/Http/Controllers/LoginController.php)
  Login, logout, cambio inicial de contrasena y seleccion de rol.
- [`app/Support/UserRoleManager.php`](./app/Support/UserRoleManager.php)
  Gestion centralizada del rol activo y de los roles disponibles del usuario.
- [`app/Http/Controllers/HomeController.php`](./app/Http/Controllers/HomeController.php)
  Home publica y metricas.
- [`app/Http/Controllers/ClassesController.php`](./app/Http/Controllers/ClassesController.php)
  Reserva y cancelacion de clases.
- [`app/Http/Controllers/ResultsController.php`](./app/Http/Controllers/ResultsController.php)
  Correccion, guardado y visualizacion de resultados de tests.
- [`app/Http/Controllers/StudentSettingsController.php`](./app/Http/Controllers/StudentSettingsController.php)
  Configuracion del alumno, seguridad e inscripcion a examenes.
- [`app/Http/Controllers/EmployeesPlaceController.php`](./app/Http/Controllers/EmployeesPlaceController.php)
  Paneles de profesor/administrador y consultas de alumnos.
- [`app/Services/EmployeesPlaceService.php`](./app/Services/EmployeesPlaceService.php)
  Consultas agregadas de estadisticas y detalles.
- [`resources/views/partials/links.blade.php`](./resources/views/partials/links.blade.php)
  Carga de CSS global.
- [`resources/views/partials/scripts.blade.php`](./resources/views/partials/scripts.blade.php)
  Carga de JS global y eventos de analitica.
- [`resources/views/partials/flashMessages.blade.php`](./resources/views/partials/flashMessages.blade.php)
  Sistema global de avisos visuales persistidos en sesion.

## Rutas Y Modulos

### Publicas

- `GET /`
  Home publica.
- `GET /plausible-seed`
  Vista de depuracion relacionada con eventos de Plausible.

### Autenticacion

- `GET /login`
- `POST /login`
- `GET /seleccionar-rol`
- `POST /seleccionar-rol`
- `POST /logout`
- `POST /cambiar_contraseña`

### Alumno

- `GET /tipos_de_test`
- `GET /classes`
- `POST /classes`
- `DELETE /classes/{class}`
- `GET /alumno/configuracion`
- `POST /alumno/configuracion/perfil`
- `POST /alumno/configuracion/seguridad`
- `POST /alumno/configuracion/examenes/{exam}`
- `GET /contacto`
- `POST /contacto`
- `GET /hacer_tests`
- `GET /haciendo_test`
- `GET /resultados`
- `POST /resultados`
- `GET /test_corregido`

### Profesor

- `GET /teacher/dashboard`
- `GET /teacher/questions`
- `POST /teacher/questions/answer`
- `GET /crear_tests`
- `POST /crear_tests`
- `GET /create_classes`
- `POST /create_classes`

### Administrador

- `GET /admin/dashboard`
- `POST /admin/dashboard/stats`
- `POST /admin/dashboard/details`
- `GET /create_user`
- `POST /create_user`
- `GET /create_timetable`
- `POST /create_timetable`

## Arquitectura Funcional

### 1. Autenticacion y roles

El login usa `Auth::attempt()` con email y contrasena. Despues del login, el sistema consulta los roles realmente asignados al usuario y decide el contexto de sesion:

- si no tiene roles, se cierra la sesion y se devuelve error
- si tiene un solo rol, se guarda en sesion como `active_role` y se redirige automaticamente
- si tiene varios, se fuerza una seleccion explicita en `/seleccionar-rol`

El control se apoya en [`UserRoleManager.php`](./app/Support/UserRoleManager.php), que centraliza:

- `getAvailableRoles()`
- `getActiveRole()`
- `setActiveRole()`
- `clearRoleSession()`
- `syncRoleSession()`
- `redirectForRole()`

Tablas implicadas:

- `users`
- `types`
- `user_is_assigned_types`

El middleware [`RoleMiddleware.php`](./app/Http/Middleware/RoleMiddleware.php) valida el rol activo en sesion y evita entrar en areas cuyo contexto no coincide con el rol permitido.

### 2. Tests teoricos

Los tests se definen por profesor y contienen preguntas y opciones.

Tablas implicadas:

- `tests`
- `question_tests`
- `options`
- `student_selects_options`
- `student_completes_tests`
- `permissions_are_associated_test`

Flujo:

- el profesor crea un test
- el alumno lo responde
- se guardan opciones seleccionadas
- se calcula nota
- se guarda el resultado final
- el alumno puede ver el resumen y la correccion

### 3. Clases practicas

Las clases se construyen a partir de horarios (`timetables`) y se reservan por alumnos.

Tablas implicadas:

- `timetables`
- `classes`
- `students_reserves_classes`
- `permissions_are_tought_in_classes`

Flujo:

- administrador crea horarios
- profesor crea una clase asociada a un horario
- alumno reserva si hay plazas
- alumno puede cancelar mientras la clase no haya empezado

### 4. Consultas alumno-profesor

El alumno puede enviar un mensaje desde contacto. Los profesores lo visualizan en una bandeja y responden.

Tablas implicadas:

- `student_questions`
- `answers`

### 5. Dashboards internos

Profesor y administrador tienen paneles con consultas agregadas montadas con `DB::table(...)` y apoyadas por `EmployeesPlaceService`.

## Modelo De Datos

### Tablas principales

- `users`
  Usuario base del sistema.
- `students`
  Extension de usuario alumno.
- `employees`
  Extension de usuario empleado.
- `teachers`
  Extension de empleado profesor.
- `administrators`
  Extension de empleado administrador.
- `permissions`
  Permisos/licencias vinculadas a tests y clases.
- `tests`
  Tests creados por profesores.
- `question_tests`
  Preguntas de cada test.
- `options`
  Opciones de respuesta por pregunta.
- `student_completes_tests`
  Resultado global de un alumno en un test.
- `student_selects_options`
  Opciones marcadas por cada alumno.
- `timetables`
  Horarios disponibles.
- `classes`
  Clases practicas publicadas.
- `students_reserves_classes`
  Reservas de clases de alumnos.
- `student_questions`
  Consultas enviadas por alumnos.
- `answers`
  Respuestas del profesorado.
- `registers`
  Historico relacionado con examenes/notas.
- `exams`
  Examenes del dominio.
- `tutions`
  Tabla del dominio academico.

### Identificadores

No todo usa el mismo tipo de clave:

- varias tablas usan `string` como PK o FK con UUID/manual ids
- `classes` usa `id()` numerico autoincremental
- hay mezcla de IDs string y numericos en el modelo general

Eso es importante al tocar relaciones, validaciones o consultas SQL.

## Vistas Y Frontend

### Vistas reales

Las vistas activas estan en `resources/views`.

Subcarpetas relevantes:

- `auth/`
- `student/`
- `teacher/`
- `admin/`
- `partials/`

Vistas recientes especialmente relevantes:

- `resources/views/auth/selectRole.blade.php`
- `resources/views/student/settings.blade.php`
- `resources/views/partials/flashMessages.blade.php`

### Carga de assets

Aunque el proyecto declara Vite y Tailwind 4, la app actualmente sigue usando una estrategia heredada:

- CSS cargado desde Blade con `asset('resources/css/...')`
- Bootstrap JS cargado desde `public/node_modules/bootstrap/...`
- JS propios cargados como scripts directos desde `resources/js/...`

Archivos a revisar antes de tocar frontend:

- [`resources/views/partials/links.blade.php`](./resources/views/partials/links.blade.php)
- [`resources/views/partials/scripts.blade.php`](./resources/views/partials/scripts.blade.php)
- [`vite.config.js`](./vite.config.js)
- [`resources/js/app.js`](./resources/js/app.js)
- [`resources/css/app.css`](./resources/css/app.css)

### Analitica

Hay integracion de eventos con Plausible en `partials/scripts.blade.php`.

Puntos relevantes:

- define `window.trackEvent`
- dispara eventos por atributos `data-plausible-event`
- dispara eventos de formulario por `data-plausible-submit`
- reinyecta eventos de sesion flash desde backend
- actualmente se usa tambien para eventos de login, logout, contacto y CTA de home

Ademas, el proyecto tiene un sistema de mensajes flash globales en `partials.flashMessages`:

- renderiza avisos de `success`, `error` y errores de validacion
- persiste avisos breves en `sessionStorage` para mejorar transiciones entre recargas
- se inyecta desde `nav.blade.php`, por lo que afecta a gran parte de la navegacion autenticada y publica

Ahora mismo el script apunta a una IP local:

- `http://192.168.1.248:8000/js/script.js`

Esto parece configuracion de entorno local o privada, no una integracion generica de produccion.

## Seeders

Hay una bateria amplia de seeders para poblar practicamente todo el dominio:

- usuarios
- roles
- empleados
- alumnos
- profesores
- administradores
- tests
- preguntas
- opciones
- horarios
- clases
- reservas
- consultas
- respuestas

Archivo principal:

- [`database/seeders/DatabaseSeeder.php`](./database/seeders/DatabaseSeeder.php)

## Como Levantar El Proyecto

### Requisitos

- PHP 8.2+
- Composer
- Node.js + npm
- Base de datos configurada en `.env`

### Instalacion

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
```

### Opcional: datos de ejemplo

```bash
php artisan db:seed
```

### Desarrollo

En una terminal:

```bash
php artisan serve
```

En otra:

```bash
npm run dev
```

Laravel tambien trae un script combinado:

```bash
composer run dev
```

### Tests

```bash
php artisan test
```

o:

```bash
composer test
```

## Convenciones Y Realidad Del Codigo

### Lo que esta bastante claro

- estructura general por roles
- dominio principal del negocio
- separacion basica de vistas por area
- consultas agregadas centralizadas en parte del backoffice

### Lo que esta mezclado o heredado

- uso mixto de Eloquent y `DB::table(...)`
- nombres mezclando espanol e ingles
- typo heredado en varios campos: `menssage`
- controladores con nomenclatura irregular
- assets modernos declarados, pero pipeline real aun manual
- mezcla de claves UUID/string con IDs numericos

## Puntos De Entrada Recomendados Segun Tarea

### Si quieres tocar login/permisos

- `routes/web.php`
- `app/Http/Controllers/LoginController.php`
- `app/Http/Middleware/RoleMiddleware.php`
- `app/Support/UserRoleManager.php`

### Si quieres tocar configuracion del alumno

- `app/Http/Controllers/StudentSettingsController.php`
- `resources/views/student/settings.blade.php`
- `resources/css/studentSettings.css`
- tablas `tutions`, `exams`, `registers`, `student_completes_tests` y `students_reserves_classes`

### Si quieres tocar tests

- `app/Http/Controllers/CrearTestsController.php`
- `app/Http/Controllers/hacerTestController.php`
- `app/Http/Controllers/haciendoTestController.php`
- `app/Http/Controllers/ResultsController.php`

### Si quieres tocar clases

- `app/Http/Controllers/ClassesController.php`
- `app/Http/Controllers/CrearClassController.php`
- migraciones de `classes`, `timetables` y `students_reserves_classes`

### Si quieres tocar dashboard profesor/admin

- `app/Http/Controllers/EmployeesPlaceController.php`
- `app/Services/EmployeesPlaceService.php`
- vistas en `resources/views/teacher` y `resources/views/admin`

### Si quieres tocar frontend global

- `resources/views/partials/links.blade.php`
- `resources/views/partials/scripts.blade.php`
- `resources/views/partials/nav.blade.php`
- `resources/css/`
- `resources/js/`

## Riesgos Tecnicos A Tener En Cuenta

- El `README` original era el de Laravel y no documentaba nada del dominio.
- El frontend esta a medio camino entre Vite/Tailwind moderno y carga manual heredada.
- La sesion multirol esta resuelta a nivel de middleware y sesion, pero todavia conviene revisar politicas mas finas si se amplian permisos.
- La analitica Plausible esta acoplada a una IP concreta.
- Hay mucha logica SQL escrita a mano; cualquier refactor debe comprobar bien joins, group by y tipos de ID.
- Parte del dominio del alumno vive en consultas agregadas extensas dentro de `StudentSettingsController`, lo que puede crecer mal si se siguen anadiendo widgets a esa pantalla.

## Objetivo De Este Documento

Este archivo no intenta ser documentacion funcional para cliente. Su objetivo es servir como hoja de contexto de mantenimiento.

Si vas a ampliar el proyecto, lo razonable es actualizar este `README` cuando cambie al menos una de estas piezas:

- modulos
- rutas
- pipeline de assets
- autenticacion/autorizacion
- modelo de datos principal
