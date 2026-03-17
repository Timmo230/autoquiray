@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear usuario</title>

    @include('partials.links')
    <link rel="stylesheet" href="/autoquiray/resources/css/createUser.css">
</head>

<body class="bg-main">

    @include("partials.nav", ['uri' => $uri])

    <main class="container-fluid py-4">

        @if ($errors->any())
            <div class="alert alert-danger rounded-4 shadow mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
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
                            <label class="form-label" for="userType">Tipo de usuario</label>
                            <select name="user_type" class="form-select form-select-lg" required id="userType">
                            </select>
                        </div>

                        <div class="col-12 col-lg-6">
                            <label class="form-label" for="name">Nombre</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-lg"
                                value="{{ old('name') }}"
                                placeholder="Nombre y apellidos"
                                required
                            />
                        </div>

                        <div class="col-12 col-lg-6">
                            <label class="form-label" for="email">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control form-control-lg"
                                value="{{ old('email') }}"
                                placeholder="usuario@correo.com"
                                required
                            />
                        </div>

                        <div class="col-12 col-lg-4">
                            <label class="form-label" for="documentType">Tipo de documento</label>
                            <select name="documentType" id="documentType" class="form-select form-select-lg" required>
                                <option value="" disabled {{ old('documentType') ? '' : 'selected' }}>Selecciona...</option>
                                <option value="passport" {{ old('documentType') === 'passport' ? 'selected' : '' }}>Pasaporte</option>
                                <option value="DNI" {{ old('documentType') === 'DNI' ? 'selected' : '' }}>DNI</option>
                            </select>
                        </div>

                        <div class="col-12 col-lg-8">
                            <label class="form-label" for="documentValue">Documento</label>
                            <input
                                type="text"
                                name="documentValue"
                                id="documentValue"
                                class="form-control form-control-lg"
                                value="{{ old('documentValue') }}"
                                placeholder="Número de documento"
                                required
                            />
                        </div>

                        <div class="col-12 col-lg-4 d-none" id="salary"></div>
                    </div>
                </div>

                <div id="tuitions" class="bg-white rounded-4 shadow p-4 d-none"></div>

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
        perms = @json($permissions);
        typesGot = @json($userTypes);
        ContentLoaded();
    </script>

</body>
</html>