<?php

namespace GsmuiPro;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class GsmuiProServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->alias(GsmuiProManager::class, 'gsmui-pro');

        $this->app->singleton(GsmuiProManager::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('GsmuiPro', \Gsmui\GsmuiPro::class);

        $this->mergeConfigFrom(
            __DIR__.'/../stubs/config/gsmui-pro-csp.php', 'gsmui-pro-csp'
        );
    }

    public function boot(): void
    {
        $this->bootComponentPath();

        $this->bootPublishableConfig();
    }

    public function bootComponentPath(): void
    {
        Blade::anonymousComponentPath(__DIR__.'/../stubs/resources/views/gsmui', 'gsmui');
    }

    public function bootPublishableConfig(): void
    {
        $this->publishes([
            __DIR__.'/../stubs/config/gsmui-pro-csp.php' => config_path('gsmui-pro-csp.php'),
        ], 'gsmui-pro-csp-config');
    }
}
