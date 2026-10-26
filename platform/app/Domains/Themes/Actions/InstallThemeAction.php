<?php

declare(strict_types=1);

namespace App\Domains\Themes\Actions;

use App\Domains\Themes\Models\Theme;
use App\Domains\Themes\Models\ThemeDownload;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;
use App\Domains\Services\ThemeService;
use App\Infrastructure\Cache\CacheService;

class InstallThemeAction
{
    public function __construct(
        protected ThemeService $themeService,
        protected NotificationService $notificationService,
        protected CacheService $cache
    ) {}

    public function execute(User $user, Theme $theme): ThemeDownload
    {
        $existingDownload = ThemeDownload::where('user_id', $user->id)
            ->where('theme_id', $theme->id)
            ->first();

        if ($existingDownload) {
            $existingDownload->update(['downloaded_at' => now()]);

            return $existingDownload;
        }

        $download = ThemeDownload::create([
            'user_id' => $user->id,
            'theme_id' => $theme->id,
            'downloaded_at' => now(),
        ]);

        $this->themeService->recordDownload($theme);

        $this->cache->invalidate("theme:{$theme->slug}");

        $this->notificationService->send(
            $user,
            'theme_installed',
            'Theme Installed',
            "You have successfully installed the theme \"{$theme->name}\".",
            ['theme_id' => $theme->id],
            '/dashboard/themes'
        );

        return $download;
    }
}
