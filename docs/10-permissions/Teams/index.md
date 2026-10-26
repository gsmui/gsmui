# Team Permissions

## Overview

Team permissions extend the RBAC model with team-scoped authorization. Users can have different roles and permissions within different teams, enabling multi-tenant permission management.

## Team Roles

### Role Definitions

| Role | Level | Description |
|------|-------|-------------|
| `team_owner` | 0 | Full team control, cannot be removed |
| `team_admin` | 1 | Manage settings, members, and content |
| `team_member` | 2 | Create content, participate in team |
| `team_guest` | 3 | Read-only access to team resources |

### Team Role Hierarchy

```
team_owner
├── team_admin
│   ├── team_member
│   │   └── team_guest
```

### Team Permissions Matrix

| Permission | team_owner | team_admin | team_member | team_guest |
|------------|:----------:|:----------:|:-----------:|:----------:|
| `team.settings.manage` | ✅ | ✅ | ❌ | ❌ |
| `team.members.invite` | ✅ | ✅ | ❌ | ❌ |
| `team.members.remove` | ✅ | ❌ | ❌ | ❌ |
| `team.members.promote` | ✅ | ❌ | ❌ | ❌ |
| `team.content.create` | ✅ | ✅ | ✅ | ❌ |
| `team.content.read` | ✅ | ✅ | ✅ | ✅ |
| `team.content.update` | ✅ | ✅ | ✅ | ❌ |
| `team.content.delete` | ✅ | ✅ | ❌ | ❌ |
| `team.billing.manage` | ✅ | ❌ | ❌ | ❌ |
| `team.api.access` | ✅ | ✅ | ✅ | ❌ |
| `team.reports.view` | ✅ | ✅ | ❌ | ❌ |

## Team Invitations

### Invitation Flow

```
┌──────────────┐    invite     ┌─────────────────┐
│ team_admin   │ ────────────► │ Invite Created   │
└──────────────┘               └────────┬────────┘
                                        │
                              email sent
                                        │
                                        ▼
                               ┌─────────────────┐
                               │ User Accepts     │
                               └────────┬────────┘
                                        │
                                assigned role
                                        │
                                        ▼
                               ┌─────────────────┐
                               │ Team Member Added│
                               └─────────────────┘
```

### Invitation Model

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `team_id` | `bigint` | FK to teams |
| `email` | `string` | Invitee email |
| `role_id` | `bigint` | FK to roles |
| `invited_by` | `bigint` | FK to users |
| `token` | `string` | Unique invitation token |
| `expires_at` | `timestamp` | Expiration time |
| `accepted_at` | `timestamp?` | When accepted |
| `created_at` | `timestamp` | |

### Sending Invitations

```php
use App\Models\Team;
use App\Services\InvitationService;

class TeamController extends Controller
{
    public function invite(InviteRequest $request, Team $team)
    {
        $this->authorize('team.members.invite', $team);

        $invitation = InvitationService::create(
            team: $team,
            email: $request->email,
            role: $request->role,
            invitedBy: $this->user(),
        );

        InvitationMail::send($invitation);

        return redirect()->back()->with('success', 'Invitation sent.');
    }
}
```

### Accepting Invitations

```php
class AcceptInvitationController extends Controller
{
    public function show(string $token)
    {
        $invitation = Invitation::where('token', $token)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        return view('invitations.accept', ['invitation' => $invitation]);
    }

    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $invitation->accept($this->user());

        return redirect()->route('teams.show', $invitation->team);
    }
}
```

## Cross-Team Access

### Global Roles vs Team Roles

```php
class User extends Model
{
    // Global roles — apply everywhere
    public function globalRoles(): BelongsToMany
    {
        return $this->roles()->wherePivotNull('team_id');
    }

    // Team-scoped roles — apply only within specific team
    public function teamRoles(): BelongsToMany
    {
        return $this->roles()->wherePivotNotNull('team_id');
    }

    // Resolve effective permissions for a team context
    public function permissionsForTeam(Team $team): array
    {
        $global = $this->resolvePermissions($this->globalRoles);
        $teamScoped = $this->resolvePermissions(
            $this->teamRoles()->wherePivot('team_id', $team->id)
        );

        // Merge: team-specific permissions override global
        return array_merge($global, $teamScoped);
    }
}
```

### Cross-Team Permission Rules

| Scenario | Behavior |
|----------|----------|
| Global admin accesses team | Uses global admin permissions |
| Team member accesses other team | Denied unless global role allows |
| User with multiple team roles | Most restrictive wins per team |
| Global + team role conflict | Team role takes precedence within team |

### Cross-Team Access Control

```php
class CrossTeamGate
{
    public function accessTeam(User $user, Team $team): bool
    {
        // Global super admin can access any team
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Must have a role in this team
        return $user->teamRoles()
            ->wherePivot('team_id', $team->id)
            ->exists();
    }

    public function transferResource(User $user, $resource, Team $from, Team $to): bool
    {
        // Must be admin in both teams
        return $user->hasTeamRole($from, 'team_admin')
            && $user->hasTeamRole($to, 'team_admin');
    }
}
```

## Team Ownership

### Ownership Transfer

```php
class Team extends Model
{
    public function transferOwnership(User $newOwner): void
    {
        DB::transaction(function () use ($newOwner) {
            // Demote current owner
            $this->removeMember($this->owner);

            // Promote new owner
            $this->addMember($newOwner, role: 'team_owner');

            // Update team record
            $this->update(['owner_id' => $newOwner->id]);

            // Fire events
            event(new TeamOwnershipTransferred($this, $this->owner, $newOwner));
        });
    }
}
```

### Ownership Constraints

| Constraint | Description |
|------------|-------------|
| Cannot leave as owner | Must transfer ownership first |
| Cannot be removed as owner | Must transfer ownership first |
| Maximum one owner per team | Enforced at database level |
| Owner has all team permissions | Implicit, no role needed |

## Database Schema

### Team-User Pivot

| Column | Type | Description |
|--------|------|-------------|
| `team_id` | `bigint` | FK to teams |
| `user_id` | `bigint` | FK to users |
| `role_id` | `bigint` | FK to roles |
| `invited_by` | `bigint?` | FK to users |
| `joined_at` | `timestamp` | |

### Invitations Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `team_id` | `bigint` | FK to teams |
| `email` | `string` | |
| `role_id` | `bigint` | FK to roles |
| `invited_by` | `bigint` | FK to users |
| `token` | `string` | Unique |
| `expires_at` | `timestamp` | |
| `accepted_at` | `timestamp?` | |
| `created_at` | `timestamp` | |

## Configuration

```php
// config/permissions.php
return [
    'teams' => [
        'enabled' => true,

        'roles' => [
            'team_owner',
            'team_admin',
            'team_member',
            'team_guest',
        ],

        'invitations' => [
            'expiry_hours' => 72,
            'max_pending' => 50,
            'allow_existing_users' => true,
        ],

        'ownership' => [
            'allow_transfer' => true,
            'require_transfer_before_leave' => true,
        ],

        'cross_team' => [
            'global_roles_override' => true,
            'allow_resource_transfer' => true,
        ],
    ],
];
```

## Best Practices

1. **Scope roles to teams** — avoid giving global roles for team-specific work
2. **Limit pending invitations** — prevents abuse of the invitation system
3. **Require ownership transfer** — prevents orphaned teams
4. **Audit team membership** quarterly — remove inactive members
5. **Use team_guest for external collaborators** — read-only is safest
6. **Log cross-team access** — important for compliance and debugging
