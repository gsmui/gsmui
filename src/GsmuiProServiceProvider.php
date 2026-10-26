<?php

namespace GsmuiPro;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\ComponentAttributeBag;
use Livewire\WireDirective;

class GsmuiProServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the manager as a singleton
        $this->app->singleton(GsmuiProManager::class, function ($app) {
            return new GsmuiProManager();
        });

        // Register an alias for convenient access
        $this->app->alias(GsmuiProManager::class, 'gsmui-pro');
        $this->app->alias(GsmuiProManager::class, 'gsmui');

        // Class aliases. Blade templates call `Gsmui::classes()` directly, so the
        // facade must be resolvable by its short name without a config/app.php entry.
        // Only aliased when unused, so a host app's own alias always wins.
        $this->registerClassAliases([
            'Gsmui' => \GsmuiPro\GsmuiPro::class,
        ]);

        // Merge default configuration
        $this->mergeConfigFrom(
            __DIR__.'/../stubs/config/gsmui-pro.php', 'gsmui-pro'
        );

        // Merge CSP configuration
        $this->mergeConfigFrom(
            __DIR__.'/../stubs/config/gsmui-pro-csp.php', 'gsmui-pro-csp'
        );
    }

    /**
     * Register short class aliases without clobbering the host application's own.
     *
     * @param  array<string, string>  $aliases
     */
    protected function registerClassAliases(array $aliases): void
    {
        foreach ($aliases as $alias => $class) {
            if (! class_exists($alias, false)) {
                class_alias($class, $alias);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootComponentPath();
        $this->bootPublishableConfig();
        $this->bootViews();
        $this->bootAttributeMacros();
    }

    /**
     * Register attribute-bag macros used by component templates.
     *
     * Components accept namespaced sub-attributes such as `track:class` or
     * `icon:variant` and pull them off the bag with a default. Laravel's
     * ComponentAttributeBag has no such helper, so it is added here rather than
     * repeating the extraction logic in a dozen templates.
     */
    protected function bootAttributeMacros(): void
    {
        if (! ComponentAttributeBag::hasMacro('pluck')) {
            ComponentAttributeBag::macro('pluck', function (string $key, mixed $default = null) {
                /** @var ComponentAttributeBag $this */
                return $this->get($key, $default);
            });
        }

        // Livewire registers `wire()` through a component hook, so it is only
        // available while a Livewire request is running. Components are also
        // rendered outside Livewire (tests, plain Blade), so register a fallback.
        if (! ComponentAttributeBag::hasMacro('wire')) {
            ComponentAttributeBag::macro('wire', function (string $name) {
                /** @var ComponentAttributeBag $this */
                $entries = $this->whereStartsWith('wire:' . $name)->getAttributes();
                $directive = array_key_first($entries);
                $value = $entries ? e(reset($entries)) : null;

                return new WireDirective($name, $directive ?: 'wire:' . $name, $value);
            });
        }

        if (! ComponentAttributeBag::hasMacro('hasWire')) {
            ComponentAttributeBag::macro('hasWire', function (string $name) {
                /** @var ComponentAttributeBag $this */
                return count($this->whereStartsWith('wire:' . $name)->getAttributes()) > 0;
            });
        }
    }

    /**
     * Register the Blade component path.
     */
    protected function bootComponentPath(): void
    {
        $path = __DIR__.'/../stubs/resources/views/gsmui';

        // Anonymous components. Laravel expects the double-colon form
        // `<x-gsmui::button>`, and the package's templates mostly use the
        // single-colon form `<x-gsmui:button>`. Both are supported by also
        // registering `gsmui` as a Blade component namespace whose classes are
        // resolved through a fallback view component.
        Blade::anonymousComponentPath($path, 'gsmui');
        $this->registerSingleColonAliases($path);
    }

    /**
     * Make `<x-gsmui:name>` compile to the same thing as `<x-gsmui::name>`.
     *
     * Laravel's tag compiler only resolves a namespaced anonymous component when
     * the tag uses the double-colon form. The package's templates predominantly
     * use the single-colon form, so the raw template is normalised before Blade
     * compiles it. This keeps existing call sites working without editing ~600
     * templates.
     */
    protected function registerSingleColonAliases(string $path): void
    {
        Blade::prepareStringsForCompilationUsing(function (string $template) {
            return preg_replace(
                '/(<x-gsmui):(?!:)/',
                '$1::',
                $template
            );
        });
    }

    /**
     * Register publishable configuration files.
     */
    protected function bootPublishableConfig(): void
    {
        // Main package config
        $this->publishes([
            __DIR__.'/../stubs/config/gsmui-pro.php' => config_path('gsmui-pro.php'),
        ], 'gsmui-pro-config');

        // CSP config
        $this->publishes([
            __DIR__.'/../stubs/config/gsmui-pro-csp.php' => config_path('gsmui-pro-csp.php'),
        ], 'gsmui-pro-csp-config');
    }

    /**
     * Register the views.
     */
    protected function bootViews(): void
    {
        $this->loadViewsFrom(
            __DIR__.'/../stubs/resources/views/gsmui',
            'gsmui'
        );

        $this->publishes([
            __DIR__.'/../stubs/resources/views/gsmui' => resource_path('views/vendor/gsmui'),
        ], 'gsmui-pro-views');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            GsmuiProManager::class,
            'gsmui-pro',
        ];
    }
}
