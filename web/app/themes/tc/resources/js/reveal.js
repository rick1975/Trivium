/*
|--------------------------------------------------------------------------
| Verschijnen bij scrollen
|
| Kaarten (blokstijl "Kaarten") schuiven één voor één omhoog en vagen in
| zodra ze in beeld komen (opmaak: [data-reveal] in css/app.css). Kaarten die
| bij het laden al in beeld staan, komen direct (met dezelfde animatie).
| Bij "minder beweging" gebeurt er niets en staat alles gewoon stil.
|--------------------------------------------------------------------------
*/

const GROUPS = ['.main .is-style-kaarten'];
const ITEMS = ':scope > .wp-block-column';

export function initReveal() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -10% 0px', threshold: 0.15 },
    );

    document.querySelectorAll(GROUPS.join(',')).forEach((group) => {
        group.querySelectorAll(ITEMS).forEach((item, index) => {
            item.dataset.reveal = '';
            item.style.setProperty('--reveal-index', index);
            observer.observe(item);
        });
    });
}
