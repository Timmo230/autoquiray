@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Horario | Autoquiray</title>

    @include('partials.links')

    <link rel="stylesheet" href="/autoquiray/resources/css/createTimetable.css">
</head>
<body class="bg-main">

    @include('partials.nav', ['uri' => $uri])

    <main class="container py-5">
        <section class="row justify-content-center">
            <div class="col-12 col-xl-10">

                <div class="aq-page-header glass-card mb-4 animate__animated animate__fadeInDown">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="aq-icon-box">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>

                            <div>
                                <p class="aq-eyebrow mb-1">Panel de administración</p>
                                <h1 class="aq-title mb-1">Crear horario de clase</h1>
                                <p class="aq-subtitle mb-0">
                                    Establece la fecha, hora de entrada y hora de salida para una nueva franja horaria.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert aq-alert-success shadow-sm rounded-4 border-0 animate__animated animate__fadeInDown">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert aq-alert-danger shadow-sm rounded-4 border-0 animate__animated animate__fadeInDown">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            <strong>Se han encontrado errores</strong>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-12 col-lg-8">
                        <div class="glass-card aq-form-card animate__animated animate__fadeInUp">
                            <div class="aq-card-header mb-4">
                                <h2 class="aq-card-title mb-1">
                                    <i class="fa-regular fa-clock me-2"></i>Datos del horario
                                </h2>
                                <p class="aq-card-text mb-0">
                                    Completa los datos necesarios para registrar un nuevo horario disponible para las clases.
                                </p>
                            </div>

                            <form action="{{ route('admin.createTimetable') }}" method="POST" id="createTimetableForm">
                                @csrf

                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="date" class="form-label aq-label">Fecha</label>
                                        <div class="aq-input-group">
                                            <span class="aq-input-icon">
                                                <i class="fa-solid fa-calendar"></i>
                                            </span>
                                            <input
                                                type="date"
                                                name="date"
                                                id="date"
                                                class="form-control aq-input"
                                                value="{{ old('date') }}"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="start_time" class="form-label aq-label">Hora de entrada</label>
                                        <div class="aq-input-group">
                                            <span class="aq-input-icon">
                                                <i class="fa-solid fa-right-to-bracket"></i>
                                            </span>
                                            <input
                                                type="time"
                                                name="start_time"
                                                id="start_time"
                                                class="form-control aq-input"
                                                value="{{ old('start_time') }}"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label for="end_time" class="form-label aq-label">Hora de salida</label>
                                        <div class="aq-input-group">
                                            <span class="aq-input-icon">
                                                <i class="fa-solid fa-right-from-bracket"></i>
                                            </span>
                                            <input
                                                type="time"
                                                name="end_time"
                                                id="end_time"
                                                class="form-control aq-input"
                                                value="{{ old('end_time') }}"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="aq-divider my-4"></div>

                                <div class="d-flex flex-column flex-md-row gap-3 justify-content-end">
                                    <button type="submit" class="btn aq-btn-primary btn-lg px-5 shadow-lg">
                                        <i class="fa-solid fa-floppy-disk me-2"></i>Guardar horario
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="glass-card aq-info-card animate__animated animate__fadeInUp">
                            <div class="aq-side-icon mb-3">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>

                            <h3 class="aq-side-title">Recomendaciones</h3>

                            <div class="aq-tip-list">
                                <div class="aq-tip-item">
                                    <span class="aq-tip-dot"></span>
                                    <p class="mb-0">Asegúrate de que la hora de salida sea posterior a la de entrada.</p>
                                </div>

                                <div class="aq-tip-item">
                                    <span class="aq-tip-dot"></span>
                                    <p class="mb-0">Evita crear horarios duplicados o solapados para el mismo día.</p>
                                </div>

                                <div class="aq-tip-item">
                                    <span class="aq-tip-dot"></span>
                                    <p class="mb-0">Utiliza franjas claras para facilitar luego la asignación de clases.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
    @include('partials.scripts')
</body>
</html>