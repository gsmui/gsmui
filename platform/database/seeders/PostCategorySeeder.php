<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Blog\Models\PostCategory;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tutorials', 'slug' => 'tutorials', 'sort_order' => 1],
            ['name' => 'News', 'slug' => 'news', 'sort_order' => 2],
            ['name' => 'Updates', 'slug' => 'updates', 'sort_order' => 3],
            ['name' => 'Community', 'slug' => 'community', 'sort_order' => 4],
        ];

        foreach ($categories as $category) {
            PostCategory::create($category);
        }
    }
}
