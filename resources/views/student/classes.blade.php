@php
    $uri = request()->path();
    $counter = 0;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Clases</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include("partials.links")
    <link rel="stylesheet" href="/resources/css/classes.css">
</head>

<body class="bg-main">
    @include("partials.nav", ["uri" => $uri])

    <main class="container-fluid main-spacing mb-5">
        <article>
            <section class="px-5 mb-4">
                <h3 class="rubik fs-2 mb-1">Mis clases</h3>
                <p class="rubik fs-5-5 opacity-75">
                    Reserva nuevas clases y revisa tu historial.
                </p>
            </section>
            <section>
                <div class="d-flex align-items-center px-5 mb-3">
                    <i class="fa-regular fa-calendar-check fs-5 me-2 text-green-btn"></i>
                    <h3 class="rubik fs-3 mb-0">
                        Próximas clases reservadas
                    </h3>
                </div>

                <div class="container-fluid my-4">
                    <div class="card reserved-table-card rounded-4">
                        <div class="card-body p-0 table-responsive">
                            <table class="table mb-0 align-middle reserved-table">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Clase</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Profesor</th>
                                        <th class="pe-4">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservedClasses as $class)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-semibold">
                                                    Clase #{{ $counter++ + 1}}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $class->title }}
                                                </small>
                                            </td>
                                            <td>{{ $class->date }}</td>
                                            <td>{{ $class->start_time }} - {{ $class->end_time }}</td>
                                            <td>{{ $class->name }}</td>
                                            <<td class="pe-4">
                                                @php
                                                    $classDate = \Carbon\Carbon::parse($class->raw_date)->startOfDay();
                                                    $today = now()->startOfDay();
                                                @endphp

                                                @if ($classDate->gt($today))
                                                    <span class="badge bg-success px-3 py-2">Próxima</span>
                                                @elseif ($classDate->eq($today))
                                                    <span class="badge bg-warning text-dark px-3 py-2">Hoy</span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2">Ya realizada</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="px-5 mb-5">
                <div class="px-4 d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa-regular fa-calendar fs-5 text-green-btn me-2"></i>
                        <h3 class="rubik fs-3 mb-0">Clases disponibles</h3>
                    </div>

                    <div class="mt-3 mt-md-0">
                        <button
                            class="btn btn-filter-soft d-flex align-items-center justify-content-center gap-2 reserve-card-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#reserves">
                            
                            <i class="fa-solid fa-sliders"></i>
                            Filtrar clases

                        </button>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                    @php
                        $counter = 0;
                    @endphp
                    @foreach ($classes as $class)
                        <div class="col p-2">
                            <div class="card rounded-4 class-card green">
                                <div class="card-body">

                                    <span class="badge bg-green-btn text-white mb-2">
                                        Disponible
                                    </span>

                                    <h5 class="card-title mb-1">
                                        Clase Práctica #{{ $counter++ + 1}}
                                    </h5>

                                    <p class="card-text opacity-75">
                                        {{ $class->title }}
                                    </p>

                                    <div class="class-meta mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fa-regular fa-calendar me-2"></i>
                                            <span>{{ $class->date }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-clock me-2"></i>
                                            <span>{{ $class->start_time }} - {{ $class->end_time }}</span>
                                        </div>
                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder"></div>
                                            <span class="ms-2 opacity-75">
                                                {{ $class->name }}
                                            </span>
                                        </div>

                                        <button
                                            class="btn bg-green-btn text-white reserve-card-btn"
                                            onclick="reservesClass({{ $class->id }})">
                                            Reservar
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </article>
    </main>

    {{-- MODAL --}}
    <div class="modal fade" id="reserves" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('student.classes') }}" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filtros</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text"
                                name="title"
                                class="form-control"
                                placeholder="Filtrar por título..."
                                value="{{ request('title') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profesor</label>
                            <input type="text"
                                name="teacher"
                                class="form-control"
                                placeholder="Nombre del profesor..."
                                value="{{ request('teacher') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date"
                                name="date"
                                class="form-control"
                                value="{{ request('date') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Límite de resultados</label>
                            <input type="number"
                                name="limit"
                                class="form-control"
                                placeholder="Ej: 20"
                                min="1"
                                max="100"
                                value="{{ request('limit') }}">
                            <small class="text-muted">Máximo 100 resultados</small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary w-100"
                                onclick="window.location='{{ route('student.classes') }}'">
                            Limpiar filtros
                        </button>
                        <button class="btn bg-green-btn text-white w-100">
                            Confirmar reserva
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include("partials.footer")
    @include("partials.scripts")
    <script src="/resources/js/classes.js"></script>
</body>
</html>