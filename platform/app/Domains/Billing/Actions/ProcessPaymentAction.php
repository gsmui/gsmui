<?php

declare(strict_types=1);

namespace App\Domains\Billing\Actions;

use App\Domains\Billing\Models\Invoice;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;
use App\Infrastructure\Payments\StripeService;
use App\Domains\Billing\Events\PaymentCompleted;

class ProcessPaymentAction
{
    public function __construct(
        protected StripeService $stripe,
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, Invoice $invoice): array
    {
        $paymentResult = $this->stripe->createPaymentIntent(
            $user,
            $invoice->total,
            "Invoice #{$invoice->invoice_number}"
        );

        $invoice->update([
            'payment_id' => $paymentResult['payment_intent_id'],
            'status' => 'processing',
        ]);

        event(new PaymentCompleted($invoice));

        $this->notificationService->send(
            $user,
            'payment_processing',
            'Payment Processing',
            "Your payment of $" . number_format($invoice->total, 2) . " is being processed.",
            ['invoice_id' => $invoice->id],
            '/dashboard/billing/invoices/' . $invoice->id
        );

        return [
            'invoice' => $invoice,
            'client_secret' => $paymentResult['client_secret'],
        ];
    }

    public function markCompleted(Invoice $invoice): Invoice
    {
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return $invoice;
    }

    public function markFailed(Invoice $invoice, string $reason): Invoice
    {
        $invoice->update([
            'status' => 'failed',
            'metadata' => array_merge($invoice->metadata ?? [], [
                'failure_reason' => $reason,
            ]),
        ]);

        return $invoice;
    }
}
