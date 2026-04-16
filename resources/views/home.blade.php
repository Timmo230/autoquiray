@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTOQUIRAY | Tu Autoescuela Digital</title>
    @include('partials.links')
    <link rel="stylesheet" href="{{ asset('resources/css/index.css') }}">
</head>
<body class="bg-navbar">   
    @include('partials.nav', ['uri' => $uri])

    <header class="pt-5 position-relative overflow-hidden bg-linear-blue">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
            style="background: radial-gradient(circle at 50% 20%, rgba(37, 99, 235, 0.2), transparent 70%); pointer-events: none;">
        </div>

        <div class="container pt-5 pb-5 position-relative" style="z-index: 2;">
            <div class="d-flex justify-content-center mb-3">
                <span class="badge-status">
                    <i class="fa-solid fa-circle-check me-2 text-green-btn"></i>Plataforma Activa 2026
                </span>
            </div>

            <div class="text-center mb-4">
                <h1 class="fw-bold text-light display-1 brand-title">AUTOQUIRAY</h1>
                <h3 class="text-green-btn fw-light ls-2">Tu autoescuela digital</h3>
            </div>

            <div class="row justify-content-center text-center">
                <div class="col-12 col-lg-8">
                    <h5 class="text-secondary text-light opacity-50 lh-base">
                        Aprende a conducir con la mejor tecnología. Tests online, seguimiento personalizado 
                        y reserva de clases desde cualquier dispositivo.
                    </h5>
                </div>
            </div>
            
            <div class="row justify-content-center text-center mt-5 g-3">
                <div class="col-12 col-sm-6 col-md-auto">
                    <a class="btn btn-green-btn rounded-pill px-5 py-3 text-light fs-5-5 fw-bold arriba w-sm-100 d-flex align-items-center justify-content-center" href="{{ url('/tipos_de_test') }}" data-plausible-event="home_tests_cta_clicked">
                        <i class="fa-regular fa-file-lines me-2"></i>Acceder a mis tests
                    </a>
                </div>

                <div class="col-12 col-sm-6 col-md-auto">
                    <a class="btn btn-outline-light rounded-pill px-5 py-3 fw-bold fs-5-5 arriba w-sm-100 d-flex align-items-center justify-content-center shadow-sm" id="iniciarSesion" href="{{ url('login') }}" data-plausible-event="home_login_cta_clicked">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>

        <div class="wave-divider">
            <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path d="M0,40 C240,80 480,80 720,60 960,40 1200,40 1440,60 L1440,100 L0,100 Z"></path>
            </svg>
        </div>
    </header>

    <main class="d-flex flex-column pt-5 align-content-center bg-main">
        <article class="d-flex flex-column">
            
            <section class="text-center py-4 mb-5">
                <h2 class="fs-1 fw-bolder">Ventajas de nuestra plataforma</h2>
                <h5 class="opacity-50">Todo lo necesario para obtener tu carnet de conducir en un solo lugar</h5>
            </section>

            <section class="container px-3 mb-5 mt-3">
                <div class="cards-flex justify-content-center">
                    
                    <div class="card card-flex ventajas arriba shadow border-0">
                        <div class="icon-container mb-3">
                            <img src="/resources/img/ventajas/tests.png" alt="Tests">
                        </div>
                        <h4>Test Online</h4>
                        <p class="text-secondary opacity-75">Miles de preguntas actualizadas según la normativa DGT vigente</p>
                    </div>

                    <div class="card card-flex ventajas arriba shadow border-0">
                        <div class="icon-container mb-3">
                            <img src="/resources/img/ventajas/Progreso.png" alt="Progreso">
                        </div>
                        <h4>Seguimiento</h4>
                        <p class="text-secondary opacity-75">Visualiza tu evolución con estadísticas detalladas y gráficos</p>
                    </div>

                    <div class="card card-flex ventajas arriba shadow border-0">
                        <div class="icon-container mb-3">
                            <img src="/resources/img/ventajas/Reserva.png" alt="Reserva">
                        </div>
                        <h4>Reserva de Clases</h4>
                        <p class="text-secondary opacity-75">Programa tus clases prácticas fácilmente desde la app</p>
                    </div>

                    <div class="card card-flex ventajas arriba shadow border-0">
                        <div class="icon-container mb-3">
                            <img src="/resources/img/ventajas/atencion.png" alt="Soporte">
                        </div>
                        <h4>Atención</h4>
                        <p class="text-secondary opacity-75">Soporte personalizado para resolver todas tus dudas</p>
                    </div>

                </div>
            </section>

            <section class="my-5">
                <h2 class="fs-1 fw-bolder text-center mb-4">Vehículos de Autoquiray</h2>
                <div id="carouselExample" class="carousel slide container">
                    <div class="carousel-inner glass-panel p-3">
                        <div class="carousel-item active">
                            <model-viewer src="/storage/models/motorbike1.glb" ar camera-controls touch-action="pan-y" style="width: 100%; height: 400px;"></model-viewer>
                        </div>
                        <div class="carousel-item">
                            <model-viewer src="/storage/models/Untitled.glb" ar camera-controls touch-action="pan-y" style="width: 100%; height: 400px;"></model-viewer>
                        </div>
                        <div class="carousel-item">
                            <model-viewer src="/storage/models/motorbike2.glb" ar camera-controls touch-action="pan-y" style="width: 100%; height: 400px;"></model-viewer>
                        </div>
                        <div class="carousel-item">
                            <model-viewer src="/storage/models/car1.glb" ar camera-controls touch-action="pan-y" style="width: 100%; height: 400px;"></model-viewer>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    </button>
                </div>
            </section>

            <section class="mt-5 pb-5">
                <div class="container py-5">
                    <div class="cards-flex justify-content-center text-center">
                        
                        <div class="card-flex data glass-stat border-green">
                            <p class="text-green-btn fs-1 fw-bold m-0">{{ $output }}%</p>
                            <p class="text-light opacity-75 fs-5">Aprobados a la primera</p>
                        </div>

                        <div class="card-flex data glass-stat border-blue">
                            <p class="text-blue fs-1 fw-bold m-0">{{ $totalQuestions }}</p>
                            <p class="text-light opacity-75 fs-5">Preguntas disponibles</p>
                        </div>

                        <div class="card-flex data glass-stat border-purple">
                            <p class="text-purple fs-1 fw-bold m-0">{{ $totalStudentsActives }}</p>
                            <p class="text-light opacity-75 fs-5">Alumnos activos</p>
                        </div>

                        <div class="card-flex data glass-stat border-orange">
                            <p class="text-orange fs-1 fw-bold m-0">15</p>
                            <p class="text-light opacity-75 fs-5">Años de experiencia</p>
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
