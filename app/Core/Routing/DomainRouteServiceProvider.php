<?php

declare(strict_types=1);

namespace App\Core\Routing;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class DomainRouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot() 
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/authentication.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/components.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/billing.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/themes.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/documentation.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/blog.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/showcase.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/marketplace.php'));

            Route::middleware('web')
                ->group(base_path('routes/domains/playground.php'));

            Route::middleware(['web', 'auth', 'role:admin'])
                ->group(base_path('routes/domains/admin.php'));

            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/domains/dashboard.php'));
        });
    }
}
