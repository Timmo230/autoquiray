@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Clase | Autoquiray</title>

    @include('partials.links')

    <link rel="stylesheet" href="/autoquiray/resources/css/createClass.css">
</head>
<body class="bg-main">

    @include('partials.nav', ['uri' => $uri])

    <main class="container py-5">
        <section class="row justify-content-center">
            <div class="col-12 col-xxl-10">

                {{-- CABECERA --}}
                <div class="glass-card aq-page-header mb-4 animate__animated animate__fadeInDown">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="aq-icon-box">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>

                            <div>
                                <p class="aq-eyebrow mb-1">Panel del profesor</p>
                                <h1 class="aq-title mb-1">Asignar nueva clase</h1>
                                <p class="aq-subtitle mb-0">
                                    Crea una clase y selecciona uno de los horarios disponibles.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap">
                            <button
                                type="button"
                                class="btn aq-btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#filterTimetablesModal"
                            >
                                <i class="fa-solid fa-filter me-2"></i>Filtrar horarios
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ALERTAS --}}
                @if (session('success'))
                    <div class="alert aq-alert-success rounded-4 border-0 shadow-sm">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert aq-alert-danger rounded-4 border-0 shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert aq-alert-danger rounded-4 border-0 shadow-sm">
                        <div class="fw-bold mb-2">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>Se han encontrado errores
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('teacher.createClasses') }}" method="POST" id="createClassForm">
                    @csrf

                    <div>
                        {{-- FORMULARIO PRINCIPAL --}}
                        <div class="mb-4">
                            <div class="glass-card aq-form-card animate__animated animate__fadeInUp">
                                <div class="aq-section-header mb-4">
                                    <h2 class="aq-card-title mb-1">
                                        <i class="fa-solid fa-pen-to-square me-2"></i>Datos de la clase
                                    </h2>
                                    <p class="aq-card-text mb-0">
                                        Completa la información general y luego selecciona un horario.
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <label for="title" class="form-label aq-label">Título de la clase</label>
                                    <div class="aq-input-group">
                                        <span class="aq-input-icon">
                                            <i class="fa-solid fa-book-open"></i>
                                        </span>
                                        <input
                                            type="text"
                                            name="title"
                                            id="title"
                                            class="form-control aq-input"
                                            placeholder="Ej: Clase práctica de circulación"
                                            value="{{ old('title') }}"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="max_students" class="form-label aq-label">Máximo de alumnos</label>
                                    <div class="aq-input-group">
                                        <span class="aq-input-icon">
                                            <i class="fa-solid fa-users"></i>
                                        </span>
                                        <input
                                            type="number"
                                            name="max_students"
                                            id="max_students"
                                            class="form-control aq-input"
                                            min="1"
                                            placeholder="Ej: 8"
                                            value="{{ old('max_students') }}"
                                            required
                                        >
                                    </div>
                                </div>

                                <div class="aq-divider my-4"></div>

                                <div class="aq-selected-box">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="aq-selected-label">Horario seleccionado</span>
                                        <span class="aq-selected-badge" id="selectedTimetableBadge">Ninguno</span>
                                    </div>

                                    <div class="aq-selected-content" id="selectedTimetableText">
                                        Aún no has seleccionado ningún horario.
                                    </div>
                                </div>

                                <div class="aq-divider my-4"></div>

                                <div class="d-grid d-md-flex justify-content-md-end gap-3">
                                    <button type="submit" class="btn aq-btn-primary btn-lg px-5">
                                        <i class="fa-solid fa-floppy-disk me-2"></i>Asignar clase
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- HORARIOS --}}
                        <div>
                            <div class="glass-card aq-timetables-card animate__animated animate__fadeInUp">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                                    <div>
                                        <h2 class="aq-card-title mb-1">
                                            <i class="fa-regular fa-clock me-2"></i>Horarios disponibles
                                        </h2>
                                        <p class="aq-card-text mb-0">
                                            Selecciona un único horario para la nueva clase.
                                        </p>
                                    </div>

                                    <div class="aq-results-pill">
                                        {{ isset($timetables) ? count($timetables) : 0 }} horario(s)
                                    </div>
                                </div>

                                @if(isset($timetables) && count($timetables) > 0)
                                    <div class="row g-3">
                                        @foreach($timetables as $timetable)
                                            <div class="col-12 col-md-6">
                                                <label class="aq-timetable-option w-100">
                                                    <input
                                                        type="radio"
                                                        name="timetable_id"
                                                        value="{{ $timetable->id }}"
                                                        class="aq-radio"
                                                        data-date="{{ $timetable->date }}"
                                                        data-start="{{ $timetable->start_time }}"
                                                        data-end="{{ $timetable->end_time }}"
                                                        {{ old('timetable_id') == $timetable->id ? 'checked' : '' }}
                                                        required
                                                    >

                                                    <div class="aq-timetable-card">
                                                        <div class="aq-card-top">
                                                            <div class="aq-calendar-icon">
                                                                <i class="fa-solid fa-calendar-day"></i>
                                                            </div>

                                                            <span class="aq-choose-pill">
                                                                Seleccionar
                                                            </span>
                                                        </div>

                                                        <div class="aq-timetable-body">
                                                            <div class="aq-data-block">
                                                                <span class="aq-data-label">Fecha</span>
                                                                <strong>{{ $timetable->date }}</strong>
                                                            </div>

                                                            <div class="row g-3 mt-1">
                                                                <div class="col-6">
                                                                    <div class="aq-data-block">
                                                                        <span class="aq-data-label">Entrada</span>
                                                                        <strong>{{ $timetable->start_time }}</strong>
                                                                    </div>
                                                                </div>

                                                                <div class="col-6">
                                                                    <div class="aq-data-block">
                                                                        <span class="aq-data-label">Salida</span>
                                                                        <strong>{{ $timetable->end_time }}</strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="aq-empty-state">
                                        <div class="aq-empty-icon">
                                            <i class="fa-regular fa-calendar-xmark"></i>
                                        </div>
                                        <h3 class="aq-empty-title">No hay horarios disponibles</h3>
                                        <p class="aq-empty-text mb-0">
                                            Prueba a cambiar los filtros o crea nuevos horarios desde administración.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    {{-- MODAL FILTROS --}}
    <div class="modal fade" id="filterTimetablesModal" tabindex="-1" aria-labelledby="filterTimetablesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content aq-modal">
                <div class="modal-header aq-modal-header border-0">
                    <div>
                        <h5 class="modal-title aq-modal-title" id="filterTimetablesModalLabel">
                            <i class="fa-solid fa-filter me-2"></i>Filtrar horarios
                        </h5>
                        <p class="aq-modal-subtitle mb-0">
                            Ajusta los filtros para encontrar más rápido el horario adecuado.
                        </p>
                    </div>

                    <button type="button" class="btn-close aq-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('teacher.createClasses') }}" method="GET">
                    <div class="modal-body aq-modal-body">
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <label for="filter_date" class="form-label aq-label">Fecha</label>
                                <div class="aq-input-group">
                                    <span class="aq-input-icon">
                                        <i class="fa-solid fa-calendar"></i>
                                    </span>
                                    <input
                                        type="date"
                                        name="date"
                                        id="filter_date"
                                        class="form-control aq-input"
                                        value="{{ request('date') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="limit" class="form-label aq-label">Máximo de resultados</label>
                                <div class="aq-input-group">
                                    <span class="aq-input-icon">
                                        <i class="fa-solid fa-hashtag"></i>
                                    </span>
                                    <input
                                        type="number"
                                        name="limit"
                                        id="limit"
                                        class="form-control aq-input"
                                        min="1"
                                        max="100"
                                        placeholder="Ej: 20"
                                        value="{{ request('limit') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="filter_start_time" class="form-label aq-label">Hora de entrada</label>
                                <div class="aq-input-group">
                                    <span class="aq-input-icon">
                                        <i class="fa-solid fa-right-to-bracket"></i>
                                    </span>
                                    <input
                                        type="time"
                                        name="start_time"
                                        id="filter_start_time"
                                        class="form-control aq-input"
                                        value="{{ request('start_time') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="filter_end_time" class="form-label aq-label">Hora de salida</label>
                                <div class="aq-input-group">
                                    <span class="aq-input-icon">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                    </span>
                                    <input
                                        type="time"
                                        name="end_time"
                                        id="filter_end_time"
                                        class="form-control aq-input"
                                        value="{{ request('end_time') }}"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer aq-modal-footer border-0">
                        <a href="{{ route('teacher.createClasses') }}" class="btn aq-btn-secondary">
                            <i class="fa-solid fa-rotate-left me-2"></i>Limpiar filtros
                        </a>

                        <button type="submit" class="btn aq-btn-primary">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>Aplicar filtros
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')
    @include('partials.scripts')

    <script src="/autoquiray/resources/js/createClasses.js"></script>
</body>
</html>