<?php

namespace GsmuiPro\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CspMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Note: Register this middleware manually in app/Http/Kernel.php:
     *
     *   protected $middleware = [
     *       // ...
     *       \GsmuiPro\Http\Middleware\CspMiddleware::class,
     *   ];
     *
     * Or add it to a specific route group:
     *
     *   Route::middleware('csp')->group(function () { ... });
     *
     * To use nonces with Livewire, set CSP_USE_NONCE=true in your .env
     * and add the following to your AppServiceProvider:
     *
     *   Livewire::useScriptTagAttributes(['nonce' => $cspNonce ?? '']);
     *   Livewire::useStyleTagAttributes(['nonce' => $cspNonce ?? '']);
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('gsmui-pro-csp.enabled', true)) {
            return $response;
        }

        $nonce = null;

        if (config('gsmui-pro-csp.use_nonce', false)) {
            $nonce = base64_encode(random_bytes(16));
            view()->share('cspNonce', $nonce);
        }

        $directives = $this->buildDirectives($nonce);

        // Report-Only mode for testing — set CSP_REPORT_ONLY=true in .env
        $header = config('gsmui-pro-csp.report_only', false)
            ? 'Content-Security-Policy-Report-Only'
            : 'Content-Security-Policy';

        $response->headers->set($header, $directives);

        return $response;
    }

    /**
     * Build the full CSP header value from the config directives.
     */
    protected function buildDirectives(?string $nonce = null): string
    {
        $directives = config('gsmui-pro-csp.directives', []);
        $policies = [];

        foreach ($directives as $directive => $values) {
            // Handle boolean directives like 'upgrade-insecure-requests' => true
            if ($values === true) {
                $policies[] = $directive;
                continue;
            }

            // Handle boolean/disabled directives
            if ($values === false || $values === null) {
                continue;
            }

            // Handle array of values
            if (is_array($values)) {
                $resolved = [];

                foreach ($values as $value) {
                    // Skip 'unsafe-inline' for script-src when nonce is used
                    if ($value === "'unsafe-inline'" && $nonce !== null && $directive === 'script-src') {
                        continue;
                    }

                    // Skip empty values
                    if (empty($value)) {
                        continue;
                    }

                    $resolved[] = $value;
                }

                // Inject nonce if applicable
                if ($nonce !== null && in_array($directive, ['script-src', 'style-src'], true)) {
                    $resolved[] = "'nonce-{$nonce}'";
                }

                if (! empty($resolved)) {
                    $policies[] = $directive.' '.implode(' ', $resolved);
                }

                continue;
            }

            // Handle string values
            if (is_string($values)) {
                $policies[] = $directive.' '.$values;
            }
        }

        return implode('; ', $policies);
    }
}
