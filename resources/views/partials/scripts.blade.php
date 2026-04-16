<script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('resources/js/nav.js') }}"></script>
<script defer data-domain="192.168.1.248" src="http://192.168.1.248:8000/js/script.js"></script>
<script>
    window.trackEvent = function (name, props = {}) {
        if (typeof window.plausible !== 'function' || !name) {
            return;
        }

        const hasProps = props && Object.keys(props).length > 0;
        window.plausible(name, hasProps ? { props } : undefined);
    };

    document.addEventListener('click', (event) => {
        const target = event.target.closest('[data-plausible-event]');
        if (!target) {
            return;
        }

        window.trackEvent(target.dataset.plausibleEvent);
    });

    document.addEventListener('submit', (event) => {
        const form = event.target.closest('[data-plausible-submit]');
        if (!form) {
            return;
        }

        window.trackEvent(form.dataset.plausibleSubmit);
    });

    const flashedPlausibleEvents = @json(session('plausible_events', []));
    flashedPlausibleEvents.forEach((item) => {
        window.trackEvent(item.name, item.props ?? {});
    });
</script>
