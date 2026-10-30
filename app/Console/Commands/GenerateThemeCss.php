<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domains\Themes\Models\Theme;
use App\Infrastructure\Storage\StorageService;
use Illuminate\Console\Command;

class GenerateThemeCss extends Command
{
    protected $signature = 'theme:generate-css {theme?}';
    protected $description = 'Generate CSS for themes';

    public function handle(StorageService $storage): int
    {
        $query = Theme::query()->where('status', 'published');

        if ($themeSlug = $this->argument('theme')) {
            $query->where('slug', $themeSlug);
        }

        $themes = $query->get();

        foreach ($themes as $theme) {
            $css = $this->generateCss($theme);
            $path = "themes/{$theme->slug}/theme.css";
            $storage->put($path, $css);
            $this->info("Generated CSS for theme: {$theme->name}");
        }

        return Command::SUCCESS;
    }

    protected function generateCss(Theme $theme): string
    {
        $tokens = $theme->tokens;
        $css = ':root {';
        foreach ($tokens as $key => $value) {
            $css .= "--gsmui-{$key}: {$value};";
        }
        $css .= '}';
        return $css;
    }
}
