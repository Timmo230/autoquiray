@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona de Profesores - Autoquiray</title>
    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/icons.css">
    <link rel="stylesheet" href="/autoquiray/resources/css/zonaProfesores.css">
    
    <style>
        
    </style>
</head>
<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container my-5">
        <article>
            <section class="px-3 mb-5 animate__animated animate__fadeIn">
                <div class="header-title">
                    <h2 class="fw-bold mb-1">Zona Profesores</h2>
                    <p class="text-muted mb-0 fw-normal">Gestión inteligente de rendimiento y seguimiento de alumnos</p>
                </div>
            </section>

            <section class="px-3">
                <div class="glass-panel py-4">
                    <div class="px-4 d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                        <h3 class="fs-4 mb-0 fw-semibold">Alumnos Matriculados</h3>

                        <div class="mt-3 mt-md-0">
                            <form action="{{ route('teacher.dashboard') }}" method="GET" class="position-relative">
                                <input type="text" 
                                    name="search" 
                                    class="form-control rounded-pill ps-5 search-input-custom" 
                                    placeholder="Filtrar por nombre..." 
                                    value="{{ request('search') }}"
                                    style="width: 300px; height: 45px;">
                                <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            </form>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Alumno</th>
                                    <th>Progreso Teórico</th>
                                    <th>Aprobados / Total</th>
                                    <th>Estado de Participación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumnos as $alum)
                                    @php
                                        $colorClase = $alum->porcentaje_aprobados >= 70 ? 'success' : ($alum->porcentaje_aprobados >= 50 ? 'warning' : 'danger');
                                        $iniciales = collect(explode(' ', $alum->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-{{ $colorClase }} text-white d-flex align-items-center justify-content-center me-3 student-avatar">
                                                    {{ strtoupper($iniciales) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-white">{{ $alum->name }}</div>
                                                    <div class="text-muted small">{{ $alum->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress-wrapper rounded-pill me-3">
                                                    <div class="bg-{{ $colorClase }} rounded-pill" 
                                                        style="width: {{ $alum->porcentaje_aprobados }}%; height: 100%; transition: width 1s ease-in-out;">
                                                    </div>
                                                </div>
                                                <span class="fw-bold small {{ $alum->porcentaje_aprobados >= 50 ? 'text-green-accent' : 'text-danger' }}">
                                                    {{ $alum->porcentaje_aprobados }}%
                                                </span>
                                            </div>
                                        </td>

                                        <td class="fw-medium text-muted">
                                            <span class="text-white">{{ $alum->aprobados }}</span> <small>/</small> {{ $alum->total_examenes }}
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill bg-{{ $colorClase }} bg-opacity-10 text-{{ $colorClase }} border border-{{ $colorClase }} border-opacity-25 px-3 py-2">
                                                {{ $alum->total_examenes }} tests realizados
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </article>
    </main>

    @include("partials.footer")
    @include("partials.scripts")
</body>
</html>