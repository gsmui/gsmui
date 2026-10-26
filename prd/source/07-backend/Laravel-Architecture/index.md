# Laravel Architecture

> Laravel 13 architecture patterns used throughout the gsmui-pro codebase.

## Service Providers

The package registers via `GsmuiProServiceProvider`, which boots component paths, publishes config, and registers routes.

```php
// src/GsmuiProServiceProvider.php
class GsmuiProServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GsmuiManager::class, function ($app) {
            return new GsmuiManager($app);
        });

        $this->mergeConfigFrom(
            __DIR__.'/../stubs/config/gsmui-pro-csp.php', 'gsmui-pro-csp'
        );
    }

    public function boot(): void
    {
        $this->bootComponentPath();
        $this->registerPublishing();
        $this->registerRoutes();
    }

    protected function bootComponentPath(): void
    {
        Blade::anonymousComponentPath(
            __DIR__.'/../stubs/resources/views/gsmui', 'gsmui'
        );
    }
}
```

## Facades

The `Gsmui` facade proxies to `GsmuiManager`, providing static access to class merging and configuration.

```php
class Gsmui extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GsmuiManager::class;
    }
}

// Usage
Gsmui::classes('input', 'outline');
// Returns merged class string for gsmui:input outline variant
```

## Container Bindings

```php
// Singleton — one instance for the entire request
$this->app->singleton(GsmuiManager::class);

// Scoped — one instance per request (reset between requests in testing)
$this->app->scoped(CspState::class);

// Transient — new instance every time
$this->app->when(CspMiddleware::class)
    ->needs(CspState::class)
    ->give(function ($app) {
        return new CspState($app['config']['gsmui-pro-csp']);
    });
```

| Binding Type | Lifecycle | Use Case |
|---|---|---|
| `singleton` | Application lifetime | Manager, config |
| `scoped` | Request lifetime | Per-request state |
| `transient` | Every resolve | Stateless helpers |

## Middleware Stack

```php
// Route-level middleware
Route::middleware(['gsmui.csp'])->group(function () {
    Route::get('/gsmui-csp-test', function () {
        return view('csp-test');
    });
});

// Global middleware registration (in service provider)
$this->app['router']->prependMiddlewareToGroup('web', CspMiddleware::class);
```

The CSP middleware sets headers on every response:

```php
class CspMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($this->shouldApplyCsp()) {
            $response->headers->set('Content-Security-Policy', $this->buildPolicy());
        }

        return $response;
    }

    protected function buildPolicy(): string
    {
        return collect([
            "default-src 'self'",
            "script-src 'self'",
            "style-src 'self' 'unsafe-inline'",
            "img-src 'self' data:",
            "connect-src 'self'",
        ])->implode('; ');
    }
}
```

## Exception Handling

```php
// app/Exceptions/Handler.php
class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($e instanceof GsmuiComponentException) {
                report_to_sentry($e);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Not found'], 404);
            }
        });
    }
}
```

## Configuration Management

Config is merged from the package stub and can be published:

```bash
php artisan vendor:publish --tag=gsmui-pro-csp-config
```

```php
// config/gsmui-pro-csp.php
return [
    'enabled' => env('CSP_ENABLED', false),
    'report_only' => false,
    'policy' => [
        'script-src' => ["'self'"],
        'style-src' => ["'self'", "'unsafe-inline'"],
        'img-src' => ["'self'", 'data:'],
    ],
];
```

Access config via the facade or `config()` helper:

```php
$cspEnabled = config('gsmui-pro-csp.enabled');
$policy = Gsmui::config('csp.policy');
```

## Lifecycle Hooks

| Stage | Method | Purpose |
|---|---|---|
| Registration | `register()` | Bind singletons, merge config |
| Boot | `boot()` | Publish assets, register routes |
| After refresh | `refreshing()` | Clear cached compiled views |
| Package publish | `registerPublishing()` | Define publish tags |
