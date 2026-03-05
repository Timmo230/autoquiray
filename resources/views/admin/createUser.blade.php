{{-- resources/views/admin/users/create.blade.php --}}
@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crear usuario</title>

    @include('partials.links')
    <link rel="stylesheet" href="/autoquiray/resources/css/createUser.css">
</head>

<body class="bg-main">

@include("partials.nav", ['uri' => $uri])

<main class="container-fluid py-4">

    @if ($errors->any())
        <div class="alert alert-danger rounded-4 shadow">
            <ul class="mb-0">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="glass-card mb-4 animate__animated animate__fadeInDown">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="rubik mb-0">Crear usuario</h3>
            <span class="badge bg-dark-subtle text-dark rounded-pill px-3 py-2">Administración</span>
        </div>

        <form id="createUserForm" method="POST" action="#">
            @csrf

            <div class="bg-white rounded-4 shadow p-4 mb-4">
                <h5 class="rubik mb-3">Datos personales</h5>

                <div class="row g-3">

                    <div class="col-12 col-lg-4">
                        <label class="form-label">Tipo de usuario</label>
                        <select name="user_type" class="form-select form-select-lg" required id="userType">
                        </select>
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Nombre</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control form-control-lg"
                            value="{{ old('name') }}"
                            placeholder="Nombre y apellidos"
                            required
                        />
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control form-control-lg"
                            value="{{ old('email') }}"
                            placeholder="usuario@correo.com"
                            required
                        />
                    </div>

                    <div class="col-12 col-lg-4">
                        <label class="form-label">Tipo de documento</label>
                        <select name="document_type" class="form-select form-select-lg" required>
                            <option value="" {{ old('document_type') ? '' : 'selected' }} disabled>Selecciona...</option>
                            <option value="PASSPORT" {{ old('document_type') === 'PASSPORT' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="DNI" {{ old('document_type') === 'DNI' ? 'selected' : '' }}>DNI</option>
                        </select>
                    </div>

                    <div class="col-12 col-lg-8">
                        <label class="form-label">Documento</label>
                        <input
                            type="text"
                            name="document_value"
                            class="form-control form-control-lg"
                            value="{{ old('document_value') }}"
                            placeholder="Número de documento"
                            required
                        />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-4 shadow p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="rubik mb-0">Matrículas</h5>
                    <div class="d-flex gap-2 align-items-center">
                        <label class="form-label mb-0">Cantidad</label>
                        <input
                            id="tuitionCount"
                            type="number"
                            min="0"
                            max="20"
                            class="form-control form-control-lg"
                            style="width: 110px"
                            value="{{ old('tuitions_count', 0) }}"
                        />
                        <input type="hidden" name="tuitions_count" id="tuitions_count_hidden" value="{{ old('tuitions_count', 0) }}">
                    </div>
                </div>

                <p class="text-muted mt-2 mb-0">
                    Al elegir la cantidad se habilitarán los campos de cada matrícula.
                </p>

                <hr class="my-4">

                <div id="tuitionsContainer"></div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ url()->previous() }}" class="btn btn-light btn-lg px-4 shadow-sm">
                    <i class="fa-solid fa-arrow-left me-2"></i> Volver
                </a>

                <button type="submit" class="btn btn-autoquiray btn-lg px-5 shadow-lg">
                    <i class="fa-solid fa-user-plus me-2"></i> Crear usuario
                </button>
            </div>
        </form>
    </div>
</main>

@include("partials.footer")
@include("partials.scripts")

<script src="/autoquiray/resources/js/createUser.js"></script>
<script>
    window.prepareArrays(@json($permissions), @json($userTypes));
</script>

</body>
</html>