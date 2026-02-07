@php
    $uri = request()->path();
    $iconos = [
        'senales'    => 'senales',
        'circulacion'=> 'circulacion',
        'seguridad'  => 'seguridad',
        'dgt'        => 'oficial'
    ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tests Online</title>
    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/tests.css">
</head>
<body class="bg-main">
    @include("partials.nav", ['uri' => $uri])
    <main class="container-fluid mb-5">
        <div class="px-1 pt-3 rubik mt-2">
            @if($categoria == 'senales')
                <h2>Tests sobre señales de trafico</h2>
            @elseif($categoria == 'circulacion')
                <h2>Tests sobre circulacion vial</h2>
            @elseif($categoria == 'seguridad')
                <h2>Tests sobre seguridad vial</h2>
            @elseif($categoria == 'dgt')
                <h2>Tests Oficiales de la DGT</h2>
            @endif
            <p class="fs-5-5 opacity-50 fw-normal">Prepárate para el examen teórico de la DGT con nuestros tests actualizados</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 p-1 container-fluid">
            @foreach ($tests as $test)
                @php
                    $registroCompletado = $testsOfStudent->firstWhere('id', $test->id);
                    $clase = 'bg-white text-dark'; 

                    if ($registroCompletado) {
                        $nota = $registroCompletado->last_note;
                        
                        $clase = match (true) {
                            $nota == 30 => 'bg-success-subtle',
                            $nota >= 27 => 'bg-warning-subtle',
                            default     => 'bg-danger-subtle',
                        };
                    }
                @endphp
                <div class="col my-2 {{ $iconos[$categoria] }} px-2" id="{{ $test->id }}">
                    <div class="card border-0 rounded-4 p-4 test-card shadow {{ $clase }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <img src="/autoquiray/resources/img/tests/{{ $iconos[$categoria] }}.png" 
                                alt="Icono {{ $categoria }}" alt="Icono señales"
                                class="rounded-4"
                                style="width:60px; height:60px; object-fit:cover;">
                            </div>
                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                {{ $test->max_note }} preguntas
                            </span>
                        </div>

                        <div class="mt-3">
                            <h5 class="fw-semibold mb-1">{{ $test->title }}</h5>
                            <p class="text-muted mb-3">
                                Hecho por: {{ $test->name }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted d-flex align-items-center gap-1">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $test->max_note }} min
                                </small>

                                <a href="#" class="btn btn-dark-green btngreenLight arriba rounded-3 px-4 text-white btn-t">
                                    Empezar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    @include("partials.footer") 
    @include("partials.scripts")
</body>
</html>