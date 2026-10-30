<?php

declare(strict_types=1);

namespace App\Domains\Billing\Actions;

use App\Domains\Billing\Models\Invoice;
use App\Domains\Billing\Models\Subscription;
use App\Infrastructure\Payments\StripeService;
use Illuminate\Support\Facades\Log;

class HandleWebhookAction
{
    public function __construct(
        protected StripeService $stripe,
        protected ProcessPaymentAction $processPaymentAction
    ) {}

    public function execute(array $payload): void
    {
        $type = $payload['type'] ?? null;
        $data = $payload['data']['object'] ?? null;

        if (!$type || !$data) {
            Log::warning('Invalid webhook payload', $payload);
            return;
        }

        match ($type) {
            'payment_intent.succeeded' => $this->handlePaymentSuccess($data),
            'payment_intent.payment_failed' => $this->handlePaymentFailure($data),
            'customer.subscription.created' => $this->handleSubscriptionCreated($data),
            'customer.subscription.updated' => $this->handleSubscriptionUpdated($data),
            'customer.subscription.deleted' => $this->handleSubscriptionDeleted($data),
            'invoice.paid' => $this->handleInvoicePaid($data),
            'invoice.payment_failed' => $this->handleInvoicePaymentFailed($data),
            default => Log::info("Unhandled webhook type: {$type}"),
        };
    }

    protected function handlePaymentSuccess(array $data): void
    {
        $invoice = Invoice::where('payment_id', $data['id'])->first();

        if ($invoice) {
            $this->processPaymentAction->markCompleted($invoice);
        }
    }

    protected function handlePaymentFailure(array $data): void
    {
        $invoice = Invoice::where('payment_id', $data['id'])->first();

        if ($invoice) {
            $reason = $data['last_payment_error']['message'] ?? 'Payment failed';
            $this->processPaymentAction->markFailed($invoice, $reason);
        }
    }

    protected function handleSubscriptionCreated(array $data): void
    {
        Subscription::updateOrCreate(
            ['stripe_id' => $data['id']],
            [
                'user_id' => $data['metadata']['user_id'] ?? null,
                'stripe_plan' => $data['plan']['id'] ?? null,
                'status' => $data['status'],
            ]
        );
    }

    protected function handleSubscriptionUpdated(array $data): void
    {
        $subscription = Subscription::where('stripe_id', $data['id'])->first();

        if ($subscription) {
            $subscription->update(['status' => $data['status']]);
        }
    }

    protected function handleSubscriptionDeleted(array $data): void
    {
        $subscription = Subscription::where('stripe_id', $data['id'])->first();

        if ($subscription) {
            $subscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        }
    }

    protected function handleInvoicePaid(array $data): void
    {
        $invoice = Invoice::where('payment_id', $data['payment_intent'])->first();

        if ($invoice && $invoice->status !== 'paid') {
            $this->processPaymentAction->markCompleted($invoice);
        }
    }

    protected function handleInvoicePaymentFailed(array $data): void
    {
        $invoice = Invoice::where('payment_id', $data['payment_intent'])->first();

        if ($invoice) {
            $this->processPaymentAction->markFailed($invoice, 'Invoice payment failed');
        }
    }
}
