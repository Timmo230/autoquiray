<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
        include "./partials/links.php";
    ?>
    <link rel="stylesheet" href="./statics/css/contacto.css">
</head>
<body class="bg-main">
    <?php 
        include "./partials/nav.php";
    ?>
    
    <main class="container">
        <article class="row row-cols-1 row-cols-lg-2 p-3">
            <section class="col d-flex flex-column my-2">
                <div class="bg-white rubik rounded-4 shadow box">
                    <div>
                        <h4>Atención al Cliente</h2>
                        <h5 class="opacity-50">¿Tienes alguna duda? Estamos aquí para ayudarte</h5>
                    </div>
                    <form>
                        <div class="mb-3 mt-4">
                            <label for="tipo" class="form-label">Asunto</label>
                            <select class="form-select form-select mb-3" aria-label="Small select example" id="tipo" name="tipo">
                                <option value="1">Matrícula y documentación</option>
                                <option value="2">Clases teóricas o prácticas</option>
                                <option value="3">Fechas de examen</option>
                                <option value="4">Pagos y facturación</option>
                                <option value="5">Problema técnico</option>
                                <option value="6">Otro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" placeholder="Escribe tu mensaje aquí"></textarea>
                        </div>
                        <div class="mb-3 d-flex flex-column">
                            <button type="submit" class="bg-dark-green btngreenLight arriba border-0 p-3 rounded-4 text-white">Enviar Mensaje</button>
                        </div>
                    </form>
                </div>
            </section>
            <section class="col d-flex flex-column my-2">
                <div class="bg-white rubik rounded-4 shadow p-4">
                    <div class="">
                        <h4>Información de Contacto</h3>
                    </div>
                    <div class="col d-flex rounded-4 my-2">
                        <div class="my-auto bg-green bg-opacity-50 px-3 py-2 rounded-4">
                            <i class="fa-solid fa-phone fs-5 text-dark-green my-2"></i>
                        </div>
                        <div class="rubik ps-3 my-auto">
                            <h5>Teléfono</h5>
                            <h5 class="fw-normal opacity-75">+34 XXX XXX XXX</h5>
                        </div>
                    </div>
                    <div class="col d-flex rounded-4 my-2">
                        <div class="my-auto blue bg-opacity-50 px-3 py-2 rounded-4">
                            <i class="fa-regular fa-envelope my-2 fs-5"></i>
                        </div>
                        <div class="rubik ps-3 my-auto">
                            <h5>Email</h5>
                            <h5 class="fw-normal opacity-75">info@autoquiray.com</h5>
                        </div>
                    </div>
                    <div class="col d-flex rounded-4 my-2">
                        <div class="my-auto purple bg-opacity-50 px-3 py-2 rounded-4">
                            <i class="fa-solid fa-location-dot my-2 fs-4"></i>
                        </div>
                        <div class="rubik ps-3 my-auto">
                            <h5>Dirección</h5>
                            <h5 class="fw-normal opacity-75">Calle Principal 123, Madrid</h5>
                        </div>
                    </div>
                </div>
                <div class="bg-white rubik rounded-4 shadow p-4 my-4">
                    <div class="mb-3">
                        <h4>Horario de Atención</h3>
                    </div>
                    <div class="col d-flex rounded-4">
                        <p class="opacity-50 mb-0">Lunes - Viernes</p>
                        <p class="ms-auto mb-0">09:00 - 20:00</p>
                    </div>
                    <hr class="m-0 mb-3">
                    <div class="col d-flex rounded-4">
                        <p class="opacity-50 mb-0">Sabados</p>
                        <p class="ms-auto mb-0">09:00 - 14:00</p>
                    </div>
                    <hr class="m-0 mb-3">
                    <div class="col d-flex rounded-4">
                        <p class="opacity-50">Domingos</p>
                        <p class="ms-auto text-danger">Cerrado</p>
                    </div>
                </div>
            </section>
        </article>
    </main>
    
    <?php 
        include "./partials/footer.php";
        include "./partials/scripts.php";
    ?>
</body>
</html>