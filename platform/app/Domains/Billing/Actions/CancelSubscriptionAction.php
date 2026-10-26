<?php

declare(strict_types=1);

namespace App\Domains\Billing\Actions;

use App\Domains\Services\BillingService;
use App\Domains\Services\NotificationService;
use App\Domains\Users\Models\User;

class CancelSubscriptionAction
{
    public function __construct(
        protected BillingService $billingService,
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user): void
    {
        $this->billingService->cancelSubscription($user);

        $this->notificationService->send(
            $user,
            'subscription_cancelled',
            'Subscription Cancelled',
            'Your subscription has been cancelled successfully.',
            [],
            '/dashboard/billing'
        );
    }
}
