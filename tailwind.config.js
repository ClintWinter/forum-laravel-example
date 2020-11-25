const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        fontFamily: {
            sans: ['Inter', ...defaultTheme.fontFamily.sans],
        },
        extend: {
            maxHeight:{
                'half': '50vh',
                '1/4': '25%',
                '1/3': '33.333333%',
                '1/2': '50%',
                '2/3': '66.666666%',
                '3/4': '75%',
                '8': '2rem',
                '16': '4rem',
                '32': '8rem',
                '48': '12rem',
                '64' : '16rem',
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        borderWidth: ['responsive', 'last', 'first']
    },

    plugins: [require('@tailwindcss/ui')],
};
