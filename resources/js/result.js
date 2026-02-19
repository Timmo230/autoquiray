function assignStyle(successes, max_note){
    color = null;
    porcentage = Math.floor((successes * 100) / max_note);

    color = successes >= (max_note - 3) && successes < max_note ? '#FFC107'
        : successes == max_note ? '#198754' : '#ff4d4d';
    
    const circle = document.getElementById('porcentage');
    const porcentageText = document.getElementById('porcentage_text');

    circle.style.background = `radial-gradient(closest-side, white 85%, transparent 86% 100%),
                                   conic-gradient(${color} ${porcentage}%, #e9ecef 0)`;
    porcentageText.textContent = porcentage + '%';
}

function time(seconds){
    const cociente = Math.floor(seconds / 60);
    const resto = seconds % 60;
    const timeObject = document.getElementById('time');
    const add01 = cociente < 10 ? '0' : '';
    const add02 = resto < 10 ? '0' : '';

    timeObject.textContent = add01 + cociente + ':' + resto + add02;
}