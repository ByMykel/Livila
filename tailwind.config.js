const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                black: {
                    500: '#090909',
                    400: '#121212',
                    300: '#212121',
                    200: '#535353',
                    100: '#b3b3b3'
                },
            },
            height: theme => ({
                "106": "26rem",
                "114": "28rem",
                "122": "30rem",
                "130": "32rem",
                "138": "34rem",
                "146": "36rem",
                "154": "38rem",
            }),

        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            borderWidth: ['hover', 'focus'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('@tailwindcss/line-clamp')],
};
