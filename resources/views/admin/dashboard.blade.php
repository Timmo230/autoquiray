@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zona de Administrador - Autoquiray</title>

    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/icons.css">
    <link rel="stylesheet" href="/autoquiray/resources/css/zonaAdmins.css">
    <link rel="stylesheet" href="/autoquiray/resources/css/loadingDots.css">
</head>
<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container my-5">
        <article>
            <section class="px-3 mb-5 animate__animated animate__fadeIn">
                <div class="header-title">
                    <h2 class="fw-bold mb-1">Zona Admins</h2>
                    <p class="text-muted mb-0 fw-normal">
                        Gestión inteligente de rendimiento y seguimiento de profesores
                    </p>
                </div>
            </section>

            <section class="px-3">
                <div class="glass-panel">

                    <div class="panel-top">
                        <h3 class="panel-title mb-0">Estadísticas profesores</h3>

                        <form action="" method="GET" class="position-relative search-form-custom">
                            <input
                                type="text"
                                name="search"
                                class="form-control rounded-pill ps-5 search-input-custom"
                                placeholder="Filtrar por email..."
                                value="{{ request('search') }}"
                            >
                            <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        </form>
                    </div>

                    <div class="table-zone">
                        <div class="table-wrapper">
                            <table class="table table-hover align-middle mb-0 custom-table">
                                <thead>
                                    <tr>
                                        <th>Profesor</th>
                                        <th>Respuestas</th>
                                        <th>Tests</th>
                                        <th>Clases</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($teachers as $teacher)
                                        @php
                                            $iniciales = collect(explode(' ', $teacher->name))
                                                ->map(fn($n) => mb_substr($n, 0, 1))
                                                ->take(2)
                                                ->join('');

                                            $respuestas = (int) $teacher->total_respuestas;
                                            $tests = (int) $teacher->total_tests;
                                            $classes = (int) $teacher->total_classes;
                                        @endphp

                                        <tr>
                                            <td>
                                                <div class="teacher-cell">
                                                    <div class="teacher-avatar">
                                                        {{ strtoupper($iniciales) }}
                                                    </div>

                                                    <div class="teacher-meta">
                                                        <div class="teacher-name">{{ $teacher->name }}</div>
                                                        <div class="teacher-email">{{ $teacher->email }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="stat-cell">
                                                    <span class="stat-number">{{ $respuestas }}</span>

                                                    <button
                                                        type="button"
                                                        class="stat-btn-custom"
                                                        data-bs-toggle="modal" data-bs-target="#teacherStatsModal"
                                                        onclick="showTeacherStats('{{ $teacher->id }}', 0)"
                                                    >
                                                        <i class="fa-solid fa-chart-line"></i>
                                                        <span>Respuestas</span>
                                                    </button>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="stat-cell">
                                                    <span class="stat-number">{{ $tests }}</span>

                                                    <button
                                                        type="button"
                                                        class="stat-btn-custom"
                                                        onclick="showTeacherStats('{{ $teacher->id }}', 1)"
                                                    >
                                                        <i class="fa-solid fa-file-lines"></i>
                                                        <span>Tests</span>
                                                    </button>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="stat-cell">
                                                    <span class="stat-number">{{ $classes }}</span>

                                                    <button
                                                        type="button"
                                                        class="stat-btn-custom"
                                                        onclick="showTeacherStats('{{ $teacher->id }}', 2)"
                                                    >
                                                        <i class="fa-solid fa-chalkboard-user"></i>
                                                        <span>Clases</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="empty-state">
                                                No se encontraron profesores.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </section>
        </article>
    </main>

    <div class="modal fade" id="teacherStatsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content teacher-modal">

                <div class="modal-header teacher-modal-header border-0">
                    <div class="teacher-modal-top">
                        <div class="teacher-modal-badge">
                            <span class="badge-label">Profesor</span>
                            <span class="badge-name" id="modalTeacherName">Carlos Fernández</span>
                        </div>

                        <div class="teacher-modal-title-block">
                            <h1 class="modal-title teacher-modal-title" id="teacherStatsModalLabel">
                                Respuestas del profesor
                            </h1>
                            <p class="teacher-modal-subtitle mb-0">
                                Selecciona un elemento para ver más información
                            </p>
                        </div>
                    </div>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body teacher-modal-body">
                    <div id="teacherStatsList" class="teacher-items-list">
                        
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <div class="modal fade details-modal-dark" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content details-modal-content">
                <div class="modal-header details-modal-header">
                    <div>
                        <h4 class="modal-title details-modal-title" id="detailsModalLabel">Detalles</h4>
                        <p class="details-modal-subtitle mb-0">Información detallada del elemento seleccionado</p>
                    </div>
                    <button type="button" class="btn-close details-modal-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body details-modal-body">

                    <div id="detailsModalContent">
                        
                    </div>
                </div>

                <div class="modal-footer details-modal-footer">
                    <button type="button" class="btn details-close-btn" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include("partials.footer")
    @include("partials.scripts")
    <script src="/autoquiray/resources/js/dashboardAdmins.js"></script>
</body>
</html>