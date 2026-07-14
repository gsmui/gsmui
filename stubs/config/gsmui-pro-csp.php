<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy
    |--------------------------------------------------------------------------
    |
    | This config controls the Content-Security-Policy header sent with every
    | response. Gsmui Pro loads zero external resources (no CDN fonts, no
    | external scripts, no iframes), so a strict CSP is possible.
    |
    | Setting 'enabled' to false will skip the header entirely.
    |
    | Set 'use_nonce' to true to generate a random nonce per request for
    | inline scripts/styles. This is recommended over 'unsafe-inline'.
    |
    | For detailed guidance, see:
    | https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
    |
    */

    'enabled' => env('CSP_ENABLED', true),

    'use_nonce' => env('CSP_USE_NONCE', false),

    'report_only' => env('CSP_REPORT_ONLY', false),

    /*
    |--------------------------------------------------------------------------
    | Directives
    |--------------------------------------------------------------------------
    |
    | The directives below are tuned for Gsmui Pro + Livewire + Alpine.
    |
    | - 'unsafe-inline' for style-src covers the popover polyfill fallback.
    | - 'unsafe-inline' for script-src is only needed for Livewire/Alpine.
    | - If using nonces, set 'use_nonce' to true and drop 'unsafe-inline'.
    |
    */

    'directives' => [

        /*
        | Base fallback for all resource types not explicitly listed.
        */
        'default-src' => [
            "'self'",
        ],

        /*
        | Script sources.
        | Gsmui Pro itself needs only 'self'. Livewire/Alpine inject inline
        | scripts, which need either 'unsafe-inline' or a nonce.
        */
        'script-src' => [
            "'self'",
            /*
             | Uncomment if not using nonces with Livewire:
             "'unsafe-inline'",
            */
        ],

        /*
        | Style sources.
        | 'unsafe-inline' covers the popover polyfill's fallback <style> tag
        | when adoptedStyleSheets is not supported.
        */
        'style-src' => [
            "'self'",
            "'unsafe-inline'",
        ],

        /*
        | Image sources.
        | data: is needed for inline SVG background-images (calendar, etc.)
        */
        'img-src' => [
            "'self'",
            'data:',
        ],

        /*
        | Font sources. Gsmui Pro uses system fonts — no @font-face.
        */
        'font-src' => [
            "'self'",
        ],

        /*
        | Connect sources (fetch, XHR, WebSocket, EventSource).
        | Livewire may need its own connect-src for polling/SSE.
        */
        'connect-src' => [
            "'self'",
        ],

        /*
        | Restrict where <base> tags can load from.
        */
        'base-uri' => [
            "'self'",
        ],

        /*
        | Restrict where forms can be submitted.
        */
        'form-action' => [
            "'self'",
        ],

        /*
        | Prevent the page from being framed (clickjacking protection).
        */
        'frame-ancestors' => [
            "'none'",
        ],

        /*
        | Upgrade HTTP requests to HTTPS automatically.
        */
        'upgrade-insecure-requests' => true,

    ],

];
