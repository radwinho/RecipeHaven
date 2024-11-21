import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import aspect from '@tailwindcss/aspect-ratio';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                bitter: ['Bitter', ...defaultTheme.fontFamily.sans],
                caveat: ['Caveat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'custom-red': '#ee0000',
            }
        },
    },

    plugins: [forms, typography, aspect],
};
