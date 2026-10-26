# Role-Based Access Control (RBAC)

## Overview

Role-Based Access Control (RBAC) is the core authorization model in gsmui. Users are assigned roles, and roles carry permissions. Users inherit permissions through their roles, never directly.

## Core Concepts

| Concept | Description |
|---------|-------------|
| **Role** | A named collection of permissions (e.g., `admin`, `editor`) |
| **Permission** | A granular ability (e.g., `posts.create`, `users.delete`) |
| **Role Hierarchy** | Parent-child relationships between roles |
| **Inheritance** | Child roles automatically receive parent permissions |
| **Assignment** | Linking a user to one or more roles |

## Role Hierarchy

Roles form a tree. A child role inherits all permissions from its parent.

```
Super Admin
├── Admin
│   ├── Editor
│   │   └── Author
│   │       └── Contributor
│   └── Manager
│       └── Team Lead
└── Viewer
```

### Defining Hierarchies

```php
// app/Permissions/RoleHierarchy.php
return [
    'super_admin' => [],       // root — no parent
    'admin'       => ['super_admin'],
    'editor'      => ['admin'],
    'author'      => ['editor'],
    'contributor' => ['author'],
    'manager'     => ['admin'],
    'team_lead'   => ['manager'],
    'viewer'      => [],       // root — standalone
];
```

### Resolving Inherited Permissions

```php
use App\Models\User;
use App\Permissions\RoleHierarchy;

class PermissionResolver
{
    public function resolve(User $user): array
    {
        $roles = $user->roles->pluck('name')->toArray();
        $permissions = [];

        foreach ($roles as $role) {
            $permissions = array_merge(
                $permissions,
                $this->getInheritedPermissions($role)
            );
        }

        return array_unique($permissions);
    }

    protected function getInheritedPermissions(string $role): array
    {
        $hierarchy = config('permissions.hierarchy');
        $permissions = $this->directPermissions($role);

        if (isset($hierarchy[$role])) {
            foreach ($hierarchy[$role] as $parent) {
                $permissions = array_merge(
                    $permissions,
                    $this->getInheritedPermissions($parent)
                );
            }
        }

        return $permissions;
    }
}
```

## Permission Inheritance Rules

| Rule | Behavior |
|------|----------|
| Additive | Permissions accumulate up the hierarchy |
| No revocation | A child cannot remove a parent's permission |
| Conflict resolution | If two roles conflict, the **least restrictive** wins |
| Explicit deny | A direct `deny` on any role always wins over inherited `allow` |

### Conflict Resolution Example

```php
class PermissionMerger
{
    public function merge(array $permissionSets): string
    {
        // Collect all values for a given permission key
        $values = array_filter($permissionSets);

        if (in_array('deny', $values)) {
            return 'deny';
        }

        return in_array('allow', $values) ? 'allow' : 'none';
    }
}
```

## RBAC vs ACL

| Aspect | RBAC | ACL |
|--------|------|-----|
| Authorization basis | Role membership | Per-resource access lists |
| Scalability | Excellent — O(roles) | Poor — O(users × resources) |
| Management | Central role definitions | Distributed per-resource entries |
| Auditability | High — role assignments are clear | Low — scattered ACL entries |
| Use case | Organization-wide policies | Fine-grained resource control |

### Combining RBAC and ACL

```php
class AuthorizationService
{
    public function allows(User $user, string $permission, $resource = null): bool
    {
        // 1. Check RBAC first
        if ($this->rbac->hasPermission($user, $permission)) {
            return true;
        }

        // 2. Fall back to ACL for resource-specific checks
        if ($resource && $this->acl->allows($user, $permission, $resource)) {
            return true;
        }

        return false;
    }
}
```

## Database Schema

### Roles Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | Unique role identifier |
| `display_name` | `string` | Human-readable label |
| `parent_id` | `bigint?` | FK to parent role |
| `hierarchy_level` | `int` | Depth in tree (0 = root) |
| `is_system` | `bool` | System roles cannot be deleted |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

### Role-Permission Pivot

| Column | Type | Description |
|--------|------|-------------|
| `role_id` | `bigint` | FK to roles |
| `permission_id` | `bigint` | FK to permissions |
| `access` | `enum` | `allow` / `deny` |

### User-Role Pivot

| Column | Type | Description |
|--------|------|-------------|
| `user_id` | `bigint` | FK to users |
| `role_id` | `bigint` | FK to roles |
| `team_id` | `bigint?` | FK to teams (null = global) |
| `assigned_at` | `timestamp` | |

## Implementation

### Assigning Roles

```php
use App\Models\User;

$user->assignRole('editor');

// Multiple roles
$user->assignRoles(['editor', 'manager']);

// Role scoped to a team
$user->assignRole('admin', team: $team);
```

### Checking Permissions

```php
// In controllers
if ($user->hasPermission('posts.create')) {
    // allow
}

// In Blade
@can('posts.create')
    <button>New Post</button>
@endcan

// With resource
@can('update', $post)
    <button>Edit</button>
@endcan
```

### Middleware Protection

```php
Route::middleware(['permission:posts.manage'])->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});
```

## Caching

RBAC data is cached per-user to avoid repeated database queries.

```php
class CachedPermissionResolver extends PermissionResolver
{
    public function resolve(User $user): array
    {
        return Cache::remember(
            "user:{$user->id}:permissions",
            now()->addMinutes(15),
            fn () => parent::resolve($user)
        );
    }

    public function invalidate(User $user): void
    {
        Cache::forget("user:{$user->id}:permissions");
    }
}
```

### Cache Invalidation Events

| Event | When | Cache cleared |
|-------|------|---------------|
| `RoleAssigned` | User gets a new role | `user:{id}:permissions` |
| `RoleRevoked` | User loses a role | `user:{id}:permissions` |
| `PermissionChanged` | Role permissions modified | All users with that role |
| `HierarchyChanged` | Role parent changes | All descendant roles |

## Best Practices

1. **Never assign permissions directly to users** — always through roles
2. **Keep role count low** — if you have >15 roles, reconsider your hierarchy
3. **Use system roles** for built-in roles that must exist
4. **Audit role assignments** quarterly
5. **Prefer `hasAnyRole()` over multiple `hasRole()` calls** for readability
6. **Scope roles to teams** when multi-tenancy is required
