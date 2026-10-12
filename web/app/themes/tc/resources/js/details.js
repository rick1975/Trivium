/*
|--------------------------------------------------------------------------
| Uitklapblokken (core/details) vloeiend open- en dichtklappen
|
| Een <details> springt van zichzelf open en dicht. Hier wordt de hoogte
| geanimeerd: bij openen van de hoogte van de vraag naar de volle hoogte, bij
| dichtklappen andersom (en pas daarna gaat het blok echt dicht). Klik je
| halverwege nog eens, dan draait de animatie vanaf de huidige hoogte om.
| Tijdens het dichtklappen staat data-state="closing" (de plus draait dan al
| terug, zie css/app.css). Bij "minder beweging" gewoon zonder animatie.
|--------------------------------------------------------------------------
*/

const DURATION = 350;
const EASING = 'cubic-bezier(.2,.8,.2,1)';

export function initDetails() {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    document.querySelectorAll('details.wp-block-details').forEach((details) => {
        const summary = details.querySelector(':scope > summary');
        if (!summary) return;

        let animation = null;

        const animate = (from, to, done) => {
            animation?.cancel();
            details.style.overflow = 'hidden';
            animation = details.animate({ height: [`${from}px`, `${to}px`] }, { duration: DURATION, easing: EASING });
            animation.onfinish = () => {
                animation = null;
                details.style.overflow = '';
                done?.();
            };
        };

        summary.addEventListener('click', (event) => {
            if (reducedMotion.matches) return;
            event.preventDefault();

            const from = details.offsetHeight;
            animation?.cancel();

            if (!details.open || details.dataset.state === 'closing') {
                delete details.dataset.state;
                details.open = true;
                animate(from, details.offsetHeight);
            } else {
                details.dataset.state = 'closing';
                animate(from, summary.offsetHeight, () => {
                    details.open = false;
                    delete details.dataset.state;
                });
            }
        });
    });
}
