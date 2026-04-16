<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plausible Seed</title>
    @include('partials.links')
    <style>
        body {
            background: #0f172a;
            color: #e2e8f0;
            font-family: Rubik, sans-serif;
        }

        .seed-shell {
            max-width: 760px;
            margin: 4rem auto;
            padding: 2rem;
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.35);
        }

        .seed-log {
            margin-top: 1.5rem;
            padding: 1rem;
            background: #020617;
            border-radius: 16px;
            min-height: 280px;
            max-height: 420px;
            overflow: auto;
            font-size: 0.95rem;
        }

        .seed-log p {
            margin: 0 0 0.65rem;
            color: #cbd5e1;
        }

        .seed-log strong {
            color: #86efac;
        }

        .seed-button {
            background: #16a34a;
            border: 0;
            color: white;
            padding: 0.9rem 1.4rem;
            border-radius: 999px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <main class="seed-shell">
        <h1 class="h3 mb-3">Registro manual de eventos para Plausible</h1>
        <p class="mb-3">
            Esta página dispara todos los eventos instrumentados uno por uno para que aparezcan en tu instancia de Plausible.
        </p>
        <p class="mb-4">
            URL: <code>{{ request()->getSchemeAndHttpHost() }}/plausible-seed</code>
        </p>

        <button class="seed-button" type="button" id="seed-trigger">
            Enviar todos los eventos
        </button>

        <div class="seed-log" id="seed-log"></div>
    </main>

    @include('partials.scripts')

    <script>
        const eventsToSeed = [
            ['home_tests_cta_clicked', {}],
            ['home_login_cta_clicked', {}],
            ['login_submitted', {}],
            ['login_success', { role: 'student' }],
            ['login_failed', { reason: 'invalid_credentials', role: 'student' }],
            ['logout', {}],
            ['class_reserved', {}],
            ['class_reservation_failed', { reason: 'manual_seed' }],
            ['class_reservation_cancelled', {}],
            ['class_cancel_failed', { reason: 'manual_seed' }],
            ['contact_form_submitted', {}],
            ['contact_message_sent', { subject: 'manual_seed' }],
            ['test_launch_clicked', {}],
            ['test_started', { test_id: 'seed-test-001' }],
            ['test_question_answered', {}],
            ['test_completed', {
                test_id: 'seed-test-001',
                score: '18',
                max_score: '20',
                answered: '20',
                duration_seconds: '320'
            }],
            ['test_submit_failed', { test_id: 'seed-test-001' }],
            ['test_results_viewed', {
                test_id: 'seed-test-001',
                score: '18',
                max_score: '20',
                failed: '2'
            }],
        ];

        const log = document.getElementById('seed-log');
        const button = document.getElementById('seed-trigger');

        const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

        const writeLog = (message) => {
            const row = document.createElement('p');
            row.innerHTML = message;
            log.appendChild(row);
            log.scrollTop = log.scrollHeight;
        };

        button.addEventListener('click', async () => {
            if (typeof window.trackEvent !== 'function') {
                writeLog('<strong>Error:</strong> trackEvent no esta disponible.');
                return;
            }

            button.disabled = true;
            log.innerHTML = '';
            writeLog('<strong>Inicio:</strong> enviando eventos a Plausible...');

            for (const [name, props] of eventsToSeed) {
                window.trackEvent(name, props);
                writeLog(`<strong>Enviado:</strong> ${name}`);
                await wait(350);
            }

            writeLog('<strong>Listo:</strong> revisa Plausible y la pestaña Network filtrando por "event".');
            button.disabled = false;
        });
    </script>
</body>
</html>
