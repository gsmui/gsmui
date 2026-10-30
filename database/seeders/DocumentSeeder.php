<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Documentation\Models\Document;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            [
                'title' => 'Installation',
                'slug' => 'installation',
                'body' => '## Installation Guide\n\n### Requirements\n\n- PHP 8.1+\n- Laravel 10+\n- Livewire 3+\n\n### Installation\n\n```bash\ncomposer require gsmui/gsmui-pro\n```\n\n### Configuration\n\nPublish the configuration file:\n\n```bash\nphp artisan vendor:publish --tag=gsmui-pro-config\n```',
                'category' => 'Getting Started',
                'status' => 'published',
                'sort_order' => 1,
                'author_id' => 1,
            ],
            [
                'title' => 'Components',
                'slug' => 'components',
                'body' => '## Components\n\nGsmUi provides 200+ pre-built components for your Laravel Livewire projects.\n\n### Button\n\n```html\n<x-gsmui-button variant="primary">Click me</x-gsmui-button>\n```\n\n### Input\n\n```html\n<x-gsmui-input label="Email" placeholder="Enter your email" />\n```',
                'category' => 'Components',
                'status' => 'published',
                'sort_order' => 2,
                'author_id' => 1,
            ],
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }
    }
}
