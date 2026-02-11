@php
    $uri = request()->path();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/results.css">
</head>
<body class="bg-main">
    @include("partials.nav", ['uri' => $uri])

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm p-4 text-center results-card">
                    
                    <div class="position-relative d-inline-block mx-auto mb-4">
                        <div class="progress-circle green shadow-sm">
                            <div class="progress-value">
                                <h2 class="fw-bold mb-0">3%</h2>
                                <small class="text-muted">Aciertos</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h3 class="fw-bold text-dark">Necesitas más práctica</h3>
                        <p class="text-secondary">Has completado el test correctamente</p>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-4">
                            <div class="stat-box bg-success-subtle p-3 rounded-4">
                                <h4 class="fw-bold text-success mb-0">1</h4>
                                <small class="text-success d-block">Aciertos</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box bg-danger-subtle p-3 rounded-4">
                                <h4 class="fw-bold text-danger mb-0">29</h4>
                                <small class="text-danger d-block">Fallos</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box bg-primary-subtle p-3 rounded-4">
                                <h4 class="fw-bold text-primary mb-0">0:10</h4>
                                <small class="text-primary d-block">Tiempo</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="btn btn-dark btn-lg px-4 fw-semibold rounded-3">Nuevo Test</a>
                        <a href="#" class="btn btn-light btn-lg px-4 fw-semibold rounded-3 text-secondary border">Ver Historial</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include("partials.footer")
    @include("partials.scripts")
</body>
</html>