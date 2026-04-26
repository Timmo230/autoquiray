@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Rol | AUTOQUIRAY</title>
    @include('partials.links')
    <link rel="stylesheet" href="{{ asset('resources/css/login.css') }}">
    <style>
        .role-selection-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 9rem 1rem 3rem;
            background:
                radial-gradient(circle at top, rgba(52, 211, 153, 0.08), transparent 28%),
                linear-gradient(180deg, #0f172a 0%, #131b31 100%);
        }

        .role-selection-card {
            width: min(920px, 100%);
            padding: 1.5rem;
            border-radius: 1.75rem;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.94), rgba(30, 41, 59, 0.82));
            border: 1px solid rgba(148, 163, 184, 0.14);
            box-shadow: 0 30px 90px rgba(2, 6, 23, 0.42);
        }

        .role-selection-hero {
            position: relative;
            overflow: hidden;
            padding: 2rem 2rem 1.5rem;
            border-radius: 1.35rem;
            background:
                radial-gradient(circle at top right, rgba(52, 211, 153, 0.18), transparent 30%),
                linear-gradient(180deg, rgba(15, 23, 42, 0.98), rgba(20, 29, 52, 0.92));
            border: 1px solid rgba(148, 163, 184, 0.12);
        }

        .role-selection-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.18);
            color: #6ee7b7;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .role-selection-brand {
            display: flex;
            justify-content: center;
            margin: 1.25rem 0 1rem;
        }

        .role-selection-brand img {
            width: min(360px, 72vw);
            max-width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 16px 24px rgba(2, 6, 23, 0.32));
        }

        .role-selection-title {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3.6rem);
            line-height: 1.04;
            text-wrap: balance;
        }

        .role-selection-copy {
            width: min(600px, 100%);
            margin: 1rem auto 0;
            color: #cbd5e1 !important;
            font-size: 1.02rem;
            line-height: 1.7;
        }

        .role-selection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }

        .role-selection-grid form {
            margin: 0;
        }

        .role-selection-option {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            width: 100%;
            min-height: 210px;
            padding: 1.35rem;
            border-radius: 1.25rem;
            border: 1px solid rgba(148, 163, 184, 0.14);
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.84), rgba(30, 41, 59, 0.72));
            color: #f8fafc;
            text-align: left;
            transition: transform 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .role-selection-option:hover {
            transform: translateY(-3px);
            border-color: rgba(52, 211, 153, 0.28);
            box-shadow: 0 18px 40px rgba(2, 6, 23, 0.28);
            background: linear-gradient(180deg, rgba(17, 24, 39, 0.96), rgba(30, 41, 59, 0.88));
        }

        .role-selection-option-top {
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        .role-selection-icon {
            width: 3.1rem;
            height: 3.1rem;
            border-radius: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(16, 185, 129, 0.14);
            border: 1px solid rgba(52, 211, 153, 0.18);
        }

        .role-selection-icon i {
            font-size: 1.5rem;
            color: #34d399;
        }

        .role-selection-option strong {
            display: block;
            font-size: 1.2rem;
            line-height: 1.2;
        }

        .role-selection-option span {
            color: #cbd5e1;
            font-size: 0.96rem;
            line-height: 1.6;
        }

        .role-selection-option-action {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            color: #86efac;
            font-weight: 700;
            font-size: 0.95rem;
        }

        @media (max-width: 767.98px) {
            .role-selection-card {
                padding: 0.9rem;
                border-radius: 1.2rem;
            }

            .role-selection-hero {
                padding: 1.25rem;
            }

            .role-selection-grid {
                grid-template-columns: 1fr;
            }

            .role-selection-option {
                min-height: unset;
            }
        }
    </style>
</head>
<body class="bg-main">
    @include('partials.nav', ['uri' => $uri])

    <main class="role-selection-page">
        <section class="role-selection-card">
            <div class="role-selection-hero text-center">
                <span class="role-selection-badge">
                    <i class="fa-solid fa-layer-group"></i>
                    Sesión multirol
                </span>

                <div class="role-selection-brand">
                    <img src="{{ asset('resources/img/logo/logo.png') }}" alt="Autoquiray">
                </div>

                <h1 class="role-selection-title">Selecciona cómo quieres entrar</h1>
                <p class="role-selection-copy mb-0">
                    Tu cuenta tiene varios roles asignados. Elige el perfil con el que quieres trabajar en esta sesión.
                </p>
            </div>

            <div class="role-selection-grid">
                @foreach ($roles as $role)
                    <form method="POST" action="{{ route('role.selection.store') }}">
                        @csrf
                        <input type="hidden" name="role" value="{{ $role }}">
                        <button type="submit" class="role-selection-option">
                            <div class="role-selection-option-top">
                                <span class="role-selection-icon">
                                    <i class="fa-solid {{ $role === 'student' ? 'fa-user-graduate' : ($role === 'teacher' ? 'fa-chalkboard-user' : 'fa-user-shield') }}"></i>
                                </span>
                                <div>
                                    <strong>
                                        {{ $role === 'student' ? 'Alumno' : ($role === 'teacher' ? 'Profesor' : 'Administrador') }}
                                    </strong>
                                    <span>
                                        {{ $role === 'student'
                                            ? 'Accede a tests, clases, soporte y a tu espacio personal.'
                                            : ($role === 'teacher'
                                                ? 'Gestiona alumnos, consultas, tests y clases prácticas.'
                                                : 'Accede al backoffice, usuarios, horarios y métricas.') }}
                                    </span>
                                </div>
                            </div>

                            <span class="role-selection-option-action">
                                Entrar con este rol
                                <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </button>
                    </form>
                @endforeach
            </div>
        </section>
    </main>

    @include('partials.scripts')
</body>
</html>
