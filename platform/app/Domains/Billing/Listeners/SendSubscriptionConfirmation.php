<?php

declare(strict_types=1);

namespace App\Domains\Billing\Listeners;

use App\Domains\Billing\Events\SubscriptionActivated;
use App\Infrastructure\Mail\EmailService;

class SendSubscriptionConfirmation
{
    public function __construct(
        protected EmailService $emailService
    ) {}

    public function handle(SubscriptionActivated $event): void
    {
        $this->emailService->sendSubscriptionConfirmation(
            $event->user,
            $event->subscription
        );
    }
}
