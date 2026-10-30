<?php

declare(strict_types=1);

namespace App\Domains\Themes\Events;

use App\Domains\Themes\Models\Theme;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThemePublished
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Theme $theme
    ) {}
}
