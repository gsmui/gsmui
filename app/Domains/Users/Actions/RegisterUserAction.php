<?php

declare(strict_types=1);

namespace App\Domains\Users\Actions;

use App\Domains\Services\UserService;
use App\Infrastructure\Mail\EmailService;
use App\Domains\Users\Models\User;

class RegisterUserAction
{
    public function __construct(
        protected UserService $userService,
        protected EmailService $emailService
    ) {}

    public function execute(array $data): User
    {
        $user = $this->userService->create($data);

        $this->emailService->sendWelcome($user);

        return $user;
    }
}
