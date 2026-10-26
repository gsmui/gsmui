# Invoice Generation

## Overview

Invoices document transactions between your business and customers. This document covers invoice creation, line items, tax calculation, PDF generation, email delivery, and payment tracking.

## Invoice Model

```php
class Invoice extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'number', 'status',
        'subtotal', 'tax', 'discount', 'total',
        'currency', 'due_at', 'paid_at',
        'billing_name', 'billing_email',
        'billing_address', 'metadata',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'tax' => 'integer',
        'discount' => 'integer',
        'total' => 'integer',
        'billing_address' => 'array',
        'metadata' => 'array',
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(InvoicePayment::class);
    }
}
```

## Line Items

### Invoice Item Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `invoice_id` | `bigint` | FK to invoices |
| `description` | `string` | Item description |
| `quantity` | `int` | |
| `unit_price` | `bigint` | In cents |
| `amount` | `bigint` | quantity × unit_price |
| `tax_rate` | `int?` | Tax rate in basis points |
| `tax_amount` | `bigint` | Calculated tax |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |

### Adding Line Items

```php
class InvoiceBuilder
{
    public function addItem(Invoice $invoice, array $data): InvoiceItem
    {
        $amount = $data['quantity'] * $data['unit_price'];
        $taxAmount = $this->calculateTax($amount, $data['tax_rate'] ?? 0);

        return $invoice->items()->create([
            'description' => $data['description'],
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'amount' => $amount,
            'tax_rate' => $data['tax_rate'] ?? 0,
            'tax_amount' => $taxAmount,
            'metadata' => $data['metadata'] ?? [],
        ]);
    }

    public function addSubscription(Invoice $invoice, Subscription $sub): InvoiceItem
    {
        return $this->addItem($invoice, [
            'description' => "{$sub->plan->name} ({$sub->billingPeriod()})",
            'quantity' => 1,
            'unit_price' => $sub->price->amount,
            'tax_rate' => $this->resolveTaxRate($sub->user),
        ]);
    }

    public function addUsage(Invoice $invoice, string $description, int $quantity, int $unitPrice): InvoiceItem
    {
        return $this->addItem($invoice, [
            'description' => $description,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'tax_rate' => 0,
        ]);
    }
}
```

## Tax Calculation

### Tax Service

```php
class TaxCalculator
{
    public function calculate(Invoice $invoice): TaxResult
    {
        $items = $invoice->items;
        $totalTax = 0;

        foreach ($items as $item) {
            $taxRate = $item->tax_rate ?? $this->resolveRate($invoice->user, $item);
            $item->update(['tax_amount' => (int) ($item->amount * $taxRate / 10000)]);
            $totalTax += $item->tax_amount;
        }

        return new TaxResult(
            tax: $totalTax,
            breakdown: $this->getBreakdown($items),
        );
    }

    protected function resolveRate(User $user, InvoiceItem $item): int
    {
        // Check tax exemptions
        if ($user->isTaxExempt()) {
            return 0;
        }

        // Resolve based on customer location
        return TaxService::getRate(
            country: $user->billingCountry,
            state: $user->billingState,
            taxClass: $item->metadata['tax_class'] ?? 'standard',
        );
    }
}
```

### Tax Rate Table

| Country | Standard Rate | Reduced Rate | Digital Services |
|---------|--------------|--------------|------------------|
| US | Varies by state | Varies | Varies |
| UK | 20% | 5% | 20% |
| EU (default) | 21% | 9% | 21% |
| Canada | 5% (GST) | Varies | 5% |
| Australia | 10% | — | 10% |

## PDF Generation

### Invoice PDF Template

```php
class InvoicePdfGenerator
{
    public function generate(Invoice $invoice): string
    {
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'items' => $invoice->items,
            'company' => config('company'),
        ]);

        $filename = "invoice-{$invoice->number}.pdf";
        $path = storage_path("app/invoices/{$filename}");

        $pdf->save($path);

        return $path;
    }
}
```

### PDF Blade Template

```php
<!-- resources/views/invoices/pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .invoice-number { font-size: 24px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f5f5f5; }
        .totals { text-align: right; margin-top: 20px; }
        .total-row { font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>INVOICE</h1>
            <p>#{{ $invoice->number }}</p>
            <p>Date: {{ $invoice->created_at->format('M d, Y') }}</p>
            <p>Due: {{ $invoice->due_at->format('M d, Y') }}</p>
        </div>
        <div>
            <h2>{{ $company['name'] }}</h2>
            <p>{{ $company['address'] }}</p>
            <p>{{ $company['email'] }}</p>
        </div>
    </div>

    <h3>Bill To</h3>
    <p>{{ $invoice->billing_name }}</p>
    <p>{{ $invoice->billing_email }}</p>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ money($item->unit_price) }}</td>
                <td>{{ money($item->amount) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>Subtotal: {{ money($invoice->subtotal) }}</p>
        <p>Tax: {{ money($invoice->tax) }}</p>
        @if($invoice->discount > 0)
        <p>Discount: -{{ money($invoice->discount) }}</p>
        @endif
        <p class="total-row">Total: {{ money($invoice->total) }}</p>
    </div>
</body>
</html>
```

## Email Delivery

### Invoice Email

```php
class InvoiceMail extends Mailable
{
    public function __construct(
        protected Invoice $invoice,
        protected ?string $pdfPath = null,
    ) {}

    public function build(): Mailable
    {
        $mail = $this->subject("Invoice #{$this->invoice->number}")
            ->view('emails.invoice', [
                'invoice' => $this->invoice,
                'amount' => money($this->invoice->total),
                'dueDate' => $this->invoice->due_at->format('M d, Y'),
            ]);

        if ($this->pdfPath) {
            $mail->attach($this->pdfPath, [
                'as' => "invoice-{$this->invoice->number}.pdf",
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
```

### Scheduled Invoice Delivery

```php
class InvoiceDeliveryCommand extends Command
{
    protected $signature = 'invoices:send-due';

    public function handle(): int
    {
        $dueInvoices = Invoice::where('status', 'sent')
            ->where('due_at', '<=', now()->addDays(3))
            ->with('user')
            ->get();

        foreach ($dueInvoices as $invoice) {
            InvoiceReminderMail::send($invoice);
        }

        $this->info("Sent {$dueInvoices->count()} reminder emails");

        return Command::SUCCESS;
    }
}
```

## Payment Tracking

### Invoice Payments

```php
class InvoicePayment extends Model
{
    protected $fillable = [
        'invoice_id', 'transaction_id', 'amount',
        'method', 'status', 'paid_at', 'metadata',
    ];

    protected $casts = [
        'amount' => 'integer',
        'paid_at' => 'datetime',
        'metadata' => 'array',
    ];
}

class InvoicePaymentTracker
{
    public function recordPayment(Invoice $invoice, array $data): InvoicePayment
    {
        $payment = $invoice->payments()->create([
            'transaction_id' => $data['transaction_id'],
            'amount' => $data['amount'],
            'method' => $data['method'],
            'status' => 'completed',
            'paid_at' => now(),
            'metadata' => $data['metadata'] ?? [],
        ]);

        $this->updateInvoiceStatus($invoice);

        return $payment;
    }

    protected function updateInvoiceStatus(Invoice $invoice): void
    {
        $totalPaid = $invoice->payments()->sum('amount');

        if ($totalPaid >= $invoice->total) {
            $invoice->update(['status' => 'paid', 'paid_at' => now()]);
        } elseif ($totalPaid > 0) {
            $invoice->update(['status' => 'partial']);
        }
    }
}
```

## Invoice Schema

### Invoices Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `user_id` | `bigint` | FK to users |
| `order_id` | `bigint?` | FK to orders |
| `number` | `string` | Unique invoice number |
| `status` | `enum` | draft / sent / paid / partial / overdue / void |
| `subtotal` | `bigint` | Before tax |
| `tax` | `bigint` | Tax amount |
| `discount` | `bigint` | Discount amount |
| `total` | `bigint` | Final amount |
| `currency` | `string` | ISO 4217 |
| `due_at` | `timestamp?` | |
| `paid_at` | `timestamp?` | |
| `billing_name` | `string` | |
| `billing_email` | `string` | |
| `billing_address` | `json` | |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Generate unique invoice numbers** — sequential with prefix
2. **Include all required tax information** for compliance
3. **Store PDFs** — don't regenerate on every request
4. **Send reminders** before and after due dates
5. **Track partial payments** — support installments
6. **Void, don't delete** — preserves audit trail
