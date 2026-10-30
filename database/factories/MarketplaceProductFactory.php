<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MarketplaceProduct;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MarketplaceProductFactory extends Factory
{
    protected $model = MarketplaceProduct::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'long_description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 9, 299),
            'compare_price' => fake()->optional(30)->randomFloat(2, 299, 499),
            'type' => fake()->randomElement(['digital', 'subscription', 'bundle']),
            'status' => fake()->randomElement(['draft', 'pending', 'published']),
            'downloads_count' => fake()->numberBetween(0, 5000),
            'reviews_count' => fake()->numberBetween(0, 200),
            'rating_avg' => fake()->randomFloat(2, 1, 5),
            'commission_rate' => fake()->randomFloat(2, 10, 30),
            'featured' => fake()->boolean(20),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['status' => 'published']);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['featured' => true, 'status' => 'published']);
    }

    public function digital(): static
    {
        return $this->state(fn () => ['type' => 'digital']);
    }

    public function subscription(): static
    {
        return $this->state(fn () => ['type' => 'subscription']);
    }

    public function bundle(): static
    {
        return $this->state(fn () => ['type' => 'bundle']);
    }
}
