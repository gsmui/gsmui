<?php

declare(strict_types=1);

namespace App\Domains\Billing\Actions;

use App\Domains\Services\BillingService;
use App\Domains\Services\NotificationService;
use App\Domains\Users\Models\User;

class CreateSubscriptionAction
{
    public function __construct(
        protected BillingService $billingService,
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, string $plan): array
    {
        $result = $this->billingService->createSubscription($user, $plan);

        $this->notificationService->send(
            $user,
            'subscription_created',
            'Subscription Activated',
            "Your {$plan} subscription has been activated successfully.",
            ['plan' => $plan],
            '/dashboard/billing'
        );

        return $result;
    }
}
