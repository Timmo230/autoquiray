@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTOQUIRAY</title>
    @include('partials.links')
    <link rel="stylesheet" href="/autoquiray/resources/css/index.css">
</head>
<body class="bg-navbar">   
    @include('partials.nav', ['uri' => $uri])

    <header class="pt-5 position-relative overflow-hidden bg-linear-blue">
        <div class="container pt-5">
            <div class="d-flex justify-content-center">
                <p class="btn text-green-btn bg-navbar bg-opacity-50 p-2 px-4 rounded-pill fw-semibold">
                    <span class="opacity-100">Plataforma Activa</span>
                </p>
            </div>
            <div class="d-flex justify-content-center">
                <h1 class="fw-bold text-light">AUTOQUIRAY</h1>
            </div>
            <div class="d-flex justify-content-center">
                <h3 class="text-green-btn">Tu autoescuela digital</h3>
            </div>
            <div class="d-flex justify-content-center text-center mt-3">
                <h5 class="text-secondary text-light opacity-50">Aprende a conducir con la mejor tecnología. Tests online, seguimiento personalizado y reserva de clases desde cualquier dispositivo.</h5>
            </div>
            <div class="row justify-content-center text-center mt-5 g-3">
                <div class="col-12 col-sm-6">
                    <a class="btn btn-green-btn rounded-4 p-3 text-light fs-5-5 fw-bold w-100 btngreenLight arriba mb-4" href="{{ url('/tipos_de_test') }}">
                        <i class="fa-regular fa-file-zipper me-2"></i>Acceder a mis tests
                    </a>
                </div>

                <div class="col-12 col-sm-6">
                    <a class="btn text-light rounded-4 p-3 border fw-bold fs-5-5 w-100" id="iniciarSesion" href="{{ url('login') }}">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>

        <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
            <path
                d="M0,40 
                C240,80 480,80 720,60 
                960,40 1200,40 1440,60 
                L1440,100 L0,100 Z"
                fill="#f8fafc">
            </path>
        </svg>
    </header>

    <main class="d-flex flex-column pt-5 align-content-center bg-main">
        <article class="d-flex flex-column">
            <section class="text-center py-4 mb-5">
                <h2 class="fs-1 fw-bolder">Ventajas de nuestra plataforma</h2>
                <h5 class="opacity-50">Todo lo necesario para obtener tu carnet de conducir en un solo lugar</h5>
            </section>
            <section class="container-fluid px-3 mb-5 mt-3">
                <div class="d-flex flex-wrap justify-content-center gap-3 align-items-stretch cards-flex">
                    <div class="card bg-white p-4 rounded-4 card-flex ventajas arriba shadow">
                        <div class="mb-2">
                            <img src="/autoquiray/resources/img/ventajas/tests.png" alt="">
                        </div>
                        <h4>Test Online</h4>
                        <p>Miles de preguntas actualizadas según la normativa DGT vigente</p>
                    </div>

                    <div class="card bg-white p-4 rounded-4 card-flex ventajas arriba shadow">
                        <div class="mb-2">
                            <img src="/autoquiray/resources/img/ventajas/Progreso.png" alt="">
                        </div>
                        <h4>Seguimiento de Progreso</h4>
                        <p>Visualiza tu evolución con estadísticas detalladas y gráficos</p>
                    </div>

                    <div class="card bg-white p-4 rounded-4 card-flex ventajas arriba shadow">
                        <div class="mb-2">
                            <img src="/autoquiray/resources/img/ventajas/Reserva.png" alt="">
                        </div>
                        <h4>Reserva de Clases</h4>
                        <p>Programa tus clases prácticas fácilmente desde la app</p>
                    </div>

                    <div class="card bg-white p-4 rounded-4 card-flex ventajas arriba shadow">
                        <div class="mb-2">
                            <img src="/autoquiray/resources/img/ventajas/atencion.png" alt="">
                        </div>
                        <h4>Atención al Alumno</h4>
                        <p>Soporte personalizado para resolver todas tus dudas</p>
                    </div>
                </div>
            </section>
            <section class="my-3">
                <div>
                    <h2 class="fs-1 fw-bolder text-center">Vehiculos de Autoquiray</h2>
                </div>

                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <model-viewer 
                                src="{{ asset('storage/models/motorbike1.glb') }}" 
                                ar 
                                camera-controls 
                                touch-action="pan-y" 
                                alt="Un modelo 3D de Autoquiray"
                                style="width: 100%; height: 400px; background-color: #f8f9fa;">
                            </model-viewer>
                        </div>
                        <div class="carousel-item">
                            <model-viewer 
                                src="{{ asset('storage/models/motorbike2.glb') }}" 
                                ar 
                                camera-controls 
                                touch-action="pan-y" 
                                alt="Un modelo 3D de Autoquiray"
                                style="width: 100%; height: 400px; background-color: #f8f9fa;">
                            </model-viewer>
                        </div>
                        <div class="carousel-item">
                            <model-viewer 
                                src="{{ asset('storage/models/Untitled.glb') }}" 
                                ar 
                                camera-controls 
                                touch-action="pan-y" 
                                alt="Un modelo 3D de Autoquiray"
                                style="width: 100%; height: 400px; background-color: #f8f9fa;">
                            </model-viewer>
                        </div>
                        <div class="carousel-item">
                            <model-viewer 
                                src="{{ asset('storage/models/car1.glb') }}" 
                                ar 
                                camera-controls 
                                touch-action="pan-y" 
                                alt="Un modelo 3D de Autoquiray"
                                style="width: 100%; height: 400px; background-color: #f8f9fa;">
                            </model-viewer>
                        </div>
                    </div>
                    <button class="carousel-control-prev bg-secondary" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next bg-secondary" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>
            <section class="mt-5">
                <div class="container-fluid bg-white pt-4">
                    <div class="d-flex flex-wrap gap-3 align-items-stretch cards-flex justify-content-center text-center">
                        <div class="card-flex data">
                            <p class="text-green-btn fs-2 fw-bold m-0">{{ $output }}%</p>
                            <p class="text-secondary opacity-75 fs-5">Aprobados a la primera</p>
                        </div>
                        <div class="card-flex data">
                            <p class="text-blue fs-2 fw-bold m-0">{{ $totalQuestions }}</p>
                            <p class="text-secondary opacity-75 fs-5">Preguntas disponibles</p>
                        </div>
                        <div class="card-flex data">
                            <p class="text-purple fs-2 fw-bold m-0">{{ $totalStudentsActives }}</p>
                            <p class="text-secondary opacity-75 fs-5">Alumnos activos</p>
                        </div>
                        <div class="card-flex data">
                            <p class="text-orange fs-2 fw-bold m-0">15</p>
                            <p class="text-secondary opacity-75 fs-5">Años de experiencia</p>
                        </div>
                    </div>
                </div>
            </section>
        </article>
    </main>

    @include("partials.footer")
    @include("partials.scripts")
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/4.0.0/model-viewer.min.js"></script>
</body>
</html>