const navGrande = `<div class="container-fluid">

            <!-- IZQUIERDA: Logo -->
            <a class="navbar-brand" href="#">
                <img src="./statics/img/logo.png" width="250" alt="">
            </a>

            <!-- CENTRO: Menu -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tests Online</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Mis Clases</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Atención al Cliente</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Zona Profesores</a></li>
                </ul>
            </div>

            <!-- DERECHA: Botón + Toggler -->
            <div class="d-flex align-items-center nav-buttons">
                <a class="btn btn-green-btn text-white me-3 btngreenLight" href="#">
                    <i class="fa-regular fa-user me-1"></i> Área Privada
                </a>
                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

        </div>`
const navPequeno = `<div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./statics/img/logo.png" width="250" alt="">
            </a>

            <div class="d-flex align-items-center nav-buttons">
                <a class="btn btn-green-btn text-white me-3 btngreenLight" href="#">
                    <i class="fa-regular fa-user me-1"></i> Área Privada
                </a>
                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            
            <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tests Online</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Mis Clases</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Atención al Cliente</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Zona Profesores</a></li>
                </ul>
            </div>
        </div>`
const nav = document.getElementById("nav");


function chequearTamano() {
  if (window.innerWidth < 1200) {
    nav.innerHTML = navPequeno;
  } else {
    nav.innerHTML = navGrande;
  }
}

chequearTamano();

window.addEventListener('resize', chequearTamano);