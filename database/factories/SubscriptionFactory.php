<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Billing\Models\Subscription;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'plan' => fake()->randomElement(['free', 'pro', 'enterprise']),
            'status' => 'active',
            'stripe_id' => fake()->optional()->uuid(),
            'stripe_plan' => fake()->optional()->slug(2),
            'quantity' => 1,
            'trial_ends_at' => null,
            'ends_at' => null,
            'cancelled_at' => null,
        ];
    }

    public function cancelled(): static
    {
        return $this->state(fn () => [
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }
}
