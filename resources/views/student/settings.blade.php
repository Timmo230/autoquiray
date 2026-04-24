@php
    $uri = request()->path();
    $tabLinks = [
        'profile' => ['label' => 'Mi perfil', 'icon' => 'fa-user'],
        'tuitions' => ['label' => 'Matrículas', 'icon' => 'fa-id-card'],
        'exams' => ['label' => 'Exámenes', 'icon' => 'fa-file-signature'],
        'security' => ['label' => 'Seguridad', 'icon' => 'fa-shield-halved'],
        'activity' => ['label' => 'Actividad', 'icon' => 'fa-chart-line'],
    ];
    $availableExams = $exams->filter(fn ($exam) => $exam->can_register);
    $registeredExams = $exams->filter(fn ($exam) => $exam->is_registered);
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi configuración | AUTOQUIRAY</title>
    @include('partials.links')
    <link rel="stylesheet" href="{{ asset('resources/css/studentSettings.css') }}">
</head>
<body class="bg-main">
    @include('partials.nav', ['uri' => $uri])

    <main class="container-fluid student-settings-page">
        <article class="student-settings-shell">
            <section class="student-settings-header">
                <div>
                    <span class="student-settings-eyebrow">Panel del alumno</span>
                    <h1 class="student-settings-title">Mi configuración</h1>
                    <p class="student-settings-subtitle">
                        Gestiona tus datos personales, revisa matrículas activas, inscríbete en exámenes y controla tu actividad desde un único panel.
                    </p>
                </div>

                <div class="student-settings-summary-grid">
                    <div class="student-summary-card">
                        <span class="student-summary-label">Matrículas activas</span>
                        <strong>{{ $stats['active_tuitions'] }}</strong>
                    </div>
                    <div class="student-summary-card">
                        <span class="student-summary-label">Exámenes inscritos</span>
                        <strong>{{ $stats['registered_exams'] }}</strong>
                    </div>
                    <div class="student-summary-card">
                        <span class="student-summary-label">Tests realizados</span>
                        <strong>{{ $stats['completed_tests'] }}</strong>
                    </div>
                    <div class="student-summary-card">
                        <span class="student-summary-label">Clases reservadas</span>
                        <strong>{{ $stats['reserved_classes'] }}</strong>
                    </div>
                </div>
            </section>

            <section class="student-settings-layout">
                <aside class="student-settings-sidebar">
                    <div class="student-settings-user-card">
                        <div class="student-settings-avatar">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="student-settings-user-name">{{ $user->name }}</p>
                            <p class="student-settings-user-email">{{ $user->email }}</p>
                        </div>
                    </div>

                    <nav class="student-settings-nav" aria-label="Secciones de configuración">
                        @foreach ($tabLinks as $tabKey => $tab)
                            <a
                                href="{{ route('student.settings', ['tab' => $tabKey]) }}"
                                class="student-settings-nav-link {{ $activeTab === $tabKey ? 'is-active' : '' }}"
                            >
                                <i class="fa-solid {{ $tab['icon'] }}"></i>
                                <span>{{ $tab['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>

                    <form action="{{ route('logout') }}" method="POST" data-plausible-submit="logout">
                        @csrf
                        <button type="submit" class="student-settings-logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </aside>

                <div class="student-settings-content">
                    @if ($activeTab === 'profile')
                        <section class="settings-panel">
                            <div class="settings-panel-head">
                                <div>
                                    <span class="settings-panel-kicker">Perfil</span>
                                    <h2>Datos personales</h2>
                                </div>
                                <p class="settings-panel-copy">Edita la información principal de tu cuenta y deja actualizados los datos que ve el centro.</p>
                            </div>

                            <form method="POST" action="{{ route('student.settings.profile') }}" class="settings-form-grid">
                                @csrf
                                <div class="settings-field">
                                    <label for="name">Nombre completo</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="settings-field">
                                    <label for="email">Correo electrónico</label>
                                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="settings-field">
                                    <label for="document_type">Tipo de documento</label>
                                    <select id="document_type" name="document_type" required>
                                        <option value="DNI" {{ old('document_type', $user->document_type) === 'DNI' ? 'selected' : '' }}>DNI</option>
                                        <option value="passport" {{ old('document_type', $user->document_type) === 'passport' ? 'selected' : '' }}>Pasaporte</option>
                                    </select>
                                </div>

                                <div class="settings-field">
                                    <label for="document_id">Número de documento</label>
                                    <input id="document_id" type="text" name="document_id" value="{{ old('document_id', $user->document_id) }}" required>
                                </div>

                                <div class="settings-field settings-field-full">
                                    <div class="student-inline-note">
                                        <div>
                                            <span class="student-inline-note-label">Cuenta activa</span>
                                            <strong>{{ $user->active ? 'Sí' : 'No' }}</strong>
                                        </div>
                                        <div>
                                            <span class="student-inline-note-label">Alta en plataforma</span>
                                            <strong>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</strong>
                                        </div>
                                        <div>
                                            <span class="student-inline-note-label">Última actualización</span>
                                            <strong>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="settings-actions">
                                    <a href="{{ route('student.settings', ['tab' => 'security']) }}" class="settings-secondary-action">
                                        Cambiar contraseña
                                    </a>
                                    <button type="submit" class="settings-primary-action">Guardar datos</button>
                                </div>
                            </form>
                        </section>
                    @endif

                    @if ($activeTab === 'tuitions')
                        <section class="settings-panel settings-panel-tuitions">
                            <div class="settings-panel-head">
                                <div>
                                    <span class="settings-panel-kicker">Matrículas</span>
                                    <h2>Estado académico</h2>
                                </div>
                                <p class="settings-panel-copy">Consulta permisos asociados, vigencia, estado económico y fechas límite de cada matrícula.</p>
                            </div>

                            <div class="settings-spotlight-grid">
                                <div class="settings-spotlight-card">
                                    <span class="settings-spotlight-label">Matrículas activas</span>
                                    <strong>{{ $tuitions->filter(fn ($tuition) => $tuition->is_active)->count() }}</strong>
                                    <p>Permisos listos para seguir operando en clases y convocatorias.</p>
                                </div>
                                <div class="settings-spotlight-card">
                                    <span class="settings-spotlight-label">Total registradas</span>
                                    <strong>{{ $tuitions->count() }}</strong>
                                    <p>Histórico completo de matrículas asociadas a tu perfil.</p>
                                </div>
                            </div>

                            <div class="settings-stack">
                                @forelse ($tuitions as $tuition)
                                    <article class="settings-card-row settings-card-row-academic">
                                        <div class="settings-card-icon settings-card-icon-emerald">
                                            <i class="fa-solid fa-id-card"></i>
                                        </div>
                                        <div class="settings-card-main">
                                            <div class="settings-card-topline settings-card-topline-wrap">
                                                <div>
                                                    <p class="settings-card-overline">Permiso matriculado</p>
                                                    <h3>{{ $tuition->permission_name }}</h3>
                                                </div>
                                                <span class="settings-pill {{ $tuition->is_active ? 'is-success' : 'is-muted' }}">
                                                    {{ $tuition->status_label }}
                                                </span>
                                            </div>
                                            <p class="settings-card-copy">
                                                {{ $tuition->is_active ? 'Matrícula operativa para reservar exámenes y seguir con el permiso.' : 'Matrícula cerrada o fuera de vigencia.' }}
                                            </p>
                                        </div>
                                        <div class="settings-card-meta-grid">
                                            <div>
                                                <span>Fecha de alta</span>
                                                <strong>{{ \Carbon\Carbon::parse($tuition->date)->format('d/m/Y') }}</strong>
                                            </div>
                                            <div>
                                                <span>Inicio</span>
                                                <strong>{{ \Carbon\Carbon::parse($tuition->start_date)->format('d/m/Y') }}</strong>
                                            </div>
                                            <div>
                                                <span>Vencimiento</span>
                                                <strong>{{ \Carbon\Carbon::parse($tuition->max_end_date)->format('d/m/Y') }}</strong>
                                            </div>
                                            <div>
                                                <span>Importe</span>
                                                <strong>{{ number_format((float) $tuition->price, 2, ',', '.') }} €</strong>
                                            </div>
                                            <div>
                                                <span>Gestionado por</span>
                                                <strong>{{ $tuition->administrator_name ?? 'Administración' }}</strong>
                                            </div>
                                        </div>
                                    </article>
                                @empty
                                    <div class="settings-empty-state">
                                        No hay matrículas registradas todavía para este alumno.
                                    </div>
                                @endforelse
                            </div>
                        </section>
                    @endif

                    @if ($activeTab === 'exams')
                        <section class="settings-panel settings-panel-exams">
                            <div class="settings-panel-head">
                                <div>
                                    <span class="settings-panel-kicker">Exámenes</span>
                                    <h2>Inscripciones y convocatorias</h2>
                                </div>
                                <p class="settings-panel-copy">Aquí puedes ver tus convocatorias, revisar calificaciones cuando existan y apuntarte a nuevos exámenes disponibles.</p>
                            </div>

                            <div class="student-exam-overview">
                                <div class="student-exam-overview-card">
                                    <span>Disponibles para inscribirte</span>
                                    <strong>{{ $availableExams->count() }}</strong>
                                </div>
                                <div class="student-exam-overview-card">
                                    <span>Convocatorias ya inscritas</span>
                                    <strong>{{ $registeredExams->count() }}</strong>
                                </div>
                            </div>

                            <div class="settings-stack">
                                @forelse ($exams as $exam)
                                    <article class="settings-card-row settings-card-row-exam {{ $exam->can_register ? 'is-available' : ($exam->is_registered ? 'is-registered' : '') }}">
                                        <div class="settings-card-icon {{ $exam->can_register ? 'settings-card-icon-emerald' : ($exam->is_registered ? 'settings-card-icon-blue' : 'settings-card-icon-slate') }}">
                                            <i class="fa-solid {{ $exam->type === 'practical' ? 'fa-car-side' : 'fa-file-lines' }}"></i>
                                        </div>
                                        <div class="settings-card-main">
                                            <div class="settings-card-topline settings-card-topline-wrap">
                                                <div>
                                                    <p class="settings-card-overline">{{ $exam->type_label }}</p>
                                                    <h3>{{ $exam->permission_name }}</h3>
                                                </div>
                                                <span class="settings-pill {{ $exam->can_register ? 'is-success' : ($exam->is_registered ? 'is-info' : 'is-muted') }}">
                                                    {{ $exam->status_label }}
                                                </span>
                                            </div>
                                            <p class="settings-card-copy">
                                                {{ $exam->is_registered
                                                    ? ($exam->note === null ? 'Ya estás inscrito. La nota aparecerá cuando la administración la registre.' : 'Resultado disponible para esta convocatoria.')
                                                    : 'Solo puedes inscribirte si tienes una matrícula activa del permiso correspondiente.' }}
                                            </p>
                                        </div>

                                        <div class="settings-card-meta-grid">
                                            <div>
                                                <span>Fecha</span>
                                                <strong>{{ \Carbon\Carbon::parse($exam->date)->format('d/m/Y') }}</strong>
                                            </div>
                                            <div>
                                                <span>Hora</span>
                                                <strong>{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</strong>
                                            </div>
                                            <div>
                                                <span>Tasa</span>
                                                <strong>{{ number_format((float) $exam->price, 2, ',', '.') }} €</strong>
                                            </div>
                                            <div>
                                                <span>Nota</span>
                                                <strong>{{ $exam->note === null ? 'Pendiente' : $exam->note }}</strong>
                                            </div>
                                        </div>

                                        <div class="settings-card-actions">
                                            @if ($exam->can_register)
                                                <form method="POST" action="{{ route('student.settings.exams.register', $exam->id) }}">
                                                    @csrf
                                                    <button type="submit" class="settings-primary-action">Apuntarme al examen</button>
                                                </form>
                                            @elseif ($exam->is_registered)
                                                <span class="settings-static-action">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Ya inscrito
                                                </span>
                                            @else
                                                <span class="settings-static-action is-muted">
                                                    <i class="fa-solid fa-lock"></i>
                                                    No disponible
                                                </span>
                                            @endif
                                        </div>
                                    </article>
                                @empty
                                    <div class="settings-empty-state">
                                        No hay convocatorias registradas en el sistema todavía.
                                    </div>
                                @endforelse
                            </div>
                        </section>
                    @endif

                    @if ($activeTab === 'security')
                        <section class="settings-panel">
                            <div class="settings-panel-head">
                                <div>
                                    <span class="settings-panel-kicker">Seguridad</span>
                                    <h2>Contraseña y acceso</h2>
                                </div>
                                <p class="settings-panel-copy">Actualiza tu contraseña para mantener la cuenta protegida. La nueva contraseña debe tener al menos 8 caracteres.</p>
                            </div>

                            <form method="POST" action="{{ route('student.settings.password') }}" class="settings-form-grid">
                                @csrf
                                <div class="settings-field settings-field-full">
                                    <label for="current_password">Contraseña actual</label>
                                    <input id="current_password" type="password" name="current_password" required>
                                </div>

                                <div class="settings-field">
                                    <label for="password">Nueva contraseña</label>
                                    <input id="password" type="password" name="password" required>
                                </div>

                                <div class="settings-field">
                                    <label for="password_confirmation">Confirmar nueva contraseña</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                                </div>

                                <div class="settings-actions">
                                    <span class="settings-secondary-note">Consejo: usa una combinación larga con números y símbolos.</span>
                                    <button type="submit" class="settings-primary-action">Actualizar contraseña</button>
                                </div>
                            </form>
                        </section>
                    @endif

                    @if ($activeTab === 'activity')
                        <section class="settings-panel settings-panel-activity">
                            <div class="settings-panel-head">
                                <div>
                                    <span class="settings-panel-kicker">Actividad</span>
                                    <h2>Resumen reciente</h2>
                                </div>
                                <p class="settings-panel-copy">Un vistazo rápido a tus tests más recientes, tus clases reservadas y las consultas abiertas con soporte.</p>
                            </div>

                            <div class="settings-spotlight-grid">
                                <div class="settings-spotlight-card">
                                    <span class="settings-spotlight-label">Tests recientes</span>
                                    <strong>{{ $recentTests->count() }}</strong>
                                    <p>Últimos resultados guardados en la plataforma.</p>
                                </div>
                                <div class="settings-spotlight-card">
                                    <span class="settings-spotlight-label">Interacciones activas</span>
                                    <strong>{{ $recentQuestions->count() + $recentClasses->count() }}</strong>
                                    <p>Movimiento reciente entre reservas de clases y soporte.</p>
                                </div>
                            </div>

                            <div class="activity-grid">
                                <div class="activity-column">
                                    <div class="activity-column-head">
                                        <span class="activity-column-icon emerald"><i class="fa-solid fa-laptop-code"></i></span>
                                        <h3>Últimos tests</h3>
                                    </div>
                                    @forelse ($recentTests as $test)
                                        <article class="activity-item">
                                            <strong>{{ $test->title }}</strong>
                                            <span>{{ ucfirst($test->type) }} · {{ $test->last_note }}/{{ $test->max_note }}</span>
                                            <small>{{ \Carbon\Carbon::parse($test->updated_at)->format('d/m/Y H:i') }} · {{ $test->time }}</small>
                                        </article>
                                    @empty
                                        <div class="settings-empty-state compact">
                                            Aún no has realizado tests.
                                        </div>
                                    @endforelse
                                </div>

                                <div class="activity-column">
                                    <div class="activity-column-head">
                                        <span class="activity-column-icon blue"><i class="fa-solid fa-chalkboard-user"></i></span>
                                        <h3>Clases reservadas</h3>
                                    </div>
                                    @forelse ($recentClasses as $class)
                                        <article class="activity-item">
                                            <strong>{{ $class->title }}</strong>
                                            <span>{{ $class->teacher_name }}</span>
                                            <small>{{ \Carbon\Carbon::parse($class->date)->format('d/m/Y') }} · {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($class->end_time)->format('H:i') }}</small>
                                        </article>
                                    @empty
                                        <div class="settings-empty-state compact">
                                            No tienes reservas de clases aún.
                                        </div>
                                    @endforelse
                                </div>

                                <div class="activity-column">
                                    <div class="activity-column-head">
                                        <span class="activity-column-icon amber"><i class="fa-solid fa-headset"></i></span>
                                        <h3>Consultas enviadas</h3>
                                    </div>
                                    @forelse ($recentQuestions as $question)
                                        <article class="activity-item">
                                            <strong>{{ ucfirst($question->affair) }}</strong>
                                            <span>{{ \Illuminate\Support\Str::limit($question->menssage, 80) }}</span>
                                            <small>{{ \Carbon\Carbon::parse($question->date_sent)->format('d/m/Y H:i') }} · {{ $question->answers_count }} respuesta{{ $question->answers_count == 1 ? '' : 's' }}</small>
                                        </article>
                                    @empty
                                        <div class="settings-empty-state compact">
                                            No has enviado consultas todavía.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </section>
        </article>
    </main>

    @include('partials.footer')
    @include('partials.scripts')
</body>
</html>
