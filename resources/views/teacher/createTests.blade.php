@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoquiray | Creador Pro</title>
    @include("partials.links")
    <style>
        /* Aplicando la paleta futurista directamente */
        body { 
            background-color: #0f172a; /* $main */
            color: #f8fafc; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-container {
            flex: 1 0 auto;
            max-width: 900px;
            margin: 0 auto;
            padding: 4rem 1rem;
        }

        .glass-card {
            background: #1e293b; /* $footer/card-bg */
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-autoquiray {
            background: #0f172a !important;
            border: 1px solid #334155 !important;
            color: #f8fafc !important;
            border-radius: 0.75rem;
        }

        .input-autoquiray:focus {
            border-color: #10b981 !important; /* $green-btn */
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.2);
        }

        .btn-autoquiray {
            background-color: #10b981;
            color: #0f172a;
            font-weight: 700;
            border-radius: 0.75rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-autoquiray:hover {
            background-color: #34d399;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4);
        }

        .question-node {
            background: rgba(2, 6, 23, 0.4);
            border-left: 4px solid #10b981;
            padding: 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    @include("partials.nav", ["uri" => $uri])

    <main class="content-container">
        <form action="#" method="POST">
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
                        <label class="small fw-bold text-grey mb-2 uppercase">Título del Test</label>
                        <input type="text" name="title" class="form-control input-autoquiray" placeholder="Ej: Señalización y Prioridad" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-grey mb-2">Tiempo Máximo (min)</label>
                        <input type="number" name="max_time" class="form-control input-autoquiray" placeholder="30" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small fw-bold text-grey mb-2">Nº Preguntas a Generar</label>
                        <div class="input-group">
                            <input type="number" id="num_questions" class="form-control input-autoquiray" value="1" min="1">
                            <button type="button" class="btn btn-autoquiray px-4" onclick="initBuilder()">Generar</button>
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

    <script>
        function initBuilder() {
            const qty = document.getElementById('num_questions').value;
            const wrapper = document.getElementById('questions-wrapper');
            const area = document.getElementById('dynamic-area');
            
            wrapper.innerHTML = '';
            area.style.display = 'block';

            for (let i = 0; i < qty; i++) {
                wrapper.innerHTML += `
                    <div class="question-node animate__animated animate__fadeIn">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold text-green">CUESTIÓN #${i + 1}</span>
                            <i class="fa-solid fa-circle-question opacity-25"></i>
                        </div>
                        <div class="mb-4">
                            <input name="questions[${i}][title]" class="form-control input-autoquiray" placeholder="¿Cuál es la respuesta correcta ante...?" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text bg-transparent border-secondary text-white">A</span>
                                    <input type="text" name="questions[${i}][options][0]" class="form-control input-autoquiray" required>
                                </div>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text bg-transparent border-secondary text-white">B</span>
                                    <input type="text" name="questions[${i}][options][1]" class="form-control input-autoquiray" required>
                                </div>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-transparent border-secondary text-white">C</span>
                                    <input type="text" name="questions[${i}][options][2]" class="form-control input-autoquiray">
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <label class="small text-green fw-bold mb-2 d-block">SOLUCIÓN</label>
                                <select name="questions[${i}][correct_option]" class="form-select input-autoquiray h-75">
                                    <option value="0">Opción A</option>
                                    <option value="1">Opción B</option>
                                    <option value="2">Opción C</option>
                                </select>
                            </div>
                        </div>
                    </div>
                `;
            }
            window.scrollTo({ top: area.offsetTop - 50, behavior: 'smooth' });
        }
    </script>
</body>
</html>