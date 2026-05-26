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
    <link rel="stylesheet" href="{{ asset('resources/css/login.css') }}">
</head>
<body class="bg-main">
    @include('partials.nav')

    <main class="py-5">
        <section class="p-4 p-md-5 rounded-4 mx-auto" id="login">
            <form method="POST" action="{{ route('login', absolute: false) }}" data-plausible-submit="login_submitted">
                @csrf 
                
                <div class="text-center mb-4">
                    <img src="{{ asset('resources/img/logo/logo.png') }}" alt="logo" class="mb-3 logo">
                    <p class="small text-secondary">Accede a tu cuenta de AUTOQUIRAY</p>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="nombre@ejemplo.com" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="••••••••">
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox"
                           class="form-check-input"
                           id="check"
                           name="remember"
                           value="1"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-secondary small" for="check">Recordarme en este equipo</label>
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-green-aq w-100 py-3 fs-5 fw-bold">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Iniciar sesión
                    </button>
                </div>

                <p class="text-center text-secondary small mb-4">
                    Si tu cuenta tiene varios perfiles, podrás elegir el rol justo después de acceder.
                </p>

                <div class="text-center">
                    <img src="{{ asset('resources/img/login/conexionSegura.png') }}" alt="Conexión Segura" class="rounded-2">
                </div>
            </form>
        </section>
    </main>

    @include('partials.footer')
    @include('partials.scripts')
</body>
</html>
