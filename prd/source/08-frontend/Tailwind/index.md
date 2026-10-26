# Tailwind CSS v4

> Configuration, custom utilities, component styles, purge strategy, dark mode.

## Configuration

```js
// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';

export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                gsmui: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                    950: '#082f49',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            fontSize: {
                '2xs': ['0.625rem', { lineHeight: '0.875rem' }],
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
            },
            borderRadius: {
                '4xl': '2rem',
            },
            boxShadow: {
                'gsmui': '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
                'gsmui-lg': '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/line-clamp'),
    ],
};
```

## CSS Variables

```css
/* resources/css/gsmui.css */
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
    :root {
        --gsmui-primary: 14 165 233;
        --gsmui-primary-hover: 2 132 199;
        --gsmui-bg: 255 255 255;
        --gsmui-bg-secondary: 249 250 251;
        --gsmui-text: 17 24 39;
        --gsmui-text-secondary: 107 114 128;
        --gsmui-border: 229 231 235;
        --gsmui-radius: 0.5rem;
    }

    .dark {
        --gsmui-primary: 56 189 248;
        --gsmui-primary-hover: 125 211 252;
        --gsmui-bg: 31 41 55;
        --gsmui-bg-secondary: 55 65 81;
        --gsmui-text: 249 250 251;
        --gsmui-text-secondary: 156 163 175;
        --gsmui-border: 75 85 99;
        --gsmui-radius: 0.5rem;
    }
}

@layer components {
    .gsmui-input {
        @apply block w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm
               shadow-sm transition-colors
               placeholder:text-zinc-400
               focus:border-gsmui-500 focus:outline-none focus:ring-1 focus:ring-gsmui-500
               disabled:cursor-not-allowed disabled:opacity-50;

        .dark & {
            @apply border-white/10 bg-white/10 text-white placeholder:text-white/40;
        }
    }

    .gsmui-button {
        @apply inline-flex items-center justify-center rounded-lg font-medium
               transition-colors focus:outline-none focus:ring-2 focus:ring-gsmui-500
               focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50;
    }

    .gsmui-card {
        @apply rounded-xl border border-zinc-200 bg-white p-6 shadow-sm;

        .dark & {
            @apply border-white/10 bg-zinc-700;
        }
    }
}
```

## Custom Utilities

```css
@layer utilities {
    .text-balance {
        text-wrap: balance;
    }

    .scrollbar-thin {
        scrollbar-width: thin;
        scrollbar-color: rgb(209 213 219) transparent;
    }

    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: rgb(209 213 219);
        border-radius: 3px;
    }

    .gsmui-transition {
        @apply transition-all duration-200 ease-in-out;
    }

    .gsmui-focus-ring {
        @apply focus:outline-none focus:ring-2 focus:ring-gsmui-500 focus:ring-offset-2;
    }

    .gsmui-shadow-inset {
        box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05);
    }
}
```

## Dark Mode

```blade
{{-- Dark mode toggle --}}
<div x-data="{ dark: $persist(false) }" @class([
    'bg-white text-zinc-900' => !$dark,
    'bg-zinc-900 text-white' => $dark,
])>
    <button @click="dark = !dark; document.documentElement.classList.toggle('dark', dark)">
        <x-gsmui::icon :name="$dark ? 'sun' : 'moon'" />
    </button>
</div>

{{-- Automatic system preference --}}
<div x-data="{ dark: window.matchMedia('(prefers-color-scheme: dark)').matches }"
     x-init="window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => dark = e.matches)"
     x-effect="document.documentElement.classList.toggle('dark', dark)">
</div>
```

## Component Styles

```css
@layer components {
    /* Dialog/Modal */
    .gsmui-dialog {
        @apply fixed inset-0 z-50 flex items-center justify-center;
    }

    .gsmui-dialog-overlay {
        @apply fixed inset-0 bg-black/50 backdrop-blur-sm;
    }

    .gsmui-dialog-content {
        @apply relative z-10 w-full max-w-md rounded-xl bg-white p-6 shadow-xl
               dark:bg-zinc-800;
    }

    /* Dropdown */
    .gsmui-dropdown {
        @apply absolute z-50 mt-1 w-full rounded-lg border border-zinc-200 bg-white
               py-1 shadow-lg dark:border-white/10 dark:bg-zinc-800;
    }

    .gsmui-dropdown-item {
        @apply flex cursor-pointer items-center px-3 py-2 text-sm text-zinc-700
               hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700;
    }

    /* Toast */
    .gsmui-toast {
        @apply fixed bottom-4 right-4 z-50 flex items-center gap-3 rounded-lg
               border border-zinc-200 bg-white p-4 shadow-lg dark:border-white/10
               dark:bg-zinc-800;
    }
}
```

## Purge Strategy

```js
// tailwind.config.js
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.ts',
        './resources/**/*.vue',
        './stubs/**/*.blade.php',
    ],

    // Safe list for dynamic classes
    safelist: [
        'text-red-500',
        'text-green-500',
        'bg-red-50',
        'bg-green-50',
    ],
};
```

## Build Configuration

```js
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/gsmui.css',
                'resources/js/gsmui.js',
            ],
            refresh: true,
        }),
    ],
});
```
