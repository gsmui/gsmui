<?php

declare(strict_types=1);

namespace App\Domains\Users\Actions;

use App\Domains\Users\Models\User;
use App\Domains\Services\UserService;
use App\Infrastructure\Cache\CacheService;

class UpdateUserSettingsAction
{
    public function __construct(
        protected UserService $userService,
        protected CacheService $cache
    ) {}

    public function execute(User $user, array $settings): User
    {
        $allowedSettings = [
            'email_notifications',
            'push_notifications',
            'marketing_emails',
            'theme',
            'language',
            'timezone',
            'date_format',
            'display_name',
            'bio',
            'location',
            'website',
            'github_username',
            'twitter_username',
        ];

        $filteredSettings = array_intersect_key($settings, array_flip($allowedSettings));

        $user = $this->userService->update($user, $filteredSettings);

        $this->cache->invalidate("user_settings:{$user->id}");

        return $user;
    }
}
