const navGrande = document.getElementById("bigNav");
const navPequeno = document.getElementById("smallNav");
const classesColapse = "collapse navbar-collapse justify-content-center";
const classesOffcanvas = "offcanvas-xl offcanvas-end";

function chequearTamano() {
  if (window.innerWidth < 1200) {
    navPequeno.className = classesOffcanvas;
    navGrande.className = "d-none";
  } else {
    navGrande.className = classesColapse;
    navPequeno.className = "d-none";
  }
}

chequearTamano();

window.addEventListener('resize', chequearTamano);