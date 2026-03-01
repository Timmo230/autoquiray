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

    <main class="container-xl mb-5">
        <div class="pt-4 mt-2">
            @if($categoria == 'senales')
                <h2 class="fw-bold mb-2">Tests sobre señales de trafico</h2>
            @elseif($categoria == 'circulacion')
                <h2 class="fw-bold mb-2">Tests sobre circulacion vial</h2>
            @elseif($categoria == 'seguridad')
                <h2 class="fw-bold mb-2">Tests sobre seguridad vial</h2>
            @elseif($categoria == 'dgt')
                <h2 class="fw-bold mb-2">Tests Oficiales de la DGT</h2>
            @endif

            <p class="text-muted fs-5 opacity-75 fw-normal mb-0">
                Prepárate para el examen teórico de la DGT con nuestros tests actualizados
            </p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 gx-4 gy-4 mt-3">
            @foreach ($tests as $test)
                @php
                    $registroCompletado = $testsOfStudent->firstWhere('id', $test->id);

                    // ✅ En vez de clases bg-* claras, usamos clases de estado propias (CSS)
                    $statusClass = 'status-new';
                    $statusLabel = 'Sin hacer';

                    if ($registroCompletado) {
                        $nota = $registroCompletado->last_note;

                        if ($nota == $test->max_note) {
                            $statusClass = 'status-perfect';
                            $statusLabel = 'Perfecto';
                        } elseif ($nota >= $test->max_note - 3) {
                            $statusClass = 'status-good';
                            $statusLabel = 'Bien';
                        } else {
                            $statusClass = 'status-bad';
                            $statusLabel = 'A mejorar';
                        }
                    }
                @endphp

                <div class="col my-2 {{ $iconos[$categoria] }}" id="{{ $test->id }}">
                    <div class="card test-card rounded-4 p-4 h-100 border-0 {{ $statusClass }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center gap-3">
                                <img src="/autoquiray/resources/img/tests/{{ $iconos[$categoria] }}.png"
                                     alt="Icono {{ $categoria }}"
                                     class="rounded-4 test-img">

                                <!-- Estado del test (badge) -->
                                <span class="badge rounded-pill px-3 py-2 status-badge">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <span class="badge rounded-pill px-3 py-2 questions-badge">
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

                                <a href="{{ route('student.complete_test', ['id'=> $test->id]) }}"
                                   class="btn btn-green-aq btngreenLight rounded-3 px-4 text-white btn-t">
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