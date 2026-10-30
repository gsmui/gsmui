<?php

declare(strict_types=1);

namespace App\Infrastructure\Payments;

use App\Domains\Users\Models\User;
use App\Domains\Billing\Models\Subscription;
use App\Domains\Billing\Models\Invoice;
use App\Shared\ValueObjects\Money;
use RuntimeException;

class StripeService
{
    protected ?object $stripe = null;

    /**
     * Resolve the Stripe client on first use so the container can build this
     * service (and the app can boot) without the Stripe SDK or an API key.
     */
    protected function client(): object
    {
        if ($this->stripe !== null) {
            return $this->stripe;
        }

        if (! class_exists(\Stripe\StripeClient::class)) {
            throw new RuntimeException(
                'Stripe support is not installed. Run: composer require stripe/stripe-php'
            );
        }

        $secret = config('services.stripe.secret');

        if (blank($secret)) {
            throw new RuntimeException('Stripe is not configured. Set STRIPE_SECRET in your .env file.');
        }

        return $this->stripe = new \Stripe\StripeClient($secret);
    }

    /**
     * Create a Stripe customer for a user.
     */
    public function createCustomer(User $user): string
    {
        $customer = $this->client()->customers->create([
            'email' => $user->email,
            'name' => $user->name,
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);

        return $customer->id;
    }

    /**
     * Create a subscription.
     */
    public function createSubscription(User $user, string $priceId): array
    {
        $customerId = $user->stripe_id ?? $this->createCustomer($user);

        $subscription = $this->client()->subscriptions->create([
            'customer' => $customerId,
            'items' => [['price' => $priceId]],
            'payment_behavior' => 'default_incomplete',
            'expand' => ['latest_invoice.payment_intent'],
        ]);

        return [
            'subscription_id' => $subscription->id,
            'client_secret' => $subscription->latest_invoice->payment_intent->client_secret,
        ];
    }

    /**
     * Cancel a subscription.
     */
    public function cancelSubscription(string $subscriptionId): void
    {
        $this->client()->subscriptions->cancel($subscriptionId);
    }

    /**
     * Create a payment intent for one-time purchase.
     */
    public function createPaymentIntent(User $user, Money $amount, string $description): array
    {
        $paymentIntent = $this->client()->paymentIntents->create([
            'amount' => $amount->cents(),
            'currency' => strtolower($amount->currency()),
            'customer' => $user->stripe_id,
            'description' => $description,
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);

        return [
            'payment_intent_id' => $paymentIntent->id,
            'client_secret' => $paymentIntent->client_secret,
        ];
    }

    /**
     * Handle webhook event.
     */
    public function handleWebhook(array $payload): void
    {
        $type = $payload['type'] ?? '';
        $data = $payload['data']['object'] ?? [];

        match ($type) {
            'customer.subscription.created' => $this->handleSubscriptionCreated($data),
            'customer.subscription.updated' => $this->handleSubscriptionUpdated($data),
            'customer.subscription.deleted' => $this->handleSubscriptionDeleted($data),
            'invoice.paid' => $this->handleInvoicePaid($data),
            'invoice.payment_failed' => $this->handleInvoicePaymentFailed($data),
            default => null,
        };
    }

    protected function handleSubscriptionCreated(array $data): void
    {
        Subscription::create([
            'user_id' => $data['metadata']['user_id'] ?? 0,
            'stripe_id' => $data['id'],
            'stripe_plan' => $data['items']['data'][0]['price']['id'] ?? '',
            'status' => $data['status'],
            'quantity' => $data['quantity'] ?? 1,
        ]);
    }

    protected function handleSubscriptionUpdated(array $data): void
    {
        Subscription::where('stripe_id', $data['id'])->update([
            'status' => $data['status'],
            'ends_at' => isset($data['cancel_at']) ? date('Y-m-d H:i:s', $data['cancel_at']) : null,
        ]);
    }

    protected function handleSubscriptionDeleted(array $data): void
    {
        Subscription::where('stripe_id', $data['id'])->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    protected function handleInvoicePaid(array $data): void
    {
        Invoice::create([
            'user_id' => $data['metadata']['user_id'] ?? 0,
            'stripe_id' => $data['id'],
            'amount' => $data['amount_paid'] / 100,
            'currency' => strtoupper($data['currency']),
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    protected function handleInvoicePaymentFailed(array $data): void
    {
        Invoice::create([
            'user_id' => $data['metadata']['user_id'] ?? 0,
            'stripe_id' => $data['id'],
            'amount' => $data['amount_due'] / 100,
            'currency' => strtoupper($data['currency']),
            'status' => 'failed',
        ]);
    }
}
