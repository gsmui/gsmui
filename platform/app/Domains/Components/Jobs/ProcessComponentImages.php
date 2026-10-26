<?php

declare(strict_types=1);

namespace App\Domains\Components\Jobs;

use App\Domains\Components\Models\Component;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessComponentImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Component $component
    ) {}

    public function handle(): void
    {
        if ($this->component->preview_image) {
            $this->optimizeImage($this->component->preview_image);
        }
    }

    protected function optimizeImage(string $path): void
    {
        // Image optimization logic
        // - Resize to optimal dimensions
        // - Compress for web
        // - Generate thumbnails
        // - Create WebP version
    }
}
