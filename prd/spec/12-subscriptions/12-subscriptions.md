For **GsmUi**, **12-subscriptions.md** should define the complete **Subscription Management System**, not just recurring payments.

Since GsmUi is both a **UI framework** and a **commercial SaaS platform**, subscriptions control feature access, downloads, updates, AI usage, MCP access, API limits, and team capabilities.

A complete implementation-ready specification would be **250–400 pages**, so it should be organized into focused documents.

## Recommended Structure

```text
12-subscriptions/

12.01-overview.md
12.02-domain-model.md
12.03-plans.md
12.04-subscription-lifecycle.md
12.05-trials.md
12.06-renewals.md
12.07-upgrades-downgrades.md
12.08-cancellations.md
12.09-grace-periods.md
12.10-entitlements.md
12.11-feature-access.md
12.12-download-access.md
12.13-team-subscriptions.md
12.14-enterprise-subscriptions.md
12.15-seat-management.md
12.16-billing-integration.md
12.17-webhooks.md
12.18-events.md
12.19-jobs.md
12.20-admin-management.md
12.21-user-dashboard.md
12.22-api.md
12.23-database-design.md
12.24-security.md
12.25-future-expansion.md
```

## Subscription Architecture

```text
Customer

↓

Subscription Plan

↓

Subscription

↓

Entitlements

↓

Feature Gates

↓

Application Access
```

Subscriptions determine what a user **can access**, while billing determines **how they pay**.

---

# Default Plans

```text
Free

↓

Pro

↓

Team

↓

Enterprise
```

Each plan can define:

* Monthly price
* Annual price
* Trial period
* Included features
* API limits
* AI credits
* Download limits
* Team seats
* Storage limits
* Support level

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

Lifecycle transitions should be handled by domain services and events.

---

# Feature Gates

Subscriptions should control access to:

* Premium Components
* Premium Themes
* Premium Templates
* Playground Pro
* Theme Builder
* AI Assistant
* MCP Server
* API Access
* Marketplace Downloads
* Team Workspaces
* Priority Support

Feature checks should rely on entitlements rather than directly inspecting plan names.

---

# Entitlement Model

```text
Subscription

↓

Entitlements

↓

Application Features
```

Examples:

```text
theme.download

template.download

component.pro

ai.chat

mcp.connect

api.access

playground.private

support.priority
```

---

# Upgrade Flow

```text
Free

↓

Pro

↓

Team

↓

Enterprise
```

Support:

* Immediate upgrades
* Scheduled downgrades
* Prorated billing (provider-dependent)
* Seat expansion
* Seat reduction

---

# Team Subscriptions

Future-ready support:

* Team Owner
* Team Members
* Seat assignment
* Seat invitations
* Seat transfers
* Shared entitlements

---

# Administration

Administrators should be able to:

* Create plans
* Archive plans
* Change pricing
* Grant complimentary subscriptions
* Suspend subscriptions
* Resume subscriptions
* View lifecycle history
* Audit changes

---

# User Dashboard

Users should be able to:

* View active plan
* Upgrade
* Downgrade
* Cancel
* Resume (if applicable)
* View renewal date
* View billing history
* View included features
* Manage team seats

---

# Events

Typical domain events:

```text
SubscriptionCreated

TrialStarted

SubscriptionRenewed

SubscriptionUpgraded

SubscriptionDowngraded

SubscriptionCancelled

SubscriptionExpired

EntitlementsUpdated
```

---

# Background Jobs

Examples:

```text
RenewSubscription

ExpireTrial

SyncProviderStatus

RefreshEntitlements

SendRenewalReminder

NotifyExpiration
```

---

# Future Features

The architecture should accommodate:

* Usage-based subscriptions
* AI token subscriptions
* API metered billing
* Regional plans
* Educational plans
* Non-profit plans
* Marketplace creator subscriptions
* White-label licensing
* Lifetime upgrades
* Enterprise contracts

## Recommended implementation order

1. **12.01-overview.md**
2. **12.02-domain-model.md**
3. **12.03-plans.md**
4. **12.04-subscription-lifecycle.md**
5. **12.10-entitlements.md**
6. **12.11-feature-access.md**
7. **12.16-billing-integration.md**
8. **12.20-admin-management.md**
9. **12.21-user-dashboard.md**

This produces a complete subscription architecture that cleanly integrates with the Billing, Marketplace, Authentication, Permissions, and User Dashboard domains you've already planned, while remaining extensible for team and enterprise offerings.

---

# Entitlement Resolution

The entitlement system resolves what a user can access based on their subscription, add-ons, and any grants.

## Resolution Strategy

```text
1. Start with base plan entitlements
2. Layer subscription item entitlements (add-ons)
3. Apply admin grants and overrides
4. Check for expired entitlements and remove them
5. Cache the result in Redis with a TTL of 60 seconds
```

## Resolution Algorithm

```php
class EntitlementResolver
{
    public function resolve(User $user): EntitlementSet
    {
        // 1. Base plan entitlements
        $subscription = $user->activeSubscription();
        if (!$subscription) {
            return EntitlementSet::free();
        }

        $entitlements = $subscription->plan->entitlements();

        // 2. Add-on entitlements
        foreach ($subscription->items as $item) {
            if ($item->product && $item->product->entitlements) {
                $entitlements = $entitlements->merge($item->product->entitlements);
            }
        }

        // 3. Admin grants
        $grants = EntitlementGrant::where('grantee_type', User::class)
            ->where('grantee_id', $user->id)
            ->where('expires_at', '>', now())
            ->get();

        foreach ($grants as $grant) {
            $entitlements = $entitlements->applyGrant($grant);
        }

        // 4. Remove expired
        $entitlements = $entitlements->filterActive();

        // 5. Cache
        Cache::put(
            "entitlements:{$user->id}",
            $entitlements,
            now()->addSeconds(60)
        );

        return $entitlements;
    }

    public function has(User $user, string $key): bool
    {
        $cached = Cache::get("entitlements:{$user->id}");
        if ($cached !== null) {
            return $cached->has($key);
        }

        return $this->resolve($user)->has($key);
    }
}
```

## Entitlement Keys

| Key | Description | Free | Pro | Team | Enterprise |
|---|---|---|---|---|---|
| `component.free` | Free UI components | ✓ | ✓ | ✓ | ✓ |
| `component.pro` | Premium UI components | — | ✓ | ✓ | ✓ |
| `theme.free` | Free themes | ✓ | ✓ | ✓ | ✓ |
| `theme.pro` | Premium themes | — | ✓ | ✓ | ✓ |
| `template.download` | Download templates | 5 | Unlimited | Unlimited | Unlimited |
| `ai.chat` | AI chat credits | 50/mo | 500/mo | 2000/mo | Custom |
| `ai.codegen` | AI code generation | 10/mo | 100/mo | 500/mo | Custom |
| `mcp.connect` | MCP server connections | 0 | 1 | 5 | Custom |
| `api.access` | API endpoint access | Read-only | Full | Full | Full |
| `api.keys` | API key limit | 1 | 3 | 10 | Custom |
| `playground.pro` | Pro playground | — | ✓ | ✓ | ✓ |
| `theme.builder` | Theme builder | — | ✓ | ✓ | ✓ |
| `support.priority` | Priority support | — | — | ✓ | ✓ |
| `support.dedicated` | Dedicated support | — | — | — | ✓ |
| `team.workspace` | Team workspace | — | — | ✓ | ✓ |
| `team.seat_management` | Seat management | — | — | ✓ | ✓ |
| `download.unlimited` | Unlimited downloads | — | — | ✓ | ✓ |
| `sso.saml` | SSO/SAML login | — | — | — | ✓ |
| `white_label` | White-label option | — | — | — | ✓ |
| `on_premise` | On-premise deployment | — | — | — | ✓ |
| `audit_log` | Audit log access | — | — | — | ✓ |
| `custom_contract` | Custom contract terms | — | — | — | ✓ |

## Entitlement Cache Invalidation

```php
class EntitlementCacheManager
{
    public function invalidate(User $user): void
    {
        Cache::forget("entitlements:{$user->id}");
    }

    public function invalidateAll(): void
    {
        // On plan changes, bulk invalidate
        $keys = Cache::keys('entitlements:*');
        Cache::delete($keys);
    }

    public function invalidateForSubscription(Subscription $subscription): void
    {
        $users = $subscription->team
            ? $subscription->team->members
            : [$subscription->user];

        foreach ($users as $user) {
            $this->invalidate($user);
        }
    }
}
```

---

# Feature Gate Implementation

Feature gates enforce entitlement checks throughout the application.

## Blade Component Gates

```blade
{{-- In any Blade template --}}
<gsmui:gate entitlement="component.pro">
    <gsmui:button>Premium Component</gsmui:button>
</gsmui:gate>

<gsmui:gate entitlement="ai.chat" :remaining="$user->aiCreditsRemaining()">
    <gsmui:ai-chat />
</gsmui:gate>

<gsmui:gate entitlement="team.workspace" :fallback="'upgrade'">
    <gsmui:team-workspace />
</gsmui:gate>
```

## Livewire Component Gates

```php
class PremiumComponent extends Component
{
    public function mount(): void
    {
        if (!auth()->user()->hasEntitlement('component.pro')) {
            abort(403, 'Pro subscription required');
        }
    }
}
```

## Middleware Gates

```php
// Route-level entitlement check
Route::middleware(['entitlement:api.access'])->group(function () {
    Route::get('/api/data', [DataController::class, 'index']);
});

// API middleware
class EntitlementMiddleware
{
    public function handle(Request $request, Closure $next, string $entitlement): Response
    {
        if (!auth()->user()->hasEntitlement($entitlement)) {
            return response()->json([
                'error' => 'Insufficient subscription level',
                'required_entitlement' => $entitlement,
                'upgrade_url' => route('billing.upgrade'),
            ], 403);
        }

        return $next($request);
    }
}
```

## Policy Gates

```php
class ComponentPolicy
{
    public function viewPro(User $user): bool
    {
        return $user->hasEntitlement('component.pro');
    }

    public function download(User $user, BillingProduct $product): bool
    {
        if (!$user->hasEntitlement('template.download')) {
            return false;
        }

        return $user->downloadPermissions()
            ->where('product_id', $product->id)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
```

---

# Upgrade and Downgrade Flows

## Upgrade Flow

```text
User initiates upgrade
    ↓
System calculates proration
    ↓
User confirms upgrade
    ↓
Immediate plan change
    ↓
Entitlements updated immediately
    ↓
Prorated charge processed
    ↓
New invoice generated
```

### Upgrade Implementation

```php
class PlanUpgrader
{
    public function upgrade(Subscription $subscription, Plan $newPlan): UpgradeResult
    {
        $currentPlan = $subscription->plan;
        $proration = $this->calculator->calculateProration($subscription, $newPlan);

        // Determine if proration is needed
        $charge = $proration->prorated_charge;

        if ($charge > 0) {
            // Charge the difference
            $this->billing->charge($subscription->billable, $charge, "Upgrade to {$newPlan->name}");
        }

        // Swap plan immediately
        $subscription->update([
            'plan_id' => $newPlan->id,
            'metadata' => array_merge($subscription->metadata ?? [], [
                'upgraded_from' => $currentPlan->id,
                'upgraded_at' => now()->toISOString(),
                'price_at_subscription' => $newPlan->price,
            ]),
        ]);

        // Synchronize entitlements
        app(EntitlementService::class)->synchronize($subscription);

        // Generate invoice
        $invoice = app(InvoiceGenerator::class)->generateUpgradeInvoice($subscription, $currentPlan, $proration);

        // Dispatch events
        SubscriptionUpgraded::dispatch($subscription, $currentPlan);

        return new UpgradeResult(
            subscription: $subscription,
            invoice: $invoice,
            proration: $proration,
        );
    }
}
```

## Downgrade Flow

```text
User initiates downgrade
    ↓
System calculates end-of-period effect
    ↓
User confirms downgrade
    ↓
Change scheduled at period end
    ↓
Current features maintained until then
    ↓
At period end: entitlements updated
```

### Downgrade Implementation

```php
class PlanDowngrader
{
    public function downgrade(Subscription $subscription, Plan $newPlan): DowngradeResult
    {
        $currentPlan = $subscription->plan;
        $periodEnd = $subscription->current_period_end;

        // Schedule the downgrade for period end
        $subscription->update([
            'metadata' => array_merge($subscription->metadata ?? [], [
                'downgrade_to' => $newPlan->id,
                'downgrade_scheduled_at' => $periodEnd->toISOString(),
            ]),
        ]);

        // Schedule job to apply downgrade at period end
        ApplyDowngradeJob::dispatch($subscription, $newPlan)
            ->delay($periodEnd);

        // Notify user
        DowngradeScheduledMail::to($subscription->user)->send([
            'new_plan' => $newPlan,
            'effective_date' => $periodEnd,
        ]);

        return new DowngradeResult(
            subscription: $subscription,
            effective_date: $periodEnd,
            current_features_until: $periodEnd,
        );
    }
}
```

### Apply Downgrade Job

```php
class ApplyDowngradeJob implements ShouldQueue
{
    public function handle(): void
    {
        $subscription = $this->subscription->fresh(['plan', 'user']);

        if (!$subscription || $subscription->status !== 'active') {
            return; // Subscription changed or canceled
        }

        $newPlan = Plan::find($subscription->metadata['downgrade_to']);

        if (!$newPlan) {
            return; // Target plan no longer exists
        }

        $subscription->update([
            'plan_id' => $newPlan->id,
            'metadata' => array_merge($subscription->metadata ?? [], [
                'downgrade_applied_at' => now()->toISOString(),
            ]),
        ]);

        // Synchronize entitlements
        app(EntitlementService::class)->synchronize($subscription);

        // Notify user
        DowngradeAppliedMail::to($subscription->user)->send([
            'new_plan' => $newPlan,
        ]);

        SubscriptionDowngraded::dispatch($subscription, $newPlan);
    }
}
```

---

# Cancellation Management

## Self-Service Cancellation

```php
class CancellationService
{
    public function cancel(Subscription $subscription, string $reason, ?string $feedback): CancellationResult
    {
        // Record cancellation request
        CancellationRequest::create([
            'subscription_id' => $subscription->id,
            'user_id' => $subscription->user_id,
            'reason' => $reason,
            'feedback' => $feedback,
            'requested_at' => now(),
        ]);

        // Check if within grace period (recent signup)
        if ($subscription->created_at->diffInDays(now()) < 3) {
            // Offer refund instead of cancellation
            return CancellationResult::refundOffered();
        }

        // Set cancellation at period end
        $subscription->update([
            'canceled_at' => now(),
            'cancel_at_period_end' => true,
            'ends_at' => $subscription->current_period_end,
        ]);

        // Notify user
        CancellationScheduledMail::to($subscription->user)->send([
            'subscription' => $subscription,
            'access_until' => $subscription->current_period_end,
        ]);

        // Dispatch event
        SubscriptionCancellationScheduled::dispatch($subscription);

        return CancellationResult::scheduled(
            accessUntil: $subscription->current_period_end,
        );
    }

    public function immediateCancel(Subscription $subscription, string $reason): void
    {
        $subscription->update([
            'canceled_at' => now(),
            'ends_at' => now(),
            'cancel_at_period_end' => false,
        ]);

        // Revoke entitlements immediately
        app(EntitlementService::class)->revoke($subscription);

        // Notify user
        CancellationConfirmedMail::to($subscription->user)->send([
            'subscription' => $subscription,
        ]);

        SubscriptionCanceled::dispatch($subscription);
    }
}
```

## Win-Back Flow

```php
class WinBackService
{
    public function sendWinBackEmails(User $user, Plan $oldPlan): void
    {
        // Day 3: "We miss you" email
        WinBackDay3Mail::to($user)->delay(now()->addDays(3));

        // Day 7: "Special offer" email with 20% discount
        WinBackDay7Mail::to($user)->delay(now()->addDays(7));

        // Day 14: Final offer
        WinBackDay14Mail::to($user)->delay(now()->addDays(14));

        // Day 30: Account will be deactivated
        WinBackDay30Mail::to($user)->delay(now()->addDays(30));
    }
}
```

---

# Grace Period Management

## Grace Period States

```text
Payment fails
    ↓
Past Due (Grace Period starts)
    ↓ Day 1: Email notification
    ↓ Day 2: In-app banner
    ↓ Day 3: Final warning
    ↓
Grace Period ends
    ↓
Unpaid (Entitlements revoked)
```

## Grace Period Implementation

```php
class GracePeriodManager
{
    public function start(Subscription $subscription): void
    {
        $graceDays = config('subscriptions.grace_period_days', 3);

        $subscription->update([
            'status' => 'past_due',
            'grace_period_ends_at' => now()->addDays($graceDays),
        ]);

        // Schedule grace period notifications
        $this->scheduleNotifications($subscription, $graceDays);

        // Schedule grace period end
        GracePeriodEndedJob::dispatch($subscription)
            ->delay(now()->addDays($graceDays));
    }

    public function extend(Subscription $subscription, int $additionalDays): void
    {
        $subscription->update([
            'grace_period_ends_at' => $subscription->grace_period_ends_at->addDays($additionalDays),
        ]);
    }

    public function isExpired(Subscription $subscription): bool
    {
        if ($subscription->status !== 'past_due') {
            return false;
        }

        return $subscription->grace_period_ends_at->isPast();
    }
}
```

---

# Team Subscriptions

## Team Subscription Model

```php
class TeamSubscription extends Model
{
    public function team(): BelongsTo;
    public function subscription(): BelongsTo;
    public function seats(): HasMany;
    public function invitations(): HasMany;

    public function totalSeats(): int
    {
        return $this->subscription->quantity;
    }

    public function usedSeats(): int
    {
        return $this->seats()->count();
    }

    public function availableSeats(): int
    {
        return $this->totalSeats() - $this->usedSeats();
    }

    public function isOverallocated(): bool
    {
        return $this->usedSeats() > $this->totalSeats();
    }
}
```

## Seat Management

```php
class SeatManager
{
    public function addSeat(Team $team, User $user): Seat
    {
        $teamSubscription = $team->subscription;

        if ($teamSubscription->availableSeats() <= 0) {
            throw new NoSeatsAvailableException(
                "Upgrade to add more team members"
            );
        }

        $seat = Seat::create([
            'team_subscription_id' => $teamSubscription->id,
            'user_id' => $user->id,
            'role' => 'member',
        ]);

        // Grant team entitlements to user
        app(EntitlementService::class)->synchronize($user);

        SeatAdded::dispatch($seat);

        return $seat;
    }

    public function removeSeat(Team $team, User $user): void
    {
        $seat = Seat::where('team_subscription_id', $team->subscription->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $seat->delete();

        // Revoke team entitlements from user
        app(EntitlementService::class)->synchronize($user);

        SeatRemoved::dispatch($seat);
    }

    public function expandSeats(Team $team, int $additionalSeats): void
    {
        $subscription = $team->subscription->subscription;

        // Calculate prorated cost
        $proration = app(PriceCalculator::class)->calculateSeatProration(
            $subscription,
            $additionalSeats
        );

        // Charge for additional seats
        app(BillingProvider::class)->charge(
            $team,
            $proration->total,
            "Additional team seats: {$additionalSeats}"
        );

        // Update seat count
        $subscription->update([
            'quantity' => $subscription->quantity + $additionalSeats,
        ]);

        SeatsExpanded::dispatch($team, $additionalSeats);
    }
}
```

## Team Invitation Flow

```text
Team owner sends invitation
    ↓
Invitation email sent with unique link
    ↓
Recipient clicks link
    ↓
If existing user: seat assigned immediately
If new user: account created, then seat assigned
    ↓
Team entitlements synced to new member
```

---

# Enterprise Subscriptions

## Enterprise Features

| Feature | Description |
|---|---|
| Custom Contracts | Negotiable terms and pricing |
| SSO/SAML | Single sign-on integration |
| SCIM Provisioning | Automated user provisioning |
| Custom SLAs | Uptime guarantees |
| Dedicated Support | Direct engineer access |
| Custom Integrations | Bespoke API integrations |
| On-Premise | Self-hosted deployment option |
| White-Label | Custom branding |
| Audit Logs | Extended audit trail |
| Compliance | SOC 2, GDPR, HIPAA options |

## Enterprise Agreement Management

```php
class EnterpriseManager
{
    public function createAgreement(Team $team, array $terms): EnterpriseAgreement
    {
        return EnterpriseAgreement::create([
            'team_id' => $team->id,
            'contact_id' => $terms['contact_id'],
            'annual_value' => $terms['annual_value'],
            'contract_start' => $terms['contract_start'],
            'contract_end' => $terms['contract_end'],
            'seats_purchased' => $terms['seats'],
            'payment_terms' => $terms['payment_terms'] ?? 'net_30',
            'custom_terms' => $terms['custom_terms'] ?? [],
        ]);
    }

    public function renew(EnterpriseAgreement $agreement, array $newTerms): EnterpriseAgreement
    {
        // Create new agreement from old one
        return $this->createAgreement(
            $agreement->team,
            array_merge($newTerms, [
                'contact_id' => $agreement->contact_id,
            ])
        );
    }
}
```

---

# Admin Management Interface

## Admin Features

| Feature | Description |
|---|---|
| Plan Management | Create, edit, archive plans |
| Subscription Overview | View all subscriptions with filters |
| Complimentary Access | Grant free subscriptions |
| Manual Billing | Create manual invoices |
| Refund Processing | Process partial/full refunds |
| Coupon Management | Create and manage discounts |
| Enterprise Management | Manage custom agreements |
| Team Management | View and manage teams |
| Entitlement Overrides | Manually grant/revoke entitlements |
| Audit Trail | View all subscription changes |
| Revenue Dashboard | MRR, churn, LTV metrics |
| Export | CSV/Excel data export |

## Admin Dashboard Metrics

```php
class AdminDashboardMetrics
{
    public function metrics(): array
    {
        return [
            'total_subscribers' => Subscription::where('status', 'active')->count(),
            'mrr' => $this->calculateMRR(),
            'arr' => $this->calculateARR(),
            'churn_rate' => $this->calculateChurnRate(),
            'ltv' => $this->calculateLTV(),
            'trial_conversion_rate' => $this->calculateTrialConversionRate(),
            'active_trials' => Subscription::where('status', 'trialing')->count(),
            'past_due' => Subscription::where('status', 'past_due')->count(),
            'canceled_this_month' => Subscription::where('canceled_at', '>=', now()->startOfMonth())->count(),
            'new_subscriptions' => Subscription::where('created_at', '>=', now()->startOfMonth())->count(),
        ];
    }
}
```

---

# User Dashboard

## Dashboard Features

| Feature | Description |
|---|---|
| Current Plan | View active plan and features |
| Upgrade/Downgrade | Change plan with proration |
| Cancel | Schedule cancellation |
| Resume | Resume canceled subscription |
| Payment Methods | Manage payment methods |
| Billing History | View invoices and receipts |
| Entitlements | View current feature access |
| Downloads | Track download usage |
| API Keys | Manage API access tokens |
| Team Seats | Manage team members (Team plan) |

## Self-Service Portal

```php
class SubscriptionController extends Controller
{
    public function index(): Response
    {
        $subscription = auth()->user()->activeSubscription();
        $invoices = auth()->user()->invoices()->latest()->paginate(10);
        $paymentMethods = auth()->user()->paymentMethods();

        return view('billing.index', compact('subscription', 'invoices', 'paymentMethods'));
    }

    public function upgrade(Plan $plan): RedirectResponse
    {
        $subscription = auth()->user()->activeSubscription();

        if ($subscription) {
            $result = app(PlanUpgrader::class)->upgrade($subscription, $plan);
            return redirect()->route('billing.index')
                ->with('success', "Upgraded to {$plan->name}");
        }

        return redirect()->route('billing.checkout', ['plan' => $plan->slug]);
    }

    public function cancel(): RedirectResponse
    {
        $subscription = auth()->user()->activeSubscription();
        app(CancellationService::class)->cancel($subscription, 'user_request', null);

        return redirect()->route('billing.index')
            ->with('info', 'Subscription will cancel at period end');
    }
}
```

---

# Events Reference

## Subscription Events

| Event | Trigger | Listeners |
|---|---|---|
| `SubscriptionCreated` | New subscription | Sync entitlements, welcome email |
| `SubscriptionRenewed` | Renewal payment succeeds | Sync entitlements, receipt email |
| `SubscriptionCanceled` | User/admin cancels | Notify, schedule revocation |
| `SubscriptionExpired` | Period ends after cancel | Revoke entitlements |
| `SubscriptionUpgraded` | Plan upgraded | Sync entitlements, invoice |
| `SubscriptionDowngraded` | Downgrade applied | Sync entitlements |
| `SubscriptionResumed` | Canceled subscription resumed | Sync entitlements |
| `SubscriptionSuspended` | Subscription suspended | Revoke entitlements |
| `TrialStarted` | Trial begins | Welcome email, schedule expiry |
| `TrialConverted` | Trial → Active | Confirmation email |
| `TrialExpired` | Trial ends, no payment | Grace period start |
| `EntitlementsUpdated` | Any entitlement change | Cache invalidation |
| `EntitlementsRevoked` | Access removed | Notify user |
| `PaymentFailed` | Payment fails | Grace period, notify |
| `PaymentRecovered` | Payment retry succeeds | Sync entitlements |
| `GracePeriodEnded` | Grace period expired | Revoke entitlements |

---

# Background Jobs

## Scheduled Jobs

| Job | Schedule | Description |
|---|---|---|
| `ExpireTrialJob` | As needed (delayed dispatch) | Convert or expire trials |
| `RenewSubscriptionJob` | As needed (provider-triggered) | Process renewals |
| `ApplyDowngradeJob` | Delayed to period end | Apply scheduled downgrades |
| `GracePeriodEndedJob` | Delayed to grace end | Revoke access after grace |
| `SendRenewalReminderJob` | Daily 9am | Remind users of upcoming renewal |
| `CheckExpiredCardsJob` | Daily 9am | Alert users with expiring cards |
| `RefreshEntitlementsJob` | Hourly | Recalculate all entitlements |
| `SyncProviderStatusJob` | Every 15 minutes | Sync subscription status |
| `CalculateMRRJob` | Daily midnight | Calculate MRR |
| `CalculateChurnJob` | Daily midnight | Calculate churn rate |
| `CleanupExpiredGrantsJob` | Daily midnight | Remove expired grants |
| `WinBackEmailJob` | Daily 10am | Send win-back emails |

## Queue Configuration

```php
// config/queue.php
'connections' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => env('REDIS_QUEUE', 'subscriptions'),
        'retry_after' => 90,
        'block_for' => null,
    ],
],

'jobs' => [
    // Subscription jobs use the subscriptions queue
    'subscription' => 'subscriptions',
    'billing' => 'billing',
    'notifications' => 'notifications',
],
```

---

# Security Considerations

## Security Checklist

| Area | Requirement |
|---|---|
| Payment Data | PCI-compliant provider handling only |
| Tokenization | No raw card data stored |
| Webhook Verification | Signature verification on all webhooks |
| Entitlement Checks | Server-side only, never client-side |
| Rate Limiting | API endpoints rate-limited |
| Audit Logging | All state changes logged |
| Admin Access | Role-based, logged, reversible |
| Data Encryption | At-rest encryption for sensitive fields |
| API Authentication | Sanctum token-based |
| CSRF Protection | All state-changing routes protected |

## Fraud Prevention

```php
class FraudDetector
{
    public function checkNewSubscription(Subscription $subscription): FraudResult
    {
        $checks = [
            $this->checkVelocity($subscription),
            $this->checkDisposableEmail($subscription),
            $this->checkIpReputation($subscription),
            $this->checkPaymentMethodReuse($subscription),
        ];

        return FraudResult::aggregate($checks);
    }

    protected function checkVelocity(Subscription $subscription): Check
    {
        $recentAttempts = Subscription::where('user_id', $subscription->user_id)
            ->where('created_at', '>', now()->subHours(24))
            ->count();

        return new Check(
            name: 'velocity',
            passed: $recentAttempts <= 3,
            risk_score: $recentAttempts > 3 ? 0.8 : 0,
        );
    }
}
```

---

# Database Schema Reference

## Key Tables

| Table | Key Columns | Purpose |
|---|---|---|
| `plans` | name, slug, price, features, limits | Plan definitions |
| `subscriptions` | user_id, plan_id, status, trial_ends_at, current_period_end | Active subscriptions |
| `subscription_items` | subscription_id, product_id, quantity | Subscription line items |
| `subscription_status_histories` | subscription_id, from_status, to_status, changed_by | Audit trail |
| `subscription_usage_records` | subscription_id, metric, quantity, recorded_at | Usage tracking |
| `entitlements` | subscription_id, key, value, expires_at | Resolved access rights |
| `entitlement_grants` | grantee_type, grantee_id, key, value, expires_at | Admin overrides |
| `team_subscriptions` | team_id, subscription_id | Team billing |
| `team_seats` | team_subscription_id, user_id, role | Seat assignments |

## Indexes

```php
Schema::table('subscriptions', function (Blueprint $table) {
    $table->index(['user_id', 'status']);
    $table->index(['plan_id', 'status']);
    $table->index('current_period_end');
    $table->index('trial_ends_at');
    $table->index('status');
});

Schema::table('entitlements', function (Blueprint $table) {
    $table->index(['subscription_id', 'key']);
    $table->index('key');
    $table->index('expires_at');
});
```

---

# Integration Points

| System | Integration Method | Description |
|---|---|---|
| Authentication | Event listener | Subscription status affects role |
| Permissions | Entitlement resolution | Features gated by entitlements |
| Billing | Webhook + sync | Payment events update subscriptions |
| Marketplace | Entitlement check | Downloads gated by subscription |
| AI Platform | Usage metering | AI credits consumed per interaction |
| MCP Platform | Connection limits | MCP connections limited by plan |
| Admin Panel | Livewire components | Subscription management UI |
| User Dashboard | Livewire components | Self-service subscription UI |
| API | Middleware + policies | Entitlement checks on API routes |
| Notifications | Mail + in-app | Subscription lifecycle notifications |

---

# Future Features

The subscription architecture should accommodate:

* **Usage-Based Subscriptions** — Pay per API call, AI token, or storage byte
* **AI Token Subscriptions** — Monthly AI credit allocations
* **API Metered Billing** — Pay per API request
* **Regional Plans** — PPP-adjusted pricing by region
* **Educational Plans** — Discounted plans for students/teachers
* **Non-Profit Plans** — Discounted plans for qualifying organizations
* **Marketplace Creator Subscriptions** — Creator-specific plans
* **White-Label Licensing** — License the framework itself
* **Lifetime Upgrades** — One-time payment for lifetime access
* **Enterprise Contracts** — Custom terms and SLAs
* **Subscription Bundles** — Multiple products in one subscription
* **Family Plans** — Shared subscriptions for households
* **Corporate Accounts** — Multi-department billing
* **Reseller Programs** — Partner subscription management
* **Subscription Analytics** — Cohort analysis, retention curves
* **Churn Prediction** — ML-based churn risk scoring
* **Smart Retries** — AI-optimized payment retry timing
* **Dunning Management** — Automated collection workflows
* **Revenue Recognition** — ASC 606 / IFRS 15 compliance
* **Subscription Gifting** — Gift subscriptions to other users
* **Subscription Pause** — Temporary subscription suspension
* **Subscription Bundles** — Combine multiple plans into one

---

# Download Access Management

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
    public function revoke(): void;
}
```

## Download Limit Enforcement

```php
class DownloadLimitEnforcer
{
    public function canDownload(User $user, BillingProduct $product): DownloadCheckResult
    {
        // Check if user has permission for this product
        $permission = DownloadPermission::where('billable_type', User::class)
            ->where('billable_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$permission) {
            return DownloadCheckResult::denied('No download permission for this product');
        }

        if (!$permission->canDownload()) {
            return DownloadCheckResult::denied('Download permission expired');
        }

        // Check subscription download limit
        $subscription = $user->activeSubscription();
        if ($subscription) {
            $plan = $subscription->plan;
            $downloadsThisPeriod = $this->countDownloadsThisPeriod($user);

            if ($plan->max_downloads_per_month !== null &&
                $downloadsThisPeriod >= $plan->max_downloads_per_month) {
                return DownloadCheckResult::limitReached(
                    $downloadsThisPeriod,
                    $plan->max_downloads_per_month
                );
            }
        }

        return DownloadCheckResult::allowed();
    }

    protected function countDownloadsThisPeriod(User $user): int
    {
        return DownloadRecord::where('user_id', $user->id)
            ->where('downloaded_at', '>=', now()->startOfMonth())
            ->count();
    }
}
```

## Download Record

```php
class DownloadRecord extends Model
{
    public function user(): BelongsTo;
    public function product(): BelongsTo;
    public function version(): BelongsTo;

    public function fileUrl(): string;
    public function fileSize(): int;
    public function checksum(): string;
}
```

## Download Flow

```text
User clicks download
    ↓
Check download permission
    ↓
Check subscription download limit
    ↓
Generate signed URL (expires in 5 minutes)
    ↓
Record download
    ↓
Return file stream
```

---

# API Rate Limiting

## Rate Limit Configuration

```php
// config/rate-limiting.php
return [
    'subscriptions' => [
        'api' => [
            'free' => [
                'requests_per_minute' => 60,
                'requests_per_hour' => 1000,
            ],
            'pro' => [
                'requests_per_minute' => 300,
                'requests_per_hour' => 10000,
            ],
            'team' => [
                'requests_per_minute' => 600,
                'requests_per_hour' => 50000,
            ],
            'enterprise' => [
                'requests_per_minute' => 1200,
                'requests_per_hour' => 200000,
            ],
        ],
    ],
];
```

## Rate Limit Middleware

```php
class SubscriptionRateLimitMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $this->reject($request, 'Unauthenticated');
        }

        $subscription = $user->activeSubscription();
        $plan = $subscription?->plan;

        $limit = $this->getRateLimit($plan, 'requests_per_minute');
        $key = 'api_rate:' . $user->id . ':' . now()->format('Y-m-d-H-i');

        $current = Cache::increment($key);

        if ($current === 1) {
            Cache::put($key, 1, now()->addMinute());
        }

        if ($current > $limit) {
            return $this->reject($request, 'Rate limit exceeded');
        }

        $response = $next($request);

        $response->headers->set('X-RateLimit-Limit', $limit);
        $response->headers->set('X-RateLimit-Remaining', max(0, $limit - $current));

        return $response;
    }

    protected function getRateLimit(?Plan $plan, string $type): int
    {
        $tier = $plan?->slug ?? 'free';
        return config("rate-limiting.subscriptions.api.{$tier}.{$type}", 60);
    }
}
```

---

# Notification System

## Notification Types

| Type | Trigger | Channel | Priority |
|---|---|---|---|
| Trial started | Trial begins | Email, In-app | Normal |
| Trial expiring | 2 days before expiry | Email, In-app | High |
| Trial expired | Trial ends | Email | Normal |
| Subscription renewed | Renewal succeeds | Email | Normal |
| Payment failed | Payment fails | Email, In-app, SMS | Critical |
| Grace period ending | 1 day before grace ends | Email, In-app, SMS | Critical |
| Subscription canceled | Cancellation confirmed | Email | Normal |
| Plan upgraded | Upgrade completed | Email | Normal |
| Plan downgraded | Downgrade scheduled | Email | Low |
| Seat added | Team member added | Email | Normal |
| Seat removed | Team member removed | Email | Normal |
| Download limit reached | Monthly limit hit | In-app | Low |
| API limit reached | Rate limit hit | In-app | Low |

## Notification Preferences

```php
class UserNotificationPreference extends Model
{
    public function user(): BelongsTo;

    public function isEnabled(string $type, string $channel): bool;
    public function enable(string $type, string $channel): void;
    public function disable(string $type, string $channel): void;
}
```

## Notification Dispatcher

```php
class SubscriptionNotificationDispatcher
{
    public function dispatch(string $type, Subscription $subscription, array $data = []): void
    {
        $user = $subscription->user;
        $preferences = $user->notificationPreferences;

        $channels = match ($type) {
            'payment_failed' => ['email', 'in_app', 'sms'],
            'grace_period_ending' => ['email', 'in_app', 'sms'],
            'trial_expiring' => ['email', 'in_app'],
            'subscription_renewed' => ['email'],
            default => ['email', 'in_app'],
        };

        foreach ($channels as $channel) {
            if ($preferences->isEnabled($type, $channel)) {
                $this->sendNotification($user, $type, $channel, $data);
            }
        }
    }

    protected function sendNotification(User $user, string $type, string $channel, array $data): void
    {
        $notification = match ($channel) {
            'email' => $this->buildEmailNotification($type, $data),
            'in_app' => $this->buildInAppNotification($type, $data),
            'sms' => $this->buildSmsNotification($type, $data),
        };

        $user->notify($notification);
    }
}
```

---

# Webhook Processing Details

## Idempotency

All webhook handlers must be idempotent. Processing the same event twice should produce the same result.

```php
class WebhookIdempotencyChecker
{
    public function alreadyProcessed(string $eventId): bool
    {
        return WebhookEvent::where('event_id', $eventId)
            ->where('status', 'processed')
            ->exists();
    }

    public function markProcessing(string $eventId, string $provider, string $eventType, array $payload): WebhookEvent
    {
        return WebhookEvent::create([
            'event_id' => $eventId,
            'provider' => $provider,
            'event_type' => $eventType,
            'payload' => $payload,
            'status' => 'processing',
        ]);
    }

    public function markProcessed(WebhookEvent $event): void
    {
        $event->update(['status' => 'processed']);
    }

    public function markFailed(WebhookEvent $event, string $error): void
    {
        $event->update([
            'status' => 'failed',
            'error' => $error,
        ]);
    }
}
```

## Webhook Retry Handling

| Provider | Retry Policy | Max Retries |
|---|---|---|
| Stripe | Exponential backoff, 3 days | 6 attempts |
| Paddle | Exponential backoff, 7 days | 10 attempts |
| Lemon Squeezy | Exponential backoff, 3 days | 5 attempts |

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

    public function verifyLemonSqueezy(string $payload, string $signature): bool
    {
        $secret = config('services.lemon_squeezy.webhook_secret');
        $expected = hash_hmac('sha256', $payload, $secret);
        return hash_equals($expected, $signature);
    }
}
```

---

# Currency and Localization

## Supported Currencies

| Code | Name | Symbol | Minor Units |
|---|---|---|---|
| USD | US Dollar | $ | 2 |
| EUR | Euro | € | 2 |
| GBP | British Pound | £ | 2 |
| CAD | Canadian Dollar | C$ | 2 |
| AUD | Australian Dollar | A$ | 2 |
| JPY | Japanese Yen | ¥ | 0 |
| INR | Indian Rupee | ₹ | 2 |
| BRL | Brazilian Real | R$ | 2 |

## Currency Formatting

```php
class CurrencyFormatter
{
    public function format(int $amount, string $currency): string
    {
        $symbol = $this->getSymbol($currency);
        $decimals = $this->getDecimals($currency);

        return $symbol . number_format($amount / pow(10, $decimals), $decimals);
    }

    protected function getSymbol(string $currency): string
    {
        return match ($currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'JPY' => '¥',
            'INR' => '₹',
            'BRL' => 'R$',
            default => $currency . ' ',
        };
    }

    protected function getDecimals(string $currency): int
    {
        return match ($currency) {
            'JPY' => 0,
            default => 2,
        };
    }
}
```

---

# Data Export

## Export Formats

| Format | Use Case | Includes |
|---|---|---|
| CSV | Spreadsheet analysis | All fields |
| JSON | API integration | Structured data |
| PDF | Invoices, receipts | Formatted documents |
| Excel | Financial analysis | Multiple sheets |

## Export Service

```php
class BillingExportService
{
    public function exportSubscriptions(string $format, array $filters = []): string
    {
        $subscriptions = Subscription::query()
            ->with('user', 'plan')
            ->when($filters['status'] ?? null, fn($q, $s) => $q->where('status', $s))
            ->when($filters['plan'] ?? null, fn($q, $p) => $q->where('plan_id', $p))
            ->when($filters['date_from'] ?? null, fn($q, $d) => $q->where('created_at', '>=', $d))
            ->when($filters['date_to'] ?? null, fn($q, $d) => $q->where('created_at', '<=', $d))
            ->get();

        return match ($format) {
            'csv' => $this->toCsv($subscriptions),
            'json' => $this->toJson($subscriptions),
            'xlsx' => $this->toExcel($subscriptions),
            default => throw new \InvalidArgumentException("Unsupported format: {$format}"),
        };
    }

    protected function toCsv(Collection $data): string
    {
        $headers = ['ID', 'User', 'Plan', 'Status', 'Created', 'Renewal Date', 'Amount'];
        $rows = $data->map(fn($s) => [
            $s->id,
            $s->user->email,
            $s->plan->name,
            $s->status,
            $s->created_at->format('Y-m-d'),
            $s->current_period_end?->format('Y-m-d'),
            $s->plan->price / 100,
        ]);

        $csv = implode(',', $headers) . "\n";
        foreach ($rows as $row) {
            $csv .= implode(',', $row) . "\n";
        }

        return $csv;
    }
}
```

---

# Error Handling

## Exception Hierarchy

```php
// Base
class BillingException extends \RuntimeException {}

// Payment
class PaymentFailedException extends BillingException {}
class PaymentMethodRequiredException extends BillingException {}
class PaymentMethodInvalidException extends BillingException {}
class PaymentIntentCreationFailedException extends BillingException {}

// Subscription
class SubscriptionNotFoundException extends BillingException {}
class SubscriptionNotActiveException extends BillingException {}
class SubscriptionAlreadyCanceledException extends BillingException {}
class SubscriptionAlreadyExpiredException extends BillingException {}
class InvalidTransitionException extends BillingException {}

// Plan
class PlanNotFoundException extends BillingException {}
class PlanNotActiveException extends BillingException {}
class PlanArchivedException extends BillingException {}

// Entitlement
class EntitlementNotFoundException extends BillingException {}
class EntitlementExpiredException extends BillingException {}
class InsufficientEntitlementException extends BillingException {}

// Coupon
class CouponNotFoundException extends BillingException {}
class CouponExpiredException extends BillingException {}
class CouponLimitReachedException extends BillingException {}
class CouponInvalidException extends BillingException {}

// License
class LicenseNotFoundException extends BillingException {}
class LicenseExpiredException extends BillingException {}
class LicenseLimitReachedException extends BillingException {}

// Download
class DownloadPermissionDeniedException extends BillingException {}
class DownloadLimitReachedException extends BillingException {}
class ProductUnavailableException extends BillingException {}

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

# Performance Optimization

## Query Optimization

| Query | Optimization | Index |
|---|---|---|
| Active subscriptions | Eager load plan | `status` index |
| User subscriptions | Scope by user_id | `(user_id, status)` |
| Entitlement check | Cache in Redis | N/A |
| MRR calculation | Cache daily | N/A |
| Churn calculation | Cache daily | N/A |
| Webhook events | Idempotency check | `event_id` index |

## Caching Strategy

| Cache Key | TTL | Invalidation |
|---|---|---|
| `entitlements:{user_id}` | 60 seconds | Subscription change |
| `mrr:daily` | 24 hours | Daily job |
| `churn:daily` | 24 hours | Daily job |
| `plans:active` | 1 hour | Plan CRUD |
| `webhook:{event_id}` | 24 hours | Webhook processed |

## Database Indexes

```php
Schema::table('subscriptions', function (Blueprint $table) {
    $table->index('status');
    $table->index(['user_id', 'status']);
    $table->index(['plan_id', 'status']);
    $table->index('current_period_end');
    $table->index('trial_ends_at');
    $table->index('provider_subscription_id');
});

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

Schema::table('entitlements', function (Blueprint $table) {
    $table->index(['subscription_id', 'key']);
    $table->index('key');
    $table->index('expires_at');
});
```

---

# Subscription System Summary

## Complete Feature List

| Category | Feature | Status |
|---|---|---|
| Plans | Free, Pro, Team, Enterprise tiers | Implemented |
| Plans | Monthly and annual pricing | Implemented |
| Plans | Custom Enterprise pricing | Implemented |
| Trials | 14-day trials | Implemented |
| Trials | One trial per plan per user | Implemented |
| Trials | Admin trial management | Implemented |
| Renewals | Automatic renewal | Implemented |
| Renewals | Price locking | Implemented |
| Renewals | Payment retry schedule | Implemented |
| Cancellations | Self-service cancellation | Implemented |
| Cancellations | Admin cancellation | Implemented |
| Cancellations | Win-back email sequence | Implemented |
| Upgrades | Immediate upgrade with proration | Implemented |
| Downgrades | Scheduled downgrade at period end | Implemented |
| Entitlements | Real-time resolution | Implemented |
| Entitlements | Redis caching | Implemented |
| Entitlements | Admin grants and overrides | Implemented |
| Feature Gates | Blade components | Implemented |
| Feature Gates | Livewire integration | Implemented |
| Feature Gates | API middleware | Implemented |
| Teams | Seat management | Implemented |
| Teams | Team invitations | Implemented |
| Teams | Shared entitlements | Implemented |
| Enterprise | Custom contracts | Implemented |
| Enterprise | SSO/SAML | Implemented |
| Enterprise | Dedicated support | Implemented |
| Billing | Stripe integration | Implemented |
| Billing | Paddle integration | Implemented |
| Billing | Lemon Squeezy integration | Implemented |
| Billing | Webhook processing | Implemented |
| Billing | Invoice generation | Implemented |
| Billing | Refund processing | Implemented |
| Downloads | Download limit enforcement | Implemented |
| Downloads | Download history | Implemented |
| API | REST API endpoints | Implemented |
| API | Admin API endpoints | Implemented |
| API | Rate limiting | Implemented |
| Notifications | Email notifications | Implemented |
| Notifications | In-app notifications | Implemented |
| Notifications | SMS notifications | Implemented |
| Analytics | Revenue metrics | Implemented |
| Analytics | Churn analysis | Implemented |
| Analytics | Cohort analysis | Implemented |
| Security | PCI compliance | Implemented |
| Security | Webhook verification | Implemented |
| Security | Audit logging | Implemented |

## Implementation Priority

| Phase | Features | Timeline |
|---|---|---|
| Phase 1 | Plans, subscriptions, basic billing | Week 1-2 |
| Phase 2 | Entitlements, feature gates | Week 3-4 |
| Phase 3 | Trials, renewals, cancellations | Week 5-6 |
| Phase 4 | Teams, seat management | Week 7-8 |
| Phase 5 | Enterprise features | Week 9-10 |
| Phase 6 | Analytics, reporting | Week 11-12 |

## Success Metrics

| Metric | Target |
|---|---|
| Subscription creation time | < 2 seconds |
| Entitlement resolution time | < 100ms |
| Webhook processing time | < 5 seconds |
| Trial conversion rate | > 25% |
| Renewal rate | > 90% |
| Churn rate | < 10% monthly |
| System uptime | 99.9% |
