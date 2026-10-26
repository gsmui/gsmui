<?php

namespace GsmuiPro;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->bootComponentPath();
        $this->bootPublishableConfig();
        $this->bootViews();
    }

    /**
     * Register the Blade component path.
     */
    protected function bootComponentPath(): void
    {
        Blade::anonymousComponentPath(
            __DIR__.'/../stubs/resources/views/gsmui',
            'gsmui'
        );
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
