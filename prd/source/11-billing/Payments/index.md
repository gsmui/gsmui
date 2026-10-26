# Payment Processing

## Overview

This document covers Stripe integration, payment method management, 3D Secure handling, webhook processing, and failure recovery in gsmui's billing system.

## Stripe Integration

### Configuration

```php
// config/services.php
return [
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'api_version' => '2024-04-10',
    ],
];
```

### Customer Management

```php
class StripeCustomerManager
{
    public function getOrCreate(User $user): string
    {
        if ($user->stripe_customer_id) {
            return $user->stripe_customer_id;
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        $customer = $stripe->customers->create([
            'email' => $user->email,
            'name' => $user->name,
            'metadata' => [
                'user_id' => $user->id,
            ],
        ]);

        $user->update(['stripe_customer_id' => $customer->id]);

        return $customer->id;
    }

    public function sync(User $user): void
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $stripe->customers->update($user->stripe_customer_id, [
            'email' => $user->email,
            'name' => $user->name,
        ]);
    }
}
```

## Payment Methods

### Supported Methods

| Method | Type | Currencies | 3D Secure |
|--------|------|------------|-----------|
| Visa | Card | All | Optional |
| Mastercard | Card | All | Optional |
| Amex | Card | All | Optional |
| SEPA | Bank transfer | EUR | No |
| Bancontact | Bank transfer | EUR | No |
| iDEAL | Bank transfer | EUR | No |
| Alipay | Wallet | Multi | No |
| Apple Pay | Wallet | Multi | Optional |
| Google Pay | Wallet | Multi | Optional |

### Payment Method Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `user_id` | `bigint` | FK to users |
| `stripe_id` | `string` | Stripe payment method ID |
| `type` | `string` | card, bank_account, etc. |
| `brand` | `string?` | Visa, Mastercard, etc. |
| `last_four` | `string` | Last 4 digits |
| `exp_month` | `int?` | Expiration month |
| `exp_year` | `int?` | Expiration year |
| `is_default` | `bool` | Default payment method |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

### Payment Method Operations

```php
class PaymentMethodService
{
    public function attach(User $user, string $paymentMethodId): PaymentMethod
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $stripe->paymentMethods->attach($paymentMethodId, [
            'customer' => $user->stripe_customer_id,
        ]);

        return PaymentMethod::create([
            'user_id' => $user->id,
            'stripe_id' => $paymentMethodId,
            'type' => $this->resolveType($paymentMethodId),
            'is_default' => !$user->paymentMethods()->exists(),
        ]);
    }

    public function setDefault(User $user, PaymentMethod $method): void
    {
        $user->paymentMethods()->update(['is_default' => false]);
        $method->update(['is_default' => true]);

        $stripe = new StripeClient(config('services.stripe.secret'));
        $stripe->customers->update($user->stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $method->stripe_id,
            ],
        ]);
    }

    public function detach(PaymentMethod $method): void
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $stripe->paymentMethods->detach($method->stripe_id);

        $method->delete();
    }
}
```

## 3D Secure

### 3DS Flow

```
┌──────────┐   create    ┌──────────┐   requires_action   ┌──────────┐
│ Client   │ ──────────► │ Stripe   │ ──────────────────► │ Client   │
│          │             │          │                      │ 3DS Form │
└──────────┘             └──────────┘                      └──────────┘
                                                          │
                                                    authorize
                                                          │
                                                          ▼
                                                   ┌──────────┐
                                                   │ Stripe   │
                                                   │ Confirmed│
                                                   └──────────┘
```

### Handling 3DS

```php
class PaymentService
{
    public function charge(Order $order): PaymentResult
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        try {
            $intent = $stripe->paymentIntents->create([
                'amount' => $order->total,
                'currency' => strtolower($order->currency),
                'customer' => $order->user->stripe_customer_id,
                'payment_method' => $order->paymentMethod->stripe_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('checkout.3ds-return'),
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            if ($intent->status === 'requires_action') {
                return new PaymentResult(
                    status: 'requires_action',
                    clientSecret: $intent->client_secret,
                );
            }

            return new PaymentResult(
                status: 'succeeded',
                transactionId: $intent->id,
            );
        } catch (CardException $e) {
            return new PaymentResult(
                status: 'failed',
                error: $e->getMessage(),
            );
        }
    }
}
```

### 3DS Return Handler

```php
class ThreeDsReturnController extends Controller
{
    public function handle(Request $request)
    {
        $intent = $request->input('payment_intent');
        $status = $request->input('payment_intent_client_secret');

        $stripe = new StripeClient(config('services.stripe.secret'));
        $intent = $stripe->paymentIntents->retrieve($intent);

        $order = Order::where('stripe_payment_intent', $intent->id)->first();

        if ($intent->status === 'succeeded') {
            $order->transitionTo('paid');
            return redirect()->route('checkout.complete', $order);
        }

        return redirect()->route('checkout.payment')
            ->withErrors(['payment' => 'Payment verification failed.']);
    }
}
```

## Webhooks

### Webhook Events

| Event | Description | Action |
|-------|-------------|--------|
| `payment_intent.succeeded` | Payment completed | Mark order as paid |
| `payment_intent.payment_failed` | Payment failed | Notify customer, retry |
| `customer.subscription.created` | Subscription started | Activate subscription |
| `customer.subscription.updated` | Subscription changed | Update subscription |
| `customer.subscription.deleted` | Subscription cancelled | Deactivate subscription |
| `invoice.paid` | Invoice paid | Record payment |
| `invoice.payment_failed` | Invoice payment failed | Retry, notify |
| `charge.refunded` | Refund processed | Update order status |

### Webhook Handler

```php
class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (Exception $e) {
            return response('Invalid signature', 400);
        }

        return match ($event->type) {
            'payment_intent.succeeded' => $this->handlePaymentSuccess($event->data->object),
            'payment_intent.payment_failed' => $this->handlePaymentFailure($event->data->object),
            'customer.subscription.created' => $this->handleSubscriptionCreated($event->data->object),
            'customer.subscription.updated' => $this->handleSubscriptionUpdated($event->data->object),
            'customer.subscription.deleted' => $this->handleSubscriptionDeleted($event->data->object),
            'invoice.paid' => $this->handleInvoicePaid($event->data->object),
            'invoice.payment_failed' => $this->handleInvoiceFailed($event->data->object),
            'charge.refunded' => $this->handleRefund($event->data->object),
            default => response('Unhandled event', 200),
        };
    }

    protected function handlePaymentSuccess(object $paymentIntent): Response
    {
        $order = Order::where('stripe_payment_intent', $paymentIntent->id)->first();

        if ($order && $order->status === 'pending') {
            $order->transitionTo('paid');
        }

        return response('OK', 200);
    }

    protected function handlePaymentFailure(object $paymentIntent): Response
    {
        $order = Order::where('stripe_payment_intent', $paymentIntent->id)->first();

        if ($order) {
            event(new PaymentFailed($order, $paymentIntent->last_payment_error));
        }

        return response('OK', 200);
    }
}
```

## Failure Handling

### Retry Strategy

```php
class PaymentRetryService
{
    protected array $retrySchedule = [
        1 => 0,      // immediate
        2 => 3600,   // 1 hour
        3 => 86400,  // 1 day
        4 => 259200, // 3 days
        5 => 604800, // 7 days
    ];

    public function retry(Order $order): void
    {
        $attempt = $order->metadata['retry_count'] ?? 0;

        if ($attempt >= count($this->retrySchedule)) {
            $this->maxRetriesReached($order);
            return;
        }

        $delay = $this->retrySchedule[$attempt + 1];

        PaymentRetryJob::dispatch($order)
            ->delay(now()->addSeconds($delay));

        $order->update([
            'metadata' => array_merge($order->metadata ?? [], [
                'retry_count' => $attempt + 1,
                'next_retry_at' => now()->addSeconds($delay),
            ]),
        ]);
    }

    protected function maxRetriesReached(Order $order): void
    {
        $order->update(['status' => 'failed']);
        event(new PaymentRetriesExhausted($order));
    }
}
```

### Failure Notifications

```php
class PaymentFailedNotification extends Notification
{
    public function __construct(
        protected Order $order,
        protected string $reason
    ) {}

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Failed')
            ->line('Your payment for Order #' . $this->order->number . ' failed.')
            ->line('Reason: ' . $this->reason)
            ->action('Update Payment Method', route('billing.payment-methods'))
            ->line('Please update your payment method to avoid service interruption.');
    }
}
```

## Best Practices

1. **Use Stripe's test mode** for all development and staging
2. **Handle webhooks idempotently** — check if order is already processed
3. **Retry failed payments** — use exponential backoff
4. **Notify customers** immediately on payment failure
5. **Store payment method references** — not raw card data
6. **Use 3D Secure** when required by SCA regulations
7. **Test with Playwright** — verify the complete payment flow
