<nav class="navbar navbar-expand-xl bg-navbar position-sticky top-0 z-3 bg-opacity-90" id="nav" data-bs-theme="dark">
    <div class="container-fluid">

        <!-- IZQUIERDA: Logo -->
        <a class="navbar-brand" href="./index.php">
            <img src="./statics/img/logo/logo.png" width="250" alt="">
        </a>

        <!-- CENTRO: Menu -->
        <div class="collapse navbar-collapse justify-content-center" id="bigNav">
            <?php require "./partials/navlinks.php"; ?>
        </div>


        <!-- DERECHA: Botón + Toggler -->
        <div class="d-flex align-items-center nav-buttons">
            <a class="btn btn-green-btn text-white me-3 btngreenLight arriba" href="./login.php">
                <i class="fa-regular fa-user me-1"></i> Área Privada
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#smallNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse justify-content-center" id="smallNav">
            <?php require "./partials/navlinks.php"; ?>
        </div>
    </div>
</nav>
