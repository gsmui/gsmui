<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', fn ($user) => $user->isAdmin());
        Gate::define('pro', fn ($user) => $user->isPro() || $user->isEnterprise());
        Gate::define('enterprise', fn ($user) => $user->isEnterprise());
    }
}
