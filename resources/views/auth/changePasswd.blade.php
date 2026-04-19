<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('partials.links')
    <link rel="stylesheet" href="/resources/css/changePassword.css">
</head>
<body class="bg-main">
    @include('partials.flashMessages')

    <main class="change-password-page">
        <section class="password-box animate__animated animate__fadeInUp">
            <div class="password-header">
                <div class="password-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h1>Cambiar contraseña</h1>
                <p>Introduce tu nueva contraseña para actualizar el acceso a tu cuenta.</p>
            </div>

            <form method="POST" action="#" class="password-form" id="form">
                @csrf

                <div class="mb-4">
                    <label for="new_password" class="form-label">Nueva contraseña</label>
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        class="form-control autoquiray-input"
                        placeholder="Introduce la nueva contraseña"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="new_password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input
                        type="password"
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        class="form-control autoquiray-input"
                        placeholder="Repite la nueva contraseña"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-autoquiray btn-lg w-100 shadow-lg">
                    <i class="fa-solid fa-key me-2"></i>
                    Cambiar contraseña
                </button>
            </form>
        </section>
    </main>

    @include('partials.scripts')

    <script src="/resources/js/changePassword.js"></script>
    <script>
        email = @json($email);
    </script>
</body>
</html>
