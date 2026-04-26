@php
    $type = \App\Support\UserRoleManager::getActiveRole();

    $studentThreads = collect();
    $studentThreadCount = 0;

    if (auth()->check() && $type == 'student') {
        $studentQuestions = DB::table('student_questions')
            ->where('student_id', auth()->id())
            ->orderByDesc('date_sent')
            ->select('id', 'affair', 'message', 'date_sent')
            ->get();

        $studentAnswers = $studentQuestions->isNotEmpty()
            ? DB::table('answers as a')
                ->leftJoin('teachers as t', 't.employees_id', '=', 'a.teacher_id')
                ->leftJoin('employees as e', 'e.user_id', '=', 't.employees_id')
                ->leftJoin('users as u', 'u.id', '=', 'e.user_id')
                ->whereIn('a.question_id', $studentQuestions->pluck('id'))
                ->orderBy('a.date_sent')
                ->select(
                    'a.id',
                    'a.question_id',
                    'a.message',
                    'a.date_sent',
                    DB::raw("COALESCE(u.name, 'Profesor') as teacher_name")
                )
                ->get()
                ->groupBy('question_id')
            : collect();

        $studentThreads = $studentQuestions->map(function ($question) use ($studentAnswers) {
            $question->answers = $studentAnswers->get($question->id, collect());
            $question->answers_count = $question->answers->count();
            return $question;
        });

        $studentThreadCount = $studentThreads->count();
    }
@endphp

<footer class="pt-5 px-2">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-3 mt-2 footDiv text-center border-bottom border-secondary border-opacity-25 pb-4">
            
            <div class="col my-3 d-flex flex-column align-items-center">
                <div class="mb-4">
                    <img src="/resources/img/logo/logo.png" alt="Autoquiray Logo" class="footLogo">
                </div>
                <p class="px-4 text-grey small">
                    Tu autoescuela digital de confianza. <br>
                    Formación de alta tecnología para obtener tu carnet de conducir.
                </p>
            </div>

            <div class="col d-flex flex-column my-3">
                <p class="text-white fw-bold fs-5 mb-3">Enlaces Rápidos</p>
                <ul class="navbar-nav mb-2">
                    @auth
                        @if($type == 'student')
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'tipos_de_test' ? 'text-green-btn' : ''}}" 
                                href="{{ route('student.testType') }}">Test Online</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'classes' ? 'text-green-btn' : ''}}" 
                                href="{{ route('student.classes') }}">Mis Clases</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'contacto' ? 'text-green-btn' : ''}}" 
                                href="{{ route('student.contacto') }}">Contactos</a>
                            </li>
                        @elseif($type == 'teacher')
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'teacher/dashboard' ? 'text-green-btn' : ''}}" 
                                href="{{ route('teacher.dashboard') }}">Información alumnos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'crear_tests' ? 'text-green-btn' : ''}}" 
                                href="{{ route('teacher.createTests') }}">Crear tests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'create_classes' ? 'text-green-btn' : ''}}" 
                                href="{{ route('teacher.createClasses') }}">Crear tests</a>
                            </li>
                        @elseif($type == 'administrator')
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'admin/dashboard' ? 'text-green-btn' : ''}}" 
                                href="{{ route('admin.dashboard') }}">Informacion profesores</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'create_user' ? 'text-green-btn' : ''}}" 
                                href="{{ route('admin.createUser') }}">Crear usuario</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $uri == 'create_timetable' ? 'text-green-btn' : ''}}" 
                                href="{{ route('admin.createTimetable') }}">Crear horario</a>
                            </li>
                        @endif
                    @endauth
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ $uri == 'contacto' ? 'text-green-btn' : ''}}" 
                            href="{{ route('student.contacto') }}">Contactos</a>
                        </li>
                    @endguest
                </ul>
            </div>

            <div class="col d-flex flex-column my-3">
                <p class="text-white fw-bold fs-5 mb-3">Seguridad</p>
                <ul class="navbar-nav mb-2">
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-shield-halved text-green-btn me-3 fs-5"></i>
                            <p class="text-grey m-0 small">Datos protegidos RGPD</p>
                        </div>
                    </li>
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-lock text-green-btn me-3 fs-5"></i>
                            <p class="text-grey m-0 small">Conexión SSL cifrada</p>
                        </div>
                    </li>
                    <li class="nav-item mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-server text-green-btn me-3 fs-5"></i>
                            <p class="text-grey m-0 small">Servidor local seguro</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12 py-4">
                <p class="text-grey text-center m-0 small">
                    © 2026 <span class="text-green-btn fw-bold">AUTOQUIRAY</span>. Todos los derechos reservados. | 
                    <a href="#" class="text-grey text-decoration-none mx-1">Aviso Legal</a> | 
                    <a href="#" class="text-grey text-decoration-none mx-1">Privacidad</a>
                </p>
            </div>
        </div>
    </div>
</footer>

@if(auth()->check() && $type == 'student')
    <button type="button"
       class="student-message-fab"
       id="studentMessagesToggle"
       aria-label="Abrir mensajes"
       aria-expanded="false"
       aria-controls="studentMessagesPanel">
        <i class="fa-solid fa-comments"></i>
        @if($studentThreadCount > 0)
            <span class="student-message-fab-count">{{ $studentThreadCount }}</span>
        @endif
    </button>

    <aside class="student-messages-panel" id="studentMessagesPanel" aria-labelledby="studentMessagesPanelLabel" aria-hidden="true">
        <div class="student-messages-panel-head border-bottom border-secondary border-opacity-10">
            <div>
                <h5 class="text-white mb-1" id="studentMessagesPanelLabel">Mis mensajes</h5>
                <p class="mb-0 text-secondary small">Historial de consultas y respuestas de profesores</p>
            </div>
            <button type="button" class="btn-close btn-close-white student-messages-close" id="studentMessagesClose" aria-label="Cerrar mensajes"></button>
        </div>

        <div class="student-messages-panel-body">
            @forelse($studentThreads as $thread)
                <article class="student-thread-card">
                    <div class="student-thread-head">
                        <div>
                            <p class="student-thread-affair mb-1">{{ ucfirst($thread->affair) }}</p>
                            <p class="student-thread-date mb-0">{{ \Carbon\Carbon::parse($thread->date_sent)->format('d/m/Y H:i') }}</p>
                        </div>

                        @if($thread->answers_count > 0)
                            <span class="student-thread-status student-thread-status-answered">
                                {{ $thread->answers_count }} respuesta{{ $thread->answers_count > 1 ? 's' : '' }}
                            </span>
                        @else
                            <span class="student-thread-status student-thread-status-pending">
                                Pendiente
                            </span>
                        @endif
                    </div>

                    <div class="student-thread-bubble student-thread-bubble-student">
                        <div class="student-thread-meta">
                            <strong>Tu mensaje</strong>
                            <span>{{ \Carbon\Carbon::parse($thread->date_sent)->diffForHumans() }}</span>
                        </div>
                        <p class="mb-0">{{ $thread->message }}</p>
                    </div>

                    @foreach($thread->answers as $answer)
                        <div class="student-thread-bubble student-thread-bubble-teacher">
                            <div class="student-thread-meta">
                                <strong>{{ $answer->teacher_name }}</strong>
                                <span>{{ \Carbon\Carbon::parse($answer->date_sent)->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="mb-0">{{ $answer->message }}</p>
                        </div>
                    @endforeach
                </article>
            @empty
                <div class="student-thread-empty">
                    <i class="fa-regular fa-paper-plane fs-1 text-secondary mb-3"></i>
                    <h6 class="text-white mb-2">Todavia no has enviado mensajes</h6>
                    <p class="text-secondary mb-0">Cuando escribas a soporte, aqui podras leer todo el historial sin salir de la pagina.</p>
                </div>
            @endforelse
        </div>
    </aside>

    <style>
        .student-message-fab {
            position: fixed;
            right: 1.1rem;
            bottom: 1.35rem;
            width: 62px;
            height: 62px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: #fff;
            border: 0;
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.35);
            z-index: 1050;
            font-size: 1.35rem;
        }

        .student-message-fab:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .student-message-fab-count {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 24px;
            height: 24px;
            padding: 0 6px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f97316;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            border: 2px solid #0f172a;
        }

        .student-messages-panel {
            position: fixed;
            right: 1.1rem;
            bottom: 5.9rem;
            background: #0f172a;
            color: #e2e8f0;
            width: min(440px, calc(100vw - 1.6rem));
            max-height: min(72vh, 760px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 26px;
            box-shadow: 0 22px 65px rgba(2, 8, 23, 0.45);
            z-index: 1049;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
            transform: translateY(18px) scale(0.98);
            transform-origin: bottom right;
            transition: opacity 0.18s ease, transform 0.18s ease;
        }

        .student-messages-panel.is-open {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }

        .student-messages-panel-head {
            padding: 1rem 1rem 0.9rem;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: flex-start;
        }

        .student-messages-panel-body {
            padding: 0 1rem 1rem;
            overflow-y: auto;
            max-height: calc(min(72vh, 760px) - 85px);
        }

        .student-thread-card {
            background: rgba(30, 41, 59, 0.95);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 22px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .student-thread-head,
        .student-thread-meta {
            display: flex;
            justify-content: space-between;
            gap: 0.75rem;
            align-items: flex-start;
        }

        .student-thread-head {
            margin-bottom: 0.9rem;
        }

        .student-thread-affair {
            color: #fff;
            font-weight: 700;
        }

        .student-thread-date,
        .student-thread-meta span {
            color: #94a3b8;
            font-size: 0.82rem;
        }

        .student-thread-status {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.7rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .student-thread-status-answered {
            background: rgba(34, 197, 94, 0.16);
            color: #86efac;
        }

        .student-thread-status-pending {
            background: rgba(249, 115, 22, 0.15);
            color: #fdba74;
        }

        .student-thread-bubble {
            border-radius: 18px;
            padding: 0.9rem 1rem;
            margin-top: 0.75rem;
        }

        .student-thread-bubble-student {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(96, 165, 250, 0.18);
        }

        .student-thread-bubble-teacher {
            background: rgba(20, 83, 45, 0.28);
            border: 1px solid rgba(34, 197, 94, 0.18);
        }

        .student-thread-empty {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 1.5rem;
            border: 1px dashed rgba(255,255,255,0.14);
            border-radius: 24px;
        }

        .student-message-fab.is-active {
            background: linear-gradient(135deg, #15803d, #16a34a);
        }

        @media (max-width: 768px) {
            .student-message-fab {
                right: 0.9rem;
                bottom: 0.95rem;
                width: 58px;
                height: 58px;
            }

            .student-messages-panel {
                right: 0.75rem;
                left: 0.75rem;
                bottom: 5.3rem;
                width: auto;
                max-height: min(70vh, 640px);
                border-radius: 24px 24px 18px 18px;
            }

            .student-messages-panel-body {
                max-height: calc(min(70vh, 640px) - 85px);
            }

            .student-thread-head,
            .student-thread-meta {
                flex-direction: column;
            }
        }
    </style>

    <script>
        (() => {
            const toggleButton = document.getElementById('studentMessagesToggle');
            const closeButton = document.getElementById('studentMessagesClose');
            const panel = document.getElementById('studentMessagesPanel');

            if (!toggleButton || !closeButton || !panel) {
                return;
            }

            const setPanelState = (isOpen) => {
                panel.classList.toggle('is-open', isOpen);
                toggleButton.classList.toggle('is-active', isOpen);
                toggleButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                panel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
            };

            toggleButton.addEventListener('click', () => {
                setPanelState(!panel.classList.contains('is-open'));
            });

            closeButton.addEventListener('click', () => {
                setPanelState(false);
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    setPanelState(false);
                }
            });

            document.addEventListener('click', (event) => {
                if (!panel.classList.contains('is-open')) {
                    return;
                }

                if (panel.contains(event.target) || toggleButton.contains(event.target)) {
                    return;
                }

                setPanelState(false);
            });
        })();
    </script>
@endif
