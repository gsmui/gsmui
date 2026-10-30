<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CreatorPayout;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreatorPayoutFactory extends Factory
{
    protected $model = CreatorPayout::class;

    public function definition(): array
    {
        return [
            'creator_id' => User::factory(),
            'amount' => fake()->randomFloat(2, 50, 2000),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'failed']),
            'method' => fake()->randomElement(['paypal', 'bank_transfer', 'stripe']),
            'reference' => fake()->optional()->bothify('PAY-#####'),
            'paid_at' => fake()->optional(60)->dateTimeBetween('-3 months', 'now'),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => 'completed',
            'paid_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
