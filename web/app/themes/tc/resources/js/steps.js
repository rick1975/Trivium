/*
|--------------------------------------------------------------------------
| Stappen als trap (lijst met blokstijl "Stappen (trap)", is-style-trap)
|
| Elk lijst-item begint met een vetgedrukte titel, bv. "PM0: een goede start".
| Boven de lijst komt een rij knoppen: balkjes die per stap hoger worden
| (meer hulp), met het deel vóór de dubbele punt als label. Een klik toont de
| uitleg van die stap; de andere stappen worden verborgen (tabs, met pijltjes-
| toetsen te bedienen). Zonder JavaScript blijft het een genummerde lijst.
|--------------------------------------------------------------------------
*/

export function initSteps() {
    document.querySelectorAll('.is-style-trap').forEach((list, n) => {
        const items = [...list.children].filter((el) => el.tagName === 'LI');
        if (items.length < 2) return;

        const tabs = document.createElement('div');
        tabs.className = 'trap-tabs';
        tabs.setAttribute('role', 'tablist');
        tabs.setAttribute('aria-label', 'Stappen');
        tabs.style.setProperty('--trap-stappen', items.length);

        let buttons = [];
        const select = (index, focus = false) => {
            buttons.forEach((button, i) => {
                button.setAttribute('aria-selected', String(i === index));
                button.tabIndex = i === index ? 0 : -1;
            });
            items.forEach((item, i) => {
                item.hidden = i !== index;
            });
            if (focus) buttons[index].focus();
        };

        buttons = items.map((item, i) => {
            const title = item.querySelector('strong')?.textContent.trim() || `Stap ${i + 1}`;
            const [code, ...rest] = title.split(':');

            const button = document.createElement('button');
            button.type = 'button';
            button.id = `trap-${n}-knop-${i}`;
            button.setAttribute('role', 'tab');
            button.style.setProperty('--trap-fractie', (i + 1) / items.length);
            button.innerHTML = '<span class="trap-balk" aria-hidden="true"></span><span class="trap-code"></span><span class="trap-titel"></span>';
            button.querySelector('.trap-code').textContent = code.trim();
            button.querySelector('.trap-titel').textContent = rest.join(':').trim();

            item.id = `trap-${n}-stap-${i}`;
            item.setAttribute('role', 'tabpanel');
            item.setAttribute('aria-labelledby', button.id);
            item.tabIndex = 0;
            button.setAttribute('aria-controls', item.id);

            button.addEventListener('click', () => select(i));
            button.addEventListener('keydown', (event) => {
                const keys = {
                    ArrowRight: i + 1,
                    ArrowLeft: i - 1,
                    Home: 0,
                    End: items.length - 1,
                };
                if (!(event.key in keys)) return;
                event.preventDefault();
                select((keys[event.key] + items.length) % items.length, true);
            });

            tabs.append(button);
            return button;
        });

        list.before(tabs);
        list.classList.add('is-enhanced');
        select(0);
    });
}
