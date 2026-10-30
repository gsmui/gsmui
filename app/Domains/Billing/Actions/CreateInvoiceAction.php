<?php

declare(strict_types=1);

namespace App\Domains\Billing\Actions;

use App\Domains\Billing\Models\Invoice;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;
use App\Infrastructure\Mail\EmailService;

class CreateInvoiceAction
{
    public function __construct(
        protected NotificationService $notificationService,
        protected EmailService $emailService
    ) {}

    public function execute(User $user, array $items, array $metadata = []): Invoice
    {
        $subtotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = $subtotal * (config('billing.tax_rate', 0) / 100);
        $total = $subtotal + $tax;

        $invoice = Invoice::create([
            'user_id' => $user->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'currency' => 'USD',
            'status' => 'pending',
            'metadata' => $metadata,
        ]);

        $this->emailService->sendInvoice($user, $invoice);

        $this->notificationService->send(
            $user,
            'invoice_created',
            'New Invoice',
            "Invoice #{$invoice->invoice_number} has been created for $" . number_format($total, 2),
            ['invoice_id' => $invoice->id],
            '/dashboard/billing/invoices/' . $invoice->id
        );

        return $invoice;
    }

    protected function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $date = now()->format('Ym');
        $sequence = Invoice::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count() + 1;

        return "{$prefix}-{$date}-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
