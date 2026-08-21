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
     * Elke kleur tekent zichzelf (net als bij SAIC, via
     * eenzelfde soort "trim paths"-beweging) en blijft
     * daarna gewoon staan — geen losse fade per kleur.
     */
    .future-shape {
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;

        stroke-dasharray: 0 1000;

        opacity: 0;

        animation:
            future-draw 1.5s cubic-bezier(.22, 1, .36, 1)
            var(--delay) forwards;
    }

    @keyframes future-draw {

        0% {
            stroke-dasharray: 0 1000;
            opacity: 0;
        }

        8% {
            opacity: 1;
        }

        100% {
            stroke-dasharray: 1000 1000;
            opacity: 1;
        }
    }

    /*
     * Pas als alle kleuren van een letter klaar zijn met
     * tekenen en een tijdje hebben gestaan, vervaagt de
     * hele letter in één keer samen naar wit.
     */
    .future-letter-group {
        opacity: 1;

        animation:
            future-fade-out 0.8s ease-in
            var(--fade-delay) forwards;
    }

    @keyframes future-fade-out {

        0% {
            opacity: 1;
        }

        100% {
            opacity: 0;
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
        | Masker-achtergrond, ruim genoeg zodat de lussen
        | nooit buiten de rand vallen.
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
            | ÉÉN GEDEELDE GROEP PER LETTER
            |
            | Alle 6 kleuren tekenen na elkaar hetzelfde pad
            | en blijven daarna gewoon staan (zoals bij SAIC).
            | Pas als de laatste kleur een tijdje heeft
            | gestaan, vervaagt de hele letter in één keer
            | samen naar wit.
            |--------------------------------------------------------------------------
            */

            const strokeStagger = 0.22;

            const strokeDrawDuration = 1.5;

            const strokeHoldBuffer = 0.6;

            const strokeTotalTime =
                (COLORS.length - 1) * strokeStagger +
                strokeDrawDuration +
                strokeHoldBuffer;

            const letterGroup = create("g", {

                mask:
                    `url(#${maskId})`,

                class:
                    "future-letter-group",

                style: `
                    --fade-delay:
                    ${
                        letterIndex *
                        LETTER_DELAY +
                        strokeTotalTime
                    }s;
                `

            });

            textGroup.appendChild(letterGroup);


            /*
            |--------------------------------------------------------------------------
            | ZES KLEUR-LAGEN
            |--------------------------------------------------------------------------
            */

            for (let c = 0; c < COLORS.length; c++) {

                const color =
                    COLORS[
                        (letterIndex + c) % COLORS.length
                    ];

                const delay = `
                    --delay:
                    ${
                        letterIndex *
                        LETTER_DELAY +
                        c * strokeStagger
                    }s;
                `;


                /*
                |--------------------------------------------------------------------------
                | Elke letter krijgt een andere beweging.
                |--------------------------------------------------------------------------
                */

                const reverse =
                    letterIndex % 2 !== 0;


                const direction =
                    reverse ? -1 : 1;


                /*
                |--------------------------------------------------------------------------
                | Spiraalvulling, zoals bij SAIC.
                |
                | Drie gestapelde lussen (rond) van onder tot
                | boven in de letter, allemaal dezelfde kant op
                | draaiend: de ene letter linksdraaiend, de
                | volgende rechtsdraaiend (via `direction`).
                |--------------------------------------------------------------------------
                */

                const r =
                    Math.max(width * 0.28, FONT_SIZE * 0.15);

                const k =
                    r * 0.5523;

                const spiralY = [
                    line.y - capHeight * 0.14,
                    line.y - capHeight * 0.50,
                    line.y - capHeight * 0.86
                ];

                const loop = cy => `

                    C
                    ${centerX - k * direction} ${cy + r},
                    ${centerX - r * direction} ${cy + k},
                    ${centerX - r * direction} ${cy}

                    C
                    ${centerX - r * direction} ${cy - k},
                    ${centerX - k * direction} ${cy - r},
                    ${centerX} ${cy - r}

                    C
                    ${centerX + k * direction} ${cy - r},
                    ${centerX + r * direction} ${cy - k},
                    ${centerX + r * direction} ${cy}

                    C
                    ${centerX + r * direction} ${cy + k},
                    ${centerX + k * direction} ${cy + r},
                    ${centerX} ${cy + r}
                `;

                const bridge = (fromY, toY) => `

                    C
                    ${centerX} ${fromY - r * 0.4},
                    ${centerX} ${toY + r * 0.4},
                    ${centerX} ${toY + r}
                `;


                const pathData = `

                    M ${centerX} ${spiralY[0] + r}

                    ${loop(spiralY[0])}
                    ${bridge(spiralY[0], spiralY[1])}
                    ${loop(spiralY[1])}
                    ${bridge(spiralY[1], spiralY[2])}
                    ${loop(spiralY[2])}

                `;


                const path = create("path", {

                    d: pathData,

                    fill: "none",

                    stroke: color,

                    /*
                     * Dikke stroke zodat de vorm
                     * daadwerkelijk delen van de
                     * letter kan vullen.
                     */
                    "stroke-width":
                        Math.max(width * .65, FONT_SIZE * 0.22),

                    "stroke-linecap":
                        "round",

                    "stroke-linejoin":
                        "round",

                    class:
                        "future-shape",

                    style: delay

                });


                letterGroup.appendChild(path);

            }


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