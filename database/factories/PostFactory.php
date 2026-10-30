<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Blog\Models\Post;
use App\Domains\Blog\Models\PostCategory;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->paragraphs(3, true),
            'excerpt' => fake()->paragraph(),
            'category_id' => PostCategory::factory(),
            'status' => fake()->randomElement(['draft', 'published']),
            'published_at' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
            'featured_image' => fake()->optional()->imageUrl(640, 480),
            'meta_title' => fake()->optional()->sentence(),
            'meta_description' => fake()->optional()->paragraph(),
            'views_count' => fake()->numberBetween(0, 10000),
            'is_featured' => fake()->boolean(20),
            'tags' => fake()->words(3),
            'author_id' => User::factory(),
        ];
    }
}
