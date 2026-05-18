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
                // ── Enterprise Design System v3 — Dark Navy ──────────────
                navy: {
                    900: '#06141B',
                    800: '#11212D',
                    700: '#253745',
                    600: '#4A5C6A',
                },
                app:     '#F7F9FB',
                surface: '#F1F5F9',
                soft:    '#E5E7EB',
                primary: { DEFAULT: '#06141B', hover: '#11212D' },
                secondary: { DEFAULT: '#4A5C6A', light: '#64748B' },

                // ── Legacy theme.* references (used by invoices/show print CSS)
                // ⚠️ FROZEN — required by thermal print media queries
                theme: {
                    bg:          '#F7F9FB',
                    sidebar:     '#11212D',
                    card:        '#ffffff',
                    border:      '#E5E7EB',
                    primary:     '#06141B',
                    text2:       '#374151',
                    text1:       '#0F172A',
                    success:     '#dcfce7',
                    successText: '#15803d',
                    warning:     '#fef9c3',
                    warningText: '#a16207',
                    error:       '#fee2e2',
                    errorText:   '#dc2626',
                    info:        '#dbeafe',
                    infoText:    '#1e40af',
                },
            },
        },
    },

    plugins: [forms],
};
