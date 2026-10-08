/*
|--------------------------------------------------------------------------
| Geanimeerde titel ("Leren met lef") in de hero
|
| Bouwt per letter een SVG-masker op dat gevuld wordt met groeiende
| kleurcirkels. Gebruikt de markup uit components/animated-text.blade.php.
| Als module draait dit pas nadat de DOM is ingelezen.
|--------------------------------------------------------------------------
*/

export function initAnimatedText() {

    const svg = document.getElementById("future-svg");
    const defs = document.getElementById("future-defs");
    const textGroup = document.getElementById("future-text");
    const container = document.querySelector(".future-animation");

    if (!svg || !defs || !textGroup || !container) return;


    /*
    |--------------------------------------------------------------------------
    | INSTELLINGEN
    |--------------------------------------------------------------------------
    */

    // Hoe lang (in seconden) de kleurgolf erover doet om van de
    // linker- naar de rechterkant van de tekst te lopen. De start
    // van elke cirkel hangt af van zijn horizontale positie, zodat
    // de golf gelijkmatig loopt, ongeacht hoe breed een letter is.
    const SWEEP_DURATION = 1.3;

    // Hoe lang een cirkel erover doet om tot volle grootte te
    // groeien, en hoe lang hij in totaal zichtbaar is (opkomen,
    // even blijven staan en weer naar wit vervagen).
    const GROW_DURATION = 0.7;
    const FADE_DURATION = 1.1;

    // In hoeveel rijen (boven naar onder) elke letter wordt
    // opgebouwd — elke rij krijgt zijn eigen kleur(en).
    const ROW_COUNT = 3;

    // Vertraging per rij: bepaalt hoe duidelijk de vulling
    // van boven naar beneden "zakt" — zoals bij SAIC.
    const ROW_STAGGER = 0.09;

    // Minimaal aantal kolommen cirkels per letter. Bredere
    // letters (w, m) krijgen er automatisch meer.
    const MIN_COLS_PER_LETTER = 1;

    // Lettertype van de titel. Terug naar het oude font: zet
    // FONT_FAMILY op "Poppins" en FONT_WEIGHT op "700".
    // (Het font moet ook geladen worden in resources/js/fonts.js.)
    const FONT_FAMILY = "Poppins";
    const FONT_WEIGHT = "700";

    // "Knal" op het laatste woord (LEF): zodra het vol kleur staat,
    // schiet het kort groter en veert het terug. PUNCH_SCALE is de
    // grootte op het hoogtepunt (1.25 = 125%), PUNCH_DURATION de duur
    // in seconden en PUNCH_OFFSET hoe lang na de start van de laatste
    // kleurcirkel de knal valt. Uitzetten: PUNCH_SCALE op 1.
    const PUNCH_SCALE = 1.25;
    const PUNCH_DURATION = 0.55;
    const PUNCH_OFFSET = 0.3;

    // Soort knal: "stempel" (woord komt omhoog, hangt even en slaat
    // dan hard neer, als een stempel op papier) of "knal" (alleen
    // groter worden en terugveren). Terug naar de oude
    // knal: zet PUNCH_STYLE op "knal".
    const PUNCH_STYLE = "stempel";

    // Binnenkomst van de letters zelf: elke letter schuift omhoog en
    // wordt zichtbaar op het moment dat de kleurgolf hem bereikt.
    // ENTER_RISE is de afstand (als deel van de lettergrootte),
    // ENTER_DURATION de duur in seconden en ENTER_LEAD hoeveel eerder
    // dan de eerste kleurcirkel de letter al begint te bewegen.
    // Uitzetten: ENTER_RISE op 0 en ENTER_DURATION op 0.
    const ENTER_RISE = 0.35;
    const ENTER_DURATION = 0.6;
    const ENTER_LEAD = 0.1;


    /*
    |--------------------------------------------------------------------------
    | KLEUREN
    |--------------------------------------------------------------------------
    */

    // Zelfde palet als het SAIC-logo.
    const COLORS = [
        "#5597CE",
        "#4DADAA",
        "#F3DC4A",
        "#E69C3F",
        "#D93386",
        "#FFFFFF"
    ];

    // Voor de kleurstroken zelf laten we wit weg (dat is
    // toch al de kleur van de basisletter eronder).
    const GLITCH_COLORS =
        COLORS.filter(color => color !== "#FFFFFF");


    /*
    |--------------------------------------------------------------------------
    | TEKST
    |--------------------------------------------------------------------------
    */

    const lines = [
        // Tekst komt uit de (visueel verborgen) h1, zodat die op één plek staat.
        {
            text: container.parentElement?.querySelector("h1")?.textContent.trim()
                || "Leren met LEF"
        }
    ];


    /*
    |--------------------------------------------------------------------------
    | SVG helper
    |--------------------------------------------------------------------------
    */

    const create = (tag, attributes = {}) => {

        const element = document.createElementNS(
            "http://www.w3.org/2000/svg",
            tag
        );

        Object.entries(attributes).forEach(
            ([key, value]) => {
                element.setAttribute(key, value);
            }
        );

        return element;
    };


    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");


    /*
    |--------------------------------------------------------------------------
    | OPBOUW
    |
    | Wordt bij het laden en bij elke resize opnieuw
    | uitgevoerd, zodat de tekst altijd exact even groot
    | is als de h1 erboven (die zelf ook responsive is
    | via text-5xl / lg:text-7xl).
    |--------------------------------------------------------------------------
    */

    let lastBuildKey = null;

    const build = () => {

        /*
        |----------------------------------------------------------------
        | Lettergrootte overnemen van de h1 erboven.
        |----------------------------------------------------------------
        */

        const h1 =
            container.parentElement?.querySelector("h1")
            ?? document.querySelector("h1");

        const FONT_SIZE = h1
            ? parseFloat(getComputedStyle(h1).fontSize)
            : 48;

        const viewBoxWidth =
            svg.getBoundingClientRect().width || 1600;


        /*
        |----------------------------------------------------------------
        | Alleen echt opnieuw opbouwen (en de animatie laten
        | herstarten) als de grootte ook echt is veranderd.
        | Voorkomt dat een losse resize-event (bv. door het
        | verdwijnen van de scrollbar) de hele animatie
        | opnieuw laat afspelen.
        |----------------------------------------------------------------
        */

        const buildKey = `${FONT_SIZE}|${Math.round(viewBoxWidth)}`;

        if (buildKey === lastBuildKey) return;

        lastBuildKey = buildKey;


        defs.replaceChildren();
        textGroup.replaceChildren();

        ctx.font = `italic ${FONT_WEIGHT} ${FONT_SIZE}px ${FONT_FAMILY}`;


        const capHeight =
            FONT_SIZE * 0.72;

        const topPad =
            FONT_SIZE * 0.3;

        const bottomPad =
            FONT_SIZE * 0.3;

        const lineHeight =
            FONT_SIZE * 1.05;

        const viewBoxHeight =
            topPad +
            capHeight +
            (lines.length - 1) * lineHeight +
            bottomPad;

        svg.style.setProperty("--grow-duration", `${GROW_DURATION}s`);
        svg.style.setProperty("--fade-duration", `${FADE_DURATION}s`);
        svg.style.setProperty("--enter-duration", `${ENTER_DURATION}s`);
        svg.style.setProperty("--enter-rise", `${FONT_SIZE * ENTER_RISE}px`);

        svg.setAttribute(
            "viewBox",
            `0 0 ${viewBoxWidth} ${viewBoxHeight}`
        );


        /*
        |----------------------------------------------------------------
        | Masker-achtergrond, ruim genoeg zodat niets
        | onbedoeld wordt afgeknipt.
        |----------------------------------------------------------------
        */

        const maskMargin = FONT_SIZE;

        const maskBounds = {
            x: -maskMargin,
            y: -maskMargin,
            width: viewBoxWidth + maskMargin * 2,
            height: viewBoxHeight + maskMargin * 2
        };


        let letterIndex = 0;


    /*
    |--------------------------------------------------------------------------
    | REGELS
    |--------------------------------------------------------------------------
    */

    lines.forEach((line, lineIndex) => {

        line.y = topPad + capHeight + lineIndex * lineHeight;

        const characters = [...line.text];

        // Posities meten we over de tekst tot en met elke letter (en
        // niet per losse letter), zodat de kerning van het font
        // behouden blijft — anders staan paren als "Le" of "re"
        // losser dan in gewone tekst.
        const offsets = characters.map((_, index) =>
            ctx.measureText(characters.slice(0, index).join("")).width
        );

        offsets.push(ctx.measureText(line.text).width);

        const widths = characters.map((_, index) =>
            offsets[index + 1] - offsets[index]
        );

        // De canvas-breedte van een letter is de "advance width" en
        // laat de inkt meestal een stukje na x=0 beginnen (de linker
        // sidebearing van het font). Bij grote koptekst is dat gat
        // zichtbaar; we meten het exact voor de eerste letter en
        // trekken de startpositie ervoor terug, zodat de tekst hier
        // optisch even ver links begint als de tekst eronder.
        const firstCharBearing =
            ctx.measureText(characters[0] ?? "")
                .actualBoundingBoxLeft || 0;

        let x = firstCharBearing;

        // Totale breedte van de regel, voor de positie-afhankelijke
        // vertraging van de kleurgolf.
        const lineWidth =
            widths.reduce((sum, w) => sum + w, 0) || 1;

        // Letters van het laatste woord komen in een eigen groep,
        // zodat dat woord als geheel kan "knallen" (zie PUNCH_*).
        const lastWordStart =
            line.text.trimEnd().lastIndexOf(" ") + 1;

        const punchGroup = create("g", { class: "future-punch" });

        let punchLeft = Infinity;
        let punchRight = -Infinity;
        let punchDelay = 0;


        /*
        |--------------------------------------------------------------------------
        | LETTERS
        |--------------------------------------------------------------------------
        */

        characters.forEach((char, index) => {

            const width = widths[index];


            if (char === " ") {

                x += width;
                letterIndex++;

                return;
            }


            const centerX = x + width / 2;

            const isPunch = index >= lastWordStart;

            // Eigen groep per letter, zodat de letter (met zijn
            // kleurvulling en masker) als geheel kan binnenkomen.
            const letterGroup = create("g", { class: "future-letter" });

            const group = letterGroup;

            if (isPunch) {
                punchLeft = Math.min(punchLeft, x);
                punchRight = Math.max(punchRight, x + width);
            }

            const maskId =
                `letter-mask-${letterIndex}`;


            /*
            |--------------------------------------------------------------------------
            | WITTE BASISLETTER
            |--------------------------------------------------------------------------
            */

            const base = create("text", {

                x,
                y: line.y,

                "text-anchor": "start",

                "font-family":
                    `${FONT_FAMILY}, sans-serif`,

                "font-size":
                    FONT_SIZE,

                "font-weight":
                    FONT_WEIGHT,

                "font-style":
                    "italic",

                class:
                    "future-base"

            });

            base.textContent = char;

            group.appendChild(base);


            /*
            |--------------------------------------------------------------------------
            | MASK: ALLEEN DEZE LETTER
            |--------------------------------------------------------------------------
            */

            const mask = create("mask", {

                id: maskId,

                maskUnits: "userSpaceOnUse",

                ...maskBounds

            });


            mask.appendChild(
                create("rect", {

                    ...maskBounds,

                    fill: "black"

                })
            );


            const maskLetter = create("text", {

                x,
                y: line.y,

                "text-anchor": "start",

                "font-family":
                    `${FONT_FAMILY}, sans-serif`,

                "font-size":
                    FONT_SIZE,

                "font-weight":
                    FONT_WEIGHT,

                "font-style":
                    "italic",

                fill: "white"

            });

            maskLetter.textContent = char;

            mask.appendChild(maskLetter);

            defs.appendChild(mask);


            /*
            |--------------------------------------------------------------------------
            | RASTER VAN GROEIENDE CIRKELS PER LETTER
            |
            | De letter wordt gevuld door een paar ronde
            | kleurvlekken (rijen x kolommen) die elk vanuit
            | een punt zichtbaar uitdijen tot volle grootte —
            | bij ronde letters (o, a, e) zie je daardoor
            | letterlijk cirkels met kleur ontstaan. De
            | vertraging is vooral gebaseerd op de rij, zodat
            | de vulling merkbaar van boven naar beneden door
            | de letter zakt en er meerdere kleuren tegelijk
            | in beeld komen — zoals bij SAIC. Daarna vervaagt
            | alles samen weer naar wit.
            |--------------------------------------------------------------------------
            */

            const fillHeight =
                capHeight * 1.1;

            const fillTop =
                line.y - fillHeight;

            const letterLeft =
                centerX - width / 2;

            // Bredere letters krijgen automatisch meer
            // kolommen, zodat ze net zo goed gevuld raken.
            const cols = Math.max(
                MIN_COLS_PER_LETTER,
                Math.round(width / (FONT_SIZE * 0.6))
            );

            const colWidth = width / cols;
            const rowHeight = fillHeight / ROW_COUNT;

            // Straal ruim genoeg zodat naburige vlekken elkaar
            // stevig overlappen — anders blijven er bij
            // complexere vormen (zoals de inkeping in een "M")
            // witte gaatjes zichtbaar binnen de letter.
            const dotRadius =
                Math.max(colWidth, rowHeight) * 1.35;

            let letterDelay = Infinity;

            const fillGroup = create("g", {

                mask:
                    `url(#${maskId})`

            });

            for (let row = 0; row < ROW_COUNT; row++) {

                const dotY =
                    fillTop + rowHeight * (row + 0.5);

                for (let col = 0; col < cols; col++) {

                    const color =
                        GLITCH_COLORS[
                            Math.floor(Math.random() * GLITCH_COLORS.length)
                        ];

                    const dotX =
                        letterLeft +
                        colWidth * (col + 0.5) +
                        (Math.random() - 0.5) * colWidth * 0.4;

                    const delay =
                        Math.max(0, dotX - firstCharBearing) / lineWidth * SWEEP_DURATION +
                        row * ROW_STAGGER;

                    letterDelay = Math.min(letterDelay, delay);

                    if (isPunch) {
                        punchDelay = Math.max(punchDelay, delay);
                    }

                    const dot = create("circle", {

                        cx: dotX,
                        cy: dotY,
                        r: dotRadius,

                        fill: color,

                        class:
                            "future-circle-fill",

                        style: `
                            --delay: ${delay}s;
                        `

                    });

                    fillGroup.appendChild(dot);

                }

            }

            group.appendChild(fillGroup);

            letterGroup.style.setProperty(
                "--enter-delay",
                `${Math.max(0, letterDelay - ENTER_LEAD)}s`
            );

            (isPunch ? punchGroup : textGroup).appendChild(letterGroup);


            x += width;

            letterIndex++;

        });


        /*
        |--------------------------------------------------------------------------
        | KNAL OP HET LAATSTE WOORD
        |--------------------------------------------------------------------------
        */

        if (punchGroup.childNodes.length) {

            const originX = (punchLeft + punchRight) / 2;
            const originY = line.y - capHeight / 2;

            punchGroup.style.setProperty("--punch-scale", PUNCH_SCALE);
            punchGroup.style.setProperty("--punch-duration", `${PUNCH_DURATION}s`);
            punchGroup.style.setProperty("--punch-delay", `${punchDelay + PUNCH_OFFSET}s`);
            punchGroup.style.transformOrigin = `${originX}px ${originY}px`;

            if (PUNCH_STYLE === "stempel") {
                punchGroup.classList.add("future-stamp");
            }

            textGroup.appendChild(punchGroup);
        }

    });

    };


    // Pas opbouwen zodra het lettertype echt geladen is. Anders meet
    // canvas de letterbreedtes met een fallback-font (bv. bij een
    // harde refresh, wanneer Poppins nog niet in de cache zit), en
    // komen de posities niet meer overeen zodra Poppins alsnog
    // verschijnt — de tekst lijkt dan horizontaal in elkaar gedrukt.
    // De cursieve variant wordt pas opgehaald als hij gebruikt wordt, dus
    // die laden we hier expliciet voordat we gaan meten.
    if (document.fonts && document.fonts.load) {
        document.fonts.load(`italic ${FONT_WEIGHT} 48px ${FONT_FAMILY}`).then(build, build);
    } else {
        build();
    }


    /*
    |--------------------------------------------------------------------------
    | Opnieuw opbouwen bij resize, zodat de tekst even
    | groot blijft als de (responsive) h1 erboven.
    |--------------------------------------------------------------------------
    */

    let resizeTimer;

    window.addEventListener("resize", () => {

        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(build, 200);
    });
}
