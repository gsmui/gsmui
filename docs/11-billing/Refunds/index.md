# Refund Policy

## Overview

This document covers refund processing, full and partial refunds, the credit system, and dispute handling in gsmui's billing system.

## Refund Types

| Type | Description | Use Case |
|------|-------------|----------|
| `full` | Complete order refund | Order cancelled, defective product |
| `partial` | Portion of order refunded | Partial return, service credit |
| `credit` | Store credit issued | Customer goodwill |
| `chargeback` | Disputed by customer | Bank-initiated dispute |

## Refund Model

```php
class Refund extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'amount', 'reason',
        'type', 'status', 'stripe_refund_id',
        'notes', 'processed_by', 'metadata',
    ];

    protected $casts = [
        'amount' => 'integer',
        'metadata' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### Refund Status Flow

```
┌──────────┐   process   ┌──────────┐   complete   ┌──────────┐
│ Pending  │ ──────────► │ Processed│ ────────────► │ Complete │
└──────────┘              └──────────┘               └──────────┘
     │                         │
     │ reject                  │ fail
     ▼                         ▼
┌──────────┐              ┌──────────┐
│ Rejected │              │ Failed   │
└──────────┘              └──────────┘
```

## Full Refunds

### Processing a Full Refund

```php
class RefundService
{
    public function fullRefund(Order $order, string $reason, User $processedBy): Refund
    {
        $this->validateRefund($order);

        $refund = Refund::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'amount' => $order->total,
            'reason' => $reason,
            'type' => 'full',
            'status' => 'pending',
            'processed_by' => $processedBy->id,
        ]);

        try {
            $stripe = new StripeClient(config('services.stripe.secret'));

            $stripeRefund = $stripe->refunds->create([
                'payment_intent' => $order->stripe_payment_intent,
                'amount' => $order->total,
                'reason' => $this->mapReason($reason),
            ]);

            $refund->update([
                'status' => 'complete',
                'stripe_refund_id' => $stripeRefund->id,
            ]);

            $order->transitionTo('refunded');

            event(new RefundProcessed($refund));

            return $refund;
        } catch (Exception $e) {
            $refund->update(['status' => 'failed', 'notes' => $e->getMessage()]);
            throw $e;
        }
    }

    protected function validateRefund(Order $order): void
    {
        if (in_array($order->status, ['pending', 'cancelled'])) {
            throw new InvalidRefundException('Cannot refund pending or cancelled orders.');
        }

        $alreadyRefunded = $order->refunds()
            ->where('status', 'complete')
            ->sum('amount');

        if ($alreadyRefunded >= $order->total) {
            throw new InvalidRefundException('Order has already been fully refunded.');
        }
    }
}
```

## Partial Refunds

### Partial Refund Processing

```php
class PartialRefundService
{
    public function partialRefund(Order $order, int $amount, string $reason, User $processedBy): Refund
    {
        $this->validatePartialRefund($order, $amount);

        $refund = Refund::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'amount' => $amount,
            'reason' => $reason,
            'type' => 'partial',
            'status' => 'pending',
            'processed_by' => $processedBy->id,
        ]);

        $stripe = new StripeClient(config('services.stripe.secret'));

        $stripeRefund = $stripe->refunds->create([
            'payment_intent' => $order->stripe_payment_intent,
            'amount' => $amount,
        ]);

        $refund->update([
            'status' => 'complete',
            'stripe_refund_id' => $stripeRefund->id,
        ]);

        // Check if fully refunded after this
        $totalRefunded = $order->refunds()
            ->where('status', 'complete')
            ->sum('amount');

        if ($totalRefunded >= $order->total) {
            $order->transitionTo('refunded');
        } else {
            $order->update(['status' => 'partial_refund']);
        }

        event(new RefundProcessed($refund));

        return $refund;
    }

    protected function validatePartialRefund(Order $order, int $amount): void
    {
        $alreadyRefunded = $order->refunds()
            ->where('status', 'complete')
            ->sum('amount');

        if ($alreadyRefunded + $amount > $order->total) {
            throw new InvalidRefundException(
                'Refund amount exceeds available balance. Maximum: ' . ($order->total - $alreadyRefunded)
            );
        }
    }
}
```

## Credit System

### Store Credit

```php
class Credit extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'balance',
        'reason', 'expires_at', 'metadata',
    ];

    protected $casts = [
        'amount' => 'integer',
        'balance' => 'integer',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];
}

class CreditService
{
    public function issue(User $user, int $amount, string $reason, ?Carbon $expiresAt = null): Credit
    {
        return Credit::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'balance' => $amount,
            'reason' => $reason,
            'expires_at' => $expiresAt,
        ]);
    }

    public function apply(Credit $credit, Order $order): int
    {
        $applicable = min($credit->balance, $order->total);

        $credit->decrement('balance', $applicable);

        // Apply to order
        $order->update([
            'discount' => $order->discount + $applicable,
            'total' => $order->total - $applicable,
        ]);

        // Record credit usage
        CreditUsage::create([
            'credit_id' => $credit->id,
            'order_id' => $order->id,
            'amount' => $applicable,
        ]);

        return $applicable;
    }

    public function getBalance(User $user): int
    {
        return Credit::where('user_id', $user->id)
            ->where('balance', '>', 0)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->sum('balance');
    }
}
```

## Dispute Handling

### Chargeback Flow

```
┌──────────┐   dispute    ┌──────────┐   evidence   ┌──────────┐
│ Customer │ ──────────► │ Stripe   │ ────────────► │ Resolved │
│ (bank)   │              │ Dispute  │               │          │
└──────────┘              └──────────┘               └──────────┘
                                │
                          lose dispute
                                │
                                ▼
                          ┌──────────┐
                          │ Refunded │
                          └──────────┘
```

### Dispute Management

```php
class DisputeService
{
    public function handleDispute(Dispute $dispute): void
    {
        // Notify admin immediately
        Notification::send(
            User::role('admin')->get(),
            new DisputeNotification($dispute)
        );

        // Auto-gather evidence
        $evidence = $this->gatherEvidence($dispute->order);

        // Submit evidence to Stripe
        $stripe = new StripeClient(config('services.stripe.secret'));

        $stripe->disputes->update($dispute->stripe_dispute_id, [
            'evidence' => [
                'customer_name' => $evidence['customer_name'],
                'customer_email' => $evidence['customer_email'],
                'shipping_tracking_number' => $evidence['tracking'] ?? null,
                'product_description' => $evidence['product_description'],
                'receipt_url' => $evidence['receipt_url'],
            ],
        ]);

        $dispute->update(['status' => 'evidence_submitted']);
    }

    protected function gatherEvidence(Order $order): array
    {
        return [
            'customer_name' => $order->user->name,
            'customer_email' => $order->user->email,
            'product_description' => $order->items->pluck('description')->join(', '),
            'receipt_url' => route('orders.receipt', $order),
            'tracking' => $order->metadata['tracking_number'] ?? null,
        ];
    }
}
```

## Refund Schema

### Refunds Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `order_id` | `bigint` | FK to orders |
| `user_id` | `bigint` | FK to users |
| `amount` | `bigint` | Refund amount in cents |
| `reason` | `string` | |
| `type` | `enum` | full / partial / credit / chargeback |
| `status` | `enum` | pending / complete / failed / rejected |
| `stripe_refund_id` | `string?` | |
| `notes` | `text?` | |
| `processed_by` | `bigint?` | FK to users |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Validate refund amounts** — prevent over-refunding
2. **Use Stripe refunds** — not manual adjustments
3. **Keep detailed notes** — every refund needs a reason
4. **Track partial refunds** — know how much of an order remains refundable
5. **Handle disputes quickly** — Stripe has strict deadlines
6. **Offer store credit** as an alternative to cash refunds
7. **Audit all refunds** — log who processed each refund
