<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\License;
use App\Models\MarketplaceProduct;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseFactory extends Factory
{
    protected $model = License::class;

    public function definition(): array
    {
        $maxActivations = fake()->randomElement([1, 3, 5, 10]);

        return [
            'user_id' => User::factory(),
            'product_id' => MarketplaceProduct::factory(),
            'order_id' => Order::factory(),
            'license_key' => 'GSMUI-' . strtoupper(fake()->bothify('????-????-????-????')),
            'status' => fake()->randomElement(['active', 'expired', 'revoked']),
            'activated_at' => fake()->optional(80)->dateTimeBetween('-1 year', 'now'),
            'expires_at' => fake()->optional(40)->dateTimeBetween('+1 month', '+2 years'),
            'activations_count' => fake()->numberBetween(0, $maxActivations),
            'max_activations' => $maxActivations,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['status' => 'active']);
    }
}
