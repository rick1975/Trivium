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
        font-size: 190px;
        font-weight: 700;
    }

    /*
     * De letter wordt van onderaf opgevuld
     * met kleur, zoals bij SAIC.
     */
    .future-fill {
        transform-box: fill-box;
        transform-origin: bottom center;
        transform: scaleY(0);

        animation:
            future-fill 0.9s cubic-bezier(.22, 1, .36, 1)
            var(--delay) forwards;
    }

    @keyframes future-fill {

        0% {
            transform: scaleY(0);
        }

        100% {
            transform: scaleY(1);
        }
    }

    /*
     * De kleurvorm wordt getekend,
     * niet als complete blob zichtbaar.
     */
    .future-shape {
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;

        stroke-dasharray: 0 1000;

        opacity: 0;

        animation:
            future-draw 1.3s cubic-bezier(.22, 1, .36, 1)
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
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const svg = document.getElementById("future-svg");
    const defs = document.getElementById("future-defs");
    const textGroup = document.getElementById("future-text");

    if (!svg || !defs || !textGroup) return;


    /*
    |--------------------------------------------------------------------------
    | INSTELLINGEN
    |--------------------------------------------------------------------------
    */

    const FONT_SIZE = 190;

    // Hoe snel de animatie door de letters loopt.
    const LETTER_DELAY = 0.10;


    /*
    |--------------------------------------------------------------------------
    | KLEUREN
    |--------------------------------------------------------------------------
    */

    const COLORS = [
        "#FF7A00",
        "#F04444",
        "#F72585"
    ];


    /*
    |--------------------------------------------------------------------------
    | TEKST
    |--------------------------------------------------------------------------
    */

    const lines = [
        {
            text: "Maak",
            y: 155
        },
        {
            text: "Jouw toekomst!",
            y: 335
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


    /*
    |--------------------------------------------------------------------------
    | Font meten
    |--------------------------------------------------------------------------
    */

    const canvas = document.createElement("canvas");
    const ctx = canvas.getContext("2d");

    ctx.font = `700 ${FONT_SIZE}px Poppins`;


    let letterIndex = 0;


    /*
    |--------------------------------------------------------------------------
    | REGELS
    |--------------------------------------------------------------------------
    */

    lines.forEach(line => {

        const characters = [...line.text];

        const widths = characters.map(char =>
            ctx.measureText(char).width
        );

        const totalWidth = widths.reduce(
            (sum, width) => sum + width,
            0
        );

        let x = (1600 - totalWidth) / 2;


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

                x: 0,
                y: 0,

                width: 1600,
                height: 420

            });


            mask.appendChild(
                create("rect", {

                    x: 0,
                    y: 0,

                    width: 1600,
                    height: 420,

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
            | KLEUR-VULLING
            |
            | De letter wordt van onderaf opgevuld met
            | een vlakke kleur, zoals bij SAIC.
            |--------------------------------------------------------------------------
            */

            const capHeight =
                FONT_SIZE * 0.72;

            const fillWidth =
                width * 1.2;

            const fillHeight =
                capHeight * 1.1;

            const fill = create("rect", {

                x: centerX - fillWidth / 2,
                y: line.y - fillHeight,

                width: fillWidth,
                height: fillHeight,

                fill: COLORS[letterIndex % COLORS.length],

                class:
                    "future-fill",

                style: `
                    --delay:
                    ${letterIndex * LETTER_DELAY}s;
                `

            });

            const fillGroup =
                create("g", {

                    mask:
                        `url(#${maskId})`

                });

            fillGroup.appendChild(fill);

            textGroup.appendChild(fillGroup);


            /*
            |--------------------------------------------------------------------------
            | DRIE KLEUR-PATHS
            |--------------------------------------------------------------------------
            */

            for (let c = 0; c < 3; c++) {

                const color =
                    COLORS[
                        (letterIndex + c) % 3
                    ];


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
                    Math.max(width * 0.28, 28);

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
                        Math.max(width * .65, 42),

                    "stroke-linecap":
                        "round",

                    "stroke-linejoin":
                        "round",

                    class:
                        "future-shape",

                    style: `
                        --delay:
                        ${
                            letterIndex *
                            LETTER_DELAY +
                            c * 0.18
                        }s;
                    `

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


                maskedGroup.appendChild(path);

                textGroup.appendChild(maskedGroup);

            }


            x += width;

            letterIndex++;

        });

    });

});
</script>