@php
    $uri = request()->path();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    @include("partials.links")
    <link rel="stylesheet" href="{{ asset('resources/css/results.css') }}">
</head>
<body class="bg-main">
    @include("partials.nav", ['uri' => $uri])

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 p-4 text-center results-card">

                    <div class="position-relative d-inline-block mx-auto mb-4">
                        <div class="progress-circle" id="porcentage">
                            <div class="progress-value">
                                <h2 class="fw-bold mb-0" id="porcentage_text">3%</h2>
                                <small class="text-muted">Aciertos</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h3 class="fw-bold text-white mb-2" id="result_title">Necesitas más práctica</h3>
                        <p class="text-muted mb-0">Has completado el test correctamente</p>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-4">
                            <div class="stat-box p-3 rounded-4 stat-success">
                                <h4 class="fw-bold mb-0 stat-value">{{ $successes }}</h4>
                                <small class="d-block stat-label">Aciertos</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box p-3 rounded-4 stat-fail">
                                <h4 class="fw-bold mb-0 stat-value">{{ $failed }}</h4>
                                <small class="d-block stat-label">Fallos</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box p-3 rounded-4 stat-time">
                                <h4 class="fw-bold mb-0 stat-value" id="time">00:10</h4>
                                <small class="d-block stat-label">Tiempo</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('student.testType') }}"
                           class="btn btn-green-aq btngreenLight px-4 fw-semibold rounded-3">
                            Nuevo Test
                        </a>

                        <a href="{{ route('student.showCorrectedTest', ['id' => $testId]) }}"
                           class="btn btn-outline-light px-4 fw-semibold rounded-3 btn-ghost">
                            Test corregido
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include("partials.footer")
    @include("partials.scripts")
    <script src="{{ asset('resources/js/result.js') }}"></script>
    <script>
        const successes = {{ $successes }};
        const max_note = {{ $max_note }};
        assignStyle(successes, max_note);
        time({{ $time }});
        window.trackEvent('test_results_viewed', {
            test_id: '{{ $testId }}',
            score: '{{ $successes }}',
            max_score: '{{ $max_note }}',
            failed: '{{ $failed }}'
        });
    </script>
</body>
</html>
