<div class="future-animation">
    <svg
        id="future-svg"
        viewBox="0 0 1600 420"
        xmlns="http://www.w3.org/2000/svg"
    >
        <defs id="future-defs"></defs>
        <g id="future-text"></g>
    </svg>
</div>

<style>
    .future-animation {
        width: 100%;
        max-width: 1600px;
        margin: 80px auto;
        padding: 0 20px;
    }

    .future-animation svg {
        display: block;
        width: 100%;
        height: auto;
        overflow: visible;
    }

    .future-base {
        fill: #fff;
        font-family: "Poppins", sans-serif;
        font-weight: 700;
    }

    /*
     * De letter wordt gevuld door een paar ronde
     * kleurvlekken die elk zichtbaar vanuit een punt uitdijen
     * tot volle grootte, kort blijven staan en dan samen naar
     * wit vervagen — zoals bij SAIC (goed te zien bij ronde
     * letters als de "o", en met meerdere kleuren tegelijk in
     * beeld).
     */
    .future-circle-fill {
        opacity: 0;
        transform-box: fill-box;
        transform-origin: center;

        animation:
            future-circle .62s cubic-bezier(.22, 1, .36, 1)
            var(--delay) forwards;
    }

    @keyframes future-circle {

        0% {
            opacity: 0;
            transform: scale(0);
        }

        8% {
            opacity: 1;
            transform: scale(.08);
        }

        62% {
            opacity: 1;
            transform: scale(1);
        }

        65% {
            opacity: 1;
            transform: scale(1);
        }

        100% {
            opacity: 0;
            transform: scale(1);
        }
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {

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

    // Hoe snel de animatie door de letters loopt.
    const LETTER_DELAY = 0.10;

    // In hoeveel rijen (boven naar onder) elke letter wordt
    // opgebouwd — elke rij krijgt zijn eigen kleur(en).
    const ROW_COUNT = 3;

    // Vertraging per rij: bepaalt hoe duidelijk de vulling
    // van boven naar beneden "zakt" — zoals bij SAIC.
    const ROW_STAGGER = 0.09;

    // Kleine extra vertraging per kolom binnen een rij.
    const COL_STAGGER = 0.02;

    // Minimaal aantal kolommen cirkels per letter. Bredere
    // letters (w, m) krijgen er automatisch meer.
    const MIN_COLS_PER_LETTER = 1;


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
        { text: "Maak Jouw" },
        { text: "toekomst!" }
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

        ctx.font = `700 ${FONT_SIZE}px Poppins`;


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

        const widths = characters.map(char =>
            ctx.measureText(char).width
        );

        let x = 0;


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

            const maskId =
                `letter-mask-${letterIndex}`;


            /*
            |--------------------------------------------------------------------------
            | WITTE BASISLETTER
            |--------------------------------------------------------------------------
            */

            const base = create("text", {

                x: centerX,
                y: line.y,

                "text-anchor": "middle",

                "font-family":
                    "Poppins, sans-serif",

                "font-size":
                    FONT_SIZE,

                "font-weight":
                    "700",

                class:
                    "future-base"

            });

            base.textContent = char;

            textGroup.appendChild(base);


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

                x: centerX,
                y: line.y,

                "text-anchor": "middle",

                "font-family":
                    "Poppins, sans-serif",

                "font-size":
                    FONT_SIZE,

                "font-weight":
                    "700",

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

            // Straal ruim genoeg zodat naburige vlekken
            // (ook tussen rijen) elkaar overlappen.
            const dotRadius =
                Math.max(colWidth, rowHeight) * 0.78;

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
                        letterIndex * LETTER_DELAY +
                        row * ROW_STAGGER +
                        col * COL_STAGGER;

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

            textGroup.appendChild(fillGroup);


            x += width;

            letterIndex++;

        });

    });

    };


    build();


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

});
</script>