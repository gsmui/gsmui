# Checkout Flow

## Overview

The checkout flow converts visitors into paying customers. This document covers cart management, payment processing, billing address collection, order review, and conversion optimization strategies.

## Checkout Stages

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│ Cart     │───►│ Account  │───►│ Payment  │───►│ Review   │───►│ Complete │
└──────────┘    └──────────┘    └──────────┘    └──────────┘    └──────────┘
```

### Stage Descriptions

| Stage | Description | Required |
|-------|-------------|----------|
| Cart | Add/remove items, review totals | Yes |
| Account | Login or create account | Yes |
| Payment | Enter payment method | Yes |
| Review | Confirm order details | Optional |
| Complete | Order confirmation | Yes |

## Cart Management

### Cart Model

```php
class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'coupon_code', 'metadata'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function addItem(Product $product, Price $price, int $quantity = 1): CartItem
    {
        $existing = $this->items()
            ->where('product_id', $product->id)
            ->where('price_id', $price->id)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $quantity);
            return $existing;
        }

        return $this->items()->create([
            'product_id' => $product->id,
            'price_id' => $price->id,
            'quantity' => $quantity,
            'unit_price' => $price->amount,
        ]);
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
        $this->recalculate();
    }

    public function totals(): array
    {
        $subtotal = $this->items->sum(fn ($item) => $item->quantity * $item->unit_price);
        $discount = $this->calculateDiscount($subtotal);
        $tax = $this->calculateTax($subtotal - $discount);

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $subtotal - $discount + $tax,
        ];
    }
}
```

### Cart Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `user_id` | `bigint?` | FK to users (null for guest) |
| `session_id` | `string?` | Guest session identifier |
| `coupon_code` | `string?` | Applied coupon |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

### Cart Items Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `cart_id` | `bigint` | FK to carts |
| `product_id` | `bigint` | FK to products |
| `price_id` | `bigint` | FK to prices |
| `quantity` | `int` | |
| `unit_price` | `bigint` | Price at time of adding |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Payment Method Collection

### Stripe Elements Integration

```php
// resources/views/checkout/payment.blade.php
<form id="payment-form">
    @csrf
    <div id="card-element"></div>
    <div id="card-errors"></div>
    <button type="submit">Pay {{ $totals['total'] }}</button>
</form>

<script>
const stripe = Stripe('{{ config('services.stripe.key') }}');
const elements = stripe.elements();
const card = elements.create('card');
card.mount('#card-element');

document.getElementById('payment-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const { paymentMethod, error } = await stripe.createPaymentMethod('card', card);

    if (error) {
        document.getElementById('card-errors').textContent = error.message;
    } else {
        document.getElementById('payment-method-id').value = paymentMethod.id;
        e.target.submit();
    }
});
</script>
```

### Saved Payment Methods

```php
class PaymentMethodManager
{
    public function getSavedMethods(User $user): Collection
    {
        return PaymentMethod::where('user_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->get();
    }

    public function saveMethod(User $user, string $paymentMethodId): PaymentMethod
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $paymentMethod = $stripe->paymentMethods->retrieve($paymentMethodId);
        $paymentMethod->attach(['customer' => $user->stripe_customer_id]);

        return PaymentMethod::create([
            'user_id' => $user->id,
            'stripe_id' => $paymentMethod->id,
            'type' => $paymentMethod->type,
            'last_four' => $paymentMethod->card->last4,
            'brand' => $paymentMethod->card->brand,
            'exp_month' => $paymentMethod->card->exp_month,
            'exp_year' => $paymentMethod->card->exp_year,
            'is_default' => !$user->paymentMethods()->exists(),
        ]);
    }
}
```

## Billing Address

### Address Form

```php
// resources/views/checkout/address.blade.php
<form wire:submit="saveAddress">
    <x-gsmui:input wire:model="address.line1" label="Address Line 1" />
    <x-gsmui:input wire:model="address.line2" label="Address Line 2" />
    <x-gsmui:input wire:model="address.city" label="City" />
    <x-gsmui:select wire:model="address.state" label="State" :options="$states" />
    <x-gsmui:input wire:model="address.postal_code" label="Postal Code" />
    <x-gsmui:select wire:model="address.country" label="Country" :options="$countries" />
    <x-gsmui:button type="submit">Continue</x-gsmui:button>
</form>
```

### Address Validation

```php
class AddressValidator
{
    public function validate(array $address): array
    {
        $rules = [
            'line1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|size:2',
        ];

        $validator = Validator::make($address, $rules);

        if ($validator->fails()) {
            return ['valid' => false, 'errors' => $validator->errors()];
        }

        // Optional: verify with Stripe or similar service
        return ['valid' => true, 'address' => $address];
    }
}
```

## Order Review

### Review Step

```php
class CheckoutReview extends Component
{
    public Cart $cart;
    public array $totals;
    public ?PaymentMethod $paymentMethod;
    public ?Address $billingAddress;

    public function mount(): void
    {
        $this->totals = $this->cart->totals();
    }

    public function placeOrder(): RedirectResponse
    {
        $order = OrderService::create(
            user: $this->user,
            cart: $this->cart,
            paymentMethod: $this->paymentMethod,
            billingAddress: $this->billingAddress,
        );

        try {
            PaymentService::charge($order);
            $order->transitionTo('paid');

            Cart::clear($this->user);

            return redirect()->route('checkout.complete', $order);
        } catch (PaymentException $e) {
            $this->addError('payment', $e->getMessage());
            return redirect()->back();
        }
    }
}
```

## Conversion Optimization

### Abandoned Cart Recovery

```php
class AbandonedCartRecovery extends Command
{
    protected $signature = 'carts:recover';

    public function handle(): int
    {
        $abandoned = Cart::has('items')
            ->whereNull('user_id')
            ->where('updated_at', '<', now()->subHours(2))
            ->where('recovery_sent', false)
            ->get();

        foreach ($abandoned as $cart) {
            AbandonedCartMail::send($cart);
            $cart->update(['recovery_sent' => true]);
        }

        $this->info("Sent {$abandoned->count()} recovery emails");

        return Command::SUCCESS;
    }
}
```

### Conversion Tracking

```php
class CheckoutAnalytics
{
    public function trackStep(string $step, User $user = null): void
    {
        AnalyticsEvent::create([
            'event' => 'checkout.step',
            'user_id' => $user?->id,
            'session_id' => session()->getId(),
            'data' => [
                'step' => $step,
                'cart_value' => Cart::current()?->totals()['total'],
                'items_count' => Cart::current()?->items->count(),
            ],
        ]);
    }

    public function conversionRate(): float
    {
        $started = AnalyticsEvent::where('event', 'checkout.step')
            ->where('data->step', 'cart')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $completed = Order::where('created_at', '>=', now()->subDays(30))
            ->count();

        return $started > 0 ? ($completed / $started) * 100 : 0;
    }
}
```

### Checkout Configuration

```php
// config/checkout.php
return [
    'stages' => ['cart', 'account', 'payment', 'review', 'complete'],

    'guest_checkout' => [
        'enabled' => true,
        'require_email' => true,
    ],

    'cart' => [
        'session_expiry_hours' => 24,
        'max_items' => 50,
    ],

    'recovery' => [
        'enabled' => true,
        'delay_hours' => 2,
        'max_emails' => 3,
    ],

    'conversion' => [
        'track_steps' => true,
        'track_abandonment' => true,
    ],
];
```

## Best Practices

1. **Minimize checkout steps** — fewer steps = higher conversion
2. **Offer guest checkout** — don't force account creation
3. **Save cart to session** — persist across page loads
4. **Show order summary** at every step
5. **Recover abandoned carts** — email reminders boost revenue
6. **Test with Playwright** — verify the complete flow end-to-end
7. **Mobile-first** — most checkouts happen on mobile
