<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\DocumentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentCategoryFactory extends Factory
{
    protected $model = DocumentCategory::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
