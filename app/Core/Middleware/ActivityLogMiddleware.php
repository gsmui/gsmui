<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivityLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->user() && $request->isMethod('POST')) {
            activity()
                ->causedBy($request->user())
                ->performedOn($request->user())
                ->withProperties([
                    'method' => $request->method(),
                    'path' => $request->path(),
                    'ip' => $request->ip(),
                ])
                ->log('User performed action: ' . $request->method() . ' ' . $request->path());
        }

        return $response;
    }
}
