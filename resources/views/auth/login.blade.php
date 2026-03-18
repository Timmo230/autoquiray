@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AUTOQUIRAY</title>
    
    @include('partials.links')
    <link rel="stylesheet" href="/autoquiray/resources/css/login.css">
</head>
<body class="bg-main">
    @include('partials.nav')

    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-0 m-0">
            <div class="container">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fa-solid fa-triangle-exclamation me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main class="py-5">
        <section class="p-4 p-md-5 rounded-4 mx-auto" id="login">
            <form method="POST" action="{{ route('login') }}">
                @csrf 
                
                <div class="text-center mb-4">
                    <img src="/autoquiray/resources/img/logo/logo.png" alt="logo" class="mb-3 logo">
                    <p class="small text-secondary">Accede a tu cuenta de AUTOQUIRAY</p>
                </div>
                
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo de usuario</label>
                    <select class="form-select form-select-lg" id="type" name="type">
                        <option value="student">Alumno</option>
                        <option value="teacher">Profesor</option>
                        <option value="administrator">Administrador</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="nombre@ejemplo.com" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="••••••••">
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="check">
                    <label class="form-check-label text-secondary small" for="check">Recordarme en este equipo</label>
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-green-aq w-100 py-3 fs-5 fw-bold">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Iniciar sesión
                    </button>
                </div>

                <div class="text-center">
                    <img src="/autoquiray/resources/img/login/conexionSegura.png" alt="Conexión Segura" class="rounded-2">
                </div>
            </form>
        </section>
    </main>

    @include('partials.footer')
    @include('partials.scripts')
</body>
</html>