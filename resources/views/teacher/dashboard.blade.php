@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona de Profesores</title>
    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/icons.css">
    <link rel="stylesheet" href="/autoquiray/resources/css/zonaProfesores.css">
</head>
<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container mb-3">
        <article>
            <section>
                <div class="px-3 pt-3 rubik mt-2">
                    <h2>Zona Profesores</h2>
                    <p class="fs-5-5 opacity-50 fw-normal">Panel de gestión de alumnos y seguimiento</p>
                </div>
            </section>
            <section class="row row-cols-1 row-cols-md-3 px-3 g-3">
                <div class="col">
                    <div class="bg-white p-3 rounded-4 shadow d-flex align-items-center justify-content-between">
                    <div>
                        <p class="opacity-50 mb-0 fs-5">Total Alumnos</p>
                        <p class="fs-3 fw-bold mb-0">24</p>
                    </div>
                    <div class="green icon rounded-4 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-user fs-2"></i>
                    </div>
                    </div>
                </div>

                <div class="col">
                    <div class="bg-white p-3 rounded-4 shadow d-flex align-items-center justify-content-between">
                    <div>
                        <p class="opacity-50 mb-0 fs-5">Clases Hoy</p>
                        <p class="fs-3 fw-bold mb-0">8</p>
                    </div>
                    <div class="blue icon rounded-4 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-calendar fs-2"></i>
                    </div>
                    </div>
                </div>

                <div class="col">
                    <div class="bg-white p-3 rounded-4 shadow d-flex align-items-center justify-content-between">
                    <div>
                        <p class="opacity-50 mb-0 fs-5">Tests Realizados</p>
                        <p class="fs-3 fw-bold mb-0">156</p>
                    </div>
                    <div class="purple icon rounded-4 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-file fs-2"></i>
                    </div>
                    </div>
                </div>
            </section>
            <section class="my-4">
                <div class="bg-white rounded-4 mx-2 pt-3">
                    <div class="d-flex align-items-center ms-3">
                        <h3 class="rubik fs-3">Lista de Alumnos</h3>
                    </div>
                    <div class="container-fluid my-4 p-0">
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="table-responsive shadow-sm table-container">
                                <table class="table align-middle mb-0 table-hover">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Alumno</th>
                                        <th>Progreso Teórico</th>
                                        <th>Clases Prácticas</th>
                                        <th>Tests</th>
                                        <th>Observaciones</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 student-avatar">
                                                    MG
                                                    </div>
                                                    <div>
                                                    <div class="fw-semibold">María García</div>
                                                    <div class="text-muted small">maria.garcia@email.com</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="min-width:180px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                    <div class="bg-light rounded-pill progress-wrapper">
                                                        <div class="bg-success rounded-pill progress-bar-custom progress-80"></div>
                                                    </div>
                                                    </div>
                                                    <span class="fw-semibold small">85%</span>
                                                </div>
                                            </td>

                                            <td class="fw-semibold">12/15</td>

                                            <td>
                                                <span class="badge rounded-3 text-bg-success px-3 py-2">
                                                    <span class="fw-semibold">28</span>
                                                    <span class="small d-block">tests</span>
                                                </span>
                                            </td>

                                            <td class="text-muted">Preparada para examen</td>

                                            <td class="text-end">
                                                <a href="#" class="text-success fw-semibold text-decoration-none">Ver detalles</a>
                                            </td>
                                        </tr>
                                            <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 student-avatar">
                                                    MG
                                                    </div>
                                                    <div>
                                                    <div class="fw-semibold">María García</div>
                                                    <div class="text-muted small">maria.garcia@email.com</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="min-width:180px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                    <div class="bg-light rounded-pill progress-wrapper">
                                                        <div class="bg-success rounded-pill progress-bar-custom progress-80"></div>
                                                    </div>
                                                    </div>
                                                    <span class="fw-semibold small">85%</span>
                                                </div>
                                            </td>

                                            <td class="fw-semibold">12/15</td>

                                            <td>
                                                <span class="badge rounded-3 text-bg-success px-3 py-2">
                                                    <span class="fw-semibold">28</span>
                                                    <span class="small d-block">tests</span>
                                                </span>
                                            </td>

                                            <td class="text-muted">Preparada para examen</td>

                                            <td class="text-end">
                                                <a href="#" class="text-success fw-semibold text-decoration-none">Ver detalles</a>
                                            </td>
                                        </tr>
                                            <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 student-avatar">
                                                    MG
                                                    </div>
                                                    <div>
                                                    <div class="fw-semibold">María García</div>
                                                    <div class="text-muted small">maria.garcia@email.com</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="min-width:180px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                    <div class="bg-light rounded-pill progress-wrapper">
                                                        <div class="bg-success rounded-pill progress-bar-custom progress-80"></div>
                                                    </div>
                                                    </div>
                                                    <span class="fw-semibold small">85%</span>
                                                </div>
                                            </td>

                                            <td class="fw-semibold">12/15</td>

                                            <td>
                                                <span class="badge rounded-3 text-bg-success px-3 py-2">
                                                    <span class="fw-semibold">28</span>
                                                    <span class="small d-block">tests</span>
                                                </span>
                                            </td>

                                            <td class="text-muted">Preparada para examen</td>

                                            <td class="text-end">
                                                <a href="#" class="text-success fw-semibold text-decoration-none">Ver detalles</a>
                                            </td>
                                        </tr>
                                            <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 student-avatar">
                                                    MG
                                                    </div>
                                                    <div>
                                                    <div class="fw-semibold">María García</div>
                                                    <div class="text-muted small">maria.garcia@email.com</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="min-width:180px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                    <div class="bg-light rounded-pill progress-wrapper">
                                                        <div class="bg-success rounded-pill progress-bar-custom progress-80"></div>
                                                    </div>
                                                    </div>
                                                    <span class="fw-semibold small">85%</span>
                                                </div>
                                            </td>

                                            <td class="fw-semibold">12/15</td>

                                            <td>
                                                <span class="badge rounded-3 text-bg-success px-3 py-2">
                                                    <span class="fw-semibold">28</span>
                                                    <span class="small d-block">tests</span>
                                                </span>
                                            </td>

                                            <td class="text-muted">Preparada para examen</td>

                                            <td class="text-end">
                                                <a href="#" class="text-success fw-semibold text-decoration-none">Ver detalles</a>
                                            </td>
                                        </tr>
                                            <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 student-avatar">
                                                    MG
                                                    </div>
                                                    <div>
                                                    <div class="fw-semibold">María García</div>
                                                    <div class="text-muted small">maria.garcia@email.com</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="min-width:180px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 me-2">
                                                    <div class="bg-light rounded-pill progress-wrapper">
                                                        <div class="bg-success rounded-pill progress-bar-custom progress-80"></div>
                                                    </div>
                                                    </div>
                                                    <span class="fw-semibold small">85%</span>
                                                </div>
                                            </td>

                                            <td class="fw-semibold">12/15</td>

                                            <td>
                                                <span class="badge rounded-3 text-bg-success px-3 py-2">
                                                    <span class="fw-semibold">28</span>
                                                    <span class="small d-block">tests</span>
                                                </span>
                                            </td>

                                            <td class="text-muted">Preparada para examen</td>

                                            <td class="text-end">
                                                <a href="#" class="text-success fw-semibold text-decoration-none">Ver detalles</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </article>
    </main>
    
    @include("partials.footer")
    @include("partials.scripts")
</body>
</html>