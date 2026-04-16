document.addEventListener('DOMContentLoaded', function () {
    const smallNavElement = document.getElementById('smallNav');
    const bigNav = document.getElementById('bigNav');

    function handleLayout() {
        const isDesktop = window.innerWidth >= 1200;

        if (isDesktop) {
            // FORZAR CIERRE: Si el offcanvas está abierto, lo cerramos por completo
            const bsOffcanvas = bootstrap.Offcanvas.getInstance(smallNavElement);
            if (bsOffcanvas) {
                bsOffcanvas.hide();
            }
            
            // Aseguramos que el bigNav se vea y el small sea invisible
            if (bigNav) bigNav.style.display = 'flex';
            if (smallNavElement) smallNavElement.style.visibility = 'hidden';
        } else {
            // MODO MÓVIL: bigNav oculto, smallNav listo para actuar
            if (bigNav) bigNav.style.display = 'none';
            if (smallNavElement) smallNavElement.style.visibility = 'visible';
        }
    }

    window.addEventListener('resize', handleLayout);
    handleLayout(); // Ejecución inicial
});