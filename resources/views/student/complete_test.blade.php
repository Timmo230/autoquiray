@php
    $uri = request()->path();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=`, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Haciendo test...</title>
    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/complete_test.css">
</head>
<body class="bg-main">
    @include("partials.nav", ['uri' => $uri])

    <main class="container-fluid pb-5">
        <div class="px-1 pt-3 rubik mt-2 container-fluid">
            <h2>Plataforma de Test</h2>
            <p class="fs-5-5 opacity-50 fw-normal">Prepárate para el examen teórico de la DGT con nuestros tests actualizados</p>
        </div>
        <form action="">
            @foreach($questions as $index => $group)
                @php 
                    $first = $group->first(); 
                    $qId = $first->question_id;
                @endphp
                
                <div class="question-step" id="{{ $index }}" style="display: {{ $index == 0 ? 'block' : 'none' }}">
                    <div class="card shadow border-0 rounded-4">
                        <div class="card-header bg-transparent border-0 p-4 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h1 class="h4 fw-bold text-navbar mb-0">{{ $test->title }}</h1>
                                    <small class="text-grey">Pregunta {{ $index + 1 }} de {{ $test->max_note }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 mt-3">
                            <div class="progress" style="height: 6px;">
                                @php $percentage = (($index + 1) / $test->max_note) * 100; @endphp
                                <div class="progress-bar bg-green" role="progressbar" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <h2 class="h5 fw-bold text-dark mb-4">{{ $first->title }}</h2>

                            <div class="d-flex flex-column gap-3">
                                @foreach($group as $option)
                                    <input type="radio" 
                                        name="{{ $qId }}" 
                                        id="{{ $option->id }}" 
                                        class="btn-check"
                                        onclick="saveAnswer('{{ $qId }}', '{{ $option->id }}')">
                                    
                                    <label for="{{ $option->id }}" class="btn btn-outline-green text-start p-3 rounded-3 d-flex align-items-center shadow-none border-light-subtle custom-option">
                                        <span class="custom-radio me-3"></span>
                                        <span class="text-dark">{{ $option->option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer bg-transparent border-0 p-4 pt-0 d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-link text-grey text-decoration-none fw-bold p-0" 
                                    onclick="quizApp.changeStep(-1)" {{ $index == 0 ? 'disabled' : '' }}>
                                <i class="bi bi-chevron-left"></i> Anterior
                            </button>
                            
                            @if($index < $questions->count() - 1)
                                <button type="button" class="btn bg-green-btn text-white px-4 py-2 fw-bold rounded-3" onclick="quizApp.changeStep(1)">
                                    Siguiente <i class="bi bi-chevron-right ms-1"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-primary px-4 py-2 fw-bold rounded-3" onclick="finishTest()">
                                    Finalizar Test <i class="bi bi-check2-all ms-1"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </form>
    </main>

    <script src="/autoquiray/resources/js/test.js"></script>

    <script>
        quizApp.init({{ $test->max_note }});
    </script>
    @include("partials.footer") 
    @include("partials.scripts")
</body>
</html>