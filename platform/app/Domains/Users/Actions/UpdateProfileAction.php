<?php

declare(strict_types=1);

namespace App\Domains\Users\Actions;

use App\Domains\Services\UserService;
use App\Domains\Users\Models\User;

class UpdateProfileAction
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function execute(User $user, array $profileData, array $userData = []): User
    {
        if (!empty($userData)) {
            $user = $this->userService->update($user, $userData);
        }

        $this->userService->updateProfile($user, $profileData);

        return $user;
    }
}
