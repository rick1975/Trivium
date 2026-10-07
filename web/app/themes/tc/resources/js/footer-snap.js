/*
|--------------------------------------------------------------------------
| Footer die vanzelf in beeld glijdt (vanaf tablet)
|
| Stopt de bezoeker met naar beneden scrollen terwijl de bovenrand van de
| footer in de onderste helft van het scherm staat, dan glijdt de pagina
| rustig door tot de footer het scherm vult. Pas daarna krijgt de footer
| data-shown, waarop de foto van links inschuift (zie sections/footer).
| Scrollt de bezoeker zelf tot de footer, dan start de foto ook.
| Mobiel en bij "minder beweging": geen glijden, foto meteen zichtbaar.
|--------------------------------------------------------------------------
*/

const DURATION = 1000;
const SNAP_ZONE = 0.5; // bovenrand footer binnen de onderste helft van het scherm
const SHOWN_ZONE = 0.1; // bovenrand footer bijna bovenaan: foto starten

const easeInOutCubic = (t) => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

export function initFooterSnap() {
    const footer = document.querySelector('.footer');
    if (!footer) return;

    const desktop = window.matchMedia('(min-width: 48rem)');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    let lastY = window.scrollY;
    let direction = 0;
    let animating = false;

    const show = () => {
        footer.dataset.shown = '';
    };

    const glideTo = (targetY) => {
        const startY = window.scrollY;
        const distance = targetY - startY;
        const start = performance.now();
        let frame;

        animating = true;

        const stop = () => {
            cancelAnimationFrame(frame);
            animating = false;
            ['wheel', 'touchstart', 'keydown'].forEach((type) => window.removeEventListener(type, stop));
        };

        // Bezoeker grijpt in: animatie direct loslaten
        ['wheel', 'touchstart', 'keydown'].forEach((type) => window.addEventListener(type, stop, { passive: true }));

        const step = (now) => {
            const progress = Math.min((now - start) / DURATION, 1);
            window.scrollTo({ top: startY + distance * easeInOutCubic(progress), behavior: 'instant' });

            if (progress < 1) {
                frame = requestAnimationFrame(step);
            } else {
                stop();
                show();
            }
        };

        frame = requestAnimationFrame(step);
    };

    const onSettle = () => {
        if (animating) return;

        const top = footer.getBoundingClientRect().top;
        const viewport = window.innerHeight;

        if (top <= viewport * SHOWN_ZONE) {
            show();
            return;
        }

        if (!desktop.matches || reducedMotion.matches) {
            if (top < viewport) show();
            return;
        }

        if (direction > 0 && top < viewport * SNAP_ZONE) {
            glideTo(window.scrollY + top);
        }
    };

    // scrollend waar beschikbaar, anders wachten tot er even niet gescrold is
    let settleTimer;
    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (y !== lastY) direction = Math.sign(y - lastY);
        lastY = y;

        if (!('onscrollend' in window)) {
            clearTimeout(settleTimer);
            settleTimer = setTimeout(onSettle, 150);
        }
    }, { passive: true });

    if ('onscrollend' in window) {
        window.addEventListener('scrollend', onSettle);
    }

    onSettle();
}
