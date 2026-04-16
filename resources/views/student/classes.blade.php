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
    <link rel="stylesheet" href="{{ asset('resources/css/classes.css') }}">
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
                        <div class="card-body p-0 table-responsive d-none d-md-block">
                            <table class="table mb-0 align-middle reserved-table">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Clase</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Profesor</th>
                                        <th>Estado</th>
                                        <th class="pe-4 text-end">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservedClasses as $class)
                                        @php
                                            $classStart = \Carbon\Carbon::parse($class->raw_date . ' ' . $class->raw_start_time);
                                            $canCancel = $classStart->isFuture();
                                            $classDate = \Carbon\Carbon::parse($class->raw_date)->startOfDay();
                                            $today = now()->startOfDay();
                                        @endphp
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
                                            <td>
                                                @if ($classDate->gt($today))
                                                    <span class="badge bg-success px-3 py-2">Proxima</span>
                                                @elseif ($classDate->eq($today))
                                                    <span class="badge bg-warning text-dark px-3 py-2">Hoy</span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2">Ya realizada</span>
                                                @endif
                                            </td>
                                            <td class="pe-4 text-end">
                                                @if ($canCancel)
                                                    <button
                                                        class="btn btn-outline-danger reserve-card-btn cancel-btn"
                                                        type="button"
                                                        onclick="cancelReservation({{ $class->id }})">
                                                        Desapuntar
                                                    </button>
                                                @else
                                                    <span class="text-muted small">Bloqueada</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-4 text-center text-muted">
                                                No tienes clases reservadas ahora mismo.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-body p-0 d-md-none">
                            <table class="table mb-0 align-middle reserved-table reserved-table-mobile">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Clase</th>
                                        <th>Fecha</th>
                                        <th class="pe-3 text-end">Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 0;
                                    @endphp
                                    @foreach ($reservedClasses as $class)
                                        @php
                                            $classStart = \Carbon\Carbon::parse($class->raw_date . ' ' . $class->raw_start_time);
                                            $canCancel = $classStart->isFuture();
                                            $classDate = \Carbon\Carbon::parse($class->raw_date)->startOfDay();
                                            $today = now()->startOfDay();
                                            $detailId = 'class-detail-' . $class->id;
                                        @endphp
                                        <tr>
                                            <td class="ps-3">
                                                <div class="fw-semibold">
                                                    Clase #{{ $counter++ + 1}}
                                                </div>
                                            </td>
                                            <td>{{ $class->date }}</td>
                                            <td class="pe-3 text-end">
                                                <button
                                                    class="btn btn-sm btn-detail-toggle"
                                                    type="button"
                                                    data-class-toggle="{{ $detailId }}"
                                                    aria-expanded="false">
                                                    Ver
                                                </button>
                                            </td>
                                        </tr>
                                        <tr id="{{ $detailId }}" class="class-detail-row" hidden>
                                            <td colspan="3" class="p-0">
                                                <div class="class-detail-panel">
                                                    <div class="class-detail-grid">
                                                        <div>
                                                            <span class="class-detail-label">Clase</span>
                                                            <p class="mb-0">{{ $class->title }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="class-detail-label">Profesor</span>
                                                            <p class="mb-0">{{ $class->name }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="class-detail-label">Horario</span>
                                                            <p class="mb-0">{{ $class->start_time }} - {{ $class->end_time }}</p>
                                                        </div>
                                                        <div>
                                                            <span class="class-detail-label">Estado</span>
                                                            <p class="mb-0">
                                                                @if ($classDate->gt($today))
                                                                    <span class="badge bg-success px-3 py-2">Proxima</span>
                                                                @elseif ($classDate->eq($today))
                                                                    <span class="badge bg-warning text-dark px-3 py-2">Hoy</span>
                                                                @else
                                                                    <span class="badge bg-secondary px-3 py-2">Ya realizada</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    @if ($canCancel)
                                                        <button
                                                            class="btn btn-outline-danger w-100 reserve-card-btn cancel-btn mt-3"
                                                            type="button"
                                                            onclick="cancelReservation({{ $class->id }})">
                                                            Desapuntarme de esta clase
                                                        </button>
                                                    @else
                                                        <p class="small text-muted mb-0 mt-3">
                                                            Esta clase ya ha empezado o ha finalizado.
                                                        </p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($reservedClasses->isEmpty())
                                        <tr>
                                            <td colspan="3" class="px-3 py-4 text-center text-muted">
                                                No tienes clases reservadas ahora mismo.
                                            </td>
                                        </tr>
                                    @endif
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
                    @forelse ($classes as $class)
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
                                        <div class="d-flex align-items-center justify-content-between mb-2 class-meta-row">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-regular fa-calendar me-2"></i>
                                                <span>{{ $class->date }}</span>
                                            </div>
                                            <span class="class-slots">{{ $class->available_slots }} plazas</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fa-regular fa-calendar me-2"></i>
                                            <span>{{ $class->name }}</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fa-regular fa-clock me-2"></i>
                                            <span>{{ $class->start_time }} - {{ $class->end_time }}</span>
                                        </div>
                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex justify-content-between align-items-center class-card-footer">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder"></div>
                                            <span class="ms-2 opacity-75">
                                                Grupo practico
                                            </span>
                                        </div>

                                        <button
                                            class="btn bg-green-btn text-white reserve-card-btn"
                                            type="button"
                                            onclick="reservesClass({{ $class->id }})">
                                            Reservar
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 p-2">
                            <div class="card rounded-4 class-card empty-state-card">
                                <div class="card-body text-center py-5">
                                    <h5 class="mb-2">No hay clases disponibles con esos filtros</h5>
                                    <p class="mb-0 opacity-75">Prueba a limpiar filtros o vuelve mas tarde.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
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
    <script src="{{ asset('resources/js/classes.js') }}"></script>
</body>
</html>
