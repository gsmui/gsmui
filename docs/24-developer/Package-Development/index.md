# Package Development

> PRD — Volume 24: Developer Guide — Package Development

## Overview

This document covers package structure, service providers, auto-discovery, and publishing for developing reusable packages within the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Package structure | Consistent layout | 100% |
| Auto-discovery | Automatic registration | 100% |
| Config publishing | Publishable configs | All packages |
| Test coverage | Package test coverage | 90%+ |
| Documentation | README completeness | 100% |

## Package Structure

```
packages/gsmui/
├── config/
│   └── gsmui.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       └── components/
├── routes/
│   ├── api.php
│   └── web.php
├── src/
│   ├── Commands/
│   ├── Console/
│   ├── Events/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Livewire/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Services/
│   ├── Support/
│   ├── GsmuiServiceProvider.php
│   ├── GsmuiManager.php
│   └── GsmuiFacade.php
├── stubs/
│   ├── config/
│   └── resources/
├── tests/
│   ├── Feature/
│   ├── Unit/
│   ├── TestCase.php
│   └── CreatesApplication.php
├── composer.json
├── LICENSE
└── README.md
```

## Service Provider

```php
namespace Gsmui\Providers;

use Illuminate\Support\ServiceProvider;
use Gsmui\GsmuiManager;
use Gsmui\GsmuiFacade;

class GsmuiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/gsmui.php', 'gsmui'
        );

        $this->app->singleton('gsmui', function ($app) {
            return new GsmuiManager($app);
        });

        $this->app->bind('gsmui-components', function ($app) {
            return $app['gsmui']->components();
        });
    }

    public function boot(): void
    {
        $this->registerPublishing();
        $this->registerViews();
        $this->registerRoutes();
        $this->registerCommands();
        $this->registerComponentPath();
    }

    private function registerPublishing(): void
    {
        if (!$this->app->runningInConsole()) return;

        // Config
        $this->publishes([
            __DIR__ . '/../../config/gsmui.php' => config_path('gsmui.php'),
        ], 'gsmui-config');

        // Views
        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/gsmui'),
        ], 'gsmui-views');

        // Migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'gsmui-migrations');

        // Public assets
        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/gsmui'),
        ], 'gsmui-public');
    }

    private function registerViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/../../resources/views', 'gsmui'
        );
    }

    private function registerComponentPath(): void
    {
        $this->app->booted(function () {
            config([
                'gsmui.component_path' => __DIR__ . '/../../resources/views/components',
            ]);
        });
    }

    private function registerRoutes(): void
    {
        if ($this->app->routesAreCached()) return;

        $this->app['router']
            ->namespace('Gsmui\Http\Controllers')
            ->group(__DIR__ . '/../../routes/web.php');

        $this->app['router']
            ->prefix('api')
            ->namespace('Gsmui\Http\Controllers\Api')
            ->group(__DIR__ . '/../../routes/api.php');
    }

    private function registerCommands(): void
    {
        if (!$this->app->runningInConsole()) return;

        $this->commands([
            \Gsmui\Console\InstallCommand::class,
            \Gsmui\Console\PublishCommand::class,
        ]);
    }
}
```

## Auto-Discovery

### composer.json Configuration

```json
{
    "name": "gsmui/gsmui-pro",
    "description": "Premium Livewire UI components for Laravel",
    "type": "library",
    "license": "proprietary",
    "autoload": {
        "psr-4": {
            "Gsmui\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Gsmui\\Tests\\": "tests/"
        }
    },
    "extra": {
        "laravel": {
            "providers": [
                "Gsmui\\Providers\\GsmuiServiceProvider"
            ],
            "aliases": {
                "Gsmui": "Gsmui\\GsmuiFacade"
            }
        }
    },
    "require": {
        "php": "^8.2",
        "illuminate/support": "^10.0|^11.0",
        "livewire/livewire": "^3.0"
    },
    "require-dev": {
        "orchestra/testbench": "^8.0",
        "phpunit/phpunit": "^10.0"
    }
}
```

## Config Publishing

```bash
# Publish config only
php artisan vendor:publish --tag=gsmui-config

# Publish views only
php artisan vendor:publish --tag=gsmui-views

# Publish all
php artisan vendor:publish --tag=gsmui
```

## Package Config

```php
// config/gsmui.php
return [
    'prefix' => env('GSMUI_PREFIX', 'gsmui'),
    'component_path' => null,
    'components' => [
        'button' => \Gsmui\Components\Button::class,
        'input' => \Gsmui\Components\Input::class,
        'modal' => \Gsmui\Components\Modal::class,
        'dropdown' => \Gsmui\Components\Dropdown::class,
    ],
    'themes' => [
        'default' => [
            'primary' => 'indigo',
            'dark' => 'zinc',
        ],
    ],
];
```

## Facade

```php
namespace Gsmui;

use Illuminate\Support\Facades\Facade;

class GsmuiFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'gsmui';
    }
}

// Usage
Gsmui::components();
Gsmui::prefix();
```

## Acceptance Criteria

- [ ] Package follows standard Laravel package structure
- [ ] Service provider registers all bindings
- [ ] Config is publishable via vendor:publish
- [ ] Views are publishable and overridable
- [ ] Auto-discovery works without manual registration
- [ ] Facade provides static access to manager
- [ ] Routes are loaded only when not cached
- [ ] Commands are registered for artisan
- [ ] Tests use Orchestra Testbench
- [ ] README documents installation and usage
