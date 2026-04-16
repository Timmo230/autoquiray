const timetableRadios = document.querySelectorAll('input[name="timetable_id"]');
const selectedTimetableText = document.getElementById('selectedTimetableText');
const selectedTimetableBadge = document.getElementById('selectedTimetableBadge');

function updateSelectedTimetable() {
    const checked = document.querySelector('input[name="timetable_id"]:checked');

    if (!checked) {
        selectedTimetableBadge.textContent = 'Ninguno';
        selectedTimetableText.textContent = 'Aún no has seleccionado ningún horario.';
        return;
    }

    const date = checked.dataset.date;
    const start = checked.dataset.start;
    const end = checked.dataset.end;

    selectedTimetableBadge.textContent = '1 seleccionado';
    selectedTimetableText.innerHTML = `
        <strong>Fecha:</strong> ${date}<br>
        <strong>Hora de entrada:</strong> ${start}<br>
        <strong>Hora de salida:</strong> ${end}
    `;
}

timetableRadios.forEach(radio => {
    radio.addEventListener('change', updateSelectedTimetable);
});

updateSelectedTimetable();