<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Package Version
    |--------------------------------------------------------------------------
    |
    | The current version of the Gsmui Pro package.
    |
    */

    'version' => '2.15.0',

    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    |
    | The default theme to use for Gsmui components. Available themes:
    | 'default', 'blue', 'green', 'purple', 'red', 'orange', 'pink',
    | 'teal', 'indigo', 'slate', 'emerald'
    |
    */

    'theme' => env('GSMUI_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Component Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix used for Blade component names.
    |
    */

    'prefix' => 'gsmui',

    /*
    |--------------------------------------------------------------------------
    | Dark Mode
    |--------------------------------------------------------------------------
    |
    | Configure dark mode behavior.
    |
    | - 'class': Toggle dark mode by adding/removing a class on <html>
    | - 'media': Use prefers-color-scheme media query
    | - 'manual': Manual control only (no auto-detection)
    |
    */

    'dark_mode' => [
        'strategy' => env('GSMUI_DARK_MODE', 'class'),
        'class' => 'dark',
    ],

    /*
    |--------------------------------------------------------------------------
    | Component Defaults
    |--------------------------------------------------------------------------
    |
    | Default classes for each component. These can be overridden in your
    | application config to customize the appearance of components.
    |
    */

    'components' => [

        /*
        | Button Component
        */
        'button' => [
            'base' => 'inline-flex items-center justify-center gap-2 rounded-lg font-medium transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50',
            'primary' => 'bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100 focus-visible:ring-zinc-500',
            'secondary' => 'bg-zinc-100 text-zinc-900 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700 focus-visible:ring-zinc-400',
            'danger' => 'bg-red-500 text-white hover:bg-red-600 focus-visible:ring-red-500',
            'ghost' => 'text-zinc-600 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-zinc-800 focus-visible:ring-zinc-400',
            'subtle' => 'text-zinc-500 hover:text-zinc-700 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:text-zinc-200 dark:hover:bg-zinc-800 focus-visible:ring-zinc-400',
            'link' => 'text-zinc-600 underline-offset-4 hover:underline dark:text-zinc-400 focus-visible:ring-zinc-400',
            'sizes' => [
                'xs' => 'h-6 px-2 text-xs',
                'sm' => 'h-8 px-3 text-sm',
                'md' => 'h-10 px-4 text-sm',
                'lg' => 'h-12 px-6 text-base',
                'xl' => 'h-14 px-8 text-base',
            ],
        ],

        /*
        | Input Component
        */
        'input' => [
            'base' => 'block w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-xs transition-colors duration-200 placeholder:text-zinc-400 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:bg-white/10',
            'border' => 'border-zinc-300 focus:border-zinc-500 focus:ring-zinc-500/20 dark:border-white/10 dark:focus:border-white/20',
            'error' => 'border-red-500 focus:border-red-500 focus:ring-red-500/20',
            'sizes' => [
                'sm' => 'h-8 text-sm',
                'md' => 'h-10 text-sm',
                'lg' => 'h-12 text-base',
            ],
        ],

        /*
        | Card Component
        */
        'card' => [
            'base' => 'rounded-xl border bg-white shadow-sm dark:bg-zinc-900',
            'border' => 'border-zinc-200 dark:border-white/10',
            'padding' => [
                'sm' => 'p-4',
                'md' => 'p-6',
                'lg' => 'p-8',
            ],
        ],

        /*
        | Badge Component
        */
        'badge' => [
            'base' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
            'variants' => [
                'default' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200',
                'success' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                'danger' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            ],
        ],

        /*
        | Modal Component
        */
        'modal' => [
            'overlay' => 'fixed inset-0 z-50 bg-black/50 backdrop-blur-sm',
            'content' => 'fixed left-1/2 top-1/2 z-50 -translate-x-1/2 -translate-y-1/2 rounded-xl bg-white p-6 shadow-2xl dark:bg-zinc-900',
            'sizes' => [
                'sm' => 'max-w-sm',
                'md' => 'max-w-md',
                'lg' => 'max-w-lg',
                'xl' => 'max-w-xl',
                '2xl' => 'max-w-2xl',
                'full' => 'max-w-4xl',
            ],
        ],

        /*
        | Tooltip Component
        */
        'tooltip' => [
            'base' => 'absolute z-50 rounded-lg bg-zinc-900 px-3 py-1.5 text-xs text-white shadow-lg dark:bg-zinc-700',
        ],

        /*
        | Select Component
        */
        'select' => [
            'base' => 'block w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-xs transition-colors duration-200 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:bg-white/10',
            'border' => 'border-zinc-300 focus:border-zinc-500 focus:ring-zinc-500/20 dark:border-white/10 dark:focus:border-white/20',
        ],

        /*
        | Textarea Component
        */
        'textarea' => [
            'base' => 'block w-full rounded-lg border bg-white px-3 py-2 text-sm shadow-xs transition-colors duration-200 placeholder:text-zinc-400 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:bg-white/10',
            'border' => 'border-zinc-300 focus:border-zinc-500 focus:ring-zinc-500/20 dark:border-white/10 dark:focus:border-white/20',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Icons
    |--------------------------------------------------------------------------
    |
    | Configure icon settings. Gsmui Pro uses inline SVGs by default.
    |
    */

    'icons' => [
        'size' => [
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
        ],
    ],

];
