<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Documentation\Models\Document;
use App\Domains\Users\Models\User;
use Illuminate\Database\Seeder;

class DocumentationSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::first()->id;

        $documents = [
            ['title' => 'Installation', 'slug' => 'installation', 'category' => 'Getting Started', 'sort_order' => 1, 'status' => 'published', 'is_featured' => true, 'views_count' => 15234, 'body' => "## Requirements\n\n- PHP 8.1+\n- Laravel 10+\n- Livewire 3+\n\n## Installation\n\n```bash\ncomposer require gsmui/gsmui-pro\n```\n\n## Publish Assets\n\n```bash\nphp artisan vendor:publish --tag=gsmui-assets\n```\n\n## Configuration\n\n```bash\nphp artisan vendor:publish --tag=gsmui-pro-config\n```"],
            ['title' => 'Quick Start', 'slug' => 'quick-start', 'category' => 'Getting Started', 'sort_order' => 2, 'status' => 'published', 'is_featured' => true, 'views_count' => 12456, 'body' => "## Your First Page\n\n1. Add a component to any Blade view\n2. Wire it to a Livewire property\n3. That's it!\n\n```html\n<x-gsmui-input label=\"Name\" wire:model=\"name\" />\n<x-gsmui-button wire:click=\"save\">Save</x-gsmui-button>\n```"],
            ['title' => 'Configuration', 'slug' => 'configuration', 'category' => 'Getting Started', 'sort_order' => 3, 'status' => 'published', 'views_count' => 8901, 'body' => "## Config File\n\nThe configuration file lives at `config/gsmui-pro.php`.\n\n## Key Options\n\n- `theme` - Active theme name\n- `prefix` - CSS class prefix\n- `animations` - Enable/disable animations"],
            ['title' => 'Button', 'slug' => 'button', 'category' => 'Components', 'subcategory' => 'Form', 'sort_order' => 10, 'status' => 'published', 'is_featured' => true, 'views_count' => 23456, 'body' => "## Button Component\n\nA versatile button with multiple variants, sizes, and states.\n\n## Variants\n\n`primary`, `secondary`, `ghost`, `danger`\n\n## Sizes\n\n`sm`, `md`, `lg`\n\n## Usage\n\n```html\n<x-gsmui-button variant=\"primary\" size=\"md\">Click me</x-gsmui-button>\n```"],
            ['title' => 'Input', 'slug' => 'input-doc', 'category' => 'Components', 'subcategory' => 'Form', 'sort_order' => 11, 'status' => 'published', 'views_count' => 19876, 'body' => "## Input Component\n\nA text input with label, placeholder, validation, and prefix/suffix support.\n\n## Props\n\n- `label` - Field label\n- `placeholder` - Placeholder text\n- `error` - Validation error message\n\n## Usage\n\n```html\n<x-gsmui-input label=\"Email\" placeholder=\"you@example.com\" wire:model=\"email\" />\n```"],
            ['title' => 'Select', 'slug' => 'select-doc', 'category' => 'Components', 'subcategory' => 'Form', 'sort_order' => 12, 'status' => 'published', 'views_count' => 16543, 'body' => "## Select Component\n\nA searchable select dropdown with multi-select and grouping.\n\n## Features\n\n- Search/filter options\n- Multi-select mode\n- Option groups\n- Async loading"],
            ['title' => 'Data Table', 'slug' => 'data-table-doc', 'category' => 'Components', 'subcategory' => 'Data Display', 'sort_order' => 20, 'status' => 'published', 'is_featured' => true, 'views_count' => 18765, 'body' => "## Data Table Component\n\nA powerful table with sorting, filtering, pagination, and bulk actions.\n\n## Features\n\n- Server-side sorting\n- Column filtering\n- Row selection\n- Export to CSV/PDF"],
            ['title' => 'Dialog', 'slug' => 'dialog-doc', 'category' => 'Components', 'subcategory' => 'Overlays', 'sort_order' => 30, 'status' => 'published', 'views_count' => 14321, 'body' => "## Dialog Component\n\nA modal dialog with focus trapping and backdrop.\n\n## Usage\n\n```html\n<x-gsmui-dialog wire:model=\"open\">\n    <x-slot name=\"title\">Confirm Action</x-slot>\n    Are you sure?\n</x-gsmui-dialog>\n```"],
            ['title' => 'Toast', 'slug' => 'toast-doc', 'category' => 'Components', 'subcategory' => 'Feedback', 'sort_order' => 35, 'status' => 'published', 'views_count' => 11234, 'body' => "## Toast Component\n\nNon-blocking notifications with auto-dismiss.\n\n## Usage\n\n```php\n$this->dispatch('toast', message: 'Saved!', type: 'success');\n```"],
            ['title' => 'Theming', 'slug' => 'theming', 'category' => 'Guides', 'sort_order' => 40, 'status' => 'published', 'is_featured' => true, 'views_count' => 9876, 'body' => "## Theming Guide\n\nGsmUi uses CSS custom properties for theming.\n\n## Creating a Theme\n\nDefine tokens in your CSS:\n\n```css\n:root {\n    --gsmui-color-primary: #6366f1;\n}\n```"],
            ['title' => 'Dark Mode', 'slug' => 'dark-mode', 'category' => 'Guides', 'sort_order' => 41, 'status' => 'published', 'views_count' => 12098, 'body' => "## Dark Mode\n\nGsmUi supports dark mode out of the box.\n\n## Setup\n\nAdd the dark class to your HTML element or use the system preference detector."],
            ['title' => 'Accessibility', 'slug' => 'accessibility', 'category' => 'Guides', 'sort_order' => 42, 'status' => 'published', 'views_count' => 7654, 'body' => "## Accessibility Guide\n\nGsmUi follows WCAG 2.1 AA standards.\n\n## Key Features\n\n- Semantic HTML\n- ARIA attributes\n- Keyboard navigation\n- Focus management"],
            ['title' => 'Performance', 'slug' => 'performance', 'category' => 'Guides', 'sort_order' => 43, 'status' => 'published', 'views_count' => 6543, 'body' => "## Performance Tips\n\n- Lazy load components\n- Debounce wire:model\n- Use pagination for large datasets"],
            ['title' => 'Migration Guide', 'slug' => 'migration-guide', 'category' => 'Guides', 'sort_order' => 44, 'status' => 'published', 'views_count' => 5432, 'body' => "## Migrating to GsmUi\n\nStep-by-step guide for migrating from other component libraries."],
            ['title' => 'Contributing', 'slug' => 'contributing', 'category' => 'Community', 'sort_order' => 50, 'status' => 'published', 'views_count' => 4321, 'body' => "## Contributing Guide\n\nWe welcome contributions! Here's how to get started.\n\n1. Fork the repository\n2. Create a feature branch\n3. Submit a pull request"],
            ['title' => 'Changelog', 'slug' => 'changelog', 'category' => 'Community', 'sort_order' => 51, 'status' => 'published', 'views_count' => 8765, 'body' => "## Changelog\n\n### v2.0.0\n- 50+ new components\n- Theme system\n- Accessibility overhaul\n\n### v1.5.0\n- Performance improvements\n- Bug fixes"],
            ['title' => 'Command Palette', 'slug' => 'command-palette-doc', 'category' => 'Components', 'subcategory' => 'Overlays', 'sort_order' => 31, 'status' => 'published', 'views_count' => 9012, 'body' => "## Command Palette\n\nA Spotlight-style command palette for quick actions.\n\n## Features\n\n- Fuzzy search\n- Keyboard shortcuts\n- Custom actions"],
            ['title' => 'Calendar', 'slug' => 'calendar-doc', 'category' => 'Components', 'subcategory' => 'Form', 'sort_order' => 13, 'status' => 'published', 'views_count' => 7890, 'body' => "## Calendar Component\n\nA full-featured calendar with date selection and events.\n\n## Views\n\n- Month view\n- Week view\n- Day view"],
            ['title' => 'File Upload', 'slug' => 'file-upload-doc', 'category' => 'Components', 'subcategory' => 'Form', 'sort_order' => 14, 'status' => 'published', 'views_count' => 6789, 'body' => "## File Upload\n\nDrag-and-drop file upload with preview and progress.\n\n## Features\n\n- Multi-file support\n- Image preview\n- Progress bar\n- Validation"],
            ['title' => 'Slider', 'slug' => 'slider-doc', 'category' => 'Components', 'subcategory' => 'Form', 'sort_order' => 15, 'status' => 'published', 'views_count' => 5678, 'body' => "## Slider Component\n\nA range slider with single/dual handles and marks.\n\n## Usage\n\n```html\n<x-gsmui-slider min=\"0\" max=\"100\" wire:model=\"value\" />\n```"],
            ['title' => 'Timeline', 'slug' => 'timeline-doc', 'category' => 'Components', 'subcategory' => 'Data Display', 'sort_order' => 21, 'status' => 'published', 'views_count' => 4567, 'body' => "## Timeline Component\n\nA vertical timeline for chronological events.\n\n## Usage\n\n```html\n<x-gsmui-timeline :events=\"$events\" />\n```"],
            ['title' => 'Tabs', 'slug' => 'tabs-doc', 'category' => 'Components', 'subcategory' => 'Navigation', 'sort_order' => 25, 'status' => 'published', 'views_count' => 8234, 'body' => "## Tabs Component\n\nTabbed interface with horizontal/vertical modes.\n\n## Features\n\n- Lazy loading panels\n- Keyboard navigation\n- Animated transitions"],
            ['title' => 'Pagination', 'slug' => 'pagination-doc', 'category' => 'Components', 'subcategory' => 'Navigation', 'sort_order' => 26, 'status' => 'published', 'views_count' => 7123, 'body' => "## Pagination Component\n\nPage navigation with numbers and items-per-page.\n\n## Usage\n\n```html\n<x-gsmui-pagination :total=\"100\" :per-page=\"10\" wire:model=\"page\" />\n```"],
        ];

        foreach ($documents as $docData) {
            Document::create([...$docData, 'author_id' => $authorId]);
        }
    }
}
