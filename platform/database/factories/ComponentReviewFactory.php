<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Component;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComponentReviewFactory extends Factory
{
    protected $model = Component::class;

    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5),
            'rating_count' => fake()->numberBetween(1, 100),
        ];
    }
}
