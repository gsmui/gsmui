<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MarketplaceProduct;
use App\Domains\Marketplace\Models\Order;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
    protected $model = \App\Domains\Marketplace\Models\ProductReview::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => MarketplaceProduct::factory(),
            'order_id' => Order::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'helpful_count' => fake()->numberBetween(0, 50),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn () => ['status' => 'approved']);
    }
}
