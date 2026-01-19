<?php
    require "./database.php";

    $statement = $conn->prepare("SELECT count(*) AS total FROM students WHERE active=1");
    $statement->execute();
    $user_ammount = $statement->fetch(PDO::FETCH_ASSOC)["total"];

    $statement = $conn->prepare("SELECT count(*) AS total FROM question_tests");
    $statement->execute();
    $questions_ammount = $statement->fetch(PDO::FETCH_ASSOC)["total"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTOQUIRAY</title>
    <?php
        require "./partials/links.php"
    ?>
    <link rel="stylesheet" href="./statics/css/index.css">
</head>
<body class="bg-navbar">   
    <?php require "./partials/nav.php" ?>

    <header class="pt-5 position-relative overflow-hidden bg-linear-blue">
        <div class="container pt-5">
            <div class="d-flex justify-content-center">
                <p class="btn text-green-btn bg-navbar bg-opacity-50 p-2 px-4 rounded-pill fw-semibold">
                    <span class="opacity-100">Plataforma Activa</span>
                </p>
            </div>
            <div class="d-flex justify-content-center">
                <h1 class="fw-bold text-light">AUTOQUIRAY</h1>
            </div>
            <div class="d-flex justify-content-center">
                <h3 class="text-green-btn">Tu autoescuela digital</h3>
            </div>
            <div class="d-flex justify-content-center text-center mt-3">
                <h5 class="text-secondary text-light opacity-50">Aprende a conducir con la mejor tecnología. Tests online, seguimiento personalizado y reserva de clases desde cualquier dispositivo.</h5>
            </div>
            <div class="row justify-content-center text-center mt-5 g-3">
                <div class="col-12 col-sm-6">
                    <p class="btn btn-green-btn rounded-4 p-3 text-light fs-5-5 fw-bold w-100 btngreenLight">
                        <i class="fa-regular fa-file-zipper me-2"></i>Acceder a mis tests
                    </p>
                </div>

                <div class="col-12 col-sm-6">
                    <a class="btn text-light rounded-4 p-3 border fw-bold fs-5-5 w-100" id="iniciarSesion" href="./login.php">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>

        <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
            <path
                d="M0,40 
                C240,80 480,80 720,60 
                960,40 1200,40 1440,60 
                L1440,100 L0,100 Z"
                fill="#f0f0f0">
            </path>
        </svg>
    </header>

    <main class="d-flex flex-column pt-5 align-content-center bg-main">
        <article class="d-flex flex-column">
            <section class="text-center py-4 mb-5">
                <h2 class="fs-1 fw-bolder">Ventajas de nuestra plataforma</h2>
                <h5 class="opacity-50">Todo lo necesario para obtener tu carnet de conducir en un solo lugar</h5>
            </section>
            <section class="container-fluid px-3 mb-5 mt-3">
                <div class="d-flex flex-wrap justify-content-center gap-3 align-items-stretch cards-flex">
                    <div class="card bg-white p-4 rounded-4 card-flex ventajas arriba shadow">
                        <div class="mb-2">
                            <img src="./statics/img/tests.png" alt="">
                        </div>
                        <h4>Test Online</h4>
                        <p>Miles de preguntas actualizadas según la normativa DGT vigente</p>
                    </div>

                    <div class="card bg-white p-4 rounded-4 card-flex ventajas arriba shadow">
                        <div class="mb-2">
                            <img src="./statics/img/Progreso.png" alt="">
                        </div>
                        <h4>Seguimiento de Progreso</h4>
                        <p>Visualiza tu evolución con estadísticas detalladas y gráficos</p>
                    </div>

                    <div class="card bg-white p-4 rounded-4 card-flex ventajas arriba shadow">
                        <div class="mb-2">
                            <img src="./statics/img/Reserva.png" alt="">
                        </div>
                        <h4>Reserva de Clases</h4>
                        <p>Programa tus clases prácticas fácilmente desde la app</p>
                    </div>

                    <div class="card bg-white p-4 rounded-4 card-flex ventajas arriba shadow">
                        <div class="mb-2">
                            <img src="./statics/img/atencion.png" alt="">
                        </div>
                        <h4>Atención al Alumno</h4>
                        <p>Soporte personalizado para resolver todas tus dudas</p>
                    </div>
                </div>
            </section>
            <section class="mt-5">
                <div class="container-fluid bg-white pt-4">
                    <div class="d-flex flex-wrap gap-3 align-items-stretch cards-flex justify-content-center text-center">
                        <div class="card-flex data">
                            <p class="text-green-btn fs-2 fw-bold m-0">98%</p>
                            <p class="text-secondary opacity-75 fs-5">Aprobados a la primera</p>
                        </div>
                        <div class="card-flex data">
                            <p class="text-blue fs-2 fw-bold m-0"><?= $questions_ammount?></p>
                            <p class="text-secondary opacity-75 fs-5">Preguntas disponibles</p>
                        </div>
                        <div class="card-flex data">
                            <p class="text-purple fs-2 fw-bold m-0"><?= $user_ammount ?></p>
                            <p class="text-secondary opacity-75 fs-5">Alumnos activos</p>
                        </div>
                        <div class="card-flex data">
                            <p class="text-orange fs-2 fw-bold m-0">15</p>
                            <p class="text-secondary opacity-75 fs-5">Años de experiencia</p>
                        </div>
                    </div>
                </div>
            </section>
        </article>
    </main>

    <?php
        require "./partials/footer.php"
    ?>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./statics/js/app.js"></script>
</body>
</html>