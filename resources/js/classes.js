async function reservesClass(idClass){
    const post = await fetch('/classes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            idClass: idClass,
        })
    });

    if(post.ok) {
        window.trackEvent('class_reserved');
        window.showAppFlash?.('success', 'Clase reservada correctamente.', { persist: true });
        window.location.href = `/classes`;
    }
    else {
        const data = await post.json().catch(() => ({}));
        window.trackEvent('class_reservation_failed', data.error ? { reason: data.error } : {});
        window.showAppFlash?.('error', data.error ?? 'Error al reservar clase');
    }
}

async function cancelReservation(idClass){
    const confirmed = window.confirm('¿Quieres desapuntarte de esta clase?');
    if (!confirmed) return;

    const response = await fetch(`/classes/${idClass}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });

    if (response.ok) {
        window.trackEvent('class_reservation_cancelled');
        window.showAppFlash?.('success', 'Te has desapuntado de la clase correctamente.', { persist: true });
        window.location.href = '/classes';
        return;
    }

    const data = await response.json().catch(() => ({}));
    window.trackEvent('class_cancel_failed', data.error ? { reason: data.error } : {});
    window.showAppFlash?.('error', data.error ?? 'No se pudo desapuntar de la clase');
}

document.addEventListener('click', (event) => {
    const toggleButton = event.target.closest('[data-class-toggle]');
    if (!toggleButton) return;

    const detailId = toggleButton.getAttribute('data-class-toggle');
    const detailRow = document.getElementById(detailId);
    if (!detailRow) return;

    const isOpen = detailRow.hasAttribute('hidden') === false;
    detailRow.hidden = isOpen;
    toggleButton.setAttribute('aria-expanded', String(!isOpen));
    toggleButton.textContent = isOpen ? 'Ver' : 'Ocultar';
});
