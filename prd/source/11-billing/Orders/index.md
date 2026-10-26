# Order Management

## Overview

Orders track purchases, subscriptions, and transactions. This document covers the complete order lifecycle from creation to fulfillment, including order items, status management, notifications, and admin tools.

## Order Lifecycle

```
┌──────────┐   payment    ┌──────────┐  fulfillment  ┌──────────┐
│ Pending  │ ──────────► │ Paid     │ ────────────► │ Complete │
└──────────┘              └──────────┘               └──────────┘
     │                         │
     │ cancel                  │ refund
     ▼                         ▼
┌──────────┐              ┌──────────┐
│ Cancelled│              │ Refunded │
└──────────┘              └──────────┘
                                │
                           partial refund
                                │
                                ▼
                          ┌──────────┐
                          │ Partial  │
                          │ Refund   │
                          └──────────┘
```

### Order Model

```php
class Order extends Model
{
    protected $fillable = [
        'user_id', 'number', 'status', 'subtotal', 'tax',
        'discount', 'total', 'currency', 'notes',
        'metadata', 'paid_at', 'shipped_at', 'completed_at',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'tax' => 'integer',
        'discount' => 'integer',
        'total' => 'integer',
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }
}
```

## Order Items

### Order Item Model

```php
class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'price_id', 'sku_id',
        'name', 'quantity', 'unit_price', 'total',
        'metadata',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'integer',
        'total' => 'integer',
        'metadata' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function price(): BelongsTo
    {
        return $this->belongsTo(Price::class);
    }
}
```

### Adding Items

```php
$order = Order::create([
    'user_id' => $user->id,
    'number' => OrderNumber::generate(),
    'status' => 'pending',
    'currency' => 'USD',
]);

$order->addItem([
    'product_id' => $product->id,
    'price_id' => $price->id,
    'sku_id' => $sku->id,
    'name' => $product->name,
    'quantity' => 1,
    'unit_price' => $price->amount,
]);

$order->calculateTotals();
```

## Order Status

### Status Values

| Status | Description | Next States |
|--------|-------------|-------------|
| `pending` | Awaiting payment | paid, cancelled |
| `paid` | Payment received | processing, completed, refunded |
| `processing` | Being fulfilled | shipped, completed |
| `shipped` | In transit | delivered |
| `delivered` | Received | completed |
| `completed` | Order finalized | refunded |
| `cancelled` | User cancelled | — |
| `refunded` | Fully refunded | — |

### Status Transitions

```php
class OrderStateMachine
{
    protected array $transitions = [
        'pending' => ['paid', 'cancelled'],
        'paid' => ['processing', 'completed', 'refunded'],
        'processing' => ['shipped', 'completed'],
        'shipped' => ['delivered'],
        'delivered' => ['completed'],
        'completed' => ['refunded'],
    ];

    public function transition(Order $order, string $to): void
    {
        $from = $order->status;

        if (!in_array($to, $this->transitions[$from] ?? [])) {
            throw new InvalidTransitionException(
                "Cannot transition from '{$from}' to '{$to}'"
            );
        }

        $order->update(['status' => $to]);
        $this->fireEvents($order, $from, $to);
    }

    protected function fireEvents(Order $order, string $from, string $to): void
    {
        event(new OrderStatusChanged($order, $from, $to));

        match ($to) {
            'paid' => event(new OrderPaid($order)),
            'completed' => event(new OrderCompleted($order)),
            'cancelled' => event(new OrderCancelled($order)),
            'refunded' => event(new OrderRefunded($order)),
            default => null,
        };
    }
}
```

## Email Notifications

### Notification Events

| Event | Recipient | Template | Trigger |
|-------|-----------|----------|---------|
| `OrderCreated` | Customer | `order.created` | Order placed |
| `OrderPaid` | Customer | `order.paid` | Payment received |
| `OrderShipped` | Customer | `order.shipped` | Item shipped |
| `OrderCompleted` | Customer | `order.completed` | Order finalized |
| `OrderCancelled` | Customer | `order.cancelled` | Order cancelled |
| `OrderRefunded` | Customer | `order.refunded` | Refund processed |
| `NewOrder` | Admin | `admin.new_order` | New order created |
| `OrderIssue` | Admin | `admin.order_issue` | Payment failure |

### Notification Setup

```php
class OrderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(OrderPaid::class, function (OrderPaid $event) {
            Notification::send($event->order->user, new OrderPaidNotification($event->order));
        });

        Event::listen(OrderShipped::class, function (OrderShipped $event) {
            Notification::send($event->order->user, new OrderShippedNotification($event->order));
        });

        Event::listen(NewOrder::class, function (NewOrder $event) {
            Notification::send(
                User::role('admin')->get(),
                new AdminNewOrderNotification($event->order)
            );
        });
    }
}
```

## Admin Tools

### Order Dashboard

```php
class OrderDashboard extends Component
{
    public function stats(): array
    {
        return [
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'refunds_today' => Refund::whereDate('created_at', today())->count(),
        ];
    }

    public function recentOrders(): Collection
    {
        return Order::with('user', 'items')
            ->latest()
            ->limit(20)
            ->get();
    }
}
```

### Admin Order Actions

```php
class AdminOrderController extends Controller
{
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $this->authorize('manage-orders');

        $order->transitionTo($request->status);

        return redirect()->back()->with('success', 'Order status updated.');
    }

    public function addNote(AddOrderNoteRequest $request, Order $order)
    {
        $this->authorize('manage-orders');

        $order->notes()->create([
            'user_id' => $this->user()->id,
            'content' => $request->content,
        ]);

        return redirect()->back();
    }

    public function resendConfirmation(Order $order)
    {
        $this->authorize('manage-orders');

        OrderConfirmationMail::send($order);

        return redirect()->back()->with('success', 'Confirmation email resent.');
    }
}
```

## Order Database Schema

### Orders Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `user_id` | `bigint` | FK to users |
| `number` | `string` | Unique order number |
| `status` | `enum` | Order status |
| `subtotal` | `bigint` | Before tax/discounts |
| `tax` | `bigint` | Tax amount |
| `discount` | `bigint` | Discount amount |
| `total` | `bigint` | Final amount |
| `currency` | `string` | ISO 4217 |
| `notes` | `text?` | Admin notes |
| `metadata` | `json` | |
| `paid_at` | `timestamp?` | |
| `shipped_at` | `timestamp?` | |
| `completed_at` | `timestamp?` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

### Order Items Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `order_id` | `bigint` | FK to orders |
| `product_id` | `bigint` | FK to products |
| `price_id` | `bigint` | FK to prices |
| `sku_id` | `bigint?` | FK to skus |
| `name` | `string` | Snapshot of product name |
| `quantity` | `int` | |
| `unit_price` | `bigint` | Price at time of purchase |
| `total` | `bigint` | quantity × unit_price |
| `metadata` | `json` | |

## Best Practices

1. **Generate unique order numbers** — sequential but non-guessable
2. **Snapshot prices** — never reference live prices in historical orders
3. **Use state machines** — enforce valid status transitions
4. **Send notifications** at every status change
5. **Keep audit trail** — log all admin actions on orders
6. **Handle webhooks idempotently** — prevent duplicate processing
