<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['percentage', 'fixed']);

        return [
            'code' => strtoupper(fake()->bothify('???-#####')),
            'type' => $type,
            'value' => $type === 'percentage'
                ? fake()->randomElement([5, 10, 15, 20, 25, 30])
                : fake()->randomFloat(2, 5, 50),
            'minimum_order_amount' => fake()->randomElement([0, 10, 25, 50, 100]),
            'maximum_uses' => fake()->optional(70)->numberBetween(10, 500),
            'used_count' => fake()->numberBetween(0, 50),
            'starts_at' => fake()->optional(80)->dateTimeBetween('-3 months', 'now'),
            'expires_at' => fake()->optional(70)->dateTimeBetween('+1 month', '+6 months'),
            'active' => fake()->boolean(80),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'active' => true,
            'starts_at' => now()->subMonth(),
            'expires_at' => now()->addMonths(3),
        ]);
    }

    public function percentage(): static
    {
        return $this->state(fn () => ['type' => 'percentage']);
    }

    public function fixed(): static
    {
        return $this->state(fn () => ['type' => 'fixed']);
    }
}
