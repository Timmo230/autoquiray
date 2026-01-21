const navGrande = document.getElementById("bigNav");
const navPequeno = document.getElementById("smallNav");
const classes = "collapse navbar-collapse justify-content-center";

function chequearTamano() {
  if (window.innerWidth < 1200) {
    navPequeno.className = classes;
    navGrande.className = "d-none";
  } else {
    navGrande.className = classes;
    navPequeno.className = "d-none";
  }
}

chequearTamano();

window.addEventListener('resize', chequearTamano);