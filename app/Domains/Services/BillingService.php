<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Users\Models\User;
use App\Domains\Billing\Models\Subscription;
use App\Domains\Billing\Models\Invoice;
use App\Infrastructure\Payments\StripeService;
use App\Infrastructure\Mail\EmailService;

class BillingService
{
    public function __construct(
        protected StripeService $stripe,
        protected EmailService $emailService
    ) {}

    public function createSubscription(User $user, string $plan): array
    {
        $priceId = config("billing.plans.{$plan}.price_id");

        if (!$priceId) {
            throw new \InvalidArgumentException("Invalid plan: {$plan}");
        }

        $result = $this->stripe->createSubscription($user, $priceId);

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'stripe_id' => $result['subscription_id'],
            'stripe_plan' => $priceId,
            'status' => 'active',
        ]);

        $this->emailService->sendSubscriptionConfirmation($user, $subscription);

        return $result;
    }

    public function cancelSubscription(User $user): void
    {
        $subscription = $user->subscription;

        if (!$subscription || !$subscription->is_active) {
            throw new \LogicException('No active subscription found');
        }

        $this->stripe->cancelSubscription($subscription->stripe_id);

        $subscription->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    public function getSubscription(User $user): ?Subscription
    {
        return $user->subscription;
    }

    public function isInvoices(User $user)
    {
        return $user->invoices()->orderBy('created_at', 'desc')->get();
    }

    public function handleWebhook(array $payload): void
    {
        $this->stripe->handleWebhook($payload);
    }
}
