<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests Online</title>
    <?php include "./partials/links.php"; ?>
    <link rel="stylesheet" href="./statics/css/tests.css">
</head>
<body class="bg-main">
    <?php include "./partials/nav.php"; ?>

    <main>
        <div class="p-3">
            <h2>Plataforma de Test</h2>
            <p>Prepárate para el examen teórico de la DGT con nuestros tests actualizados</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 p-3">
            <div class="col p-2">
                <div class="card rounded-4 shadow">
                    <div class="card-body">
                        <div>
                            <img src="./statics/img/tests/senales.png" alt="" width="50px">
                            <span class="badge rounded-pill bg-green-btn text-light bg-opacity-75 my-1">Confirmada</span>
                        </div>
                        <h5 class="card-title">Clase Practica #12</h5>
                        <p class="card-text">Maniobras en rotondas</p>
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-regular fa-calendar text-secondary"></i>
                                <p class="my-auto mx-2 opacity-75">Mañana</p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-regular fa-clock"></i>
                                <p class="my-auto mx-2 opacity-75">10:00 - 11:00</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <img src="" alt="" class="rounded-50">
                            <p class="my-auto mx-2 opacity-75">Prof. Juan Martinez</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php 
        include "./partials/footer.php"; 
        include "./partials/scripts.php";
    ?>
</body>
</html>