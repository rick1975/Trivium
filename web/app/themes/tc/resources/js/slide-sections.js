/*
|--------------------------------------------------------------------------
| Schermvullende secties als "slides" (vanaf tablet), zoals restaurantazurite.nl
|
| Secties met data-slide (fotobanner, footer) glijden rustig in beeld:
| - Scrollwiel omlaag terwijl de volgende slide al deels in beeld is: de
|   pagina glijdt meteen door tot die slide het scherm vult.
| - Scrollwiel omhoog bovenaan een slide die direct op een andere slide
|   volgt: terug naar die vorige slide.
| - Trackpad-uitloop, scrollbalk of toetsen: als het scrollen stopt met de
|   bovenrand van een slide in de onderste helft, glijdt die alsnog in beeld.
| Na aankomst krijgt de slide data-shown (de footerfoto schuift dan in).
| Gewone inhoud ertussen scrollt vrij. Mobiel en bij "minder beweging"
| gebeurt er niets, behalve data-shown zetten.
|--------------------------------------------------------------------------
*/

const DURATION = 1000;
const COOLDOWN = 500; // wiel-uitloop na het glijden negeren
const SNAP_ZONE = 0.5; // bij stilstand: bovenrand in de onderste helft
const SHOWN_ZONE = 0.1; // bovenrand bijna bovenaan: slide geldt als in beeld

const easeInOutCubic = (t) => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

export function initSlideSections() {
    const slides = [...document.querySelectorAll('[data-slide]')];
    if (!slides.length) return;

    const desktop = window.matchMedia('(min-width: 48rem)');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const active = () => desktop.matches && !reducedMotion.matches;

    let lastY = window.scrollY;
    let direction = 0;
    let busyUntil = 0; // tijdens glijden + cooldown

    const topOf = (el) => el.getBoundingClientRect().top;
    const show = (el) => {
        el.dataset.shown = '';
    };

    const glideTo = (slide) => {
        const startY = window.scrollY;
        const distance = topOf(slide);
        const start = performance.now();
        let frame;

        busyUntil = Infinity;

        const stop = () => {
            cancelAnimationFrame(frame);
            busyUntil = performance.now() + COOLDOWN;
            ['touchstart', 'keydown', 'mousedown'].forEach((type) => window.removeEventListener(type, stop));
        };

        // Bezoeker grijpt in (aanraken, toets, scrollbalk): glijden direct loslaten
        ['touchstart', 'keydown', 'mousedown'].forEach((type) => window.addEventListener(type, stop, { passive: true }));

        const step = (now) => {
            const progress = Math.min((now - start) / DURATION, 1);
            window.scrollTo({ top: startY + distance * easeInOutCubic(progress), behavior: 'instant' });

            if (progress < 1) {
                frame = requestAnimationFrame(step);
            } else {
                stop();
                show(slide);
            }
        };

        frame = requestAnimationFrame(step);
    };

    // Slide waarvan de bovenrand nu onder de bovenkant maar nog in beeld staat
    const nextInView = () => slides.find((el) => {
        const top = topOf(el);
        return top > 4 && top < window.innerHeight;
    });

    // Slide die precies bovenaan staat en direct aansluit op de vorige slide (onderrand vorige = bovenrand huidige).
    // Geen DOM-buren nodig: de fotobanner staat in <main>, de footer-slide in <footer>.
    const previousSlide = () => {
        const current = slides.find((el) => Math.abs(topOf(el)) <= 4);
        const previous = current && slides[slides.indexOf(current) - 1];
        return previous && Math.abs(previous.getBoundingClientRect().bottom - topOf(current)) <= 4 ? previous : null;
    };

    window.addEventListener('wheel', (event) => {
        if (!active() || event.ctrlKey) return;

        if (performance.now() < busyUntil) {
            event.preventDefault();
            return;
        }

        const target = event.deltaY > 0 ? nextInView() : event.deltaY < 0 ? previousSlide() : null;

        if (target) {
            event.preventDefault();
            glideTo(target);
        }
    }, { passive: false });

    const onSettle = () => {
        if (busyUntil === Infinity) return;

        const viewport = window.innerHeight;

        slides.forEach((el) => {
            if (topOf(el) <= viewport * SHOWN_ZONE) show(el);
        });

        if (!active()) {
            slides.forEach((el) => topOf(el) < viewport && show(el));
            return;
        }

        const target = direction > 0 && slides.find((el) => {
            const top = topOf(el);
            return top > 4 && top < viewport * SNAP_ZONE;
        });

        if (target) glideTo(target);
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
