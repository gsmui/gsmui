import defaultConfig from 'tailwindcss/defaultConfig';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
            },
            colors: {
                primary: {
                    50: '#f3f0ff', 100: '#e9e3ff', 200: '#d4cafe', 300: '#b5a5fc',
                    400: '#9281f8', 500: '#7354f1', 600: '#5d2fe6', 700: '#4e1ed0',
                    800: '#3f19a9', 900: '#351787', 950: '#1e0a5f',
                },
            },
        },
    },
    plugins: [forms, typography],
};
