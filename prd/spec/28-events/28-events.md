# 28 - Events

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

Events are the decoupling mechanism between GsmUi bounded contexts. Instead of services calling each other directly, they publish domain events that other services can subscribe to.

---

# Vision

Create a loosely-coupled, event-driven architecture that enables services to evolve independently while maintaining consistency through eventual consistency.

---

# Core Concepts

## Event Types

* Domain Events — Business occurrences
* Integration Events — Cross-service communication
* Infrastructure Events — System events

## Event Characteristics

* Immutable
* Timestamped
* Contains relevant data
* Named in past tense
* Serializable

---

# Event Architecture

```text
Action / Service
    ↓
Event Dispatcher
    ↓
Event Listeners
├── Synchronous Listeners
├── Asynchronous Listeners (Jobs)
└── Subscriber Classes
    ↓
Side Effects
├── Database Updates
├── Cache Invalidation
├── Notifications
├── Search Index Updates
└── External Integrations
```

---

# Domain Events

## User Events

```
UserRegistered
UserUpdated
UserDeleted
UserEmailVerified
UserPasswordChanged
UserTwoFactorEnabled
UserTwoFactorDisabled
```

## Component Events

```
ComponentCreated
ComponentUpdated
ComponentPublished
ComponentArchived
ComponentFeatured
ComponentViewed
ComponentInstalled
```

## Template Events

```
TemplateCreated
TemplateUpdated
TemplatePublished
TemplatePurchased
TemplateDownloaded
TemplateReviewed
```

## Theme Events

```
ThemeCreated
ThemeUpdated
ThemePublished
ThemeForked
ThemeApplied
ThemeExported
```

## Documentation Events

```
DocPageCreated
DocPageUpdated
DocPagePublished
DocPageViewed
DocSearchPerformed
```

## Marketplace Events

```
ProductListed
ProductPurchased
ProductReviewed
OrderCreated
OrderCompleted
OrderRefunded
```

## Subscription Events

```
SubscriptionCreated
SubscriptionRenewed
SubscriptionUpgraded
SubscriptionDowngraded
SubscriptionCancelled
SubscriptionExpired
```

## Billing Events

```
PaymentSuccessful
PaymentFailed
InvoiceGenerated
RefundProcessed
CouponRedeemed
```

---

# Event Structure

## Base Event Class

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class DomainEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $eventId;
    public string $eventType;
    public string $aggregateType;
    public string $aggregateId;
    public array $payload;
    public \DateTimeImmutable $occurredAt;
    public array $metadata;

    public function __construct(string $aggregateId, array $payload = [], array $metadata = [])
    {
        $this->eventId = $this->generateEventId();
        $this->eventType = static::class;
        $this->aggregateType = $this->getAggregateType();
        $this->aggregateId = $aggregateId;
        $this->payload = $payload;
        $this->occurredAt = new \DateTimeImmutable();
        $this->metadata = array_merge([
            'caused_by' => auth()->id(),
            'ip_address' => request()->ip(),
        ], $metadata);
    }

    abstract protected function getAggregateType(): string;

    protected function generateEventId(): string
    {
        return sprintf('%s-%s', strtolower(static::class), uniqid());
    }
}
```

## Concrete Event Example

```php
<?php

namespace App\Events\Components;

use App\Events\DomainEvent;

class ComponentPublished extends DomainEvent
{
    protected function getAggregateType(): string
    {
        return 'component';
    }

    public static function create(string $componentId, array $data = []): static
    {
        return new static($componentId, $data);
    }
}
```

---

# Event Listeners

## Synchronous Listener

```php
<?php

namespace App\Listeners\Components;

use App\Events\Components\ComponentPublished;

class NotifySubscribers
{
    public function handle(ComponentPublished $event): void
    {
        $subscribers = User::subscribedToCategory($event->payload['category'])
            ->get();

        foreach ($subscribers as $subscriber) {
            Notification::send($subscriber, new ComponentPublishedNotification(
                $event->aggregateId,
                $event->payload
            ));
        }
    }
}
```

## Asynchronous Listener (Job)

```php
<?php

namespace App\Listeners\Components;

use App\Events\Components\ComponentPublished;
use App\Jobs\Search\IndexComponent;

class IndexComponentForSearch
{
    public function handle(ComponentPublished $event): void
    {
        IndexComponent::dispatch($event->aggregateId);
    }
}
```

---

# Event Registration

## EventServiceProvider

```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ComponentPublished::class => [
            NotifySubscribers::class,
            IndexComponentForSearch::class,
            InvalidateComponentCache::class,
            SendPublicationNotification::class,
        ],

        TemplatePurchased::class => [
            GenerateLicenseKey::class,
            SendPurchaseReceipt::class,
            UpdateTemplateStats::class,
            GrantDownloadAccess::class,
        ],

        SubscriptionCreated::class => [
            GrantEntitlements::class,
            SendWelcomeEmail::class,
            InitializeUsageQuota::class,
        ],
    ];
}
```

---

# Event Storage

## Event Store Table

```sql
CREATE TABLE domain_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id VARCHAR(255) UNIQUE NOT NULL,
    event_type VARCHAR(255) NOT NULL,
    aggregate_type VARCHAR(255) NOT NULL,
    aggregate_id VARCHAR(255) NOT NULL,
    payload JSON NOT NULL,
    metadata JSON,
    occurred_at TIMESTAMP NOT NULL,
    processed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_aggregate (aggregate_type, aggregate_id),
    INDEX idx_event_type (event_type),
    INDEX idx_occurred_at (occurred_at)
);
```

---

# Event Replay

## Use Cases

* Rebuild read models
* Debug issues
* Audit trail
* Data migration

## Replay Process

```text
Load events from store
    ↓
Filter by aggregate type
    ↓
Filter by date range
    ↓
Replay events in order
    ↓
Rebuild current state
```

---

# Event Monitoring

## Metrics

* Events dispatched per minute
* Listener execution time
* Failed events
* Event queue depth

## Logging

```json
{
  "event_id": "componentpublished-comp_abc123",
  "event_type": "ComponentPublished",
  "aggregate_id": "comp_abc123",
  "payload": {
    "name": "button",
    "category": "actions"
  },
  "occurred_at": "2024-01-15T10:00:00Z",
  "listeners_executed": 4,
  "total_time_ms": 45
}
```

---

# Technical Architecture

```text
Event Producer (Action/Service)
    ↓
Event Dispatcher (Laravel)
    ↓
Event Store (Database)
    ↓
Event Listeners
├── Synchronous (direct)
└── Asynchronous (queue)
    ↓
Side Effects
├── Database updates
├── Cache invalidation
├── Notifications
├── Search updates
└── External webhooks
```

---

# Best Practices

* Keep events small and focused
* Include all necessary data in payload
* Make events idempotent
* Use descriptive names (past tense)
* Version events for backward compatibility
* Log all events for debugging
* Test event handlers independently

---

# Success Metrics

* 100% event coverage for domain actions
* <50ms average listener execution
* <1% event failure rate
* 99.9% eventual consistency
* Zero lost events

---

# Database Schema (Extended)

## domain_events

```sql
CREATE TABLE domain_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id VARCHAR(255) UNIQUE NOT NULL,
    event_type VARCHAR(255) NOT NULL,
    event_version INT DEFAULT 1,
    aggregate_type VARCHAR(255) NOT NULL,
    aggregate_id VARCHAR(255) NOT NULL,
    payload JSON NOT NULL,
    metadata JSON NULL,
    correlation_id VARCHAR(255) NULL,
    causation_id VARCHAR(255) NULL,
    occurred_at TIMESTAMP NOT NULL,
    stored_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_at TIMESTAMP NULL,
    processed_by JSON NULL,
    INDEX idx_aggregate (aggregate_type, aggregate_id),
    INDEX idx_event_type (event_type),
    INDEX idx_occurred_at (occurred_at),
    INDEX idx_stored_at (stored_at),
    INDEX idx_correlation (correlation_id),
    INDEX idx_processed (processed_at)
);
```

## event_subscriptions

```sql
CREATE TABLE event_subscriptions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    subscriber_type VARCHAR(255) NOT NULL,
    subscriber_id BIGINT UNSIGNED NOT NULL,
    event_type VARCHAR(255) NOT NULL,
    channel VARCHAR(255) DEFAULT 'default',
    is_active BOOLEAN DEFAULT TRUE,
    last_event_id BIGINT UNSIGNED NULL,
    last_consumed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_subscriber (subscriber_type, subscriber_id),
    INDEX idx_event_type (event_type),
    INDEX idx_channel (channel),
    FOREIGN KEY (last_event_id) REFERENCES domain_events(id) ON DELETE SET NULL
);
```

## event_projections

```sql
CREATE TABLE event_projections (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    status ENUM('active','paused','failed') NOT NULL DEFAULT 'active',
    last_event_id BIGINT UNSIGNED NULL,
    last_processed_at TIMESTAMP NULL,
    events_processed BIGINT DEFAULT 0,
    errors_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (last_event_id) REFERENCES domain_events(id) ON DELETE SET NULL
);
```

## event_snapshots

```sql
CREATE TABLE event_snapshots (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    aggregate_type VARCHAR(255) NOT NULL,
    aggregate_id VARCHAR(255) NOT NULL,
    version INT NOT NULL,
    state JSON NOT NULL,
    event_count INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_aggregate (aggregate_type, aggregate_id),
    INDEX idx_version (version)
);
```

---

# Event Bus

## EventBus Service

```php
<?php

namespace App\Services\Events;

use App\Events\DomainEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventBus
{
    protected array $handlers = [];
    protected array $middleware = [];

    public function register(string $eventType, string $handlerClass): void
    {
        $this->handlers[$eventType][] = $handlerClass;
    }

    public function addMiddleware(string $middleware): void
    {
        $this->middleware[] = $middleware;
    }

    public function dispatch(DomainEvent $event): void
    {
        $this->storeEvent($event);

        foreach ($this->middleware as $middlewareClass) {
            $middleware = app($middlewareClass);
            if (!$middleware->handle($event)) {
                return;
            }
        }

        $handlers = $this->handlers[$event->eventType] ?? [];

        foreach ($handlers as $handlerClass) {
            $handler = app($handlerClass);
            try {
                $handler->handle($event);
            } catch (\Exception $e) {
                Log::error("Event handler failed", [
                    'event_type' => $event->eventType,
                    'handler' => $handlerClass,
                    'error' => $e->getMessage(),
                ]);
                $this->handleFailure($event, $handlerClass, $e);
            }
        }
    }

    public function dispatchAsync(DomainEvent $event): void
    {
        $this->storeEvent($event);
        ProcessEventJob::dispatch($event);
    }

    protected function storeEvent(DomainEvent $event): void
    {
        DB::table('domain_events')->insert([
            'event_id' => $event->eventId,
            'event_type' => $event->eventType,
            'event_version' => 1,
            'aggregate_type' => $event->aggregateType,
            'aggregate_id' => $event->aggregateId,
            'payload' => json_encode($event->payload),
            'metadata' => json_encode($event->metadata),
            'correlation_id' => $event->metadata['correlation_id'] ?? null,
            'causation_id' => $event->metadata['causation_id'] ?? null,
            'occurred_at' => $event->occurredAt,
        ]);
    }

    protected function handleFailure(DomainEvent $event, string $handlerClass, \Exception $e): void
    {
        DB::table('failed_events')->insert([
            'event_id' => $event->eventId,
            'event_type' => $event->eventType,
            'handler' => $handlerClass,
            'error' => $e->getMessage(),
            'payload' => json_encode($event->payload),
            'retry_count' => 0,
            'created_at' => now(),
        ]);
    }

    public function replay(string $aggregateType, string $aggregateId, ?string $fromDate = null, ?string $toDate = null): \Illuminate\Support\Collection
    {
        $query = DB::table('domain_events')
            ->where('aggregate_type', $aggregateType)
            ->where('aggregate_id', $aggregateId)
            ->orderBy('occurred_at');

        if ($fromDate) {
            $query->where('occurred_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->where('occurred_at', '<=', $toDate);
        }

        return $query->get()->map(function ($record) {
            return json_decode(json_encode([
                'event_id' => $record->event_id,
                'event_type' => $record->event_type,
                'aggregate_type' => $record->aggregate_type,
                'aggregate_id' => $record->aggregate_id,
                'payload' => json_decode($record->payload, true),
                'metadata' => json_decode($record->metadata, true),
                'occurred_at' => $record->occurred_at,
            ]));
        });
    }

    public function getEventStream(string $aggregateType, ?int $afterEventId = null, int $limit = 100): \Illuminate\Support\Collection
    {
        $query = DB::table('domain_events')
            ->where('aggregate_type', $aggregateType)
            ->orderBy('id');

        if ($afterEventId) {
            $query->where('id', '>', $afterEventId);
        }

        return $query->limit($limit)->get();
    }
}
```

## ProcessEventJob

```php
<?php

namespace App\Services\Events;

use App\Events\DomainEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 30;
    public array $backoff = [10, 30, 60];

    public function __construct(
        public DomainEvent $event
    ) {}

    public function handle(EventBus $eventBus): void
    {
        $eventBus->dispatch($this->event);
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error("ProcessEventJob failed", [
            'event_id' => $this->event->eventId,
            'event_type' => $this->event->eventType,
            'error' => $exception->getMessage(),
        ]);
    }
}
```

---

# Event Middleware

## RateLimitMiddleware

```php
<?php

namespace App\Services\Events\Middleware;

use App\Events\DomainEvent;

class RateLimitMiddleware
{
    public function handle(DomainEvent $event): bool
    {
        $key = "event_rate:{$event->eventType}";
        $limit = 100;
        $window = 60;

        $current = \Illuminate\Support\Facades\Cache::get($key, 0);

        if ($current >= $limit) {
            \Log::warning("Event rate limit exceeded", [
                'event_type' => $event->eventType,
                'current' => $current,
                'limit' => $limit,
            ]);
            return false;
        }

        \Illuminate\Support\Facades\Cache::put($key, $current + 1, $window);
        return true;
    }
}
```

## AuditMiddleware

```php
<?php

namespace App\Services\Events\Middleware;

use App\Events\DomainEvent;

class AuditMiddleware
{
    public function handle(DomainEvent $event): bool
    {
        \Log::info("Event dispatched", [
            'event_id' => $event->eventId,
            'event_type' => $event->eventType,
            'aggregate_type' => $event->aggregateType,
            'aggregate_id' => $event->aggregateId,
            'caused_by' => $event->metadata['caused_by'] ?? null,
            'ip_address' => $event->metadata['ip_address'] ?? null,
            'occurred_at' => $event->occurredAt->toIso8601String(),
        ]);

        return true;
    }
}
```

---

# Event Subscribers

## UserEventSubscriber

```php
<?php

namespace App\Services\Events\Subscribers;

class UserEventSubscriber
{
    public function subscribe($events): void
    {
        $events->listen(
            \App\Events\User\UserRegistered::class,
            \App\Listeners\User\SendWelcomeEmail::class
        );

        $events->listen(
            \App\Events\User\UserRegistered::class,
            \App\Listeners\User\InitializeProfile::class
        );

        $events->listen(
            \App\Events\User\UserRegistered::class,
            \App\Listeners\User\GrantTrialAccess::class
        );

        $events->listen(
            \App\Events\User\UserEmailVerified::class,
            \App\Listeners\User\SendVerificationConfirmation::class
        );

        $events->listen(
            \App\Events\User\UserPasswordChanged::class,
            \App\Listeners\User\RevokeAllSessions::class
        );

        $events->listen(
            \App\Events\User\UserPasswordChanged::class,
            \App\Listeners\User\SendPasswordChangeNotification::class
        );

        $events->listen(
            \App\Events\User\UserTwoFactorEnabled::class,
            \App\Listeners\User\SendTwoFactorEnabledNotification::class
        );

        $events->listen(
            \App\Events\User\UserDeleted::class,
            \App\Listeners\User\CleanupUserData::class
        );

        $events->listen(
            \App\Events\User\UserDeleted::class,
            \App\Listeners\User\CancelSubscriptions::class
        );
    }
}
```

## ComponentEventSubscriber

```php
<?php

namespace App\Services\Events\Subscribers;

class ComponentEventSubscriber
{
    public function subscribe($events): void
    {
        $events->listen(
            \App\Events\Components\ComponentCreated::class,
            \App\Listeners\Components\IndexComponentForSearch::class
        );

        $events->listen(
            \App\Events\Components\ComponentCreated::class,
            \App\Listeners\Components\InvalidateComponentCache::class
        );

        $events->listen(
            \App\Events\Components\ComponentPublished::class,
            \App\Listeners\Components\NotifySubscribers::class
        );

        $events->listen(
            \App\Events\Components\ComponentPublished::class,
            \App\Listeners\Components\UpdateComponentStats::class
        );

        $events->listen(
            \App\Events\Components\ComponentPublished::class,
            \App\Listeners\Components\SendPublicationNotification::class
        );

        $events->listen(
            \App\Events\Components\ComponentFeatured::class,
            \App\Listeners\Components\NotifyFeaturedAuthor::class
        );

        $events->listen(
            \App\Events\Components\ComponentViewed::class,
            \App\Listeners\Components\TrackViewCount::class
        );

        $events->listen(
            \App\Events\Components\ComponentInstalled::class,
            \App\Listeners\Components\TrackInstallCount::class
        );
    }
}
```

---

# Concrete Event Classes

## UserRegistered

```php
<?php

namespace App\Events\User;

use App\Events\DomainEvent;

class UserRegistered extends DomainEvent
{
    protected function getAggregateType(): string
    {
        return 'user';
    }

    public static function create(array $userData): static
    {
        return new static(
            (string) $userData['id'],
            [
                'name' => $userData['name'],
                'email' => $userData['email'],
                'plan' => $userData['plan'] ?? 'free',
            ]
        );
    }
}
```

## ComponentPublished

```php
<?php

namespace App\Events\Components;

use App\Events\DomainEvent;

class ComponentPublished extends DomainEvent
{
    protected function getAggregateType(): string
    {
        return 'component';
    }

    public static function create(string $componentId, array $data): static
    {
        return new static($componentId, $data);
    }
}
```

## TemplatePurchased

```php
<?php

namespace App\Events\Marketplace;

use App\Events\DomainEvent;

class TemplatePurchased extends DomainEvent
{
    protected function getAggregateType(): string
    {
        return 'template';
    }

    public static function create(string $templateId, array $data): static
    {
        return new static($templateId, $data);
    }
}
```

## SubscriptionCreated

```php
<?php

namespace App\Events\Subscription;

use App\Events\DomainEvent;

class SubscriptionCreated extends DomainEvent
{
    protected function getAggregateType(): string
    {
        return 'subscription';
    }

    public static function create(string $subscriptionId, array $data): static
    {
        return new static($subscriptionId, $data);
    }
}
```

---

# Event Listeners (Extended)

## NotifySubscribers

```php
<?php

namespace App\Listeners\Components;

use App\Events\Components\ComponentPublished;
use App\Models\User;
use App\Notifications\ComponentPublishedNotification;

class NotifySubscribers
{
    public function handle(ComponentPublished $event): void
    {
        $subscribers = User::whereHas('subscriptions', function ($q) use ($event) {
            $q->where('category', $event->payload['category'] ?? null)
              ->orWhere('all_categories', true);
        })->get();

        foreach ($subscribers as $subscriber) {
            $subscriber->notify(new ComponentPublishedNotification(
                $event->aggregateId,
                $event->payload['name'] ?? 'Unknown',
                $event->payload['category'] ?? 'general'
            ));
        }
    }
}
```

## IndexComponentForSearch

```php
<?php

namespace App\Listeners\Components;

use App\Events\Components\ComponentPublished;
use App\Jobs\Search\IndexComponentJob;

class IndexComponentForSearch
{
    public function handle(ComponentPublished $event): void
    {
        IndexComponentJob::dispatch($event->aggregateId);
    }
}
```

## InvalidateComponentCache

```php
<?php

namespace App\Listeners\Components;

use App\Events\Components\ComponentPublished;
use Illuminate\Support\Facades\Cache;

class InvalidateComponentCache
{
    public function handle(ComponentPublished $event): void
    {
        Cache::forget("component:{$event->aggregateId}");
        Cache::tags(['components'])->flush();
        Cache::tags(['components:featured'])->flush();
    }
}
```

## SendPublicationNotification

```php
<?php

namespace App\Listeners\Components;

use App\Events\Components\ComponentPublished;
use App\Models\Component;
use App\Models\User;
use App\Notifications\PublicationNotification;

class SendPublicationNotification
{
    public function handle(ComponentPublished $event): void
    {
        $component = Component::find($event->aggregateId);
        if (!$component) {
            return;
        }

        $author = $component->author;
        if ($author) {
            $author->notify(new PublicationNotification(
                $component->name,
                $component->version
            ));
        }
    }
}
```

## GenerateLicenseKey

```php
<?php

namespace App\Listeners\Marketplace;

use App\Events\Marketplace\TemplatePurchased;
use App\Models\License;
use Illuminate\Support\Str;

class GenerateLicenseKey
{
    public function handle(TemplatePurchased $event): void
    {
        License::create([
            'user_id' => $event->metadata['caused_by'],
            'product_type' => 'template',
            'product_id' => $event->aggregateId,
            'license_key' => Str::upper(Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4) . '-' . Str::random(4)),
            'type' => $event->payload['license_type'] ?? 'pro',
            'expires_at' => now()->addYear(),
            'max_projects' => $event->payload['max_projects'] ?? 5,
        ]);
    }
}
```

## GrantEntitlements

```php
<?php

namespace App\Listeners\Subscription;

use App\Events\Subscription\SubscriptionCreated;
use App\Models\User;

class GrantEntitlements
{
    public function handle(SubscriptionCreated $event): void
    {
        $user = User::find($event->metadata['caused_by']);
        if (!$user) {
            return;
        }

        $plan = $event->payload['plan'] ?? 'pro';

        $entitlements = match ($plan) {
            'free' => [
                'ai_credits' => 10,
                'api_calls' => 1000,
                'storage' => 1 * 1024 * 1024 * 1024,
                'components' => 'basic',
            ],
            'pro' => [
                'ai_credits' => 100,
                'api_calls' => 50000,
                'storage' => 10 * 1024 * 1024 * 1024,
                'components' => 'all',
            ],
            'team' => [
                'ai_credits' => 500,
                'api_calls' => 250000,
                'storage' => 50 * 1024 * 1024 * 1024,
                'components' => 'all',
            ],
            default => [
                'ai_credits' => 10,
                'api_calls' => 1000,
                'storage' => 1 * 1024 * 1024 * 1024,
                'components' => 'basic',
            ],
        };

        $user->entitlements()->create($entitlements);
    }
}
```

---

# Event Caching Strategy

| Cache Key | TTL | Invalidation |
|-----------|-----|--------------|
| `event:stats:{type}` | 5 min | On new event |
| `event:recent:{type}` | 1 min | On new event |
| `event:rate:{type}` | 1 min | Sliding window |
| `event:handler:{type}` | 24 hours | On handler change |

---

# Event Monitoring

## Metrics Dashboard

```text
Event Bus Dashboard
───────────────────

Events Today: 12,450
├── User Events: 2,300
├── Component Events: 4,500
├── Template Events: 1,200
├── Subscription Events: 800
├── Marketplace Events: 2,100
└── Other: 1,550

Listener Performance
├── Avg Execution: 12ms
├── P95 Execution: 45ms
├── P99 Execution: 120ms
└── Failed: 3

Event Queue Depth: 23
├── Default: 15
├── Mail: 5
└── Critical: 3
```

## Health Checks

```php
<?php

namespace App\Services\Events\Monitoring;

class EventHealthCheck
{
    public function check(): array
    {
        return [
            'queue_depth' => $this->getQueueDepth(),
            'failed_events' => $this->getFailedEventCount(),
            'avg_processing_time' => $this->getAvgProcessingTime(),
            'events_per_minute' => $this->getEventsPerMinute(),
            'stale_events' => $this->getStaleEventCount(),
        ];
    }

    protected function getQueueDepth(): int
    {
        return \Illuminate\Support\Facades\DB::table('jobs')->count();
    }

    protected function getFailedEventCount(): int
    {
        return \Illuminate\Support\Facades\DB::table('failed_events')
            ->where('created_at', '>=', now()->subHour())
            ->count();
    }

    protected function getAvgProcessingTime(): float
    {
        $result = \Illuminate\Support\Facades\DB::table('domain_events')
            ->where('processed_at', '!=', null)
            ->where('occurred_at', '>=', now()->subHour())
            ->selectRaw('AVG(TIMESTAMPDIFF(MICROSECOND, occurred_at, processed_at) / 1000) as avg_ms')
            ->first();

        return $result->avg_ms ?? 0;
    }

    protected function getEventsPerMinute(): float
    {
        $count = \Illuminate\Support\Facades\DB::table('domain_events')
            ->where('occurred_at', '>=', now()->subMinute())
            ->count();

        return (float) $count;
    }

    protected function getStaleEventCount(): int
    {
        return \Illuminate\Support\Facades\DB::table('domain_events')
            ->whereNull('processed_at')
            ->where('occurred_at', '<', now()->subMinutes(5))
            ->count();
    }
}
```

---

# Event Testing

## Test Helper

```php
<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Bus;

trait EventTestHelpers
{
    protected function assertEventDispatched(string $eventClass, callable $callback = null): void
    {
        if ($callback) {
            Event::assertDispatched($eventClass, $callback);
        } else {
            Event::assertDispatched($eventClass);
        }
    }

    protected function assertEventNotDispatched(string $eventClass): void
    {
        Event::assertNotDispatched($eventClass);
    }

    protected function assertEventCount(string $eventClass, int $count): void
    {
        Event::assertDispatchedTimes($eventClass, $count);
    }

    protected function assertJobDispatched(string $jobClass, callable $callback = null): void
    {
        if ($callback) {
            Bus::assertDispatched($jobClass, $callback);
        } else {
            Bus::assertDispatched($jobClass);
        }
    }
}
```

## Example Tests

```php
<?php

namespace Tests\Feature\Events;

use Tests\TestCase;
use App\Events\Components\ComponentPublished;
use App\Models\Component;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Bus;

class ComponentPublishedEventTest extends TestCase
{
    public function test_component_published_event_is_dispatched(): void
    {
        Event::fake([ComponentPublished::class]);

        $component = Component::factory()->create([
            'status' => 'draft',
        ]);

        $component->publish();

        Event::assertDispatched(ComponentPublished::class, function ($event) use ($component) {
            return $event->aggregateId === (string) $component->id;
        });
    }

    public function test_component_published_triggers_search_index(): void
    {
        Bus::fake();

        $component = Component::factory()->create();
        event(new ComponentPublished($component->id, [
            'name' => $component->name,
            'category' => $component->category->slug,
        ]));

        Bus::assertDispatched(\App\Jobs\Search\IndexComponentJob::class);
    }

    public function test_component_published_sends_notifications(): void
    {
        Event::fake([ComponentPublished::class]);

        $component = Component::factory()->create();
        event(new ComponentPublished($component->id, [
            'name' => $component->name,
            'category' => $component->category->slug,
        ]));

        Event::assertDispatched(ComponentPublished::class);
    }
}
```

---

# Event Replay Service

## ReplayService

```php
<?php

namespace App\Services\Events;

use Illuminate\Support\Facades\DB;

class ReplayService
{
    public function replayAggregate(string $aggregateType, string $aggregateId): array
    {
        $events = DB::table('domain_events')
            ->where('aggregate_type', $aggregateType)
            ->where('aggregate_id', $aggregateId)
            ->orderBy('occurred_at')
            ->get();

        $state = [];
        foreach ($events as $event) {
            $state = $this->applyEvent($state, json_decode($event->payload, true));
        }

        return $state;
    }

    public function replayAll(?string $fromDate = null, ?string $toDate = null): array
    {
        $query = DB::table('domain_events')
            ->orderBy('occurred_at');

        if ($fromDate) {
            $query->where('occurred_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->where('occurred_at', '<=', $toDate);
        }

        $events = $query->get();
        $states = [];

        foreach ($events as $event) {
            $type = $event->aggregate_type;
            $id = $event->aggregate_id;

            if (!isset($states[$type][$id])) {
                $states[$type][$id] = [];
            }

            $states[$type][$id] = $this->applyEvent(
                $states[$type][$id],
                json_decode($event->payload, true)
            );
        }

        return $states;
    }

    public function createSnapshot(string $aggregateType, string $aggregateId, array $state, int $version): void
    {
        DB::table('event_snapshots')->insert([
            'aggregate_type' => $aggregateType,
            'aggregate_id' => $aggregateId,
            'version' => $version,
            'state' => json_encode($state),
            'event_count' => $version,
            'created_at' => now(),
        ]);
    }

    public function getLatestSnapshot(string $aggregateType, string $aggregateId): ?array
    {
        $snapshot = DB::table('event_snapshots')
            ->where('aggregate_type', $aggregateType)
            ->where('aggregate_id', $aggregateId)
            ->orderBy('version', 'desc')
            ->first();

        if (!$snapshot) {
            return null;
        }

        return json_decode($snapshot->state, true);
    }

    protected function applyEvent(array $state, array $payload): array
    {
        return array_merge($state, $payload);
    }
}
```

---

# Event Migration

## EventServiceProvider

```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // User Events
        \App\Events\User\UserRegistered::class => [
            \App\Listeners\User\SendWelcomeEmail::class,
            \App\Listeners\User\InitializeProfile::class,
            \App\Listeners\User\GrantTrialAccess::class,
        ],
        \App\Events\User\UserEmailVerified::class => [
            \App\Listeners\User\SendVerificationConfirmation::class,
        ],
        \App\Events\User\UserPasswordChanged::class => [
            \App\Listeners\User\RevokeAllSessions::class,
            \App\Listeners\User\SendPasswordChangeNotification::class,
        ],
        \App\Events\User\UserTwoFactorEnabled::class => [
            \App\Listeners\User\SendTwoFactorEnabledNotification::class,
        ],
        \App\Events\User\UserDeleted::class => [
            \App\Listeners\User\CleanupUserData::class,
            \App\Listeners\User\CancelSubscriptions::class,
        ],

        // Component Events
        \App\Events\Components\ComponentCreated::class => [
            \App\Listeners\Components\IndexComponentForSearch::class,
            \App\Listeners\Components\InvalidateComponentCache::class,
        ],
        \App\Events\Components\ComponentPublished::class => [
            \App\Listeners\Components\NotifySubscribers::class,
            \App\Listeners\Components\UpdateComponentStats::class,
            \App\Listeners\Components\SendPublicationNotification::class,
            \App\Listeners\Components\IndexComponentForSearch::class,
        ],
        \App\Events\Components\ComponentFeatured::class => [
            \App\Listeners\Components\NotifyFeaturedAuthor::class,
        ],
        \App\Events\Components\ComponentViewed::class => [
            \App\Listeners\Components\TrackViewCount::class,
        ],
        \App\Events\Components\ComponentInstalled::class => [
            \App\Listeners\Components\TrackInstallCount::class,
        ],

        // Template Events
        \App\Events\Marketplace\TemplatePurchased::class => [
            \App\Listeners\Marketplace\GenerateLicenseKey::class,
            \App\Listeners\Marketplace\SendPurchaseReceipt::class,
            \App\Listeners\Marketplace\UpdateTemplateStats::class,
            \App\Listeners\Marketplace\GrantDownloadAccess::class,
        ],

        // Subscription Events
        \App\Events\Subscription\SubscriptionCreated::class => [
            \App\Listeners\Subscription\GrantEntitlements::class,
            \App\Listeners\Subscription\SendWelcomeEmail::class,
            \App\Listeners\Subscription\InitializeUsageQuota::class,
        ],
        \App\Events\Subscription\SubscriptionRenewed::class => [
            \App\Listeners\Subscription\ResetUsageQuota::class,
            \App\Listeners\Subscription\SendRenewalConfirmation::class,
        ],
        \App\Events\Subscription\SubscriptionCancelled::class => [
            \App\Listeners\Subscription\RevokeEntitlements::class,
            \App\Listeners\Subscription\SendCancellationEmail::class,
        ],
    ];

    protected $subscribe = [
        \App\Services\Events\Subscribers\UserEventSubscriber::class,
        \App\Services\Events\Subscribers\ComponentEventSubscriber::class,
    ];
}
```

---

# Event Configuration

```php
// config/events.php

return [
    'enabled' => env('EVENTS_ENABLED', true),
    'store_enabled' => env('EVENTS_STORE_ENABLED', true),
    'logging' => [
        'enabled' => env('EVENT_LOGGING', true),
        'level' => env('EVENT_LOG_LEVEL', 'info'),
    ],
    'async' => [
        'default_queue' => 'events',
        'timeout' => 30,
        'tries' => 3,
        'backoff' => [10, 30, 60],
    ],
    'snapshotting' => [
        'enabled' => true,
        'interval' => 100,
    ],
    'monitoring' => [
        'enabled' => true,
        'check_interval' => 60,
    ],
    'middleware' => [
        \App\Services\Events\Middleware\AuditMiddleware::class,
        \App\Services\Events\Middleware\RateLimitMiddleware::class,
    ],
];
```

---

# Event Workflow Patterns

## Saga Pattern

```php
<?php

namespace App\Services\Events\Sagas;

use Illuminate\Support\Facades\DB;

class PurchaseSaga
{
    protected array $steps = [];
    protected array $compensations = [];
    protected int $currentStep = 0;

    public function execute(array $data): array
    {
        $this->steps = [
            'validate_payment' => fn ($d) => $this->validatePayment($d),
            'create_order' => fn ($d) => $this->createOrder($d),
            'process_payment' => fn ($d) => $this->processPayment($d),
            'generate_license' => fn ($d) => $this->generateLicense($d),
            'send_confirmation' => fn ($d) => $this->sendConfirmation($d),
        ];

        $this->compensations = [
            'create_order' => fn ($d) => $this->cancelOrder($d),
            'process_payment' => fn ($d) => $this->refundPayment($d),
            'generate_license' => fn ($d) => $this->revokeLicense($d),
        ];

        $state = $data;
        foreach ($this->steps as $step => $handler) {
            try {
                $state = $handler($state);
                $this->currentStep++;
            } catch (\Exception $e) {
                $this->compensate($state, $e);
                throw $e;
            }
        }

        return $state;
    }

    protected function compensate(array $state, \Exception $error): void
    {
        $completedSteps = array_slice(array_keys($this->steps), 0, $this->currentStep);
        $completedSteps = array_reverse($completedSteps);

        foreach ($completedSteps as $step) {
            if (isset($this->compensations[$step])) {
                try {
                    $this->compensations[$step]($state);
                } catch (\Exception $e) {
                    \Log::error("Compensation failed for step: {$step}", [
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
    }

    protected function validatePayment(array $data): array
    {
        // Validate payment method exists and is valid
        return $data;
    }

    protected function createOrder(array $data): array
    {
        $order = Order::create([
            'user_id' => $data['user_id'],
            'product_type' => $data['product_type'],
            'product_id' => $data['product_id'],
            'amount' => $data['amount'],
            'status' => 'pending',
        ]);
        $data['order_id'] = $order->id;
        return $data;
    }

    protected function processPayment(array $data): array
    {
        // Process payment with payment provider
        $data['payment_id'] = 'pay_' . uniqid();
        return $data;
    }

    protected function generateLicense(array $data): array
    {
        $license = License::create([
            'user_id' => $data['user_id'],
            'order_id' => $data['order_id'],
            'license_key' => strtoupper(implode('-', array_map(fn () => substr(uniqid(), 0, 4), range(1, 4)))),
        ]);
        $data['license_id'] = $license->id;
        return $data;
    }

    protected function sendConfirmation(array $data): array
    {
        // Send confirmation email
        return $data;
    }

    protected function cancelOrder(array $data): void
    {
        if (isset($data['order_id'])) {
            Order::where('id', $data['order_id'])->update(['status' => 'cancelled']);
        }
    }

    protected function refundPayment(array $data): void
    {
        if (isset($data['payment_id'])) {
            // Process refund
        }
    }

    protected function revokeLicense(array $data): void
    {
        if (isset($data['license_id'])) {
            License::where('id', $data['license_id'])->delete();
        }
    }
}
```

## CQRS Pattern

```php
<?php

namespace App\Services\Events\CQRS;

use Illuminate\Support\Facades\DB;

class CommandBus
{
    protected array $handlers = [];

    public function register(string $commandClass, string $handlerClass): void
    {
        $this->handlers[$commandClass] = $handlerClass;
    }

    public function dispatch($command): mixed
    {
        $handlerClass = $this->handlers[get_class($command)] ?? null;

        if (!$handlerClass) {
            throw new \RuntimeException("No handler registered for " . get_class($command));
        }

        $handler = app($handlerClass);
        return $handler->handle($command);
    }
}

class QueryBus
{
    protected array $handlers = [];

    public function register(string $queryClass, string $handlerClass): void
    {
        $this->handlers[$queryClass] = $handlerClass;
    }

    public function dispatch($query): mixed
    {
        $handlerClass = $this->handlers[get_class($query)] ?? null;

        if (!$handlerClass) {
            throw new \RuntimeException("No handler registered for " . get_class($query));
        }

        $handler = app($handlerClass);
        return $handler->handle($query);
    }
}
```

---

# Event Sourcing

## EventStore

```php
<?php

namespace App\Services\Events\Sourcing;

use Illuminate\Support\Facades\DB;

class EventStore
{
    public function append(string $aggregateType, string $aggregateId, string $eventType, array $payload, int $expectedVersion = null): void
    {
        $currentVersion = $this->getCurrentVersion($aggregateType, $aggregateId);

        if ($expectedVersion !== null && $currentVersion !== $expectedVersion) {
            throw new ConcurrencyException(
                "Expected version {$expectedVersion}, but current version is {$currentVersion}"
            );
        }

        DB::table('domain_events')->insert([
            'event_id' => \Illuminate\Support\Str::uuid(),
            'event_type' => $eventType,
            'aggregate_type' => $aggregateType,
            'aggregate_id' => $aggregateId,
            'payload' => json_encode($payload),
            'metadata' => json_encode([
                'caused_by' => auth()->id(),
                'ip_address' => request()->ip(),
                'version' => $currentVersion + 1,
            ]),
            'occurred_at' => now(),
            'created_at' => now(),
        ]);
    }

    public function getEvents(string $aggregateType, string $aggregateId, ?int $afterVersion = null): \Illuminate\Support\Collection
    {
        $query = DB::table('domain_events')
            ->where('aggregate_type', $aggregateType)
            ->where('aggregate_id', $aggregateId)
            ->orderBy('id');

        if ($afterVersion !== null) {
            $query->whereRaw("JSON_EXTRACT(metadata, '$.version') > ?", [$afterVersion]);
        }

        return $query->get();
    }

    public function getCurrentVersion(string $aggregateType, string $aggregateId): int
    {
        $event = DB::table('domain_events')
            ->where('aggregate_type', $aggregateType)
            ->where('aggregate_id', $aggregateId)
            ->orderBy('id', 'desc')
            ->first();

        if (!$event) {
            return 0;
        }

        $metadata = json_decode($event->metadata, true);
        return $metadata['version'] ?? 0;
    }

    public function rebuild(string $aggregateType, string $aggregateId): array
    {
        $events = $this->getEvents($aggregateType, $aggregateId);
        $state = [];

        foreach ($events as $event) {
            $payload = json_decode($event->payload, true);
            $state = $this->applyEvent($state, $event->event_type, $payload);
        }

        return $state;
    }

    protected function applyEvent(array $state, string $eventType, array $payload): array
    {
        return match ($eventType) {
            'UserRegistered' => array_merge($state, $payload),
            'UserUpdated' => array_merge($state, $payload),
            'ComponentCreated' => array_merge($state, $payload),
            'ComponentPublished' => array_merge($state, ['status' => 'published']),
            'SubscriptionCreated' => array_merge($state, $payload),
            default => $state,
        };
    }
}
```

## Aggregate Root

```php
<?php

namespace App\Services\Events\Sourcing;

abstract class AggregateRoot
{
    protected string $aggregateId;
    protected int $version = 0;
    protected array $state = [];
    protected array $pendingEvents = [];

    public static function reconstitute(string $aggregateId, \Illuminate\Support\Collection $events): static
    {
        $aggregate = new static();
        $aggregate->aggregateId = $aggregateId;

        foreach ($events as $event) {
            $payload = json_decode($event->payload, true);
            $aggregate->apply($event->event_type, $payload);
            $aggregate->version++;
        }

        return $aggregate;
    }

    public function recordThat(string $eventType, array $payload): void
    {
        $this->pendingEvents[] = [
            'event_type' => $eventType,
            'payload' => $payload,
            'occurred_at' => now(),
        ];

        $this->apply($eventType, $payload);
    }

    public function commit(): void
    {
        $eventStore = app(EventStore::class);

        foreach ($this->pendingEvents as $event) {
            $eventStore->append(
                $this->getAggregateType(),
                $this->aggregateId,
                $event['event_type'],
                $event['payload'],
                $this->version
            );
            $this->version++;
        }

        $this->pendingEvents = [];
    }

    abstract protected function getAggregateType(): string;

    protected function apply(string $eventType, array $payload): void
    {
        $method = 'apply' . str_replace('.', '', ucwords($eventType, '.'));
        if (method_exists($this, $method)) {
            $this->$method($payload);
        }
        $this->state = array_merge($this->state, $payload);
    }

    public function getState(): array
    {
        return $this->state;
    }

    public function getVersion(): int
    {
        return $this->version;
    }
}
```

---

# Event Projection

## ProjectionService

```php
<?php

namespace App\Services\Events\Projections;

use Illuminate\Support\Facades\DB;

class ProjectionService
{
    protected array $projections = [];

    public function register(string $name, string $projectionClass): void
    {
        $this->projections[$name] = $projectionClass;
    }

    public function project(string $eventType, array $payload): void
    {
        foreach ($this->projections as $name => $projectionClass) {
            $projection = app($projectionClass);

            if ($projection->handles($eventType)) {
                try {
                    $projection->handle($eventType, $payload);
                    $this->updateProjectionStatus($name, $eventType);
                } catch (\Exception $e) {
                    \Log::error("Projection failed", [
                        'projection' => $name,
                        'event_type' => $eventType,
                        'error' => $e->getMessage(),
                    ]);
                    $this->recordProjectionError($name, $e);
                }
            }
        }
    }

    protected function updateProjectionStatus(string $name, string $eventType): void
    {
        DB::table('event_projections')
            ->where('name', $name)
            ->update([
                'last_processed_at' => now(),
                'events_processed' => DB::raw('events_processed + 1'),
            ]);
    }

    protected function recordProjectionError(string $name, \Exception $e): void
    {
        DB::table('event_projections')
            ->where('name', $name)
            ->increment('errors_count');
    }

    public function rebuild(string $projectionName): void
    {
        $projection = app($this->projections[$projectionName]);
        $projection->reset();

        $events = DB::table('domain_events')
            ->orderBy('id')
            ->get();

        foreach ($events as $event) {
            $payload = json_decode($event->payload, true);
            if ($projection->handles($event->event_type)) {
                $projection->handle($event->event_type, $payload);
            }
        }
    }
}
```

## UserStatsProjection

```php
<?php

namespace App\Services\Events\Projections;

class UserStatsProjection
{
    protected array $handledEvents = [
        'UserRegistered',
        'UserUpdated',
        'UserDeleted',
        'ComponentPublished',
        'TemplatePurchased',
        'SubscriptionCreated',
    ];

    public function handles(string $eventType): bool
    {
        return in_array($eventType, $this->handledEvents);
    }

    public function handle(string $eventType, array $payload): void
    {
        match ($eventType) {
            'UserRegistered' => $this->onUserRegistered($payload),
            'UserUpdated' => $this->onUserUpdated($payload),
            'UserDeleted' => $this->onUserDeleted($payload),
            'ComponentPublished' => $this->onComponentPublished($payload),
            'TemplatePurchased' => $this->onTemplatePurchased($payload),
            'SubscriptionCreated' => $this->onSubscriptionCreated($payload),
        };
    }

    protected function onUserRegistered(array $payload): void
    {
        DB::table('user_stats')->updateOrInsert(
            ['user_id' => $payload['user_id']],
            [
                'total_registrations' => DB::raw('total_registrations + 1'),
                'last_registration_at' => now(),
            ]
        );
    }

    protected function onComponentPublished(array $payload): void
    {
        DB::table('user_stats')->where('user_id', $payload['author_id'])
            ->increment('components_published');
    }

    protected function onTemplatePurchased(array $payload): void
    {
        DB::table('user_stats')->where('user_id', $payload['user_id'])
            ->increment('templates_purchased');
    }

    protected function onSubscriptionCreated(array $payload): void
    {
        DB::table('user_stats')->where('user_id', $payload['user_id'])
            ->update(['current_plan' => $payload['plan'] ?? 'free']);
    }

    public function reset(): void
    {
        DB::table('user_stats')->truncate();
    }
}
```

---

# Event Configuration

## EventServiceProvider Configuration

```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // User Events
        \App\Events\User\UserRegistered::class => [
            \App\Listeners\User\SendWelcomeEmail::class,
            \App\Listeners\User\InitializeProfile::class,
            \App\Listeners\User\GrantTrialAccess::class,
        ],
        \App\Events\User\UserEmailVerified::class => [
            \App\Listeners\User\SendVerificationConfirmation::class,
        ],
        \App\Events\User\UserPasswordChanged::class => [
            \App\Listeners\User\RevokeAllSessions::class,
            \App\Listeners\User\SendPasswordChangeNotification::class,
        ],
        \App\Events\User\UserTwoFactorEnabled::class => [
            \App\Listeners\User\SendTwoFactorEnabledNotification::class,
        ],
        \App\Events\User\UserDeleted::class => [
            \App\Listeners\User\CleanupUserData::class,
            \App\Listeners\User\CancelSubscriptions::class,
        ],

        // Component Events
        \App\Events\Components\ComponentCreated::class => [
            \App\Listeners\Components\IndexComponentForSearch::class,
            \App\Listeners\Components\InvalidateComponentCache::class,
        ],
        \App\Events\Components\ComponentPublished::class => [
            \App\Listeners\Components\NotifySubscribers::class,
            \App\Listeners\Components\UpdateComponentStats::class,
            \App\Listeners\Components\SendPublicationNotification::class,
            \App\Listeners\Components\IndexComponentForSearch::class,
        ],
        \App\Events\Components\ComponentFeatured::class => [
            \App\Listeners\Components\NotifyFeaturedAuthor::class,
        ],
        \App\Events\Components\ComponentViewed::class => [
            \App\Listeners\Components\TrackViewCount::class,
        ],
        \App\Events\Components\ComponentInstalled::class => [
            \App\Listeners\Components\TrackInstallCount::class,
        ],

        // Template Events
        \App\Events\Marketplace\TemplatePurchased::class => [
            \App\Listeners\Marketplace\GenerateLicenseKey::class,
            \App\Listeners\Marketplace\SendPurchaseReceipt::class,
            \App\Listeners\Marketplace\UpdateTemplateStats::class,
            \App\Listeners\Marketplace\GrantDownloadAccess::class,
        ],

        // Subscription Events
        \App\Events\Subscription\SubscriptionCreated::class => [
            \App\Listeners\Subscription\GrantEntitlements::class,
            \App\Listeners\Subscription\SendWelcomeEmail::class,
            \App\Listeners\Subscription\InitializeUsageQuota::class,
        ],
        \App\Events\Subscription\SubscriptionRenewed::class => [
            \App\Listeners\Subscription\ResetUsageQuota::class,
            \App\Listeners\Subscription\SendRenewalConfirmation::class,
        ],
        \App\Events\Subscription\SubscriptionCancelled::class => [
            \App\Listeners\Subscription\RevokeEntitlements::class,
            \App\Listeners\Subscription\SendCancellationEmail::class,
        ],
    ];

    protected $subscribe = [
        \App\Services\Events\Subscribers\UserEventSubscriber::class,
        \App\Services\Events\Subscribers\ComponentEventSubscriber::class,
    ];

    public function boot(): void
    {
        parent::boot();

        $eventBus = app(\App\Services\Events\EventBus::class);
        $eventBus->addMiddleware(\App\Services\Events\Middleware\AuditMiddleware::class);
        $eventBus->addMiddleware(\App\Services\Events\Middleware\RateLimitMiddleware::class);

        $eventBus->register(\App\Events\User\UserRegistered::class, \App\Listeners\User\SendWelcomeEmail::class);
        $eventBus->register(\App\Events\User\UserRegistered::class, \App\Listeners\User\InitializeProfile::class);
        $eventBus->register(\App\Events\Components\ComponentPublished::class, \App\Listeners\Components\NotifySubscribers::class);
        $eventBus->register(\App\Events\Components\ComponentPublished::class, \App\Listeners\Components\IndexComponentForSearch::class);
        $eventBus->register(\App\Events\Marketplace\TemplatePurchased::class, \App\Listeners\Marketplace\GenerateLicenseKey::class);
        $eventBus->register(\App\Events\Subscription\SubscriptionCreated::class, \App\Listeners\Subscription\GrantEntitlements::class);
    }
}
```

---

# Event Testing Strategies

## Event Store Test

```php
<?php

namespace Tests\Unit\Services\Events;

use Tests\TestCase;
use App\Services\Events\EventBus;
use App\Events\User\UserRegistered;
use Illuminate\Support\Facades\DB;

class EventStoreTest extends TestCase
{
    public function test_event_is_stored(): void
    {
        $event = new UserRegistered('123', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        app(EventBus::class)->dispatch($event);

        $stored = DB::table('domain_events')
            ->where('event_id', $event->eventId)
            ->first();

        $this->assertNotNull($stored);
        $this->assertEquals('UserRegistered', $stored->event_type);
        $this->assertEquals('user', $stored->aggregate_type);
        $this->assertEquals('123', $stored->aggregate_id);
    }

    public function test_event_replay(): void
    {
        $events = app(EventBus::class)->replay('user', '123');
        $this->assertNotNull($events);
    }
}
```

## Event Handler Test

```php
<?php

namespace Tests\Unit\Listeners;

use Tests\TestCase;
use App\Events\Components\ComponentPublished;
use App\Listeners\Components\NotifySubscribers;
use Illuminate\Support\Facades\Notification;

class NotifySubscribersTest extends TestCase
{
    public function test_subscribers_are_notified(): void
    {
        Notification::fake();

        $event = new ComponentPublished('123', [
            'name' => 'Button',
            'category' => 'actions',
        ]);

        $listener = new NotifySubscribers();
        $listener->handle($event);

        Notification::assertSentTo(
            // subscribers
            \App\Notifications\ComponentPublishedNotification::class
        );
    }
}
```

---

# Event Migration Strategy

```php
<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateEventTables extends Migration
{
    public function up(): void
    {
        Schema::create('domain_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id')->unique();
            $table->string('event_type');
            $table->integer('event_version')->default(1);
            $table->string('aggregate_type');
            $table->string('aggregate_id');
            $table->json('payload');
            $table->json('metadata')->nullable();
            $table->string('correlation_id')->nullable();
            $table->string('causation_id')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamp('stored_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
            $table->json('processed_by')->nullable();
            $table->timestamps();

            $table->index('aggregate_type');
            $table->index('aggregate_id');
            $table->index('event_type');
            $table->index('occurred_at');
            $table->index('stored_at');
            $table->index('correlation_id');
            $table->index('processed_at');
        });

        Schema::create('event_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('subscriber_type');
            $table->unsignedBigInteger('subscriber_id');
            $table->string('event_type');
            $table->string('channel')->default('default');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('last_event_id')->nullable();
            $table->timestamp('last_consumed_at')->nullable();
            $table->timestamps();

            $table->index('subscriber_type');
            $table->index('subscriber_id');
            $table->index('event_type');
            $table->index('channel');
        });

        Schema::create('event_projections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'paused', 'failed'])->default('active');
            $table->unsignedBigInteger('last_event_id')->nullable();
            $table->timestamp('last_processed_at')->nullable();
            $table->bigInteger('events_processed')->default(0);
            $table->integer('errors_count')->default(0);
            $table->timestamps();
        });

        Schema::create('event_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('aggregate_type');
            $table->string('aggregate_id');
            $table->integer('version');
            $table->json('state');
            $table->integer('event_count');
            $table->timestamps();

            $table->index('aggregate_type');
            $table->index('aggregate_id');
            $table->index('version');
        });

        Schema::create('failed_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id');
            $table->string('event_type');
            $table->string('handler');
            $table->text('error');
            $table->json('payload');
            $table->integer('retry_count')->default(0);
            $table->timestamps();

            $table->index('event_id');
            $table->index('event_type');
            $table->index('handler');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_events');
        Schema::dropIfExists('event_snapshots');
        Schema::dropIfExists('event_projections');
        Schema::dropIfExists('event_subscriptions');
        Schema::dropIfExists('domain_events');
    }
}
```

---

# Event Performance Optimization

## Event Queue Optimization

```php
<?php

namespace App\Services\Events;

class EventQueueOptimizer
{
    public function optimize(): void
    {
        // Batch similar events
        $this->batchSimilarEvents();

        // Prioritize critical events
        $this->prioritizeEvents();

        // Clean up old events
        $this->cleanupOldEvents();
    }

    protected function batchSimilarEvents(): void
    {
        $recentEvents = DB::table('domain_events')
            ->where('occurred_at', '>=', now()->subMinutes(5))
            ->where('processed_at', null)
            ->get()
            ->groupBy('event_type');

        foreach ($recentEvents as $type => $events) {
            if ($events->count() > 10) {
                $this->batchProcess($type, $events);
            }
        }
    }

    protected function batchProcess(string $type, $events): void
    {
        $payloads = $events->pluck('payload')->toArray();
        $batchPayload = [
            'batch_size' => count($payloads),
            'events' => $payloads,
        ];

        ProcessEventBatchJob::dispatch($type, $batchPayload);
    }

    protected function prioritizeEvents(): void
    {
        $criticalEvents = ['PaymentFailed', 'SecurityAlert', 'SystemError'];
        // Move critical events to high-priority queue
    }

    protected function cleanupOldEvents(): void
    {
        DB::table('domain_events')
            ->where('occurred_at', '<', now()->subDays(90))
            ->where('processed_at', '!=', null)
            ->delete();
    }
}
```

---

# Next Document

**29 - Jobs** — Background job processing architecture.
