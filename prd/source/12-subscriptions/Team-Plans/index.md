# Team Plans

## Overview

Team plans provide subscription management for organizations with multiple users. This document covers seat management, team billing, admin controls, and team invitations.

## Team Plan Structure

```php
class TeamPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'price_per_seat', 'price_monthly',
        'min_seats', 'max_seats', 'features',
        'billing_cycle', 'metadata',
    ];

    protected $casts = [
        'price_per_seat' => 'integer',
        'price_monthly' => 'integer',
        'min_seats' => 'int',
        'max_seats' => 'int',
        'features' => 'array',
        'metadata' => 'array',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
```

## Seat Management

### Seat Allocation

```php
class SeatManager
{
    public function addSeats(Team $team, int $count): void
    {
        $plan = $team->plan;
        $newTotal = $team->seats_used + $count;

        if ($newTotal > $plan->max_seats) {
            throw new SeatLimitExceededException(
                "Cannot exceed {$plan->max_seats} seats."
            );
        }

        $team->update(['seats_used' => $newTotal]);

        // Calculate prorated charge
        $dailyRate = $plan->price_per_seat / 30;
        $remaining = $team->subscription->ends_at->diffInDays(now());
        $charge = $dailyRate * $count * $remaining;

        if ($charge > 0) {
            PaymentService::charge(
                user: $team->owner,
                amount: (int) $charge,
                description: "Added {$count} seat(s) to {$team->name}",
            );
        }

        event(new SeatsAdded($team, $count));
    }

    public function removeSeats(Team $team, int $count): void
    {
        $newTotal = max($team->plan->min_seats, $team->seats_used - $count);

        if ($newTotal < $team->members()->count()) {
            throw new CannotRemoveOccupiedSeatsException(
                "Cannot remove seats with active members."
            );
        }

        $team->update(['seats_used' => $newTotal]);

        // Calculate credit
        $dailyRate = $team->plan->price_per_seat / 30;
        $remaining = $team->subscription->ends_at->diffInDays(now());
        $credit = $dailyRate * $count * $remaining;

        if ($credit > 0) {
            CreditService::issue(
                user: $team->owner,
                amount: (int) $credit,
                reason: "Removed {$count} seat(s) from {$team->name}",
            );
        }

        event(new SeatsRemoved($team, $count));
    }

    public function getAvailableSeats(Team $team): int
    {
        return $team->seats_used - $team->members()->count();
    }

    public function getSeatUsage(Team $team): array
    {
        return [
            'total' => $team->seats_used,
            'occupied' => $team->members()->count(),
            'available' => $this->getAvailableSeats($team),
            'utilization' => $team->seats_used > 0
                ? ($team->members()->count() / $team->seats_used) * 100
                : 0,
        ];
    }
}
```

### Seat Schema

| Column | Type | Description |
|--------|------|-------------|
| `team_id` | `bigint` | FK to teams |
| `seats_used` | `int` | Allocated seats |
| `plan_id` | `bigint` | FK to team_plans |
| `billing_cycle` | `enum` | monthly / annual |
| `price_per_seat` | `bigint` | Price per seat |
| `next_billing_at` | `timestamp` | |

## Team Billing

### Billing Service

```php
class TeamBillingService
{
    public function calculateTotal(Team $team): int
    {
        $plan = $team->plan;
        return $team->seats_used * $plan->price_per_seat;
    }

    public function createInvoice(Team $team): Invoice
    {
        $total = $this->calculateTotal($team);
        $tax = TaxCalculator::calculate($team->owner, $total);

        $invoice = Invoice::create([
            'user_id' => $team->owner_id,
            'team_id' => $team->id,
            'number' => InvoiceNumber::generate(),
            'status' => 'pending',
            'subtotal' => $total,
            'tax' => $tax,
            'total' => $total + $tax,
            'currency' => $team->currency,
            'due_at' => now()->addDays(30),
        ]);

        $invoice->items()->create([
            'description' => "{$plan->name} × {$team->seats_used} seats",
            'quantity' => $team->seats_used,
            'unit_price' => $plan->price_per_seat,
            'amount' => $total,
        ]);

        return $invoice;
    }

    public function processTeamRenewal(Team $team): void
    {
        $invoice = $this->createInvoice($team);

        try {
            PaymentService::chargeInvoice($invoice);

            $team->update([
                'next_billing_at' => $this->getNextBillingDate($team),
            ]);

            event(new TeamRenewed($team, $invoice));
        } catch (PaymentException $e) {
            event(new TeamPaymentFailed($team, $e));
        }
    }
}
```

### Billing Dashboard

```php
class TeamBillingDashboard extends Component
{
    public Team $team;

    public function summary(): array
    {
        return [
            'plan' => $this->team->plan->name,
            'seats' => $this->team->seats_used,
            'price_per_seat' => money($this->team->plan->price_per_seat),
            'total' => money(TeamBillingService::calculateTotal($this->team)),
            'next_billing' => $this->team->next_billing_at->format('M d, Y'),
            'payment_method' => $this->team->owner->defaultPaymentMethod(),
        ];
    }

    public function usage(): array
    {
        return SeatManager::getSeatUsage($this->team);
    }

    public function invoices(): Collection
    {
        return Invoice::where('team_id', $this->team->id)
            ->latest()
            ->paginate(10);
    }
}
```

## Admin Controls

### Team Admin Features

| Feature | Owner | Admin | Member |
|---------|:-----:|:-----:|:------:|
| Manage billing | ✅ | ❌ | ❌ |
| Add/remove seats | ✅ | ✅ | ❌ |
| Invite members | ✅ | ✅ | ❌ |
| Remove members | ✅ | ✅ | ❌ |
| Change plan | ✅ | ❌ | ❌ |
| Manage settings | ✅ | ✅ | ❌ |
| Create content | ✅ | ✅ | ✅ |
| View reports | ✅ | ✅ | ❌ |

### Admin Actions

```php
class TeamAdminController extends Controller
{
    public function inviteMember(InviteMemberRequest $request, Team $team)
    {
        $this->authorize('team.members.invite', $team);

        if (SeatManager::getAvailableSeats($team) <= 0) {
            return redirect()->back()->withErrors([
                'No seats available. Please add more seats first.',
            ]);
        }

        TeamInvitationService::send(
            team: $team,
            email: $request->email,
            role: $request->role,
            invitedBy: $this->user(),
        );

        return redirect()->back()->with('success', 'Invitation sent.');
    }

    public function removeMember(Team $team, User $member)
    {
        $this->authorize('team.members.remove', $team);

        if ($member->id === $team->owner_id) {
            return redirect()->back()->withErrors([
                'Cannot remove the team owner.',
            ]);
        }

        $team->removeMember($member);

        return redirect()->back()->with('success', 'Member removed.');
    }

    public function changePlan(ChangePlanRequest $request, Team $team)
    {
        $this->authorize('team.manage', $team);

        $newPlan = TeamPlan::findOrFail($request->plan_id);

        TeamPlanChangeService::change(
            team: $team,
            newPlan: $newPlan,
            effective: $request->effective, // immediate or next_billing
        );

        return redirect()->route('team.billing', $team);
    }
}
```

## Team Invitations

### Invitation Flow

```php
class TeamInvitationService
{
    public function send(Team $team, string $email, string $role, User $invitedBy): TeamInvitation
    {
        $invitation = TeamInvitation::create([
            'team_id' => $team->id,
            'email' => $email,
            'role' => $role,
            'invited_by' => $invitedBy->id,
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($email)->send(new TeamInvitationMail($invitation));

        event(new TeamInvitationSent($invitation));

        return $invitation;
    }

    public function accept(TeamInvitation $invitation, User $user): void
    {
        if ($invitation->expires_at->isPast()) {
            throw new InvitationExpiredException('This invitation has expired.');
        }

        if ($user->email !== $invitation->email) {
            throw new InvalidEmailException('This invitation was sent to a different email.');
        }

        $team = $invitation->team;

        if (SeatManager::getAvailableSeats($team) <= 0) {
            throw new NoSeatsAvailableException('No seats available.');
        }

        $team->addMember($user, role: $invitation->role);
        $invitation->update(['accepted_at' => now(), 'accepted_by' => $user->id]);

        event(new TeamInvitationAccepted($invitation));
    }
}
```

## Schema

### Team Plans Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | |
| `slug` | `string` | Unique |
| `price_per_seat` | `bigint` | In cents |
| `price_monthly` | `bigint` | Base price |
| `min_seats` | `int` | Default: 1 |
| `max_seats` | `int` | |
| `features` | `json` | |
| `is_active` | `bool` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

### Teams Table (Billing Columns)

| Column | Type | Description |
|--------|------|-------------|
| `plan_id` | `bigint?` | FK to team_plans |
| `seats_used` | `int` | |
| `billing_cycle` | `enum` | monthly / annual |
| `next_billing_at` | `timestamp?` | |
| `currency` | `string` | ISO 4217 |

## Best Practices

1. **Prorate seat changes** — charge or credit for mid-cycle changes
2. **Show seat usage** — help admins manage their team
3. **Limit seat additions** — prevent abuse
4. **Send billing reminders** — before team renewal
5. **Track seat utilization** — identify underused seats
6. **Support plan changes** — upgrade or downgrade team plan
7. **Test with Playwright** — verify team billing flows
