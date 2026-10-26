<?php

declare(strict_types=1);

namespace App\Domains\Themes\Actions;

use App\Domains\Themes\Models\Theme;
use App\Domains\Services\ThemeService;

class GenerateThemeTokensAction
{
    public function __construct(
        protected ThemeService $themeService
    ) {}

    public function execute(Theme $theme, array $overrides = []): string
    {
        $baseTokens = [
            'color-primary' => $theme->primary_color ?? '#3b82f6',
            'color-secondary' => $theme->secondary_color ?? '#6b7280',
            'color-accent' => $theme->accent_color ?? '#8b5cf6',
            'color-background' => $theme->background_color ?? '#ffffff',
            'color-surface' => $theme->surface_color ?? '#f9fafb',
            'color-text' => $theme->text_color ?? '#111827',
            'color-text-secondary' => $theme->text_secondary_color ?? '#6b7280',
            'border-radius' => $theme->border_radius ?? '0.5rem',
            'font-family' => $theme->font_family ?? 'Inter, system-ui, sans-serif',
            'font-size-base' => $theme->font_size_base ?? '1rem',
            'spacing-unit' => $theme->spacing_unit ?? '0.25rem',
            'shadow-sm' => $theme->shadow_sm ?? '0 1px 2px 0 rgb(0 0 0 / 0.05)',
            'shadow-md' => $theme->shadow_md ?? '0 4px 6px -1px rgb(0 0 0 / 0.1)',
            'shadow-lg' => $theme->shadow_lg ?? '0 10px 15px -3px rgb(0 0 0 / 0.1)',
        ];

        $tokens = array_merge($baseTokens, $overrides);

        $theme->update(['tokens' => $tokens]);

        $css = $this->themeService->generateCss($theme);

        return $css;
    }
}
