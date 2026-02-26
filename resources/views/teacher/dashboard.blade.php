@php
    $uri = request()->path();
@endphp<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona de Profesores - Autoquiray</title>
    @include("partials.links")
    <link rel="stylesheet" href="/autoquiray/resources/css/icons.css">
    <link rel="stylesheet" href="/autoquiray/resources/css/zonaProfesores.css">
</head>
<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container my-4"> {{-- He cambiado mb-3 por my-4 para equilibrar --}}
        <article>
            <section class="px-3 rubik">
                <h2>Zona Profesores</h2>
                <p class="fs-5-5 opacity-50 fw-normal">Panel de gestión de alumnos y seguimiento</p>
            </section>

            <section class="my-4 px-3">
                <div class="bg-white rounded-4 shadow-sm py-4">
                    <div class="px-3 rubik d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="rubik fs-3 mb-0">Lista de Alumnos</h3>
                        </div>

                        <div class="mt-3 mt-md-0 me-md-2">
                            <form action="{{ route('teacher.dashboard') }}" method="GET" class="position-relative">
                                <input type="text" 
                                    name="search" 
                                    class="form-control rounded-pill ps-5 border-0 shadow-sm" 
                                    placeholder="Buscar alumno..." 
                                    value="{{ request('search') }}"
                                    style="width: 280px; height: 40px;">
                                <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 opacity-50"></i>
                            </form>
                        </div>
                    </div>
                    
                    <div class="table-responsive rounded-4">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Alumno</th>
                                    <th>Progreso Teórico</th>
                                    <th>Aprobados/Total</th>
                                    <th>Participación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumnos as $alum)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $colorClase = $alum->porcentaje_aprobados >= 70 ? 'success' : ($alum->porcentaje_aprobados >= 50 ? 'warning' : 'danger');
                                                    $iniciales = collect(explode(' ', $alum->name))->map(fn($n) => mb_substr($n, 0, 1))->take(2)->join('');
                                                @endphp
                                                
                                                <div class="rounded-circle bg-{{ $colorClase }} text-white d-flex align-items-center justify-content-center me-3 student-avatar">
                                                    {{ strtoupper($iniciales) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $alum->name }}</div>
                                                    <div class="text-muted small">{{ $alum->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="me-2">
                                                    <div class="bg-light rounded-pill progress-wrapper">
                                                        <div class="bg-{{ $colorClase }} rounded-pill progress-bar-custom" 
                                                            style="width: {{ $alum->porcentaje_aprobados }}%; height: 8px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="fw-semibold small">{{ $alum->porcentaje_aprobados }}%</span>
                                            </div>
                                        </td>

                                        <td class="fw-medium">{{ $alum->aprobados }} / {{ $alum->total_examenes }}</td>

                                        <td>
                                            <span class="badge rounded-pill text-bg-{{ $colorClase }} px-3 py-2">
                                                {{ $alum->total_examenes }} tests
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