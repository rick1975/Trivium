/*
|--------------------------------------------------------------------------
| Schermvullende secties als "slides", zoals restaurantazurite.nl
|
| Secties met data-slide (fotobanner, footer) glijden rustig in beeld:
| - Scrollwiel omlaag terwijl de volgende slide al deels in beeld is: de
|   pagina glijdt meteen door tot die slide het scherm vult.
| - Scrollwiel omhoog bovenaan een slide die direct op een andere slide
|   volgt: terug naar die vorige slide.
| - Trackpad-uitloop, scrollbalk, toetsen of vegen (mobiel): als het scrollen
|   stopt met de bovenrand van een slide in de bovenste helft (aanraakscherm:
|   zodra er een stukje van in beeld is), glijdt die alsnog in beeld.
|   Aanraken tijdens het glijden stopt het meteen.
| - Vegen (mobiel): niet wachten op de uitloop. Bij loslaten, of zodra de
|   uitloop een slide in beeld brengt, glijdt die meteen door (0,7 s).
| Na aankomst krijgt de slide data-shown (de footerfoto schuift dan in).
| Gewone inhoud ertussen scrollt vrij. Bij "minder beweging" gebeurt er
| niets, behalve data-shown zetten.
|--------------------------------------------------------------------------
*/

const DURATION = 1000;
const DURATION_TOUCH = 700; // na een veeg: korter, anders voelt het traag
const COOLDOWN = 500; // wiel-uitloop na het glijden negeren
const SNAP_ZONE = 0.5; // bij stilstand: bovenrand in de bovenste helft (slide al voor meer dan de helft in beeld)
const SNAP_ZONE_TOUCH = 0.9; // aanraakscherm (geen scrollwiel): al glijden zodra de slide een stukje in beeld is
const SHOWN_ZONE = 0.1; // bovenrand bijna bovenaan: slide geldt als in beeld

const easeInOutCubic = (t) => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

export function initSlideSections() {
    const slides = [...document.querySelectorAll('[data-slide]')];
    if (!slides.length) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const active = () => !reducedMotion.matches;
    const touch = window.matchMedia('(pointer: coarse)');

    let lastY = window.scrollY;
    let direction = 0;
    let busyUntil = 0; // tijdens glijden + cooldown

    const topOf = (el) => el.getBoundingClientRect().top;
    const show = (el) => {
        el.dataset.shown = '';
    };

    const glideTo = (slide, duration = DURATION) => {
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
            const progress = Math.min((now - start) / duration, 1);
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

    // Vinger op het scherm: nooit gaan glijden (iOS meldt soms "stilstand" terwijl je nog vasthoudt).
    // flinging: vinger los, pagina rolt nog uit
    let touching = false;
    let flinging = false;

    // Tijdelijke diagnose op de telefoon: voeg ?slidedebug toe aan de url
    const debug = new URLSearchParams(location.search).has('slidedebug') && document.body.appendChild(Object.assign(document.createElement('pre'), {
        style: 'position:fixed;left:8px;bottom:8px;z-index:9999;margin:0;padding:6px 8px;font:11px/1.4 monospace;color:#fff;background:rgb(0 0 0/.75);border-radius:6px;pointer-events:none',
    }));
    const log = (result) => {
        if (!debug) return;
        debug.textContent = [
            `coarse ${touch.matches} · reduced ${reducedMotion.matches} · scrollend ${'onscrollend' in window}`,
            `richting ${direction} · vinger ${touching} · hoogte ${window.innerHeight}`,
            `slides ${slides.map((el) => Math.round(topOf(el))).join(' / ')}`,
            `laatste: ${result}`,
        ].join('\n');
    };

    const onSettle = () => {
        if (busyUntil === Infinity || touching) return log(touching ? 'vinger nog op scherm' : 'bezig met glijden');

        const viewport = window.innerHeight;

        slides.forEach((el) => {
            if (topOf(el) <= viewport * SHOWN_ZONE) show(el);
        });

        if (!active()) {
            slides.forEach((el) => topOf(el) < viewport && show(el));
            return log('uit (minder beweging)');
        }

        flinging = false;
        const target = snapTarget();
        log(target ? `glijden naar slide ${slides.indexOf(target) + 1}` : 'geen slide in de buurt');
        if (target) glideTo(target, touch.matches ? DURATION_TOUCH : DURATION);
    };

    // Omlaag bezig en een slide waarvan de bovenrand in de snapzone staat
    function snapTarget() {
        const viewport = window.innerHeight;
        return direction > 0 && slides.find((el) => {
            const top = topOf(el);
            return top > 4 && top < viewport * (touch.matches ? SNAP_ZONE_TOUCH : SNAP_ZONE);
        });
    }

    // Na een veeg direct doorglijden (bij loslaten of tijdens de uitloop) i.p.v. wachten op stilstand
    const catchFling = (moment) => {
        if (!active() || busyUntil === Infinity || performance.now() < busyUntil) return;
        const target = snapTarget();
        if (!target) return;
        flinging = false;
        clearTimeout(settleTimer);
        log(`glijden naar slide ${slides.indexOf(target) + 1} (${moment})`);
        glideTo(target, DURATION_TOUCH);
    };

    // Stilstand = even geen scroll-event meer en geen vinger op het scherm. Bewust geen scrollend: dat
    // bestaat niet overal (Safari, Chrome op iOS) en vuurt op Android soms al vóór de uitloop van een veeg.
    let settleTimer;
    const settleSoon = () => {
        clearTimeout(settleTimer);
        settleTimer = setTimeout(onSettle, 150);
    };

    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (y !== lastY) direction = Math.sign(y - lastY);
        lastY = y;
        if (flinging) catchFling('tijdens uitloop');
        settleSoon();
    }, { passive: true });

    window.addEventListener('touchstart', () => {
        touching = true;
        flinging = false;
        clearTimeout(settleTimer);
    }, { passive: true });

    ['touchend', 'touchcancel'].forEach((type) => window.addEventListener(type, () => {
        touching = false;
        flinging = true;
        settleSoon();
        catchFling('bij loslaten');
    }, { passive: true }));

    onSettle();
}
