For **GsmUi**, **11-billing.md** should define the **entire commercial engine** of the platform—not just payments.

Because your platform includes:

* Marketplace
* Pro subscriptions
* Team plans
* Enterprise
* Premium Themes
* Premium Components
* Premium Templates
* AI Credits
* MCP Access
* API Access
* Digital Licenses
* Downloads
* Swag Store
* Future SaaS products

…the Billing domain becomes one of the largest parts of the system.

A complete implementation-ready specification would be **500–800 pages**, so it should be split into focused documents.

## Recommended Structure

```text
11-billing/

11.01-overview.md
11.02-domain-model.md
11.03-pricing-engine.md
11.04-products.md
11.05-plans.md
11.06-subscriptions.md
11.07-one-time-purchases.md
11.08-shopping-cart.md
11.09-checkout.md
11.10-payment-providers.md
11.11-stripe.md
11.12-paddle.md
11.13-lemonsqueezy.md
11.14-orders.md
11.15-order-items.md
11.16-payments.md
11.17-payment-intents.md
11.18-invoices.md
11.19-refunds.md
11.20-taxes.md
11.21-coupons.md
11.22-discounts.md
11.23-gift-codes.md
11.24-license-engine.md
11.25-download-permissions.md
11.26-entitlements.md
11.27-team-billing.md
11.28-enterprise-billing.md
11.29-webhooks.md
11.30-subscription-lifecycle.md
11.31-dunning.md
11.32-admin-billing.md
11.33-user-billing-dashboard.md
11.34-events.md
11.35-jobs.md
11.36-reporting.md
11.37-security.md
11.38-database-design.md
11.39-api.md
11.40-future-expansion.md
```

## Technology Stack

| Layer          | Technology          |
| -------------- | ------------------- |
| Framework      | Laravel 13          |
| UI             | Livewire 4          |
| Authentication | Fortify             |
| API            | Sanctum             |
| Queue          | Horizon             |
| Cache          | Redis               |
| Database       | MySQL 8.4           |
| Activity Logs  | Spatie Activity Log |

Payment provider adapters should use a common interface so providers can be swapped without affecting business logic.

---

# Billing Architecture

```text
Customer

↓

Shopping Cart

↓

Checkout

↓

Payment Provider

↓

Webhook

↓

Billing Service

↓

License Service

↓

Entitlement Service

↓

Download Access
```

---

# Commercial Products

The billing engine should support:

### SaaS

* Free
* Pro
* Team
* Enterprise

### Marketplace

* Themes
* Components
* Templates
* Icons
* Charts
* Plugins
* Starter Kits

### Services

* AI Credits
* MCP Access
* API Plans
* Premium Documentation

### Physical

* T-Shirts
* Hoodies
* Stickers
* Mugs
* Accessories

---

# Pricing Models

Support multiple pricing strategies:

* Free
* One-time purchase
* Monthly subscription
* Annual subscription
* Lifetime license
* Usage-based pricing (future)
* Seat-based pricing
* Enterprise custom pricing

---

# Subscription Lifecycle

```text
Trial

↓

Active

↓

Renewing

↓

Grace Period

↓

Past Due

↓

Suspended

↓

Cancelled

↓

Expired
```

---

# License Types

```text
Free

Personal

Pro

Team

Enterprise

Lifetime
```

Licenses determine feature access and download permissions.

---

# Entitlements

The entitlement engine controls access to:

* Components
* Themes
* Templates
* Documentation
* AI Tools
* MCP
* API
* Downloads
* Updates
* Support

Applications should check entitlements rather than payment status directly.

---

# Shopping Flow

```text
Browse

↓

Add to Cart

↓

Checkout

↓

Payment

↓

Webhook

↓

Order

↓

License

↓

Entitlements

↓

Download
```

---

# Database Domains

The billing database should include entities such as:

* Billing Products
* Plans
* Prices
* Orders
* Order Items
* Subscriptions
* Payments
* Payment Intents
* Invoices
* Refunds
* Coupons
* Gift Codes
* Licenses
* Entitlements
* Transactions
* Tax Rates
* Webhook Events

---

# Admin Features

The administration interface should provide:

* Product management
* Pricing management
* Subscription management
* Manual invoices
* Refund processing
* Coupon management
* Revenue analytics
* Tax settings
* Payment provider configuration
* Webhook monitoring

---

# User Dashboard

Users should be able to:

* View invoices
* Download receipts
* Manage subscriptions
* Cancel or renew plans
* View licenses
* Download purchased assets
* Manage payment methods
* Redeem coupons
* Review order history

---

# Future Features

The architecture should support:

* Marketplace revenue sharing
* Creator payouts
* Affiliate program
* VAT OSS
* Regional tax engines
* Team billing
* Enterprise procurement
* Seat management
* Usage metering
* AI token billing
* API usage billing
* Wallet/credits system

---

## Recommended implementation order

Start with the business foundations:

1. **11.01-overview.md**
2. **11.02-domain-model.md**
3. **11.03-pricing-engine.md**
4. **11.04-products.md**
5. **11.05-plans.md**
6. **11.06-subscriptions.md**
7. **11.07-one-time-purchases.md**
8. **11.08-shopping-cart.md**
9. **11.09-checkout.md**

Then continue with payment providers, licensing, entitlements, administration, reporting, APIs, and future expansion.

This structure gives GsmUi a commercial billing architecture comparable to platforms like Paddle, Lemon Squeezy, Laravel Cloud, and GitHub Sponsors, while remaining modular and directly implementable with Laravel 13 and Livewire 4.

---

# Payment Provider Abstraction Layer

The billing engine uses a provider-agnostic adapter pattern. All payment operations go through a unified `BillingProvider` interface so business logic never depends on Stripe internals.

## Adapter Interface

```php
interface BillingProvider
{
    public function createCustomer(Billable $billable): string;
    public function createCheckout(Billable $billable, array $options): CheckoutSession;
    public function createSubscription(Billable $billable, Plan $plan, array $options): Subscription;
    public function cancelSubscription(Subscription $subscription, bool $immediately): void;
    public function resumeSubscription(Subscription $subscription): void;
    public function swapPlan(Subscription $subscription, Plan $newPlan, bool $prorate): void;
    public function invoice(Subscription $subscription): Invoice;
    public function refund(Payment $payment, int $amountInCents, ?string $reason): Refund;
    public function createPaymentIntent(Billable $billable, int $amountInCents, string $currency): PaymentIntent;
    public function confirmPaymentIntent(string $paymentIntentId, array $paymentMethod): PaymentResult;
    public function attachPaymentMethod(Billable $billable, string $paymentMethodId): void;
    public function detachPaymentMethod(string $paymentMethodId): void;
    public function listPaymentMethods(Billable $billable): array;
    public function getDefaultPaymentMethod(Billable $billable): ?PaymentMethod;
    public function updateDefaultPaymentMethod(Billable $billable, string $paymentMethodId): void;
    public function getSubscriptionStatus(string $providerSubscriptionId): string;
    public function getNextBillingDate(string $providerSubscriptionId): Carbon;
    public function createCoupon(array $options): string;
    public function createPromotionCode(string $couponId, array $options): string;
    public function validatePromoCode(string $code, int $amountInCents): ?PromoValidation;
    public function createPortal(Billable $billable, string $returnUrl): string;
    public function generateHostedInvoiceUrl(Invoice $invoice): string;
    public function verifyWebhookSignature(string $payload, string $signature, string $secret): bool;
}
```

## Provider Implementations

### Stripe Adapter

```php
class StripeBillingProvider implements BillingProvider
{
    public function createCustomer(Billable $billable): string
    {
        $customer = $this->client->customers->create([
            'email' => $billable->email,
            'name' => $billable->name,
            'metadata' => [
                'billable_type' => get_class($billable),
                'billable_id' => $billable->id,
            ],
        ]);

        return $customer->id;
    }

    public function createCheckout(Billable $billable, array $options): CheckoutSession
    {
        $session = $this->client->checkout->sessions->create([
            'mode' => $options['mode'] ?? 'subscription',
            'customer' => $billable->stripe_id,
            'line_items' => $options['line_items'],
            'success_url' => $options['success_url'],
            'cancel_url' => $options['cancel_url'],
            'subscription_data' => $options['subscription_data'] ?? [],
            'allow_promotion_codes' => $options['allow_promotion_codes'] ?? false,
            'payment_intent_data' => $options['payment_intent_data'] ?? null,
        ]);

        return new CheckoutSession(
            id: $session->id,
            url: $session->url,
            expiresAt: Carbon::createFromTimestamp($session->expires_at),
        );
    }

    public function createSubscription(Billable $billable, Plan $plan, array $options): Subscription
    {
        $stripeSubscription = $this->client->subscriptions->create([
            'customer' => $billable->stripe_id,
            'items' => [['price' => $plan->stripe_price_id]],
            'trial_period_days' => $options['trial_days'] ?? null,
            'payment_behavior' => $options['payment_behavior'] ?? 'default_incomplete',
            'expand' => ['latest_invoice.payment_intent'],
        ]);

        return $stripeSubscription;
    }
}
```

### Paddle Adapter

```php
class PaddleBillingProvider implements BillingProvider
{
    public function createCustomer(Billable $billable): string
    {
        $customer = $this->paddle->create('customers', [
            'name' => $billable->name,
            'email' => $billable->email,
        ]);

        return $customer['id'];
    }

    public function createCheckout(Billable $billable, array $options): CheckoutSession
    {
        $transaction = $this->paddle->create('transactions', [
            'customer_id' => $billable->paddle_customer_id,
            'items' => collect($options['line_items'])->map(fn($item) => [
                'price_id' => $item['price_id'],
                'quantity' => $item['quantity'] ?? 1,
            ])->toArray(),
            'return_url' => $options['success_url'],
            'custom_data' => [
                'billable_type' => get_class($billable),
                'billable_id' => $billable->id,
            ],
        ]);

        return new CheckoutSession(
            id: $transaction['id'],
            url: $transaction['checkout']['url'],
            expiresAt: Carbon::parse($transaction['checkout']['expires_at']),
        );
    }

    public function refund(Payment $payment, int $amountInCents, ?string $reason): Refund
    {
        $refund = $this->paddle->create('transactions/' . $payment->provider_transaction_id . '/refund', [
            'amount' => $amountInCents,
            'reason' => $reason,
        ]);

        return Refund::create([
            'payment_id' => $payment->id,
            'amount' => $amountInCents,
            'status' => 'succeeded',
        ]);
    }
}
```

### Lemon Squeezy Adapter

```php
class LemonSqueezyBillingProvider implements BillingProvider
{
    public function createCustomer(Billable $billable): string
    {
        $customer = $this->api->customers()->create([
            'name' => $billable->name,
            'email' => $billable->email,
        ]);

        return $customer['data']['id'];
    }

    public function createCheckout(Billable $billable, array $options): CheckoutSession
    {
        $checkout = $this->api->checkouts()->create([
            'attributes' => [
                'product_id' => $options['product_id'],
                'variant_id' => $options['variant_id'],
                'custom_price' => $options['custom_price'] ?? null,
                'redirect_url' => $options['success_url'],
            ],
            'relationships' => [
                'store' => ['data' => ['type' => 'stores', 'id' => $this->storeId]],
            ],
        ]);

        return new CheckoutSession(
            id: $checkout['data']['id'],
            url: $checkout['data']['attributes']['url'],
            expiresAt: Carbon::parse($checkout['data']['attributes']['expires_at']),
        );
    }
}
```

---

# Pricing Engine

The pricing engine calculates costs, applies discounts, handles proration, and generates price quotes.

## Price Calculator

```php
class PriceCalculator
{
    public function calculateBasePrice(Plan $plan, int $quantity = 1): PriceBreakdown
    {
        $baseAmount = $plan->price * $quantity;
        $tax = $this->taxEngine->calculate($baseAmount, $plan->currency);

        return new PriceBreakdown(
            basePrice: $baseAmount,
            discount: 0,
            tax: $tax,
            total: $baseAmount + $tax,
        );
    }

    public function calculateWithDiscount(Plan $plan, Coupon $coupon, int $quantity = 1): PriceBreakdown
    {
        $baseAmount = $plan->price * $quantity;
        $discount = $coupon->apply($baseAmount);
        $afterDiscount = $baseAmount - $discount;
        $tax = $this->taxEngine->calculate($afterDiscount, $plan->currency);

        return new PriceBreakdown(
            basePrice: $baseAmount,
            discount: $discount,
            tax: $tax,
            total: $afterDiscount + $tax,
            applied_coupon: $coupon->code,
        );
    }

    public function calculateProration(Subscription $subscription, Plan $newPlan): ProrationBreakdown
    {
        $currentPeriod = $subscription->period();
        $daysRemaining = $currentPeriod->daysRemaining();
        $daysTotal = $currentPeriod->daysTotal();

        $currentPlanCredit = $subscription->plan->price * ($daysRemaining / $daysTotal);
        $newPlanCost = $newPlan->price;
        $proratedAmount = max(0, $newPlanCost - $currentPlanCredit);

        return new ProrationBreakdown(
            current_plan_daily_rate: $subscription->plan->price / $daysTotal,
            days_remaining: $daysRemaining,
            credit_amount: $currentPlanCredit,
            new_plan_cost: $newPlanCost,
            prorated_charge: $proratedAmount,
            effective_date: $currentPeriod->end,
        );
    }
}
```

## Price Breakdown Value Object

```php
class PriceBreakdown
{
    public function __construct(
        public readonly int $basePrice,
        public readonly int $discount,
        public readonly int $tax,
        public readonly int $total,
        public readonly ?string $applied_coupon = null,
    ) {}

    public function toArray(): array
    {
        return [
            'base_price' => $this->basePrice,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total' => $this->total,
            'coupon' => $this->applied_coupon,
        ];
    }
}
```

## Tax Engine

```php
class TaxEngine
{
    public function calculate(int $amountInCents, string $currency, ?array $address = null): int
    {
        if ($address === null) {
            return 0; // No tax if address unknown
        }

        $taxRate = $this->resolveTaxRate($address);
        return (int) round($amountInCents * $taxRate);
    }

    protected function resolveTaxRate(array $address): float
    {
        $country = $address['country'] ?? null;
        $state = $address['state'] ?? null;

        // EU VAT rates
        if ($this->isEUCountry($country)) {
            return $this->getEUVatRate($country, $state);
        }

        // US sales tax
        if ($country === 'US') {
            return $this->getUSSalesTaxRate($state);
        }

        // Default: no tax
        return 0.0;
    }

    protected function isEUCountry(string $country): bool
    {
        return in_array($country, [
            'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE',
            'FI', 'FR', 'DE', 'GR', 'HU', 'IE', 'IT', 'LV',
            'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'RO', 'SK',
            'SI', 'ES', 'SE',
        ]);
    }
}
```

---

# Products

Define the product catalog for the billing system.

## Product Types

```php
enum ProductType: string
{
    case Subscription = 'subscription';
    case OneTime = 'one_time';
    case DigitalLicense = 'digital_license';
    case PhysicalGood = 'physical_good';
    case Service = 'service';
}
```

## Product Entity

```php
class BillingProduct extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'type', 'price', 'currency',
        'interval', 'metadata', 'is_active', 'is_visible', 'sort_order',
        'stripe_product_id', 'paddle_product_id', 'lemon_squeezy_product_id',
    ];

    public function prices(): HasMany;
    public function categories(): MorphToMany;
    public function variants(): HasMany;
    public function orderItems(): HasMany;
    public function isActive(): bool;
    public function isSubscription(): bool;
    public function isOneTime(): bool;
    public function isDownloadable(): bool;
    public function isPhysical(): bool;
}
```

## Product Categories

Products are organized into categories:

| Category | Description | Examples |
|---|---|---|
| Themes | Premium UI themes | Dark Pro, Glassmorphism |
| Components | Premium component packs | Charts Pro, Data Tables Pro |
| Templates | Starter kits and templates | Admin Dashboard, SaaS Kit |
| Icons | Icon packs | Feather Pro, Lucide Pro |
| Plugins | Editor and tool plugins | Markdown Pro, Code Diff |
| Services | Access-based services | AI Credits, API Plans |
| Merchandise | Physical goods | T-Shirts, Hoodies |
| Licenses | Software licenses | Enterprise License |

---

# Orders

Track all purchase transactions regardless of type.

## Order Entity

```php
class Order extends Model
{
    public function billable(): MorphTo;
    public function items(): HasMany;
    public function payments(): HasMany;
    public function invoices(): HasMany;
    public function refunds(): HasMany;
    public function coupons(): MorphToMany;

    public function subtotal(): int;
    public function discountTotal(): int;
    public function taxTotal(): int;
    public function total(): int;
    public function isPaid(): bool;
    public function isPartiallyRefunded(): bool;
    public function isFullyRefunded(): bool;
}
```

## Order Item

```php
class OrderItem extends Model
{
    public function order(): BelongsTo;
    public function product(): BelongsTo;
    public function subscription(): BelongsTo;

    public function lineTotal(): int;
    public function discountAmount(): int;
}
```

## Order States

```text
Pending
    ↓
Processing
    ↓
Completed
    ↓
Partially Refunded
    ↓
Fully Refunded
```

---

# Invoices

Generate and manage invoices for all transactions.

## Invoice Entity

```php
class Invoice extends Model
{
    public function order(): BelongsTo;
    public function billable(): MorphTo;
    public function payments(): HasMany;

    public function number(): string;
    public function pdfUrl(): string;
    public function status(): string;
    public function isPaid(): bool;
    public function isDraft(): bool;
    public function amountDue(): int;
    public function amountPaid(): int;
    public function periodStart(): Carbon;
    public function periodEnd(): Carbon;
}
```

## Invoice Generation

```php
class InvoiceGenerator
{
    public function generateFromOrder(Order $order): Invoice
    {
        $invoice = Invoice::create([
            'number' => $this->nextNumber(),
            'order_id' => $order->id,
            'billable_type' => $order->billable_type,
            'billable_id' => $order->billable_id,
            'status' => 'draft',
            'subtotal' => $order->subtotal(),
            'discount_total' => $order->discountTotal(),
            'tax_total' => $order->taxTotal(),
            'total' => $order->total(),
            'currency' => $order->currency,
            'period_start' => $order->created_at,
            'period_end' => $order->created_at->addMonth(),
        ]);

        // Copy order items to invoice items
        foreach ($order->items as $item) {
            $invoice->items()->create([
                'product_id' => $item->product_id,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total' => $item->total,
            ]);
        }

        return $invoice;
    }

    public function generateForSubscription(Subscription $subscription): Invoice
    {
        // Generate periodic subscription invoice
        $subscriptionInvoice = $this->generateFromOrder(
            $this->createOrderForSubscription($subscription)
        );

        // Sync with payment provider invoice
        $subscriptionInvoice->provider_invoice_id = $this->provider->getLatestInvoiceId($subscription);
        $subscriptionInvoice->save();

        return $subscriptionInvoice;
    }
}
```

---

# Refunds

Process partial and full refunds.

## Refund Entity

```php
class Refund extends Model
{
    public function payment(): BelongsTo;
    public function order(): BelongsTo;

    public function isFull(): bool;
    public function isPartial(): bool;
    public function amountCredited(): int;
}
```

## Refund Process

```php
class RefundProcessor
{
    public function processRefund(Payment $payment, int $amount, ?string $reason): Refund
    {
        // Validate refund amount
        if ($amount > $payment->amount - $payment->alreadyRefunded()) {
            throw new RefundExceedsPaymentException();
        }

        // Process through provider
        $providerRefund = $this->provider->refund($payment, $amount, $reason);

        // Record refund
        $refund = Refund::create([
            'payment_id' => $payment->id,
            'order_id' => $payment->order_id,
            'amount' => $amount,
            'reason' => $reason,
            'status' => 'succeeded',
            'provider_refund_id' => $providerRefund->id,
        ]);

        // Update payment record
        $payment->refunded_amount += $amount;
        $payment->save();

        // Recalculate order status
        $this->updateOrderRefundStatus($payment->order);

        // Dispatch event
        RefundProcessed::dispatch($refund);

        return $refund;
    }

    public function refundEntitlements(Refund $refund): void
    {
        // Revoke access to refunded items
        $items = $refund->order->items()->with('product')->get();

        foreach ($items as $item) {
            if ($item->product->isSubscription()) {
                // Cancel subscription
                $this->subscriptionService->cancel(
                    $item->subscription,
                    immediately: $refund->isFull(),
                );
            } elseif ($item->product->isDownloadable()) {
                // Revoke download access
                $this->downloadService->revoke($item->product, $refund->billable);
            }
        }
    }
}
```

---

# Coupons and Discounts

## Coupon Entity

```php
class Coupon extends Model
{
    public function orders(): MorphToMany;

    public function isActive(): bool;
    public function isExpired(): bool;
    public function hasReachedLimit(): bool;
    public function apply(int $amountInCents): int;
    public function remainingUses(): ?int;
}
```

## Coupon Types

```php
enum CouponType: string
{
    case Percentage = 'percentage';    // 20% off
    case FixedAmount = 'fixed_amount'; // $10 off
    case FreeShipping = 'free_shipping';
    case FreeTrial = 'free_trial';    // Extra trial days
    case FirstOrderDiscount = 'first_order';
}
```

## Discount Rules

| Rule | Description |
|---|---|
| `applies_to` | specific_products, all_products, specific_categories |
| `min_order_amount` | Minimum order value in cents |
| `max_uses` | Total redemption limit |
| `max_uses_per_user` | Per-user redemption limit |
| `valid_from` | Start date |
| `valid_until` | Expiration date |
| `stackable` | Whether it can combine with other coupons |
| `first_order_only` | Only valid on user's first order |

---

# Gift Codes

## Gift Code Entity

```php
class GiftCode extends Model
{
    public function creator(): BelongsTo;
    public function recipient(): BelongsTo;
    public function order(): BelongsTo;

    public function redeem(User $redeemer): void;
    public function isRedeemed(): bool;
    public function isValid(): bool;
    public function valueForPlan(Plan $plan): int;
}
```

## Gift Code Flow

```text
Creator generates code
    ↓
Code sent to recipient via email
    ↓
Recipient enters code at checkout
    ↓
Code applied as discount
    ↓
Code marked as redeemed
```

---

# License Engine

## License Entity

```php
class License extends Model
{
    public function billable(): MorphTo;
    public function order(): BelongsTo;

    public function key(): string;
    public function isValid(): bool;
    public function isExpired(): bool;
    public function maxActivations(): int;
    public function currentActivations(): int;
    public function activate(string $deviceId): Activation;
    public function deactivate(string $deviceId): void;
    public function verify(): bool;
}
```

## License Validation

```php
class LicenseValidator
{
    public function validate(string $key, string $deviceId): LicenseValidationResult
    {
        $license = License::where('key', $key)->first();

        if (!$license) {
            return LicenseValidationResult::invalid('License not found');
        }

        if (!$license->isValid()) {
            return LicenseValidationResult::invalid('License expired or revoked');
        }

        if ($license->isExpired()) {
            return LicenseValidationResult::expired($license);
        }

        $activation = $license->activations()->where('device_id', $deviceId)->first();

        if ($activation) {
            return LicenseValidationResult::valid($license);
        }

        if ($license->currentActivations() >= $license->maxActivations()) {
            return LicenseValidationResult::limitReached($license);
        }

        return LicenseValidationResult::valid($license);
    }
}
```

---

# Download Permissions

## Download Permission Entity

```php
class DownloadPermission extends Model
{
    public function billable(): MorphTo;
    public function product(): BelongsTo;
    public function order(): BelongsTo;

    public function canDownload(): bool;
    public function remainingDownloads(): ?int;
    public function lastDownloadedAt(): ?Carbon;
    public function recordDownload(): void;
}
```

## Download Limit Enforcement

```php
class DownloadLimitService
{
    public function canDownload(Billable $billable, BillingProduct $product): bool
    {
        $permission = DownloadPermission::where('billable_type', get_class($billable))
            ->where('billable_id', $billable->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$permission) {
            return false;
        }

        if (!$permission->canDownload()) {
            return false;
        }

        // Check subscription download limit
        $subscription = $billable->activeSubscription();
        if ($subscription) {
            $plan = $subscription->plan;
            $downloadsThisPeriod = $this->countDownloadsThisPeriod($billable);

            if ($plan->max_downloads_per_month !== null &&
                $downloadsThisPeriod >= $plan->max_downloads_per_month) {
                return false;
            }
        }

        return true;
    }
}
```

---

# Team Billing

## Team Subscription

```php
class TeamSubscription extends Model
{
    public function team(): BelongsTo;
    public function subscription(): BelongsTo;
    public function seats(): HasMany;

    public function totalSeats(): int;
    public function usedSeats(): int;
    public function availableSeats(): int;
    public function addSeat(User $user): void;
    public function removeSeat(User $user): void;
    public function seatCost(): int;
}
```

## Seat Management

```php
class SeatManager
{
    public function invite(Team $team, string $email, string $role): SeatInvitation
    {
        $subscription = $team->activeSubscription();

        if ($subscription->availableSeats() <= 0) {
            throw new NoSeatsAvailableException();
        }

        $invitation = SeatInvitation::create([
            'team_id' => $team->id,
            'email' => $email,
            'role' => $role,
            'invited_by' => auth()->id(),
        ]);

        SeatInvitationSent::dispatch($invitation);

        return $invitation;
    }

    public function accept(SeatInvitation $invitation, User $user): void
    {
        if ($invitation->email !== $user->email) {
            throw new EmailMismatchException();
        }

        $subscription = $invitation->team->activeSubscription();
        $subscription->addSeat($user);
        $invitation->accept();

        SeatAccepted::dispatch($invitation, $user);
    }
}
```

---

# Enterprise Billing

## Enterprise Agreement

```php
class EnterpriseAgreement extends Model
{
    public function team(): BelongsTo;
    public function contact(): BelongsTo;
    public function documents(): MorphMany;

    public function annualValue(): int;
    public function contractStart(): Carbon;
    public function contractEnd(): Carbon;
    public function seatsPurchased(): int;
    public function seatsUsed(): int;
    public function renewalDate(): Carbon;
    public function isExpired(): bool;
}
```

## Custom Pricing

Enterprise pricing is negotiated and stored directly:

| Factor | Description |
|---|---|
| Volume discount | Based on seat count |
| Commitment length | Annual vs multi-year |
| Support tier | Standard, priority, dedicated |
| SLA requirements | Uptime guarantees |
| Custom features | SSO, SCIM, audit logs |
| Payment terms | Net 30, Net 60, prepaid |

---

# Webhooks

## Webhook Event Processing

```php
class WebhookProcessor
{
    public function process(string $provider, string $eventType, array $payload): void
    {
        // Verify signature
        if (!$this->provider->verifyWebhookSignature($provider, $payload)) {
            throw new InvalidWebhookSignatureException();
        }

        // Idempotency check
        $eventId = $payload['id'] ?? $payload['event_id'] ?? md5(json_encode($payload));
        if (WebhookEvent::alreadyProcessed($eventId)) {
            return;
        }

        // Record event
        $event = WebhookEvent::create([
            'provider' => $provider,
            'event_type' => $eventType,
            'payload' => $payload,
            'event_id' => $eventId,
            'status' => 'processing',
        ]);

        try {
            $this->dispatchHandler($provider, $eventType, $payload);
            $event->markProcessed();
        } catch (\Exception $e) {
            $event->markFailed($e->getMessage());
            throw $e;
        }
    }

    protected function dispatchHandler(string $provider, string $ eventType, array $payload): void
    {
        $handlerClass = sprintf(
            'App\\Billing\\Handlers\\%s\\%sHandler',
            ucfirst($provider),
            Str::studly($eventType),
        );

        if (class_exists($handlerClass)) {
            app($handlerClass)->handle($payload);
        }
    }
}
```

## Webhook Events by Provider

### Stripe Events

| Event Type | Description |
|---|---|
| `checkout.session.completed` | Checkout finished successfully |
| `customer.subscription.created` | New subscription |
| `customer.subscription.updated` | Subscription modified |
| `customer.subscription.deleted` | Subscription canceled |
| `invoice.paid` | Payment succeeded |
| `invoice.payment_failed` | Payment failed |
| `invoice.refunded` | Refund processed |
| `payment_method.attached` | Payment method added |
| `payment_method.detached` | Payment method removed |

### Paddle Events

| Event Type | Description |
|---|---|
| `transaction.completed` | Purchase completed |
| `subscription.created` | Subscription started |
| `subscription.updated` | Subscription modified |
| `subscription.canceled` | Subscription canceled |
| `subscription.payment_success` | Renewal payment succeeded |
| `subscription.payment_failed` | Renewal payment failed |
| `refund.created` | Refund processed |

### Lemon Squeezy Events

| Event Type | Description |
|---|---|
| `order_created` | Order completed |
| `order_updated` | Order updated |
| `subscription_created` | Subscription started |
| `subscription_updated` | Subscription modified |
| `subscription_cancelled` | Subscription canceled |
| `subscription_resumed` | Subscription resumed |
| `subscription_expired` | Subscription expired |
| `license_key_created` | License generated |

---

# Admin Billing Interface

## Features

| Feature | Description |
|---|---|
| Dashboard | Revenue overview, MRR, churn rate, LTV |
| Product Management | CRUD for products, variants, pricing |
| Subscription Management | View, modify, cancel any subscription |
| Order Management | View all orders, process refunds |
| Invoice Management | Generate, resend, void invoices |
| Coupon Management | Create, edit, deactivate coupons |
| Tax Configuration | Tax rates, exemptions, regions |
| Revenue Reports | Daily, weekly, monthly revenue breakdowns |
| Export | CSV/Excel export of all billing data |
| Webhook Logs | View webhook delivery history |

## Revenue Dashboard

```php
class RevenueDashboard
{
    public function metrics(string $period = '30d'): array
    {
        return [
            'mrr' => $this->calculateMRR(),
            'arr' => $this->calculateARR(),
            'churn_rate' => $this->calculateChurnRate($period),
            'ltv' => $this->calculateLTV(),
            'new_revenue' => $this->newRevenue($period),
            'expansion_revenue' => $this->expansionRevenue($period),
            'contraction_revenue' => $this->contractionRevenue($period),
            'net_revenue' => $this->netRevenue($period),
        ];
    }

    public function calculateMRR(): int
    {
        return Subscription::where('status', 'active')
            ->with('plan')
            ->get()
            ->sum(fn($sub) => $sub->plan->monthlyPrice());
    }

    public function calculateChurnRate(string $period): float
    {
        $start = Carbon::now()->subPeriods(1);
        $end = Carbon::now();

        $startingSubscriptions = Subscription::where('created_at', '<', $start)->count();
        $canceled = Subscription::where('canceled_at', '>=', $start)
            ->where('canceled_at', '<', $end)
            ->count();

        return $startingSubscriptions > 0
            ? ($canceled / $startingSubscriptions) * 100
            : 0;
    }
}
```

## Subscription Management (Admin)

```php
class AdminSubscriptionController extends Controller
{
    public function index(): Response
    {
        $subscriptions = Subscription::with('user', 'plan')
            ->when(request('status'), fn($q, $status) => $q->where('status', $status))
            ->when(request('plan'), fn($q, $plan) => $q->where('plan_id', $plan))
            ->latest()
            ->paginate(50);

        return view('admin.billing.subscriptions.index', compact('subscriptions'));
    }

    public function cancel(Subscription $subscription): RedirectResponse
    {
        $this->authorize('manage', $subscription);

        $this->subscriptionService->cancel($subscription, immediately: false);

        return redirect()->back()->with('success', 'Subscription will cancel at period end.');
    }

    public function suspend(Subscription $subscription): RedirectResponse
    {
        $this->authorize('manage', $subscription);

        $this->subscriptionService->suspend($subscription);

        return redirect()->back()->with('success', 'Subscription suspended.');
    }

    public function grantComp(User $user, Plan $plan): RedirectResponse
    {
        $this->authorize('grant-comp');

        $this->subscriptionService->createComplimentary($user, $plan);

        return redirect()->back()->with('success', 'Complimentary subscription granted.');
    }
}
```

## User Billing Dashboard

```php
class UserBillingDashboard extends Component
{
    public function render(): View
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription();
        $invoices = $user->invoices()->latest()->paginate(10);
        $paymentMethods = $user->paymentMethods();
        $licenses = $user->licenses()->get();
        $downloads = $user->downloadPermissions()->get();

        return view('components.billing.dashboard', [
            'subscription' => $subscription,
            'invoices' => $invoices,
            'paymentMethods' => $paymentMethods,
            'licenses' => $licenses,
            'downloads' => $downloads,
        ]);
    }

    public function cancelSubscription(): void
    {
        $this->subscriptionService->cancel($this->subscription);
    }

    public function resumeSubscription(): void
    {
        $this->subscriptionService->resume($this->subscription);
    }

    public function swapPlan(Plan $newPlan): void
    {
        $this->subscriptionService->swap($this->subscription, $newPlan);
    }
}
```

---

# Events

## Domain Events

```php
// Subscription Events
SubscriptionCreated
SubscriptionRenewed
SubscriptionCanceled
SubscriptionExpired
SubscriptionUpgraded
SubscriptionDowngraded
SubscriptionResumed
SubscriptionSuspended

// Payment Events
PaymentSucceeded
PaymentFailed
PaymentRefunded
PaymentMethodAttached
PaymentMethodDetached

// Order Events
OrderCreated
OrderPaid
OrderRefunded
OrderFulfilled

// Invoice Events
InvoiceGenerated
InvoicePaid
InvoiceVoided

// License Events
LicenseCreated
LicenseActivated
LicenseDeactivated
LicenseExpired

// Entitlement Events
EntitlementsUpdated
EntitlementsRevoked
EntitlementsGranted
```

## Event Listeners

```php
class SubscriptionEventListener
{
    public function handleSubscriptionCanceled(SubscriptionCanceled $event): void
    {
        // 1. Update entitlements
        app(EntitlementService::class)->synchronize($event->subscription);

        // 2. Send cancellation email
        Mail::to($event->subscription->user)->send(
            new SubscriptionCanceledMail($event->subscription)
        );

        // 3. Log activity
        activity('subscription')
            ->performedOn($event->subscription)
            ->withProperties(['status' => 'canceled'])
            ->log('Subscription canceled');
    }

    public function handlePaymentFailed(PaymentFailed $event): void
    {
        // 1. Notify user
        Mail::to($event->payment->billable)->send(
            new PaymentFailedMail($event->payment)
        );

        // 2. Start grace period
        app(GracePeriodService::class)->start($event->payment->subscription);

        // 3. Schedule retry
        app(PaymentRetryManager::class)->scheduleRetries($event->payment->subscription);
    }
}
```

---

# Background Jobs

```php
// Renewal Jobs
ProcessRenewalJob           // Process subscription renewal
RenewalReminderJob          // Send renewal reminder emails
CheckExpiredCardsJob         // Alert users with expiring cards

// Trial Jobs
ExpireTrialJob              // Convert or expire trial
TrialReminderJob            // Send trial reminder emails

// Entitlement Jobs
RefreshEntitlementsJob      // Recalculate entitlements
SyncProviderStatusJob       // Sync subscription status with provider

// License Jobs
ValidateLicenseJob          // Background license validation
RevokeExpiredLicensesJob    // Clean up expired licenses

// Reporting Jobs
CalculateMRRJob             // Daily MRR calculation
CalculateChurnJob           // Daily churn calculation
GenerateRevenueReportJob    // Weekly revenue report

// Cleanup Jobs
PurgeExpiredSubscriptionsJob // Remove expired subscription records
ArchiveOldOrdersJob         // Archive old order data
```

---

# Security

## Payment Security

- All payment data is handled by PCI-compliant providers (Stripe, Paddle, Lemon Squeezy)
- No raw card numbers stored on the platform
- Payment method tokens are encrypted at rest
- Webhook signatures are verified on every incoming event
- Refund operations require admin authentication and authorization

## Access Control

| Operation | Required Role |
|---|---|
| View own billing | Authenticated user |
| Manage own subscription | Authenticated user |
| View all billing (admin) | Admin |
| Process refunds | Admin with refund permission |
| Grant complimentary access | Admin with comp permission |
| Modify pricing | Super admin |
| Export billing data | Admin with export permission |
| View webhook logs | Admin |

## Audit Logging

All billing operations are logged in the activity log:

```php
activity('billing')
    ->performedOn($order)
    ->withProperties([
        'operation' => 'refund',
        'amount' => $amount,
        'reason' => $reason,
        'admin_id' => auth()->id(),
    ])
    ->log('Refund processed');
```

---

# Database Design

## Core Tables

| Table | Purpose |
|---|---|
| `billing_products` | Product catalog |
| `billing_prices` | Price variants per product |
| `plans` | Subscription plans |
| `orders` | Purchase transactions |
| `order_items` | Line items in orders |
| `subscriptions` | Subscription records |
| `subscription_items` | Subscription line items |
| `payments` | Payment records |
| `payment_intents` | Pending payment intents |
| `invoices` | Generated invoices |
| `invoice_items` | Invoice line items |
| `refunds` | Refund records |
| `coupons` | Discount coupons |
| `coupon_usages` | Coupon redemption history |
| `gift_codes` | Gift code records |
| `licenses` | Digital licenses |
| `license_activations` | License activation records |
| `download_permissions` | Download access rights |
| `entitlements` | Resolved entitlements |
| `entitlement_grants` | Admin overrides |
| `team_subscriptions` | Team billing |
| `team_seats` | Team seat assignments |
| `webhook_events` | Webhook event log |
| `tax_rates` | Tax rate configuration |
| `transactions` | Financial transactions |

## Indexes

```php
// Critical indexes for billing queries
Schema::table('subscriptions', function (Blueprint $table) {
    $table->index('status');
    $table->index(['billable_type', 'billable_id']);
    $table->index('plan_id');
    $table->index('current_period_end');
});

Schema::table('orders', function (Blueprint $table) {
    $table->index('status');
    $table->index(['billable_type', 'billable_id']);
    $table->index('created_at');
});

Schema::table('payments', function (Blueprint $table) {
    $table->index('status');
    $table->index('order_id');
    $table->index('provider_payment_id');
});
```

---

# API Endpoints

## User API

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/billing/subscription` | Get current subscription |
| GET | `/api/billing/invoices` | List invoices |
| GET | `/api/billing/invoices/{id}` | Get invoice details |
| GET | `/api/billing/invoices/{id}/pdf` | Download invoice PDF |
| GET | `/api/billing/payment-methods` | List payment methods |
| POST | `/api/billing/payment-methods` | Add payment method |
| DELETE | `/api/billing/payment-methods/{id}` | Remove payment method |
| POST | `/api/billing/subscription/swap` | Change plan |
| POST | `/api/billing/subscription/cancel` | Cancel subscription |
| POST | `/api/billing/subscription/resume` | Resume subscription |
| GET | `/api/billing/licenses` | List licenses |
| POST | `/api/billing/licenses/activate` | Activate license |
| POST | `/api/billing/licenses/deactivate` | Deactivate license |

## Admin API

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/admin/billing/products` | List products |
| POST | `/api/admin/billing/products` | Create product |
| PUT | `/api/admin/billing/products/{id}` | Update product |
| GET | `/api/admin/billing/plans` | List plans |
| POST | `/api/admin/billing/plans` | Create plan |
| PUT | `/api/admin/billing/plans/{id}` | Update plan |
| GET | `/api/admin/billing/subscriptions` | List all subscriptions |
| GET | `/api/admin/billing/orders` | List all orders |
| POST | `/api/admin/billing/refunds` | Process refund |
| GET | `/api/admin/billing/coupons` | List coupons |
| POST | `/api/admin/billing/coupons` | Create coupon |
| GET | `/api/admin/billing/webhooks` | View webhook logs |
| GET | `/api/admin/billing/reports` | Generate reports |

## Webhook API

| Method | Endpoint | Description |
|---|---|---|
| POST | `/webhooks/stripe` | Stripe webhook handler |
| POST | `/webhooks/paddle` | Paddle webhook handler |
| POST | `/webhooks/lemon-squeezy` | Lemon Squeezy webhook handler |

---

# Future Expansion

The billing architecture is designed to accommodate:

* **Marketplace Revenue Sharing** — 70/30 split with creators, automated payouts
* **Affiliate Program** — referral tracking, commission calculation
* **Wallet/Credits System** — pre-paid balance, credit consumption
* **Usage Metering** — API calls, AI tokens, storage usage
* **Regional Pricing** — PPP-adjusted pricing by region
* **Educational Discounts** — student/teacher verification
* **Non-profit Pricing** — discounted plans for qualifying organizations
* **White-label Licensing** — license the framework itself
* **API Usage Billing** — metered billing for API consumers
* **Volume Licensing** — bulk discounts for large teams
* **Multi-currency Support** — prices in local currencies
* **Payment Plan Installments** — split payments over time
* **Revenue Recognition** — ASC 606 / IFRS 15 compliance
* **Subscription Analytics** — cohort analysis, retention curves
* **Churn Prediction** — ML-based churn risk scoring
* **Smart Retries** — AI-optimized retry timing
* **Dunning Management** — automated collection workflows
* **Multi-provider Fallback** — automatic failover between providers

---

# Billing Testing Strategy

## Unit Tests

| Test Class | Description |
|---|---|
| `PriceCalculatorTest` | Test price calculations and proration |
| `TaxEngineTest` | Test tax calculations for different regions |
| `CouponTest` | Test coupon validation and application |
| `LicenseTest` | Test license generation and validation |
| `EntitlementTest` | Test entitlement resolution |

## Feature Tests

| Test Class | Description |
|---|---|
| `CheckoutFlowTest` | Test complete checkout process |
| `SubscriptionLifecycleTest` | Test all subscription state transitions |
| `WebhookTest` | Test webhook processing for each provider |
| `RefundTest` | Test refund processing |
| `InvoiceTest` | Test invoice generation |

## Integration Tests

| Test Class | Description |
|---|---|
| `StripeIntegrationTest` | Test Stripe API integration |
| `PaddleIntegrationTest` | Test Paddle API integration |
| `LemonSqueezyIntegrationTest` | Test Lemon Squeezy API integration |

## Browser Tests (Playwright)

| Test | Description |
|---|---|
| Pricing page | Plans display correctly |
| Checkout flow | Complete purchase flow |
| Invoice download | PDF generation works |
| Coupon application | Coupons apply correctly |
| Payment method management | Add/remove cards |

---

# Billing Performance Optimization

## Query Optimization

| Query | Optimization | Index |
|---|---|---|
| Active subscriptions | Eager load plan | `status` index |
| User orders | Scope by user_id | `(user_id, status)` |
| Entitlement check | Cache in Redis | N/A |
| MRR calculation | Cache daily | N/A |
| Invoice generation | Batch processing | N/A |

## Caching Strategy

| Cache Key | TTL | Invalidation |
|---|---|---|
| `billing:plans:active` | 1 hour | Plan CRUD |
| `billing:mrr:daily` | 24 hours | Daily job |
| `billing:entitlements:{user_id}` | 60 seconds | Subscription change |
| `billing:invoice:{id}` | 24 hours | Invoice update |

## Database Indexes

```php
Schema::table('orders', function (Blueprint $table) {
    $table->index('status');
    $table->index(['user_id', 'status']);
    $table->index('created_at');
    $table->index('provider_order_id');
});

Schema::table('payments', function (Blueprint $table) {
    $table->index('status');
    $table->index('order_id');
    $table->index('provider_payment_id');
});

Schema::table('subscriptions', function (Blueprint $table) {
    $table->index('status');
    $table->index(['user_id', 'status']);
    $table->index('current_period_end');
});
```

---

# Billing Error Handling

## Exception Hierarchy

```php
// Base
class BillingException extends \RuntimeException {}

// Payment
class PaymentFailedException extends BillingException {}
class PaymentMethodRequiredException extends BillingException {}
class PaymentMethodInvalidException extends BillingException {}

// Subscription
class SubscriptionNotFoundException extends BillingException {}
class SubscriptionNotActiveException extends BillingException {}
class InvalidTransitionException extends BillingException {}

// Plan
class PlanNotFoundException extends BillingException {}
class PlanNotActiveException extends BillingException {}

// Coupon
class CouponNotFoundException extends BillingException {}
class CouponExpiredException extends BillingException {}
class CouponLimitReachedException extends BillingException {}

// License
class LicenseNotFoundException extends BillingException {}
class LicenseExpiredException extends BillingException {}
class LicenseLimitReachedException extends BillingException {}

// Refund
class RefundExceedsPaymentException extends BillingException {}
class RefundNotAllowedException extends BillingException {}

// Webhook
class WebhookSignatureInvalidException extends BillingException {}
class WebhookAlreadyProcessedException extends BillingException {}
```

## Error Response Format

```php
class BillingErrorResponse
{
    public function __construct(
        public readonly string $code,
        public readonly string $message,
        public readonly ?array $details = null,
        public readonly ?string $upgradeUrl = null,
    ) {}

    public function toArray(): array
    {
        return [
            'error' => [
                'code' => $this->code,
                'message' => $this->message,
                'details' => $this->details,
                'upgrade_url' => $this->upgradeUrl,
            ],
        ];
    }
}
```

---

# Billing Migration Guide

## From Manual Billing to Automated

```text
1. Export existing customer data
2. Map to provider customers
3. Import subscription data
4. Verify payment methods
5. Enable auto-renewal
6. Monitor first renewal cycle
7. Handle any failures
```

## Between Payment Providers

```text
1. Set up new provider account
2. Map existing products/prices
3. Migrate customer data
4. Update webhook endpoints
5. Test webhook processing
6. Switch DNS/config
7. Monitor for 7 days
8. Decommission old provider
```

## Data Migration Script

```php
class BillingMigrationCommand extends Command
{
    protected $signature = 'billing:migrate {--from=} {--to=}';

    public function handle(): void
    {
        $from = $this->option('from');
        $to = $this->option('to');

        $this->info("Migrating billing from {$from} to {$to}");

        // 1. Export customers
        $customers = $this->exportCustomers($from);

        // 2. Import to new provider
        foreach ($customers as $customer) {
            $this->importCustomer($to, $customer);
        }

        // 3. Migrate subscriptions
        $subscriptions = $this->exportSubscriptions($from);
        foreach ($subscriptions as $subscription) {
            $this->importSubscription($to, $subscription);
        }

        $this->info('Migration complete');
    }
}
```

---

# Billing Security Deep Dive

## PCI Compliance

| Requirement | Implementation |
|---|---|
| No card data stored | Provider handles all card data |
| Tokenization | Use provider tokens only |
| Secure transmission | HTTPS everywhere |
| Access control | Role-based admin access |
| Audit logging | All operations logged |

## Webhook Security

```php
class WebhookSecurityVerifier
{
    public function verifyStripe(string $payload, string $signature): bool
    {
        $secret = config('services.stripe.webhook_secret');
        $expected = hash_hmac('sha256', $payload, $secret);
        return hash_equals($expected, $signature);
    }

    public function verifyPaddle(string $payload, string $signature): bool
    {
        $publicKey = config('services.paddle.public_key');
        $params = json_decode($payload, true);
        $actualSignature = $params['signature'];
        unset($params['signature']);

        ksort($params);
        $queryString = http_build_query($params);
        $expectedSignature = hash_hmac('sha1', $queryString, $publicKey);

        return hash_equals($expectedSignature, $actualSignature);
    }
}
```

## API Security

| Measure | Description |
|---|---|
| Authentication | Sanctum token-based |
| Rate Limiting | Per-user and per-endpoint |
| Input Validation | Form Request validation |
| CSRF Protection | All state-changing routes |
| SQL Injection | Eloquent parameterized queries |
| XSS Prevention | Blade auto-escaping |

---

# Billing Reporting

## Daily Reports

| Report | Description |
|---|---|
| Revenue Summary | Daily revenue, orders, refunds |
| Subscription Changes | New, canceled, upgraded, downgraded |
| Failed Payments | Failed renewals and retries |
| Webhook Events | Webhook processing status |

## Monthly Reports

| Report | Description |
|---|---|
| MRR Report | Monthly recurring revenue |
| Churn Report | Churn rate by plan |
| LTV Report | Customer lifetime value |
| Revenue by Plan | Revenue contribution per plan |

## Report Generation

```php
class BillingReportGenerator
{
    public function generateDailyReport(Carbon $date): DailyReport
    {
        return new DailyReport(
            date: $date,
            revenue: $this->getDailyRevenue($date),
            orders: $this->getDailyOrders($date),
            refunds: $this->getDailyRefunds($date),
            newSubscriptions: $this->getNewSubscriptions($date),
            canceledSubscriptions: $this->getCanceledSubscriptions($date),
            failedPayments: $this->getFailedPayments($date),
        );
    }

    public function generateMonthlyReport(Carbon $month): MonthlyReport
    {
        return new MonthlyReport(
            month: $month,
            mrr: app(MRRCalculator::class)->calculate(),
            arr: app(MRRCalculator::class)->calculate() * 12,
            churnRate: app(ChurnCalculator::class)->calculate('30d'),
            ltv: app(LTVCalculator::class)->calculate(),
            revenueByPlan: $this->getRevenueByPlan($month),
            subscriptionChanges: $this->getSubscriptionChanges($month),
        );
    }
}
```
