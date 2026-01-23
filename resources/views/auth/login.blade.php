<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php
        include "./partials/links.php"
    ?>
    <link rel="stylesheet" href="./statics/css/login.css">
</head>
<body>

    <?php require "./partials/nav.php" ?>
    
    <main class="bg-linear-blue py-5">
        <section class="p-4 rounded-4 mx-auto" id="login">
            <form>
                <div class="d-flex justify-content-center">
                    <div class="mb-3 d-flex flex-column text-center">
                        <img src="./statics/img/logo/logo.png" alt="logo" class="bg-navbar p-3 rounded-4 bg-opacity-90 mx-auto logo">
                        <h2 class="rubik my-3">Area Privada</h2>
                        <p class="fs-5 opacity-50 rubik">Accede a tu cuenta de AUTOQUIRAY</p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de usuario</label>
                    <select class="form-select form-select-lg mb-3" aria-label="Small select example" id="tipo" name="tipo">
                        <option value="1">Alumno</option>
                        <option value="2">Profesor</option>
                        <option value="3">Administrador</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="user" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="user" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="passwd" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="passwd">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="check">
                    <label class="form-check-label" for="check">Recuerdame</label>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-green-btn rounded-4 p-3 text-light fs-5-5 fw-bold w-100 btngreenLight">Iniciar sesion</button>
                </div>
                <div class="mb-3">
                    <img src="./statics/img/login/conexionSegura.png" alt="" width="400px" class="rounded-2">
                </div>
            </form>
        </section>
    </main>

    <?php
        include "./partials/footer.php";
        require "./partials/scripts.php";
    ?>
</body>
</html>