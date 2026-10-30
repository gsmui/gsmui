<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Models live in App\Domains\<Domain>\Models, but factories are flat in
        // Database\Factories. Without this, the default resolver looks for
        // Database\Factories\Domains\<Domain>\Models\<Model>Factory and fails.
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }
}
