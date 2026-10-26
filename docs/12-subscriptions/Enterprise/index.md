# Enterprise Subscriptions

## Overview

Enterprise subscriptions provide custom pricing, SLA guarantees, dedicated support, and on-premise deployment options for large organizations.

## Enterprise Plan Structure

```php
class EnterprisePlan extends Model
{
    protected $fillable = [
        'name', 'description', 'contract_length_months',
        'custom_pricing', 'features', 'sla',
        'support_level', 'deployment_type',
        'metadata',
    ];

    protected $casts = [
        'custom_pricing' => 'array',
        'features' => 'array',
        'sla' => 'array',
        'metadata' => 'array',
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
```

## Custom Pricing

### Pricing Models

| Model | Description | Use Case |
|-------|-------------|----------|
| Per-seat | Price per user | Large teams |
| Usage-based | Pay per API call/transaction | High-volume |
| Flat rate | Fixed annual fee | Predictable budget |
| Tiered | Volume discounts | Scaling usage |
| Custom | Negotiated | Unique requirements |

### Pricing Configuration

```php
'enterprise_pricing' => [
    'models' => [
        'per_seat' => [
            'base_price' => 0,
            'price_per_seat' => 50, // $50/user/month
            'min_seats' => 50,
            'volume_discounts' => [
                100 => 10, // 10% off at 100+ seats
                500 => 20, // 20% off at 500+ seats
                1000 => 30, // 30% off at 1000+ seats
            ],
        ],
        'usage_based' => [
            'base_fee' => 500, // $500/month base
            'included_usage' => 100000, // 100K API calls
            'overage_rate' => 0.001, // $0.001 per call
        ],
        'flat_rate' => [
            'annual_price' => 24000, // $24,000/year
            'includes' => 'All features, up to 500 seats',
        ],
    ],
],
```

### Custom Quote Generation

```php
class EnterpriseQuoteService
{
    public function generateQuote(Organization $org, array $requirements): EnterpriseQuote
    {
        $pricing = $this->calculatePricing($org, $requirements);

        return EnterpriseQuote::create([
            'organization_id' => $org->id,
            'requirements' => $requirements,
            'pricing' => $pricing,
            'valid_until' => now()->addDays(30),
            'status' => 'pending',
        ]);
    }

    protected function calculatePricing(Organization $org, array $requirements): array
    {
        $seatCount = $requirements['seats'] ?? 100;
        $usage = $requirements['expected_usage'] ?? 'standard';
        $term = $requirements['contract_term'] ?? 12;

        $basePrice = config('enterprise_pricing.models.per_seat.price_per_seat');
        $discount = $this->getVolumeDiscount($seatCount);

        $monthlyTotal = $seatCount * $basePrice * (1 - $discount / 100);
        $annualTotal = $monthlyTotal * 12;
        $termDiscount = $this->getTermDiscount($term);

        return [
            'seats' => $seatCount,
            'price_per_seat' => $basePrice,
            'volume_discount' => $discount,
            'monthly_total' => $monthlyTotal,
            'annual_total' => $annualTotal,
            'term_discount' => $termDiscount,
            'final_price' => $annualTotal * (1 - $termDiscount / 100),
        ];
    }
}
```

## SLA Guarantees

### SLA Tiers

| Tier | Uptime | Response Time | Resolution Time | Support |
|------|--------|---------------|-----------------|---------|
| Standard | 99.9% | 24 hours | 72 hours | Email |
| Premium | 99.95% | 4 hours | 24 hours | Priority email |
| Enterprise | 99.99% | 1 hour | 4 hours | Dedicated support |

### SLA Configuration

```php
'sla' => [
    'tiers' => [
        'standard' => [
            'uptime_guarantee' => 99.9,
            'response_time_hours' => 24,
            'resolution_time_hours' => 72,
            'support_channels' => ['email'],
            'support_hours' => '9-5 M-F',
            'penalty_percentage' => 10, // 10% credit if missed
        ],
        'premium' => [
            'uptime_guarantee' => 99.95,
            'response_time_hours' => 4,
            'resolution_time_hours' => 24,
            'support_channels' => ['email', 'chat'],
            'support_hours' => '24/7',
            'penalty_percentage' => 25,
        ],
        'enterprise' => [
            'uptime_guarantee' => 99.99,
            'response_time_hours' => 1,
            'resolution_time_hours' => 4,
            'support_channels' => ['email', 'chat', 'phone'],
            'support_hours' => '24/7',
            'penalty_percentage' => 50,
        ],
    ],
],
```

### SLA Monitoring

```php
class SlaMonitor
{
    public function calculateUptime(Organization $org, Carbon $startDate, Carbon $endDate): float
    {
        $totalMinutes = $startDate->diffInMinutes($endDate);
        $downtimeMinutes = DowntimeLog::where('organization_id', $org->id)
            ->whereBetween('started_at', [$startDate, $endDate])
            ->sum('duration_minutes');

        return (($totalMinutes - $downtimeMinutes) / $totalMinutes) * 100;
    }

    public function checkSlaCompliance(Organization $org): SlaReport
    {
        $sla = $org->enterprisePlan->sla;
        $uptime = $this->calculateUptime($org, now()->subMonth(), now());

        $compliant = $uptime >= $sla['uptime_guarantee'];
        $credit = $compliant ? 0 : $this->calculateCredit($org, $uptime, $sla);

        return new SlaReport(
            organization: $org,
            uptime: $uptime,
            guarantee: $sla['uptime_guarantee'],
            compliant: $compliant,
            credit_amount: $credit,
        );
    }

    protected function calculateCredit(Organization $org, float $uptime, array $sla): int
    {
        $penalty = $sla['penalty_percentage'] / 100;
        $monthlyRevenue = $org->subscription->price;

        return (int) ($monthlyRevenue * $penalty);
    }
}
```

## Dedicated Support

### Support Channels

```php
class DedicatedSupportService
{
    public function getChannels(Organization $org): array
    {
        $sla = $org->enterprisePlan->sla;

        return $sla['support_channels'];
    }

    public function createTicket(Organization $org, array $data): SupportTicket
    {
        $ticket = SupportTicket::create([
            'organization_id' => $org->id,
            'user_id' => auth()->id(),
            'priority' => $data['priority'],
            'subject' => $data['subject'],
            'description' => $data['description'],
            'channel' => $data['channel'] ?? 'email',
        ]);

        // Assign to dedicated support team
        $this->assignDedicatedTeam($ticket, $org);

        return $ticket;
    }

    public function getResponseTime(Organization $org): int
    {
        $sla = $org->enterprisePlan->sla;
        return $sla['response_time_hours'];
    }
}
```

### Support Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `organization_id` | `bigint` | FK to organizations |
| `user_id` | `bigint` | FK to users |
| `priority` | `enum` | low / medium / high / critical |
| `status` | `enum` | open / in_progress / resolved / closed |
| `channel` | `string` | email / chat / phone |
| `subject` | `string` | |
| `description` | `text` | |
| `assigned_to` | `bigint?` | FK to users |
| `response_at` | `timestamp?` | |
| `resolved_at` | `timestamp?` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## On-Premise Options

### Deployment Types

| Type | Description | Use Case |
|------|-------------|----------|
| `cloud` | SaaS hosted | Standard |
| `dedicated` | Isolated infrastructure | Compliance |
| `on_premise` | Self-hosted | Data sovereignty |
| `hybrid` | Cloud + on-prem mix | Flexibility |

### On-Premise Configuration

```php
'on_premise' => [
    'enabled' => true,

    'requirements' => [
        'php_version' => '8.2+',
        'mysql_version' => '8.0+',
        'redis_version' => '7.0+',
        'min_server_ram' => '8GB',
        'min_server_cpu' => '4 cores',
    ],

    'deployment' => [
        'docker' => true,
        'kubernetes' => true,
        'manual' => true,
    ],

    'support' => [
        'installation' => true,
        'updates' => true,
        'monitoring' => false,
        'backup' => false,
    ],

    'pricing' => [
        'setup_fee' => 5000,
        'monthly_fee' => 2000,
        'support_fee' => 1000,
    ],
],
```

## Schema

### Enterprise Plans Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | |
| `description` | `text?` | |
| `contract_length_months` | `int` | 12, 24, 36 |
| `custom_pricing` | `json` | |
| `features` | `json` | |
| `sla` | `json` | |
| `support_level` | `string` | standard / premium / enterprise |
| `deployment_type` | `string` | cloud / dedicated / on_premise / hybrid |
| `is_active` | `bool` | |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Custom pricing** — negotiate based on usage and commitment
2. **SLA monitoring** — track uptime and response times
3. **Dedicated support** — provide premium support channels
4. **On-premise options** — for data sovereignty requirements
5. **Contract terms** — longer terms for better pricing
6. **Track SLA compliance** — issue credits automatically if missed
7. **Test with Playwright** — verify enterprise flows in UI
