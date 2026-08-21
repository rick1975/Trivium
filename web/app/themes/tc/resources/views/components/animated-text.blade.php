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
     * De letter wordt van onderaf opgevuld met kleur
     * en vloeit daarna weer weg, zodat de tekst
     * uiteindelijk wit blijft (zoals bij SAIC).
     */
    .future-fill {
        clip-path: circle(0% at 50% 50%);
        opacity: 1;

        animation:
            future-fill 1.1s cubic-bezier(.22, 1, .36, 1)
            var(--delay) forwards;
    }

    @keyframes future-fill {

        0% {
            clip-path: circle(0% at 50% 50%);
            opacity: 1;
        }

        35% {
            clip-path: circle(100% at 50% 50%);
            opacity: 1;
        }

        70% {
            clip-path: circle(100% at 50% 50%);
            opacity: 1;
        }

        100% {
            clip-path: circle(100% at 50% 50%);
            opacity: 0;
        }
    }

    /*
     * De kleurvorm wordt getekend, blijft even
     * zichtbaar en vervaagt dan weer.
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

        45% {
            stroke-dasharray: 1000 1000;
            opacity: 1;
        }

        75% {
            stroke-dasharray: 1000 1000;
            opacity: 1;
        }

        100% {
            stroke-dasharray: 1000 1000;
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

    const build = () => {

        defs.replaceChildren();
        textGroup.replaceChildren();


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

        const totalWidth = widths.reduce(
            (sum, width) => sum + width,
            0
        );

        let x = (viewBoxWidth - totalWidth) / 2;


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
            | Afmetingen van het vulvlak (per letter gelijk).
            |--------------------------------------------------------------------------
            */

            const fillWidth =
                width * 1.2;

            const fillHeight =
                capHeight * 1.1;


            /*
            |--------------------------------------------------------------------------
            | DRIE KLEUR-LAGEN
            |
            | Elke laag vult de letter van onderaf met een
            | kleur en vloeit daarna weer weg, zodat de
            | volgende kleur erdoorheen komt en de letter
            | uiteindelijk weer wit is.
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
                        c * 0.22
                    }s;
                `;

                const fill = create("rect", {

                    x: centerX - fillWidth / 2,
                    y: line.y - fillHeight,

                    width: fillWidth,
                    height: fillHeight,

                    fill: color,

                    class:
                        "future-fill",

                    style: delay

                });


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


                /*
                |--------------------------------------------------------------------------
                | Masker toepassen
                |--------------------------------------------------------------------------
                */

                const maskedGroup =
                    create("g", {

                        mask:
                            `url(#${maskId})`

                    });


                maskedGroup.appendChild(fill);
                maskedGroup.appendChild(path);

                textGroup.appendChild(maskedGroup);

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