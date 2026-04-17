@php
    $uri = request()->path();
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis mensajes</title>
    @include("partials.links")
    <style>
        body.bg-main {
            background: #0f172a !important;
            color: #e2e8f0;
        }

        .messages-shell {
            max-width: 1120px;
            margin: 0 auto;
            padding: 6.5rem 1rem 4rem;
        }

        .messages-hero {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 1.5rem;
        }

        .messages-summary {
            background: rgba(30, 41, 59, 0.92);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 22px;
            padding: 1rem 1.25rem;
            min-width: 220px;
        }

        .message-thread {
            background: rgba(30, 41, 59, 0.96);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 1.35rem;
            margin-bottom: 1rem;
            box-shadow: 0 18px 40px rgba(0,0,0,0.22);
        }

        .message-thread-head {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .message-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .message-badge-waiting {
            background: rgba(249, 115, 22, 0.16);
            color: #fdba74;
        }

        .message-badge-answered {
            background: rgba(34, 197, 94, 0.15);
            color: #86efac;
        }

        .message-bubble {
            border-radius: 20px;
            padding: 1rem 1.1rem;
            margin-bottom: 0.9rem;
        }

        .message-bubble-student {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(96, 165, 250, 0.18);
        }

        .message-bubble-teacher {
            background: rgba(20, 83, 45, 0.28);
            border: 1px solid rgba(34, 197, 94, 0.18);
        }

        .message-meta {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
            font-size: 0.85rem;
            color: #94a3b8;
            margin-bottom: 0.45rem;
        }

        .message-empty {
            background: rgba(30, 41, 59, 0.96);
            border: 1px dashed rgba(255,255,255,0.15);
            border-radius: 24px;
            padding: 2rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .messages-shell {
                padding-top: 5.75rem;
            }

            .messages-hero,
            .message-thread-head,
            .message-meta {
                flex-direction: column;
                align-items: flex-start;
            }

            .messages-summary {
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-main">
    @include("partials.nav", ['uri' => $uri])

    <main class="messages-shell">
        <section class="messages-hero">
            <div>
                <h1 class="h2 fw-bold mb-2">Mis mensajes</h1>
                <p class="text-muted mb-0">Aqui puedes leer todo tu historial de consultas y las respuestas que te han enviado los profesores.</p>
            </div>

            <div class="messages-summary">
                <div class="small text-uppercase text-secondary mb-1">Conversaciones</div>
                <div class="h3 mb-0 fw-bold">{{ $threads->count() }}</div>
            </div>
        </section>

        @forelse($threads as $thread)
            <article class="message-thread">
                <div class="message-thread-head">
                    <div>
                        <div class="small text-uppercase text-secondary mb-2">Asunto</div>
                        <h2 class="h5 mb-1">{{ ucfirst($thread->affair) }}</h2>
                        <p class="text-secondary mb-0">Enviado el {{ \Carbon\Carbon::parse($thread->date_sent)->format('d/m/Y H:i') }}</p>
                    </div>

                    @if($thread->answers_count > 0)
                        <span class="message-badge message-badge-answered">
                            <i class="fa-solid fa-envelope-open-text"></i>
                            {{ $thread->answers_count }} respuesta{{ $thread->answers_count > 1 ? 's' : '' }}
                        </span>
                    @else
                        <span class="message-badge message-badge-waiting">
                            <i class="fa-regular fa-clock"></i>
                            Pendiente de respuesta
                        </span>
                    @endif
                </div>

                <div class="message-bubble message-bubble-student">
                    <div class="message-meta">
                        <strong class="text-info">Tu mensaje</strong>
                        <span>{{ \Carbon\Carbon::parse($thread->date_sent)->diffForHumans() }}</span>
                    </div>
                    <p class="mb-0">{{ $thread->menssage }}</p>
                </div>

                @foreach($thread->answers as $answer)
                    <div class="message-bubble message-bubble-teacher">
                        <div class="message-meta">
                            <strong class="text-success">{{ $answer->teacher_name }}</strong>
                            <span>{{ \Carbon\Carbon::parse($answer->date_sent)->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="mb-0">{{ $answer->menssage }}</p>
                    </div>
                @endforeach
            </article>
        @empty
            <section class="message-empty">
                <i class="fa-regular fa-paper-plane fs-1 text-secondary mb-3"></i>
                <h2 class="h4 mb-2">Aun no has enviado mensajes</h2>
                <p class="text-muted mb-4">Cuando escribas a soporte desde la pagina de contacto, aqui veras el historial completo con las respuestas de los profesores.</p>
                <a href="{{ route('student.contacto') }}" class="btn btn-green-aq px-4 py-3 fw-bold rounded-4">
                    Ir a soporte
                </a>
            </section>
        @endforelse
    </main>

    @include("partials.footer")
    @include("partials.scripts")
</body>
</html>
