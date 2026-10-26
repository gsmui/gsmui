<?php

declare(strict_types=1);

namespace App\Domains\Admin\Actions;

use App\Domains\System\Models\SystemSetting;
use App\Infrastructure\Cache\CacheService;

class UpdateSystemSettingsAction
{
    public function __construct(
        protected CacheService $cache
    ) {}

    public function execute(array $settings): array
    {
        $updated = [];

        foreach ($settings as $key => $value) {
            $setting = SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );

            $updated[$key] = $setting;
        }

        $this->cache->invalidate('system_settings');

        return $updated;
    }
}
