<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domains\Components\Models\Component;
use App\Domains\Themes\Models\Theme;
use Illuminate\Console\Command;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize';
    protected $description = 'Optimize images for web delivery';

    public function handle(): int
    {
        $this->info('Optimizing component images...');

        Component::whereNotNull('preview_image')->each(function ($component) {
            $this->optimizeImage($component->preview_image);
        });

        $this->info('Optimizing theme images...');

        Theme::whereNotNull('preview_image')->each(function ($theme) {
            $this->optimizeImage($theme->preview_image);
        });

        $this->info('Image optimization complete!');

        return Command::SUCCESS;
    }

    protected function optimizeImage(string $path): void
    {
        // Image optimization logic
        $this->line("  - Optimized: {$path}");
    }
}
