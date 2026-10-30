<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Components\Models\ComponentCategory;

class ComponentCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Form', 'slug' => 'form', 'icon' => 'form', 'sort_order' => 1],
            ['name' => 'Data Display', 'slug' => 'data-display', 'icon' => 'table', 'sort_order' => 2],
            ['name' => 'Navigation', 'slug' => 'navigation', 'icon' => 'nav', 'sort_order' => 3],
            ['name' => 'Feedback', 'slug' => 'feedback', 'icon' => 'alert', 'sort_order' => 4],
            ['name' => 'Layout', 'slug' => 'layout', 'icon' => 'layout', 'sort_order' => 5],
            ['name' => 'Typography', 'slug' => 'typography', 'icon' => 'text', 'sort_order' => 6],
            ['name' => 'Media', 'slug' => 'media', 'icon' => 'media', 'sort_order' => 7],
            ['name' => 'Charts', 'slug' => 'charts', 'icon' => 'chart', 'sort_order' => 8],
            ['name' => 'Tables', 'slug' => 'tables', 'icon' => 'table', 'sort_order' => 9],
            ['name' => 'Overlays', 'slug' => 'overlays', 'icon' => 'modal', 'sort_order' => 10],
        ];

        foreach ($categories as $category) {
            ComponentCategory::create($category);
        }
    }
}
