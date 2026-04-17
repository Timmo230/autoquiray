@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zona de Profesores - Autoquiray</title>
    @include("partials.links")
    <link rel="stylesheet" href="{{ asset('resources/css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/zonaProfesores.css') }}">
</head>
<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container my-5">
        <article>
            <section class="px-3 mb-5 animate__animated animate__fadeIn">
                <div class="header-title">
                    <h2 class="fw-bold mb-1">Zona Profesores</h2>
                    <p class="text-muted mb-0 fw-normal">Gestión inteligente de rendimiento y seguimiento de alumnos</p>
                </div>
            </section>

            <section class="px-3">
                <div class="glass-panel py-4">
                    <div class="px-4 d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                        <h3 class="fs-4 mb-0 fw-semibold">Alumnos Matriculados</h3>

                        <div class="mt-3 mt-md-0">
                            <form action="{{ route('teacher.dashboard') }}" method="GET" class="position-relative">
                                <input type="text" 
                                    name="search" 
                                    class="form-control rounded-pill ps-5 search-input-custom" 
                                    placeholder="Filtrar por nombre..." 
                                    value="{{ request('search') }}"
                                    style="width: 300px; height: 45px;">
                                <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </form>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Alumno</th>
                                    <th>Progreso Teórico</th>
                                    <th>Aprobados / Total</th>
                                    <th>Estado de Participación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumnos as $alum)
                                    @php
                                        $colorClase = $alum->porcentaje_aprobados >= 70 ? 'success' : ($alum->porcentaje_aprobados >= 50 ? 'warning' : 'danger');
                                        $iniciales = collect(explode(' ', $alum->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-{{ $colorClase }} text-white d-flex align-items-center justify-content-center me-3 student-avatar">
                                                    {{ strtoupper($iniciales) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-white">{{ $alum->name }}</div>
                                                    <div class="text-muted small">{{ $alum->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress-wrapper rounded-pill me-3">
                                                    <div class="bg-{{ $colorClase }} rounded-pill" 
                                                        style="width: {{ $alum->porcentaje_aprobados }}%; height: 100%; transition: width 1s ease-in-out;">
                                                    </div>
                                                </div>
                                                <span class="fw-bold small {{ $alum->porcentaje_aprobados >= 50 ? 'text-green-accent' : 'text-danger' }}">
                                                    {{ $alum->porcentaje_aprobados }}%
                                                </span>
                                            </div>
                                        </td>

                                        <td class="fw-medium text-muted">
                                            <span class="text-white">{{ $alum->aprobados }}</span> <small>/</small> {{ $alum->total_examenes }}
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill bg-{{ $colorClase }} bg-opacity-10 text-{{ $colorClase }} border border-{{ $colorClase }} border-opacity-25 px-3 py-2">
                                                {{ $alum->total_examenes }} tests realizados
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="px-3 mt-4">
                <div class="glass-panel py-4">
                    <div class="px-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
                        <div>
                            <h3 class="fs-4 mb-1 fw-semibold">Consultas de alumnos</h3>
                            <p class="text-muted mb-0">Lee el historial completo y responde desde un modal, sin salir del panel.</p>
                        </div>

                        <div class="teacher-question-legend">
                            <span class="teacher-question-legend-pill">
                                <i class="fa-solid fa-comments"></i>
                                {{ $questions->count() }} consultas visibles
                            </span>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="px-4 mb-4">
                            <div class="teacher-alert teacher-alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="px-4 mb-4">
                            <div class="teacher-alert teacher-alert-error">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    @endif

                    <div class="px-4">
                        <div class="teacher-questions-list">
                            @forelse($questions as $question)
                                <article class="teacher-question-item">
                                    <div class="teacher-question-main">
                                        <div class="teacher-question-topline">
                                            <span class="teacher-question-subject">{{ ucfirst($question->affair) }}</span>
                                            <span class="teacher-question-date">{{ \Carbon\Carbon::parse($question->date_sent)->format('d/m/Y H:i') }}</span>
                                        </div>

                                        <div class="teacher-question-student">
                                            <strong>{{ $question->student_name }}</strong>
                                            <span>{{ $question->student_email }}</span>
                                        </div>

                                        <p class="teacher-question-preview mb-0">
                                            {{ \Illuminate\Support\Str::limit($question->menssage, 180) }}
                                        </p>
                                    </div>

                                    <div class="teacher-question-side">
                                        <div class="teacher-question-metrics">
                                            <span class="teacher-question-pill">
                                                <i class="fa-solid fa-user-group"></i>
                                                {{ $question->teachers_count }} profesor{{ $question->teachers_count == 1 ? '' : 'es' }}
                                            </span>
                                            <span class="teacher-question-pill">
                                                <i class="fa-solid fa-reply"></i>
                                                {{ $question->answers_count }} respuesta{{ $question->answers_count == 1 ? '' : 's' }}
                                            </span>
                                        </div>

                                        <button
                                            type="button"
                                            class="teacher-question-open-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#questionReplyModal"
                                            onclick="openTeacherQuestionModal('{{ $question->id }}')"
                                        >
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            Ver y responder
                                        </button>
                                    </div>
                                </article>
                            @empty
                                <div class="teacher-empty-state">
                                    No hay consultas de alumnos para mostrar.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </article>
    </main>

    <div class="modal fade details-modal-dark" id="questionReplyModal" tabindex="-1" aria-labelledby="questionReplyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content details-modal-content teacher-question-modal-content">
                <div class="modal-header details-modal-header">
                    <div>
                        <h4 class="modal-title details-modal-title" id="questionReplyModalLabel">Consulta del alumno</h4>
                        <p class="details-modal-subtitle mb-0">Historial completo de mensajes y respuesta del profesor</p>
                    </div>
                    <button type="button" class="btn-close details-modal-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body details-modal-body">
                    <div id="teacherQuestionModalContent"></div>

                    <form method="POST" action="{{ route('teacher.questions.answer') }}" class="teacher-reply-form mt-4">
                        @csrf
                        <input type="hidden" name="question_id" id="teacherReplyQuestionId">

                        <label for="teacherReplyMessage" class="teacher-reply-label">Responder a la consulta</label>
                        <textarea
                            name="menssage"
                            id="teacherReplyMessage"
                            class="form-control teacher-reply-textarea"
                            rows="5"
                            maxlength="512"
                            placeholder="Escribe una respuesta clara para el alumno"
                            required
                        >{{ old('menssage') }}</textarea>

                        <div class="modal-footer details-modal-footer px-0 pb-0 mt-4">
                            <button type="button" class="btn details-close-btn" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn teacher-reply-submit">
                                <i class="fa-solid fa-paper-plane"></i>
                                Enviar respuesta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include("partials.footer")
    @include("partials.scripts")
    <script>
        window.teacherQuestions = @json($questions);
        window.teacherQuestionAutoOpen = @json(old('question_id'));
    </script>
    <script src="{{ asset('resources/js/dashboardTeachers.js') }}"></script>
</body>
</html>
