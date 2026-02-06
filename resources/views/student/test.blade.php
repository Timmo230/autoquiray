@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests Online</title>
    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/tests.css">
</head>
<body class="bg-main">
    @include("partials.nav", ['uri' => $uri])

    <main class="container-fluid mb-5">
        <div class="px-1 pt-3 rubik mt-2">
            <h2>Plataforma de Test</h2>
            <p class="fs-5-5 opacity-50 fw-normal">Prepárate para el examen teórico de la DGT con nuestros tests actualizados</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 p-1 container-fluid">
            <div class="col my-2 senales px-2">
                <div class="card border-0 rounded-4 p-4 test-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <img src="/autoquiray/resources/img/tests/senales.png" alt="Icono señales"
                                class="rounded-4"
                                style="width:60px; height:60px; object-fit:cover;">
                        </div>
                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                            30 preguntas
                        </span>
                    </div>

                    <div class="mt-3">
                        <h5 class="fw-semibold mb-1">Test de Señales</h5>
                        <p class="text-muted mb-3">
                            Practica el reconocimiento de señales de tráfico
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted d-flex align-items-center gap-1">
                                <i class="fa-regular fa-clock"></i>
                                ~20 min
                            </small>

                            <a href="#" class="btn btn-dark-green btngreenLight arriba rounded-3 px-4 text-white btn-t">
                                Empezar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col my-2 circulacion px-2">
                <div class="card border-0 rounded-4 p-4 test-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <img src="/autoquiray/resources/img/tests/circulacion.png" alt="Icono señales"
                                class="rounded-4"
                                style="width:60px; height:60px; object-fit:cover;">
                        </div>
                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                            30 preguntas
                        </span>
                    </div>

                    <!-- Contenido -->
                    <div class="mt-3">
                        <h5 class="fw-semibold mb-1">Test de Circulación</h5>
                        <p class="text-muted mb-3">
                            Normas de circulación y prioridad en vía
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted d-flex align-items-center gap-1">
                                <i class="fa-regular fa-clock"></i>
                                ~25 min
                            </small>

                            <a href="#" class="btn btn-dark-green btngreenLight arriba rounded-3 px-4 text-white btn-t">
                                Empezar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col my-2 seguridad px-2">
                <div class="card border-0 rounded-4 p-4 test-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <img src="/autoquiray/resources/img/tests/seguridad.png" alt="Icono señales"
                                class="rounded-4"
                                style="width:60px; height:60px; object-fit:cover;">
                        </div>
                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                            30 preguntas
                        </span>
                    </div>

                    <!-- Contenido -->
                    <div class="mt-3">
                        <h5 class="fw-semibold mb-1">Test de Seguridad Vial</h5>
                        <p class="text-muted mb-3">
                            Conducción segura y prevención de accidentes
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted d-flex align-items-center gap-1">
                                <i class="fa-regular fa-clock"></i>
                                ~20 min
                            </small>

                            <a href="#" class="btn btn-dark-green btngreenLight arriba rounded-3 px-4 text-white btn-t">
                                Empezar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col my-2 oficial px-2">
                <div class="card border-0 rounded-4 p-4 test-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <img src="/autoquiray/resources/img/tests/oficial.png" alt="Icono señales"
                                class="rounded-4"
                                style="width:60px; height:60px; object-fit:cover;">
                        </div>
                        <span class="badge rounded-pill bg-green-btn text-white px-3 py-2">
                            Oficial DGT
                        </span>
                    </div>

                    <!-- Contenido -->
                    <div class="mt-3">
                        <h5 class="fw-semibold mb-1">Test Oficial DGT</h5>
                        <p class="text-muted mb-3">
                            Simulacro completo del examen oficial
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted d-flex align-items-center gap-1">
                                <i class="fa-regular fa-clock"></i>
                                ~20 min
                            </small>

                            <a href="#" class="btn btn-dark-green btngreenLight arriba rounded-3 px-4 text-white btn-t">
                                Empezar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include("partials.footer") 
    @include("partials.scripts")
</body>
</html>