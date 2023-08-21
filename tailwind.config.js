const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                illusion: {
                    DEFAULT: "#DFCCFB",
                },
                lavender: {
                    DEFAULT: "#D0BFFF",
                },
                teasel: {
                    DEFAULT: "#BEADFA",
                },
                malibu: {
                    DEFAULT: "#FFF3DA",
                },
            }
        },
        width: {
            content: "768px",
            extra: "100vw",
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
