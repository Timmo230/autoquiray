function assignStyle(successes, max_note){
  const porcentage = Math.floor((successes * 100) / max_note);

  const color =
    successes >= (max_note - 3) && successes < max_note ? '#FFC107'
    : successes == max_note ? '#10b981'
    : '#ef4444';

  const circle = document.getElementById('porcentage');
  const porcentageText = document.getElementById('porcentage_text');

  // Track oscuro (resto) + progreso (fill) + centro oscuro
  const track = 'rgba(255,255,255,.14)';
  const core  = '#0f172a';

  circle.style.background = `
    radial-gradient(closest-side, ${core} 79%, transparent 80% 100%),
    conic-gradient(${color} ${porcentage}%, ${track} 0)
  `;

  porcentageText.textContent = porcentage + '%';
}

function time(seconds){
  const cociente = Math.floor(seconds / 60);
  const resto = seconds % 60;
  const timeObject = document.getElementById('time');
  const add01 = cociente < 10 ? '0' : '';
  const add02 = resto < 10 ? '0' : '';

  timeObject.textContent = add01 + cociente + ':' + add02 + resto;
}