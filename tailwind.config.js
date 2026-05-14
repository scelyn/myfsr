import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                emerald: {
                    50: '#ecfdf5',
                    100: '#d1fae5',
                    200: '#a7f3d0',
                    300: '#6ee7b7',
                    400: '#34d399',
                    500: '#10b981',
                    600: '#059669',
                    700: '#047857',
                    800: '#065f46',
                    900: '#064e3b',
                },
                theme: {
                    bg: '#06141B',
                    sidebar: '#11212D',
                    card: '#253745',
                    border: '#4A5C6A',
                    text2: '#9BA8AB',
                    text1: '#CCD0CF',
                    success: '#1b4332',
                    successText: '#74c69d',
                    warning: '#78350f',
                    warningText: '#fcd34d',
                    error: '#7f1d1d',
                    errorText: '#fca5a5',
                    info: '#1e3a8a',
                    infoText: '#93c5fd',
                }
            }
        },
    },

    plugins: [forms],
};
