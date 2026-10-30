<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Documentation\Models\Document;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->paragraphs(3, true),
            'category' => fake()->randomElement(['getting-started', 'components', 'guides']),
            'subcategory' => null,
            'author_id' => User::factory(),
            'status' => 'draft',
            'version' => '1.0.0',
            'sort_order' => fake()->numberBetween(0, 50),
            'is_featured' => false,
            'views_count' => 0,
            'meta_title' => $title,
            'meta_description' => fake()->sentence(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['status' => 'published']);
    }
}
