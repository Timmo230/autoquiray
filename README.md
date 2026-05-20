# AUTOQUIRAY

Plataforma web de gestión para una autoescuela, desarrollada como **Proyecto Intermodular** del ciclo de grado medio **Sistemas Microinformáticos y Redes (2º SMR)** del IES Saladillo (Algeciras), curso 2025/2026.

El proyecto abarca dos capas:

- **Infraestructura de red** — segmentación en VLANs, dominio Active Directory, DHCP, almacenamiento y copias de seguridad (simulada en Cisco Packet Tracer y desplegada parcialmente en el aula).
- **Aplicación web** — gestión de tests teóricos, reserva de clases prácticas, consultas alumno–profesor y paneles de control por rol.

> Proyecto académico/ficticio. La documentación de entrega está en [`entrega/`](entrega/).

---

## Stack

| Capa | Tecnologías |
|------|-------------|
| Backend | Laravel 12, PHP 8.2, Eloquent, Blade, Composer |
| Frontend | Bootstrap 5, SCSS, JavaScript, Vite, Tailwind 4, Axios |
| Servidor | Apache 2.4 + PHP-FPM, MariaDB 10.11, Ubuntu Server |
| Dominio | Windows Server (Active Directory + DHCP) |
| Analítica | Plausible Analytics (Docker) |
| Redes | VLANs 802.1Q, switch capa 3, Cisco Packet Tracer |
| DevOps | Git, GitHub, GitHub Actions, Let's Encrypt / CA local |

## Roles

Tres roles, resueltos vía `users → user_is_assigned_types → types` y aplicados por `RoleMiddleware`:

- **student** — tests teóricos, resultados, reserva de clases, consultas, configuración.
- **teacher** — dashboard de alumnos, crear tests, crear clases, responder consultas.
- **administrator** — dashboard de profesorado, crear usuarios, crear horarios.

## Arquitectura

- **Auth + rol:** `Auth::attempt()` + verificación de rol en `RoleMiddleware`.
- **Tests:** profesor crea test → alumno responde (`student_selects_options`) → resultado en `student_completes_tests`.
- **Clases:** admin crea `timetables` → profesor crea `classes` → alumno reserva (`students_reserves_classes`). Cancelación bloqueada si la clase ha comenzado.
- **Consultas:** alumno envía (`student_questions`) → profesor responde (`answers`).
- **Dashboards:** SQL agregado en `app/Services/EmployeesPlaceService.php`.

## Requisitos

- PHP 8.2+
- Composer
- Node.js 20+ y npm
- MariaDB 10.11 / MySQL 8.0

## Instalación

```bash
git clone git@github.com:Timmo230/autoquiray.git
cd autoquiray
composer run setup          # instala dependencias, copia .env, key, migra y seedea
```

Equivalente manual:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
```

## Desarrollo

```bash
composer run dev   # servidor + cola + logs + vite en paralelo
# o por separado:
php artisan serve
npm run dev
```

## Tests y lint

```bash
php artisan test                       # toda la suite
php artisan test tests/Feature/...     # un archivo
./vendor/bin/pint                      # lint PSR-12
```

## Despliegue (producción)

El servidor sirve la app por **HTTPS**. Scripts y configuración en [`entrega/06_scripts/`](entrega/06_scripts/):

- `setup-https.sh` — certificado (Let's Encrypt para dominio público; CA local + cert por IP para red interna).
- `autoquiray.apache.conf` — VirtualHost Apache (:80 redirige a :443).
- `backup-autoquiray.sh` / `restore-autoquiray.sh` — copias cifradas con rotación.

Pipeline CI/CD en [`entrega/07_cicd/`](entrega/07_cicd/): `ci.yml` (Pint + PHPUnit + build) y `deploy.yml` (deploy por SSH).

## Estructura

```
app/            Controladores, modelos, middleware, servicios
resources/      Vistas Blade, SCSS, JS, imágenes
routes/web.php  Rutas + middleware de rol
database/       Migraciones, factories, seeders
entrega/        Documentación final del proyecto (memoria, fases, planificación, red)
```

## Notas del esquema

- PKs mixtas: algunas tablas usan UUID/string, otras autoincremental.
- Columna histórica `menssage` (doble `s`) en varias tablas; no renombrar sin migración.
- Mezcla de Eloquent y `DB::table()` con joins manuales en los dashboards.
- Nombres de tablas/columnas mezclan español e inglés.

## Autores

- Matías Álvaro Quiriquino El Ashuh
- Yeray Sampalo Pérez

Tutor: José Luis González Luna — IES Saladillo, Algeciras.
