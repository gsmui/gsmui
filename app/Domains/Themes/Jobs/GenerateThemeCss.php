<?php

declare(strict_types=1);

namespace App\Domains\Themes\Jobs;

use App\Domains\Themes\Models\Theme;
use App\Infrastructure\Storage\StorageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateThemeCss implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Theme $theme
    ) {}

    public function handle(StorageService $storage): void
    {
        $css = $this->generateCss();

        $path = "themes/{$this->theme->slug}/theme.css";
        $storage->put($path, $css);
    }

    protected function generateCss(): string
    {
        $tokens = $this->theme->tokens;
        $css = ':root {';
        foreach ($tokens as $key => $value) {
            $css .= "--gsmui-{$key}: {$value};";
        }
        $css .= '}';
        return $css;
    }
}
