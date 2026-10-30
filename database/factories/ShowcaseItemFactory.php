<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Showcase\Models\ShowcaseItem;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShowcaseItemFactory extends Factory
{
    protected $model = ShowcaseItem::class;

    public function definition(): array
    {
        $title = fake()->unique()->words(4, true);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'description' => fake()->paragraph(),
            'body' => fake()->paragraphs(3, true),
            'thumbnail' => fake()->optional(80)->imageUrl(800, 600),
            'gallery' => fake()->optional(50)->words(3),
            'category' => fake()->randomElement(['SaaS', 'E-commerce', 'Portfolio', 'Blog', 'Agency', 'Dashboard', 'Landing Page']),
            'tags' => fake()->words(4),
            'likes_count' => fake()->numberBetween(0, 500),
            'comments_count' => fake()->numberBetween(0, 100),
            'status' => fake()->randomElement(['draft', 'published']),
            'featured' => fake()->boolean(15),
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
}
