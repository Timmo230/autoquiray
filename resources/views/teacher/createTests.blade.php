@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Autoquiray | Creador Pro</title>
    @include("partials.links")
    <link rel="stylesheet" href="/resources/css/createTests.css">
</head>
<body>
    @include("partials.nav", ["uri" => $uri])

    <main class="content-container">
        <form action="#" method="POST" id="examForm">
            @csrf
            
            <div class="glass-card mb-5 animate__animated animate__fadeInDown">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-green-btn p-2 rounded-3 me-3" style="background-color: #10b981;">
                        <i class="fa-solid fa-file-signature text-dark"></i>
                    </div>
                    <h2 class="h4 mb-0 text-white">Configuración del Examen</h2>
                </div>
                
                <div class="row g-4">
                    <div class="col-12">
                        <label class="small fw-bold text-grey mb-2 uppercase">
                            Título del Test
                        </label>
                        <input type="text"
                            name="title"
                            id="title"
                            class="form-control input-autoquiray"
                            placeholder="Ej: Señalización y Prioridad"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-grey mb-2">
                            Tipo de Test
                        </label>
                        <select name="type" id="type" class="form-select input-autoquiray" required>
                            <option value="" disabled selected>
                                Selecciona un tipo
                            </option>
                            <option value="senales">
                                Test de Señales
                            </option>
                            <option value="circulacion">
                                Test de Circulación
                            </option>
                            <option value="seguridad">
                                Test de Seguridad Vial
                            </option>
                            <option value="dgt">
                                Test Oficial DGT
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-grey mb-2">
                            Tiempo Máximo (min)
                        </label>
                        <input type="number"
                            name="max_time"
                            id="max_time"
                            class="form-control input-autoquiray"
                            placeholder="30"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-grey mb-2">
                            Nº Preguntas a Generar
                        </label>
                        <div class="input-group">
                            <input type="number"
                                id="num_questions"
                                class="form-control input-autoquiray"
                                value="1"
                                min="1">
                            <button type="button"
                                    class="btn btn-autoquiray px-4"
                                    onclick="initBuilder()">
                                Generar
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div id="dynamic-area" style="display:none;">
                <div class="glass-card animate__animated animate__fadeInUp">
                    <h3 class="h5 mb-4 d-flex align-items-center">
                        <span class="badge border border-green text-green me-2">Paso 2</span>
                        Diseño de Cuestiones
                    </h3>
                    
                    <div id="questions-wrapper"></div>

                    <div class="mt-5 pt-4 border-top border-secondary text-center">
                        <button type="submit" class="btn btn-autoquiray btn-lg px-5 shadow-lg">
                            <i class="fa-solid fa-rocket me-2"></i> Publicar en Autoquiray
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    @include("partials.footer")
    @include("partials.scripts")

    <script src="\autoquiray\resources\js\createTests.js"></script>
</body>
</html>