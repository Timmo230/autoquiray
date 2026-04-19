@php
    $flashMessages = [];

    if (session('success')) {
        $flashMessages[] = [
            'type' => 'success',
            'message' => session('success'),
        ];
    }

    if (session('error')) {
        $flashMessages[] = [
            'type' => 'error',
            'message' => session('error'),
        ];
    }

    if ($errors->any()) {
        foreach ($errors->all() as $error) {
            $flashMessages[] = [
                'type' => 'error',
                'message' => $error,
            ];
        }
    }
@endphp

<div id="appFlashContainer" class="aq-flash-container" aria-live="polite" aria-atomic="true"></div>

<style>
    .aq-flash-container {
        position: fixed;
        top: 92px;
        left: 50%;
        transform: translateX(-50%);
        width: min(680px, calc(100vw - 1.5rem));
        z-index: 2000;
        display: flex;
        flex-direction: column;
        gap: .75rem;
        pointer-events: none;
    }

    .aq-flash {
        pointer-events: auto;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: .9rem;
        align-items: start;
        padding: 1rem 1.1rem;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,.08);
        box-shadow: 0 18px 45px rgba(2, 8, 23, .28);
        backdrop-filter: blur(10px);
        color: #e2e8f0;
        animation: aqFlashEnter .28s ease forwards;
    }

    .aq-flash.is-leaving {
        animation: aqFlashExit .22s ease forwards;
    }

    .aq-flash-success {
        background: rgba(6, 95, 70, .92);
        border-color: rgba(52, 211, 153, .22);
    }

    .aq-flash-error {
        background: rgba(127, 29, 29, .94);
        border-color: rgba(248, 113, 113, .24);
    }

    .aq-flash-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.14);
        font-size: 1rem;
    }

    .aq-flash-message {
        margin: 0;
        line-height: 1.45;
        font-weight: 600;
    }

    .aq-flash-close {
        appearance: none;
        border: 0;
        background: transparent;
        color: #fff;
        opacity: .8;
        font-size: 1rem;
        line-height: 1;
        padding: .2rem;
    }

    .aq-flash-close:hover {
        opacity: 1;
    }

    @keyframes aqFlashEnter {
        from {
            opacity: 0;
            transform: translateY(-22px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes aqFlashExit {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-16px);
        }
    }

    @media (max-width: 768px) {
        .aq-flash-container {
            top: 82px;
            width: calc(100vw - 1rem);
        }

        .aq-flash {
            grid-template-columns: auto 1fr;
        }

        .aq-flash-close {
            grid-column: 2;
            justify-self: end;
        }
    }
</style>

<script>
    (() => {
        if (window.showAppFlash) {
            return;
        }

        const flashIcons = {
            success: 'fa-solid fa-circle-check',
            error: 'fa-solid fa-triangle-exclamation',
        };

        const buildFlashElement = (type, message) => {
            const wrapper = document.createElement('div');
            wrapper.className = `aq-flash aq-flash-${type}`;
            wrapper.innerHTML = `
                <span class="aq-flash-icon">
                    <i class="${flashIcons[type] || flashIcons.error}"></i>
                </span>
                <p class="aq-flash-message"></p>
                <button type="button" class="aq-flash-close" aria-label="Cerrar aviso">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            `;

            wrapper.querySelector('.aq-flash-message').textContent = message;
            return wrapper;
        };

        const removeFlash = (flashElement) => {
            flashElement.classList.add('is-leaving');
            flashElement.addEventListener('animationend', () => flashElement.remove(), { once: true });
        };

        const readStoredFlashes = () => {
            try {
                const stored = sessionStorage.getItem('app_flash_messages');
                if (!stored) {
                    return [];
                }

                sessionStorage.removeItem('app_flash_messages');
                return JSON.parse(stored);
            } catch (_) {
                sessionStorage.removeItem('app_flash_messages');
                return [];
            }
        };

        window.showAppFlash = (type, message, options = {}) => {
            const { duration = 4200, persist = false } = options;

            if (persist) {
                const existing = readStoredFlashes();
                existing.push({ type, message, duration });
                sessionStorage.setItem('app_flash_messages', JSON.stringify(existing));
                return;
            }

            const container = document.getElementById('appFlashContainer');
            if (!container || !message) {
                return;
            }

            const flashElement = buildFlashElement(type, message);
            const closeButton = flashElement.querySelector('.aq-flash-close');
            closeButton.addEventListener('click', () => removeFlash(flashElement));

            container.appendChild(flashElement);

            if (duration > 0) {
                window.setTimeout(() => {
                    if (flashElement.isConnected) {
                        removeFlash(flashElement);
                    }
                }, duration);
            }
        };

        const initialFlashes = @json($flashMessages);
        document.addEventListener('DOMContentLoaded', () => {
            [...readStoredFlashes(), ...initialFlashes].forEach((flash) => {
                window.showAppFlash(flash.type, flash.message, { duration: flash.duration ?? 4200 });
            });
        });
    })();
</script>
