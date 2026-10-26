<?php

declare(strict_types=1);

namespace App\Domains\Users\Listeners;

use App\Domains\Users\Events\UserRegistered;
use App\Infrastructure\Mail\EmailService;

class SendWelcomeEmail
{
    public function __construct(
        protected EmailService $emailService
    ) {}

    public function handle(UserRegistered $event): void
    {
        $this->emailService->sendWelcome($event->user);
    }
}
