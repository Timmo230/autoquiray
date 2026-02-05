@php
    $uri = request()->path();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    @include('partials.links')
    <link rel="stylesheet" href="/autoquiray/resources/css/login.css">
</head>
<body>
    @include('partials.nav')
    @if ($errors->any())
        <div class="alert alert-danger m-0">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <main class="bg-linear-blue py-5">
        <section class="p-4 rounded-4 mx-auto" id="login">
            <form method="POST" action="{{ route('login') }}">
                @csrf <div class="d-flex justify-content-center">
                    <div class="mb-3 d-flex flex-column text-center">
                        <img src="/autoquiray/resources/img/logo/logo.png" alt="logo" class="bg-navbar p-3 rounded-4 bg-opacity-90 mx-auto logo">
                        <h2 class="rubik my-3">Area Privada</h2>
                        <p class="fs-5 opacity-50 rubik">Accede a tu cuenta de AUTOQUIRAY</p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="type" class="form-label">Tipo de usuario</label>
                    <select class="form-select form-select-lg mb-3" aria-label="Small select example" id="type" name="type">
                        <option value="student">Alumno</option>
                        <option value="teacher">Profesor</option>
                        <option value="administrator">Administrador</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="check">
                    <label class="form-check-label" for="check">Recuerdame</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-green-btn rounded-4 p-3 text-light fs-5-5 fw-bold w-100 btngreenLight">Iniciar sesion</button>
                </div>
                <div class="mb-3">
                    <img src="/autoquiray/resources/img/login/conexionSegura.png" alt="" width="400px" class="rounded-2">
                </div>
            </form>
        </section>
    </main>

    @include('partials.footer')
    @include('partials.scripts')
</body>
</html>