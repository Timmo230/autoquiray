# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Full setup from scratch
composer run setup

# Start all dev processes (server + queue + logs + vite)
composer run dev

# Run tests
composer test
# or
php artisan test

# Single test file
php artisan test tests/Feature/SomeTest.php

# Seed database
php artisan db:seed

# Lint PHP (Laravel Pint)
./vendor/bin/pint

# Frontend only
npm run dev
npm run build
```

## Architecture

Laravel 12 app. PHP 8.2+. Three roles: `student`, `teacher`, `administrator`.

**Auth & roles:** `Auth::attempt()` plus explicit role check at login. `RoleMiddleware` queries `users → user_is_assigned_types → types` to gate every protected route. Entry: [routes/web.php](routes/web.php) → [RoleMiddleware.php](app/Http/Middleware/RoleMiddleware.php).

**User hierarchy (DB):** `users` → `students` / `employees` → `teachers` / `administrators`. Role resolution helper in [app/Support/UserRoleManager.php](app/Support/UserRoleManager.php).

**Tests (teoricos):** Teacher creates test → student answers → options saved in `student_selects_options` → score calculated → result stored in `student_completes_tests`. Key controllers: `CrearTestsController`, `hacerTestController`, `haciendoTestController`, `ResultsController`.

**Clases (practicas):** Admin creates `timetables` → teacher creates `classes` from a timetable → student reserves via `students_reserves_classes`. Cancellation blocked once class has started. Controllers: `ClassesController`, `CrearClassController`, `CreateTimetableController`.

**Consultas:** Student submits via `ContactController` → stored in `student_questions`. Teacher views and replies in `EmployeesPlaceController`. Replies in `answers` table.

**Dashboards:** Aggregated SQL queries in [app/Services/EmployeesPlaceService.php](app/Services/EmployeesPlaceService.php), called from `EmployeesPlaceController`.

## Frontend

Assets are loaded manually via Blade partials — NOT through the Vite pipeline despite Vite being declared:
- CSS: `asset('resources/css/...')` in [resources/views/partials/links.blade.php](resources/views/partials/links.blade.php)
- Bootstrap JS: from `public/node_modules/bootstrap/...`
- Custom JS: direct script tags from `resources/js/...`

Check [partials/links.blade.php](resources/views/partials/links.blade.php) and [partials/scripts.blade.php](resources/views/partials/scripts.blade.php) before touching any frontend asset.

Plausible analytics events wired in `partials/scripts.blade.php` via `data-plausible-event` / `data-plausible-submit` attributes and `window.trackEvent`. Currently points to a local IP — not production-safe.

## Known Gotchas

- **Mixed PK types:** some tables use string/UUID PKs, others use numeric auto-increment (`classes` uses `id()`). Check migrations before writing raw queries or relations.
- **Typo in schema:** column `menssage` (double `s`) exists in multiple tables — don't "fix" it without a migration.
- **Mixed Eloquent / DB::table:** dashboards use raw `DB::table(...)` with manual joins. Aggregation logic lives in `EmployeesPlaceService`, not models.
- **Mixed language naming:** table names, columns, and controller names mix Spanish and English inconsistently.
