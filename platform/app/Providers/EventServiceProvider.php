<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<class-string>>
     */
    protected $listen = [
        \App\Domains\Users\Events\UserRegistered::class => [
            \App\Domains\Users\Listeners\SendWelcomeEmail::class,
        ],
        \App\Domains\Components\Events\ComponentPublished::class => [
            \App\Domains\Components\Listeners\IndexComponentForSearch::class,
        ],
        \App\Domains\Themes\Events\ThemePublished::class => [
            \App\Domains\Themes\Listeners\IndexThemeForSearch::class,
        ],
        \App\Domains\Blog\Events\PostPublished::class => [
            \App\Domains\Blog\Listeners\IndexPostForSearch::class,
        ],
        \App\Domains\Billing\Events\SubscriptionActivated::class => [
            \App\Domains\Billing\Listeners\SendSubscriptionConfirmation::class,
        ],
    ];

    /**
     * Register any other events for your application.
     */
    public function boot(): void
    {
        //
    }
}
