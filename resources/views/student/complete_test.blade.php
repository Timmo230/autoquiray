@php
    $uri = request()->path();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Haciendo test...</title>
    @include("partials.links")
    <link rel="stylesheet" href="/resources/css/complete_test.css">
</head>

<body class="bg-main">
    @include("partials.nav", ['uri' => $uri])

    <main class="container-xl pb-5">
        <div class="pt-4 mt-2">
            <h2 class="fw-bold mb-2">Plataforma de Test</h2>
            <p class="text-muted fs-5 opacity-75 fw-normal mb-0">
                Prepárate para el examen teórico de la DGT con nuestros tests actualizados
            </p>
        </div>

        <div id="question" class="position-relative mt-3">
            <form action="">
                <!-- TIMER -->
                <div class="d-flex align-items-center justify-content-center px-3 py-2 rounded-pill timer-pill" id="time">
                    <i class="fa-regular fa-clock me-2 timer-ico"></i>
                    <span id="timer-display" class="fw-bold rubik" style="min-width: 52px;">30:00</span>
                </div>

                @foreach($questions as $index => $group)
                    @php
                        $first = $group->first();
                        $qId = $first->question_id;
                        $percentage = (($index + 1) / $test->max_note) * 100;
                    @endphp

                    <div class="question-step" id="{{ $index }}" style="display: {{ $index == 0 ? 'block' : 'none' }}">
                        <div class="card test-card rounded-4 p-0 border-0">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <div class="flex-grow-1" id="title">
                                        <h1 class="h4 fw-bold text-white mb-0">{{ $test->title }}</h1>
                                        <small class="text-muted">
                                            Pregunta {{ $index + 1 }} de {{ $test->max_note }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <h2 class="h5 fw-bold text-white mb-4">{{ $first->title }}</h2>

                                <div class="d-flex flex-column gap-3">
                                    @foreach($group as $option)
                                        <input type="radio"
                                               name="{{ $qId }}"
                                               id="{{ $option->id }}"
                                               class="btn-check"
                                               onclick="saveAnswer('{{ $qId }}', '{{ $option->id }}')">

                                        <label for="{{ $option->id }}"
                                               class="option-btn text-start p-3 rounded-3 d-flex align-items-center">
                                            <span class="custom-radio me-3"></span>
                                            <span class="option-text">{{ $option->option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-0 p-4 pt-0 d-flex justify-content-between align-items-center">
                                <button type="button"
                                        class="btn btn-link text-muted text-decoration-none fw-bold p-0 nav-prev"
                                        onclick="quizApp.changeStep(-1)" {{ $index == 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-chevron-left"></i> Anterior
                                </button>

                                @if($index < $questions->count() - 1)
                                    <button type="button"
                                            class="btn bg-green-btn text-white px-4 py-2 fw-bold rounded-3 btn-next"
                                            onclick="quizApp.changeStep(1)">
                                        Siguiente <i class="bi bi-chevron-right ms-1"></i>
                                    </button>
                                @else
                                    <button type="button"
                                            class="btn btn-primary px-4 py-2 fw-bold rounded-3 btn-finish"
                                            onclick="finishTest(false)">
                                        Finalizar Test <i class="bi bi-check2-all ms-1"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </main>

    <script src="/resources/js/test.js"></script>
    <script>
        quizApp.init({{ $test->max_note }});

        const max_time = {{ $time }};
        let time_transcurred = 0;

        let timerInterval = setInterval(() => {
            time_transcurred++;
            quizApp.time(time_transcurred, max_time);
        }, 1000);
    </script>

    @include("partials.footer")
    @include("partials.scripts")
</body>
</html>