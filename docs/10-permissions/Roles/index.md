# Role Definitions

## Overview

Roles define what users can do. Each role represents a level of authority and responsibility within the system. This document defines the default role set and how to extend it.

## Default Roles

| Role | Description | Hierarchy Level |
|------|-------------|-----------------|
| `super_admin` | Full system access, cannot be removed | 0 |
| `admin` | Organization management, user administration | 1 |
| `creator` | Content creation and publishing | 2 |
| `user` | Standard authenticated user | 3 |
| `viewer` | Read-only access | 4 |

### Role Properties

```php
return [
    'super_admin' => [
        'display_name' => 'Super Administrator',
        'description'  => 'Full system access with all permissions',
        'is_system'    => true,
        'is_deletable' => false,
        'is_default'   => false,
        'color'        => '#ef4444',
        'icon'         => 'shield-check',
    ],
    'admin' => [
        'display_name' => 'Administrator',
        'description'  => 'Manage organization settings and users',
        'is_system'    => true,
        'is_deletable' => false,
        'is_default'   => false,
        'color'        => '#f97316',
        'icon'         => 'cog-6-tooth',
    ],
    'creator' => [
        'display_name' => 'Creator',
        'description'  => 'Create and publish content',
        'is_system'    => true,
        'is_deletable' => true,
        'is_default'   => true,
        'color'        => '#8b5cf6',
        'icon'         => 'pencil-square',
    ],
    'user' => [
        'display_name' => 'User',
        'description'  => 'Standard authenticated user',
        'is_system'    => true,
        'is_deletable' => true,
        'is_default'   => true,
        'color'        => '#3b82f6',
        'icon'         => 'user',
    ],
    'viewer' => [
        'display_name' => 'Viewer',
        'description'  => 'Read-only access to content',
        'is_system'    => true,
        'is_deletable' => true,
        'is_default'   => true,
        'color'        => '#6b7280',
        'icon'         => 'eye',
    ],
];
```

## Role Permissions Matrix

| Permission | super_admin | admin | creator | user | viewer |
|------------|:-----------:|:-----:|:-------:|:----:|:------:|
| `users.create` | ✅ | ✅ | ❌ | ❌ | ❌ |
| `users.read` | ✅ | ✅ | ❌ | ❌ | ❌ |
| `users.update` | ✅ | ✅ | ❌ | ❌ | ❌ |
| `users.delete` | ✅ | ❌ | ❌ | ❌ | ❌ |
| `roles.manage` | ✅ | ❌ | ❌ | ❌ | ❌ |
| `posts.create` | ✅ | ✅ | ✅ | ❌ | ❌ |
| `posts.read` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `posts.update` | ✅ | ✅ | ✅ | ❌ | ❌ |
| `posts.delete` | ✅ | ✅ | ❌ | ❌ | ❌ |
| `posts.publish` | ✅ | ✅ | ✅ | ❌ | ❌ |
| `settings.manage` | ✅ | ✅ | ❌ | ❌ | ❌ |
| `billing.manage` | ✅ | ✅ | ❌ | ❌ | ❌ |
| `api.access` | ✅ | ✅ | ✅ | ✅ | ❌ |

## Team Roles

Team roles are scoped to a specific team within an organization.

| Team Role | Inherits From | Scope |
|-----------|---------------|-------|
| `team_owner` | `admin` | Full team control |
| `team_admin` | `admin` | Team settings, member management |
| `team_member` | `user` | Standard team participation |
| `team_guest` | `viewer` | Read-only team access |

### Team Role Assignment

```php
use App\Models\Team;
use App\Models\User;

$team = Team::find(1);

// Assign team role
$team->addMember($user, role: 'team_member');

// Promote to team admin
$team->promoteMember($user, to: 'team_admin');

// Check team role
$user->hasTeamRole($team, 'team_admin'); // true/false

// List all team roles for a user
$user->teamRoles($team); // Collection of Role models
```

### Team Role Database Schema

| Column | Type | Description |
|--------|------|-------------|
| `team_id` | `bigint` | FK to teams |
| `user_id` | `bigint` | FK to users |
| `role_id` | `bigint` | FK to roles |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Custom Roles

Organizations can create custom roles beyond the defaults.

### Creating a Custom Role

```php
use App\Models\Role;

$role = Role::create([
    'name'         => 'moderator',
    'display_name' => 'Moderator',
    'description'  => 'Can moderate comments and reports',
    'parent_id'    => Role::where('name', 'creator')->id(),
    'is_system'    => false,
    'is_deletable' => true,
    'color'        => '#10b981',
    'icon'         => 'flag',
]);

// Attach permissions
$role->attachPermissions([
    'comments.moderate',
    'reports.view',
    'users.warn',
]);
```

### Custom Role Constraints

| Constraint | Value | Rationale |
|------------|-------|-----------|
| Max custom roles | 50 | Prevent role explosion |
| Max role name length | 64 chars | Database constraint |
| Role name format | `^[a-z_]+$` | Alphanumeric + underscores |
| Cannot parent to system role | Configurable | Prevent privilege escalation |
| Cannot exceed parent permissions | Enforced | RBAC integrity |

### Custom Role Validation

```php
use Illuminate\Validation\Rule;

class CreateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:64',
                'regex:/^[a-z_]+$/',
                Rule::unique('roles', 'name'),
            ],
            'parent_id' => [
                'nullable',
                'exists:roles,id',
                function ($attribute, $value, $fail) {
                    $parent = Role::find($value);
                    if ($parent && $parent->is_system) {
                        $fail('Cannot assign a system role as parent.');
                    }
                },
            ],
            'permissions' => [
                'required',
                'array',
                'min:1',
            ],
            'permissions.*' => [
                'exists:permissions,name',
            ],
        ];
    }
}
```

## Role Lifecycle

### States

```
┌──────────┐     activate     ┌──────────┐
│ Created  │ ──────────────► │ Active   │
└──────────┘                  └──────────┘
                                  │
                              suspend
                                  │
                                  ▼
                            ┌──────────┐     reactivate   ┌──────────┐
                            │ Suspended│ ────────────────► │ Active   │
                            └──────────┘                   └──────────┘
                                  │
                              archive
                                  │
                                  ▼
                            ┌──────────┐
                            │ Archived │
                            └──────────┘
```

### Lifecycle Methods

```php
class Role extends Model
{
    public function activate(): void
    {
        $this->update(['status' => 'active']);
        $this->event(new RoleActivated($this));
    }

    public function suspend(): void
    {
        $this->update(['status' => 'suspended']);
        // Remove from all users
        $this->users()->detach();
        $this->event(new RoleSuspended($this));
    }

    public function archive(): void
    {
        $this->update(['status' => 'archived', 'archived_at' => now()]);
        $this->event(new RoleArchived($this));
    }
}
```

## RBAC Configuration

```php
// config/permissions.php
return [
    'hierarchy' => require base_path('app/Permissions/RoleHierarchy.php'),

    'system_roles' => ['super_admin', 'admin', 'creator', 'user', 'viewer'],

    'defaults' => [
        'role' => 'viewer',          // role assigned on registration
        'team_role' => 'team_member', // default team role
    ],

    'custom_roles' => [
        'enabled' => true,
        'max_count' => 50,
        'allowed_parents' => ['admin', 'creator'],
    ],

    'cache' => [
        'ttl' => 900, // 15 minutes
        'prefix' => 'gsmui:roles:',
    ],
];
```

## Best Practices

1. **Use system roles** for consistent baseline permissions across deployments
2. **Scope team roles** — don't give global permissions for team-specific work
3. **Prevent role explosion** — if you need >10 custom roles, revisit your permission model
4. **Audit custom roles** monthly to remove stale or unused roles
5. **Document custom roles** with clear descriptions and permission boundaries
6. **Default new users to least-privilege roles** (viewer or user)
