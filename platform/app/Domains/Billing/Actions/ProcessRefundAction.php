<?php

declare(strict_types=1);

namespace App\Domains\Billing\Actions;

use App\Domains\Billing\Models\Invoice;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;
use App\Infrastructure\Payments\StripeService;

class ProcessRefundAction
{
    public function __construct(
        protected StripeService $stripe,
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, Invoice $invoice, ?string $reason = null): Invoice
    {
        if ($invoice->status !== 'paid') {
            throw new \LogicException('Can only refund paid invoices.');
        }

        $refundResult = $this->stripe->createRefund(
            $invoice->payment_id,
            $invoice->total,
            $reason
        );

        $invoice->update([
            'status' => 'refunded',
            'refunded_at' => now(),
            'refund_id' => $refundResult['refund_id'],
            'metadata' => array_merge($invoice->metadata ?? [], [
                'refund_reason' => $reason,
            ]),
        ]);

        $this->notificationService->send(
            $user,
            'refund_processed',
            'Refund Processed',
            "A refund of $" . number_format($invoice->total, 2) . " has been processed for Invoice #{$invoice->invoice_number}.",
            ['invoice_id' => $invoice->id, 'refund_id' => $refundResult['refund_id']],
            '/dashboard/billing/invoices/' . $invoice->id
        );

        return $invoice;
    }
}
