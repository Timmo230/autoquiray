@php
    $uri = request()->path();
    $totalQuestions = $questions->count();
    $answeredQuestions = $questions->filter(fn($question) => (int) $question->answers_count > 0)->count();
    $pendingQuestions = $questions->filter(fn($question) => (int) $question->answers_count === 0)->count();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Consultas de Alumnos - Autoquiray</title>
    @include("partials.links")
    <link rel="stylesheet" href="{{ asset('resources/css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/zonaProfesores.css') }}">
</head>
<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container my-5">
        <article>
            <section class="px-3 mb-4 animate__animated animate__fadeIn">
                <div class="header-title">
                    <h2 class="fw-bold mb-1">Consultas de alumnos</h2>
                    <p class="text-muted mb-0 fw-normal">Centro de mensajes del profesor con filtros, historial completo y respuesta desde modal.</p>
                </div>
            </section>

            <section class="px-3">
                <div class="glass-panel py-4">
                    <div class="px-4">
                        <div class="teacher-question-toolbar">
                            <form method="GET" action="{{ route('teacher.questions') }}" class="teacher-question-filter-form">
                                <div class="teacher-question-filter-group teacher-question-filter-search">
                                    <label for="teacherQuestionSearch" class="teacher-filter-label">Buscar en todos los campos</label>
                                    <div class="position-relative">
                                        <input
                                            id="teacherQuestionSearch"
                                            type="text"
                                            name="search"
                                            class="form-control search-input-custom rounded-pill ps-5"
                                            placeholder="Alumno, email, asunto, pregunta, respuesta o profesor"
                                            value="{{ $filters['search'] }}"
                                        >
                                        <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                    </div>
                                </div>

                                <div class="teacher-question-filter-group">
                                    <label for="teacherQuestionStatus" class="teacher-filter-label">Estado</label>
                                    <select name="status" id="teacherQuestionStatus" class="form-select teacher-filter-select">
                                        <option value="all" {{ $filters['status'] === 'all' ? 'selected' : '' }}>Todas</option>
                                        <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Sin responder</option>
                                        <option value="answered" {{ $filters['status'] === 'answered' ? 'selected' : '' }}>Respondidas</option>
                                    </select>
                                </div>

                                <div class="teacher-question-filter-actions">
                                    <button type="submit" class="teacher-filter-submit">
                                        <i class="fa-solid fa-filter"></i>
                                        Filtrar
                                    </button>
                                    <a href="{{ route('teacher.questions') }}" class="teacher-filter-reset">
                                        Limpiar
                                    </a>
                                </div>
                            </form>

                            <div class="teacher-question-summary">
                                <span class="teacher-question-legend-pill">
                                    <i class="fa-solid fa-comments"></i>
                                    {{ $totalQuestions }} visibles
                                </span>
                                <span class="teacher-question-legend-pill">
                                    <i class="fa-solid fa-clock"></i>
                                    {{ $pendingQuestions }} pendientes
                                </span>
                                <span class="teacher-question-legend-pill">
                                    <i class="fa-solid fa-circle-check"></i>
                                    {{ $answeredQuestions }} respondidas
                                </span>
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="teacher-alert teacher-alert-success mt-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="teacher-alert teacher-alert-error mt-4">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="teacher-questions-list mt-4">
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
                                            {{ \Illuminate\Support\Str::limit($question->menssage, 220) }}
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
                                            <span class="teacher-question-pill {{ (int) $question->answers_count > 0 ? 'teacher-question-pill-answered' : 'teacher-question-pill-pending' }}">
                                                <i class="fa-solid {{ (int) $question->answers_count > 0 ? 'fa-circle-check' : 'fa-hourglass-half' }}"></i>
                                                {{ (int) $question->answers_count > 0 ? 'Respondida' : 'Pendiente' }}
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
                                    No hay consultas que cumplan los filtros actuales.
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
                        <p class="details-modal-subtitle mb-0">Pregunta, respuestas previas y nuevo envío desde el mismo flujo.</p>
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
