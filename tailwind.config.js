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
                // Archivo is the font the app actually loads; 'Figtree' never was.
                sans: ['Archivo', ...defaultTheme.fontFamily.sans],
                brand: ['Fraunces', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                ink: {
                    DEFAULT: 'var(--ink)',
                    soft: 'var(--ink-soft)',
                    mute: 'var(--ink-mute)',
                },
                paper: {
                    DEFAULT: 'var(--paper)',
                    raised: 'var(--paper-2)',
                },
                forest: {
                    DEFAULT: 'var(--forest)',
                    dark: 'var(--forest-dark)',
                },
                gold: {
                    DEFAULT: 'var(--gold)',
                    light: 'var(--gold-light)',
                },
                line: {
                    DEFAULT: 'var(--line)',
                    strong: 'var(--line-strong)',
                },
            },
            borderRadius: {
                brand: 'var(--r-md)',
                'brand-lg': 'var(--r-lg)',
            },
            boxShadow: {
                'brand-1': 'var(--sh-1)',
                'brand-2': 'var(--sh-2)',
                'brand-3': 'var(--sh-3)',
            },
        },
    },

    plugins: [forms],
};
