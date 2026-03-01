@php
    $uri = request()->path();
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/icons.css">
    <link rel="stylesheet" href="/autoquiray/resources/css/contacto.css">
</head>
<body class="bg-main">

    @include("partials.nav", ['uri' => $uri])

    <main class="container">
        <article class="row row-cols-1 row-cols-lg-2 p-3">
            <section class="col d-flex flex-column my-2">
                <div class="rubik rounded-4 box aq-panel">
                    <div>
                        <h4 class="text-white mb-1">Atención al Cliente</h4>
                        <h5 class="aq-muted mb-0">¿Tienes alguna duda? Estamos aquí para ayudarte</h5>
                    </div>

                    <form action="{{ route('student.contacto') }}" method="POST">
                        @csrf
                        <div class="mb-3 mt-4">
                            <label for="tipo" class="form-label aq-muted">Asunto</label>
                            <select class="form-select mb-3 aq-input" id="tipo" name="tipo">
                                <option value="matricula">Matrícula y documentación</option>
                                <option value="clases">Clases teóricas o prácticas</option>
                                <option value="examenes">Fechas de examen</option>
                                <option value="pagos">Pagos y facturación</option>
                                <option value="tecnico">Problema técnico</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <div class="mb-3" id="otroAsunto"></div>

                        <div class="mb-3">
                            <label for="menssage" class="form-label aq-muted">Mensaje</label>
                            <textarea class="form-control aq-input" id="menssage" name="menssage" rows="6"
                                      placeholder="Escribe tu mensaje aquí"></textarea>
                        </div>

                        <div class="mb-3 d-flex flex-column">
                            <button type="submit" class="btn btn-green-aq btngreenLight rounded-4 p-3 fw-bold">
                                Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <section class="col d-flex flex-column my-2">
                <div class="rubik rounded-4 p-4 aq-panel">
                    <div class="mb-3">
                        <h4 class="text-white mb-0">Información de Contacto</h4>
                    </div>

                    <div class="col d-flex rounded-4 my-2 aq-item">
                        <div class="my-auto aq-chip aq-chip-green px-3 py-2 rounded-4">
                            <i class="fa-solid fa-phone fs-5 my-2"></i>
                        </div>
                        <div class="rubik ps-3 my-auto">
                            <h5 class="text-white mb-1">Teléfono</h5>
                            <h5 class="fw-normal aq-muted mb-0">+34 XXX XXX XXX</h5>
                        </div>
                    </div>

                    <div class="col d-flex rounded-4 my-2 aq-item">
                        <div class="my-auto aq-chip aq-chip-blue px-3 py-2 rounded-4">
                            <i class="fa-regular fa-envelope my-2 fs-5"></i>
                        </div>
                        <div class="rubik ps-3 my-auto">
                            <h5 class="text-white mb-1">Email</h5>
                            <h5 class="fw-normal aq-muted mb-0">info@autoquiray.com</h5>
                        </div>
                    </div>

                    <div class="col d-flex rounded-4 my-2 aq-item">
                        <div class="my-auto aq-chip aq-chip-purple px-3 py-2 rounded-4">
                            <i class="fa-solid fa-location-dot my-2 fs-4"></i>
                        </div>
                        <div class="rubik ps-3 my-auto">
                            <h5 class="text-white mb-1">Dirección</h5>
                            <h5 class="fw-normal aq-muted mb-0">Calle Principal 123, Madrid</h5>
                        </div>
                    </div>
                </div>

                <div class="rubik rounded-4 p-4 my-4 aq-panel">
                    <div class="mb-3">
                        <h4 class="text-white mb-0">Horario de Atención</h4>
                    </div>

                    <div class="col d-flex rounded-4 aq-item">
                        <p class="aq-muted mb-0">Lunes - Viernes</p>
                        <p class="ms-auto mb-0 text-white">09:00 - 20:00</p>
                    </div>
                    <hr class="aq-hr m-0 mb-3">

                    <div class="col d-flex rounded-4 aq-item">
                        <p class="aq-muted mb-0">Sábados</p>
                        <p class="ms-auto mb-0 text-white">09:00 - 14:00</p>
                    </div>
                    <hr class="aq-hr m-0 mb-3">

                    <div class="col d-flex rounded-4 aq-item">
                        <p class="aq-muted mb-0">Domingos</p>
                        <p class="ms-auto mb-0 text-danger">Cerrado</p>
                    </div>
                </div>
            </section>
        </article>
    </main>

    @include("partials.footer")
    @include("partials.scripts")
    <script src="\autoquiray\resources\js\contacto.js"></script>
</body>
</html>