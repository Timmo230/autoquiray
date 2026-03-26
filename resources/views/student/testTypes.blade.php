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
    <link rel="stylesheet" href="/resources/css/tests.css">
</head>

<body class="bg-main">

    @include("partials.nav", ['uri' => $uri])

    <main class="container-xl mb-5">

        <!-- Header -->
        <div class="pt-4 mt-2">
            <h2 class="fw-bold mb-2">Plataforma de Test</h2>
            <p class="text-muted fs-5 opacity-75 mb-0">
                Prepárate para el examen teórico de la DGT con nuestros tests actualizados
            </p>
        </div>

        <!-- Grid -->
        <div class="row row-cols-1 row-cols-md-2 gx-4 gy-4 mt-3">

            <!-- SEÑALES -->
            <div class="col senales">
                <div class="card test-card rounded-4 p-4 h-100 border-0">

                    <div class="d-flex justify-content-between align-items-start">
                        <img src="/resources/img/tests/senales.png"
                             alt="Icono señales"
                             class="rounded-4 test-img">

                        <span class="badge rounded-pill px-3 py-2">
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

                            <a href="{{ route('student.test', ['type'=> 'senales']) }}"
                               class="btn btn-green-aq btngreenLight rounded-3 px-4 text-white btn-t">
                                Mostrar
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- CIRCULACIÓN -->
            <div class="col circulacion">
                <div class="card test-card rounded-4 p-4 h-100 border-0">

                    <div class="d-flex justify-content-between align-items-start">
                        <img src="/resources/img/tests/circulacion.png"
                             alt="Icono circulación"
                             class="rounded-4 test-img">

                        <span class="badge rounded-pill px-3 py-2">
                            30 preguntas
                        </span>
                    </div>

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

                            <a href="{{ route('student.test', ['type' => 'circulacion']) }}"
                               class="btn btn-green-aq btngreenLight rounded-3 px-4 text-white btn-t">
                                Mostrar
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- SEGURIDAD -->
            <div class="col seguridad">
                <div class="card test-card rounded-4 p-4 h-100 border-0">

                    <div class="d-flex justify-content-between align-items-start">
                        <img src="/resources/img/tests/seguridad.png"
                             alt="Icono seguridad vial"
                             class="rounded-4 test-img">

                        <span class="badge rounded-pill px-3 py-2">
                            30 preguntas
                        </span>
                    </div>

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

                            <a href="{{ route('student.test', ['type' => 'seguridad']) }}"
                               class="btn btn-green-aq btngreenLight rounded-3 px-4 text-white btn-t">
                                Mostrar
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- OFICIAL -->
            <div class="col oficial">
                <div class="card test-card rounded-4 p-4 h-100 border-0">

                    <div class="d-flex justify-content-between align-items-start">
                        <img src="/resources/img/tests/oficial.png"
                             alt="Icono test oficial"
                             class="rounded-4 test-img">

                        <span class="badge rounded-pill px-3 py-2">
                            Oficial DGT
                        </span>
                    </div>

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

                            <a href="{{ route('student.test', ['type' => 'dgt']) }}"
                               class="btn btn-green-aq btngreenLight rounded-3 px-4 text-white btn-t">
                                Mostrar
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