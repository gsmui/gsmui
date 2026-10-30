<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Templates\Models\Template;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateFactory extends Factory
{
    protected $model = Template::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['draft', 'published']),
            'is_free' => fake()->boolean(50),
            'is_premium' => fake()->boolean(50),
            'price' => fake()->optional()->randomFloat(2, 19, 199),
            'demo_url' => fake()->url(),
            'version' => fake()->semver(),
            'changelog' => ['1.0.0' => 'Initial release'],
            'tags' => fake()->words(3),
            'downloads_count' => fake()->numberBetween(0, 2000),
            'rating' => fake()->randomFloat(1, 1, 5),
            'rating_count' => fake()->numberBetween(0, 30),
            'is_featured' => fake()->boolean(20),
            'framework' => fake()->randomElement(['laravel', 'livewire', 'vue', 'react']),
            'industry' => fake()->randomElement(['saas', 'ecommerce', 'portfolio', 'blog', 'agency']),
            'author_id' => User::factory(),
        ];
    }
}
