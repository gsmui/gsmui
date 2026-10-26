<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterSubscriberFactory extends Factory
{
    protected $model = NewsletterSubscriber::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->optional(70)->name(),
            'token' => \Illuminate\Support\Str::random(60),
            'subscribed_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'unsubscribed_at' => null,
            'active' => true,
        ];
    }

    public function unsubscribed(): static
    {
        return $this->state(fn () => [
            'active' => false,
            'unsubscribed_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }
}
