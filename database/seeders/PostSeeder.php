<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Blog\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Getting Started with GsmUi',
                'slug' => 'getting-started-with-gsmui',
                'body' => 'Learn how to install and use GsmUi in your Laravel project...',
                'excerpt' => 'A comprehensive guide to getting started with GsmUi.',
                'category_id' => 1,
                'status' => 'published',
                'published_at' => now(),
                'author_id' => 1,
                'tags' => ['tutorial', 'beginner', 'laravel'],
            ],
            [
                'title' => 'Introducing GsmUi v1.0',
                'slug' => 'introducing-gsmui-v1',
                'body' => 'We are excited to announce the release of GsmUi v1.0...',
                'excerpt' => 'The first stable release of GsmUi is here!',
                'category_id' => 3,
                'status' => 'published',
                'published_at' => now(),
                'author_id' => 1,
                'tags' => ['release', 'announcement'],
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
