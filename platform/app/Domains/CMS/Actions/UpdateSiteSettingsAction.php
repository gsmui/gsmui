<?php

declare(strict_types=1);

namespace App\Domains\CMS\Actions;

use App\Domains\CMS\Models\SiteSetting;
use App\Infrastructure\Cache\CacheService;

class UpdateSiteSettingsAction
{
    public function __construct(
        protected CacheService $cache
    ) {}

    public function execute(array $settings): array
    {
        $updated = [];

        foreach ($settings as $key => $value) {
            $setting = SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );

            $updated[$key] = $setting;
        }

        $this->cache->invalidate('site_settings');

        return $updated;
    }
}
