# Permission System

## Overview

Permissions are the atomic units of authorization in gsmui. Every action in the system maps to one or more permissions. This document covers permission naming, sets, wildcards, and synchronization.

## Permission Naming Convention

Permissions follow a `resource.action` pattern with optional scoping.

### Standard Format

```
{resource}.{action}
```

### Examples

| Permission | Resource | Action |
|------------|----------|--------|
| `posts.create` | posts | create |
| `posts.read` | posts | read |
| `posts.update` | posts | update |
| `posts.delete` | posts | delete |
| `posts.publish` | posts | publish |
| `users.manage` | users | manage |
| `settings.billing.read` | settings.billing | read |
| `comments.moderate` | comments | moderate |

### Action Reference

| Action | CRUD Equivalent | Description |
|--------|-----------------|-------------|
| `create` | C | Create new records |
| `read` | R | View existing records |
| `update` | U | Modify existing records |
| `delete` | D | Remove records |
| `manage` | CRUD | Full CRUD access |
| `publish` | — | Make content publicly visible |
| `moderate` | — | Review and approve content |
| `export` | — | Download or export data |
| `import` | — | Upload or import data |
| `approve` | — | Approve pending items |

## Granular Permissions

```php
// Base permissions
'posts.create',
'posts.read',
'posts.update',
'posts.delete',

// Scoped permissions (own vs any)
'posts.create.own',      // can create own posts only
'posts.create.any',      // can create posts for anyone
'posts.update.own',      // can update own posts only
'posts.update.any',      // can update any post
'posts.delete.own',      // can delete own posts only
'posts.delete.any',      // can delete any post

// Feature-specific
'posts.publish',
'posts.feature',
'posts.sticky',
'posts.draft',
'posts.schedule',
'posts.export',
```

## Permission Sets

Permission sets group related permissions for easier management.

### Defining Sets

```php
// app/Permissions/Sets/ContentPermissions.php
return [
    'set' => 'content',

    'permissions' => [
        'posts.create',
        'posts.read',
        'posts.update',
        'posts.delete',
        'posts.publish',
        'posts.draft',
        'posts.schedule',
        'posts.export',
        'pages.create',
        'pages.read',
        'pages.update',
        'pages.delete',
        'pages.publish',
        'comments.read',
        'comments.moderate',
        'comments.delete',
        'media.upload',
        'media.read',
        'media.delete',
    ],
];
```

### Using Sets

```php
use App\Permissions\PermissionSet;

// Assign all content permissions
$role->attachSet('content');

// Attach specific subset
$role->attachSet('content', except: [
    'posts.delete',
    'posts.export',
]);

// List all permissions in a set
$permissions = PermissionSet::resolve('content');
```

### Built-in Permission Sets

| Set | Permissions | Purpose |
|-----|-------------|---------|
| `content` | posts, pages, comments, media | Content management |
| `users` | users, roles, permissions | User administration |
| `billing` | invoices, subscriptions, payments | Financial operations |
| `settings` | settings, integrations, api | System configuration |
| `analytics` | analytics, reports, exports | Data and reporting |
| `support` | tickets, messages, notifications | Customer support |

## Wildcard Permissions

Wildcards allow matching multiple permissions with a single pattern.

### Syntax

```php
// Match all post permissions
'posts.*'

// Match all CRUD on any resource
'*.create'
'*.read'
'*.update'
'*.delete'

// Match all permissions
'*'

// Match nested resources
'settings.*.*'
```

### Implementation

```php
class WildcardMatcher
{
    public function matches(string $pattern, string $permission): bool
    {
        $patternParts = explode('.', $pattern);
        $permissionParts = explode('.', $permission);

        if (count($patternParts) !== count($permissionParts)) {
            return false;
        }

        foreach ($patternParts as $index => $part) {
            if ($part === '*') {
                continue;
            }
            if ($part !== $permissionParts[$index]) {
                return false;
            }
        }

        return true;
    }

    public function expand(string $pattern, array $allPermissions): array
    {
        return array_filter(
            $allPermissions,
            fn ($perm) => $this->matches($pattern, $perm)
        );
    }
}
```

### Wildcard Usage

```php
// Check with wildcard
$user->hasPermission('posts.*'); // true if user has ANY post permission

// Assign with wildcard (expands to all matching)
$role->attachPermissions(['posts.*']); // attaches posts.create, posts.read, etc.

// Deny with wildcard
$role->denyPermission('*.delete'); // denies delete on all resources
```

## Permission Sync

Syncing ensures roles stay consistent with permission definitions.

### Database Sync

```php
class PermissionSyncer
{
    public function sync(): void
    {
        $defined = $this->loadDefinedPermissions();
        $existing = Permission::pluck('name')->toArray();

        // Add new permissions
        $toCreate = array_diff($defined, $existing);
        foreach ($toCreate as $permission) {
            Permission::create([
                'name' => $permission,
                'set' => $this->resolveSet($permission),
            ]);
        }

        // Remove orphaned permissions (optional)
        $toRemove = array_diff($existing, $defined);
        if (config('permissions.auto_remove')) {
            Permission::whereIn('name', $toRemove)->delete();
        }
    }

    protected function loadDefinedPermissions(): array
    {
        $files = glob(app_path('Permissions/Sets/*.php'));
        $permissions = [];

        foreach ($files as $file) {
            $set = require $file;
            $permissions = array_merge($permissions, $set['permissions']);
        }

        return array_unique($permissions);
    }
}
```

### Event-Based Sync

```php
// Listen for permission changes
Event::listen(PermissionChanged::class, function ($event) {
    // Clear all permission caches
    Cache::tags(['permissions'])->flush();

    // Notify affected users
    $users = User::whereHas('roles', function ($q) use ($event) {
        $q->whereHas('permissions', fn ($q) => $q->where('name', $event->permission));
    })->get();

    foreach ($users as $user) {
        broadcast(new UserPermissionsChanged($user));
    }
});
```

## Database Schema

### Permissions Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | Unique permission identifier |
| `display_name` | `string` | Human-readable label |
| `set` | `string` | Permission set grouping |
| `description` | `text?` | Optional description |
| `is_system` | `bool` | System permissions cannot be deleted |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

### Permission Sets Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | Set identifier |
| `display_name` | `string` | Human-readable label |
| `description` | `text?` | |
| `created_at` | `timestamp` | |

## Checking Permissions

```php
// Simple check
$user->hasPermission('posts.create');

// Any of multiple
$user->hasAnyPermission(['posts.create', 'posts.update']);

// All of multiple
$user->hasAllPermissions(['posts.create', 'posts.read']);

// Wildcard check
$user->hasPermission('posts.*');

// With scope
$user->hasPermission('posts.update.own');

// In Blade
@can('posts.create')
    <button>New Post</button>
@endcan

@canany(['posts.create', 'posts.update'])
    <button>Manage Posts</button>
@endcan

// In Livewire
public function mount(): void
{
    abort_unless(
        $this->user->hasPermission('posts.create'),
        403
    );
}
```

## Configuration

```php
// config/permissions.php
return [
    'naming' => [
        'separator' => '.',
        'format' => '{resource}.{action}',
        'case' => 'snake',
    ],

    'wildcards' => [
        'enabled' => true,
        'max_depth' => 4,
    ],

    'sets' => [
        'enabled' => true,
        'auto_register' => true,
    ],

    'sync' => [
        'on_deploy' => true,
        'auto_remove' => false,
    ],
];
```

## Best Practices

1. **Use consistent naming** — `resource.action` format everywhere
2. **Prefer granular over broad** — `posts.update.own` over `posts.manage`
3. **Group with sets** — keeps permission management organized
4. **Use wildcards sparingly** — explicit checks are clearer
5. **Sync on deploy** — run `php artisan permissions:sync` in CI/CD
6. **Version permission changes** — track additions/removals in migrations
