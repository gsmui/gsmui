<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        // `routes/web.php` is registered by bootstrap/app.php via withRouting().
        // `routes/admin.php` and `routes/dashboard.php` set their own prefix and
        // name internally, so applying them here too produced `admin/admin/...`.
        $this->routes(function () {
            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
            Route::middleware('web')->group(base_path('routes/admin.php'));
            Route::middleware('web')->group(base_path('routes/dashboard.php'));
        });
    }
}
