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
        font-size: 170px;
        font-weight: 700;
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
            future-draw 0.55s cubic-bezier(.65, 0, .35, 1)
            var(--delay) forwards;
    }

    @keyframes future-draw {

        0% {
            stroke-dasharray: 0 1000;
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        35% {
            stroke-dasharray: 220 1000;
            opacity: 1;
        }

        65% {
            stroke-dasharray: 520 1000;
            opacity: 1;
        }

        82% {
            stroke-dasharray: 760 1000;
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

    if (!svg || !defs || !textGroup) return;


    /*
    |--------------------------------------------------------------------------
    | INSTELLINGEN
    |--------------------------------------------------------------------------
    */

    const FONT_SIZE = 170;

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
                | Krabbel-vorm (kriskras), zoals bij SAIC.
                |
                | Twee lussen die elk over zichzelf heen kruisen
                | (een soort figuur-acht), verbonden door een
                | vloeiende curve. Zo scribbelt de lijn echt over
                | zichzelf heen in plaats van in één brede boog
                | te bewegen.
                |--------------------------------------------------------------------------
                */

                const r =
                    Math.max(width * 0.30, 34);

                const jitter =
                    c * 10 - 10;

                const loop1X =
                    centerX - width * 0.45 * direction;

                const loop2X =
                    centerX + width * 0.45 * direction;

                const loop1Y =
                    line.y - 10 + jitter;

                const loop2Y =
                    line.y + 15 - jitter;


                const pathData = `

                    M ${loop1X - r * direction} ${loop1Y}

                    C
                    ${loop1X - r * 1.4 * direction}
                    ${loop1Y - r * 1.3},

                    ${loop1X + r * 1.4 * direction}
                    ${loop1Y - r * 1.3},

                    ${loop1X + r * direction}
                    ${loop1Y}

                    C
                    ${loop1X + r * 1.4 * direction}
                    ${loop1Y + r * 1.3},

                    ${loop1X - r * 1.4 * direction}
                    ${loop1Y + r * 1.3},

                    ${loop1X - r * 0.2 * direction}
                    ${loop1Y + r * 0.2}

                    C
                    ${centerX}
                    ${line.y + r * 0.6},

                    ${centerX}
                    ${line.y - r * 0.6},

                    ${loop2X - r * direction}
                    ${loop2Y}

                    C
                    ${loop2X - r * 1.4 * direction}
                    ${loop2Y - r * 1.3},

                    ${loop2X + r * 1.4 * direction}
                    ${loop2Y - r * 1.3},

                    ${loop2X + r * direction}
                    ${loop2Y}

                    C
                    ${loop2X + r * 1.4 * direction}
                    ${loop2Y + r * 1.3},

                    ${loop2X - r * 1.4 * direction}
                    ${loop2Y + r * 1.3},

                    ${loop2X - r * 0.2 * direction}
                    ${loop2Y + r * 0.2}

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
                            c * 0.055
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