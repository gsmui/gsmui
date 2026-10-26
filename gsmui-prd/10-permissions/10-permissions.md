For **GsmUi**, **10-permissions.md** should define the **complete Authorization & RBAC (Role-Based Access Control)** architecture rather than just a list of permissions.

Given your platform (Marketplace, Themes, Components, Templates, Documentation, Blog, Playground, Billing, AI, MCP, Admin, User Dashboard), this specification would be **300–500 pages** if fully detailed. It should be organized into implementation-ready documents instead of one massive file.

## Document Index

All documents below are implementation-ready specifications for the GsmUi authorization system.

### Foundation

| Document | Title | Scope |
| --- | --- | --- |
| [10.01-overview.md](./10.01-overview.md) | Permissions Overview | Master overview — tech stack, design principles, role hierarchy, naming standard |
| [10.02-rbac-architecture.md](./10.02-rbac-architecture.md) | RBAC Architecture | Technical architecture of roles, permissions, policies, gates, caching, team scoping |
| [10.03-roles.md](./10.03-roles.md) | Roles | All 9 roles, hierarchy, inheritance, and assignment rules |
| [10.04-permission-groups.md](./10.04-permission-groups.md) | Permission Groups | 20 permission groups, ~85 permissions by domain |
| [10.05-policies.md](./10.05-policies.md) | Policies | 17 per-model policy classes with ownership and role enforcement |
| [10.06-gates.md](./10.06-gates.md) | Gates | Ad-hoc authorization gates for non-resource operations |

### Role-Specific Permissions

| Document | Title | Scope |
| --- | --- | --- |
| [10.07-admin-permissions.md](./10.07-admin-permissions.md) | Admin Permissions | Admin vs Super Admin permission matrix |
| [10.08-user-permissions.md](./10.08-user-permissions.md) | User Permissions | User vs Pro User permission matrix |
| [10.09-creator-permissions.md](./10.09-creator-permissions.md) | Creator Permissions | Creator content creation, marketplace selling, approval workflow |

### Domain-Specific Permissions

| Document | Title | Scope |
| --- | --- | --- |
| [10.10-marketplace-permissions.md](./10.10-marketplace-permissions.md) | Marketplace Permissions | Browse, purchase, sell, refund, listing approval flows |
| [10.11-theme-permissions.md](./10.11-theme-permissions.md) | Theme Permissions | Theme lifecycle, publishing, featuring, export |
| [10.12-component-permissions.md](./10.12-component-permissions.md) | Component Permissions | Component creation, bundling, forking |
| [10.13-template-permissions.md](./10.13-template-permissions.md) | Template Permissions | Template installation, licensing, cloning |
| [10.14-blog-permissions.md](./10.14-blog-permissions.md) | Blog Permissions | Authoring, moderation, comments, publishing |
| [10.15-documentation-permissions.md](./10.15-documentation-permissions.md) | Documentation Permissions | Docs versioning, publishing, reordering |
| [10.16-playground-permissions.md](./10.16-playground-permissions.md) | Playground Permissions | Sandbox execution limits by role |
| [10.17-billing-permissions.md](./10.17-billing-permissions.md) | Billing Permissions | Subscriptions, invoices, refunds |
| [10.18-api-permissions.md](./10.18-api-permissions.md) | API Permissions | Sanctum token scoping, rate limits |
| [10.19-mcp-permissions.md](./10.19-mcp-permissions.md) | MCP Permissions | MCP server configuration, execution, security |

### Advanced Authorization

| Document | Title | Scope |
| --- | --- | --- |
| [10.20-team-permissions.md](./10.20-team-permissions.md) | Team Permissions | Team roles, scoped resources, invitations |
| [10.21-enterprise-permissions.md](./10.21-enterprise-permissions.md) | Enterprise Permissions | Org permissions, delegated admin, temporary permissions |
| [10.22-dynamic-permissions.md](./10.22-dynamic-permissions.md) | Dynamic Permissions | Runtime permission/role creation, versioning |
| [10.23-feature-flags.md](./10.23-feature-flags.md) | Feature Flags | Subscription/role/experimental flags, RBAC integration |
| [10.24-audit-logging.md](./10.24-audit-logging.md) | Audit Logging | Spatie Activity Log, retention, compliance |
| [10.25-permission-matrix.md](./10.25-permission-matrix.md) | Permission Matrix | Complete role × permission reference across all domains |

## Technology Stack

The authorization system should be built with:

| Layer              | Technology          |
| ------------------ | ------------------- |
| Authentication     | Laravel Fortify     |
| API Authentication | Laravel Sanctum     |
| RBAC               | Spatie Permission   |
| Authorization      | Laravel Policies    |
| Gates              | Laravel Gates       |
| Activity Logs      | Spatie Activity Log |

## Permission Architecture

```text
User

↓

Roles

↓

Permissions

↓

Policies

↓

Services

↓

Repositories

↓

Business Rules
```

Controllers should never contain complex authorization logic.

---

# Default Roles

```text
Guest

↓

User

↓

Pro User

↓

Creator

↓

Moderator

↓

Support

↓

Editor

↓

Admin

↓

Super Admin
```

Future:

* Team Owner
* Team Member
* Enterprise Admin
* Organization Owner

---

# Permission Naming Standard

Use a consistent resource.action format:

```text
users.view
users.create
users.update
users.delete

themes.view
themes.create
themes.publish
themes.delete

components.view
components.create
components.publish

templates.install

marketplace.purchase

billing.manage

admin.access
```

Avoid vague names like:

```text
manage_everything
edit
access
```

---

# Permission Groups

The system should organize permissions by domain:

* Users
* Roles
* Permissions
* Components
* Themes
* Templates
* Marketplace
* Orders
* Licenses
* Billing
* Documentation
* Blog
* CMS
* Playground
* AI
* MCP
* Analytics
* Notifications
* Settings
* System

---

# Authorization Flow

```text
Authenticated User

↓

Resolve Roles

↓

Resolve Permissions

↓

Policy

↓

Business Service

↓

Database
```

---

# Example Permission Matrix

| Permission           | User | Creator | Admin |
| -------------------- | :--: | :-----: | :---: |
| themes.view          |   ✅  |    ✅    |   ✅   |
| themes.create        |   ❌  |    ✅    |   ✅   |
| themes.publish       |   ❌  |   Own   |   ✅   |
| themes.delete        |   ❌  |   Own   |   ✅   |
| marketplace.purchase |   ✅  |    ✅    |   ✅   |
| users.manage         |   ❌  |    ❌    |   ✅   |
| settings.manage      |   ❌  |    ❌    |   ✅   |

"Own" indicates access only to resources owned by the authenticated user.

---

# Policy Examples

Each aggregate root should have a dedicated policy:

```text
UserPolicy

ThemePolicy

ComponentPolicy

TemplatePolicy

MarketplaceProductPolicy

OrderPolicy

SubscriptionPolicy

BlogPostPolicy

DocumentationPolicy

PlaygroundPolicy
```

Policies should enforce ownership, role checks, and business constraints.

---

# Future Enterprise Features

The design should accommodate:

* Team-scoped permissions
* Organization-scoped permissions
* Delegated administration
* Resource sharing
* Temporary permissions
* Permission inheritance
* Feature-flag-based authorization
* License-based feature access

---

## Recommended implementation order

1. **10.01-overview.md**
2. **10.02-rbac-architecture.md**
3. **10.03-roles.md**
4. **10.04-permission-groups.md**
5. **10.05-policies.md**
6. **10.06-gates.md**
7. Domain-specific permission documents
8. **10.25-permission-matrix.md**

This structure produces a comprehensive, enterprise-ready authorization specification for GsmUi that integrates cleanly with Laravel 13, Fortify, Sanctum, and Spatie Permission while remaining scalable for future team and enterprise capabilities.

---

## Permission Lifecycle

### Permission Creation Workflow

Every permission in GsmUi must follow a standardized creation workflow to ensure consistency, auditability, and proper access control. The lifecycle of a permission begins with identification of a capability need and ends with full production deployment and monitoring.

**Stage 1: Identification**
A new permission is identified when a feature requires access control that is not covered by existing permissions. The requesting team documents the capability, the actors who need access, and the resources affected. All requests are logged in the permission request tracker with a unique identifier.

**Stage 2: Review and Approval**
The permission is reviewed by the authorization architecture team. The review checks for naming convention compliance (`resource.action` format), uniqueness against existing permissions, proper domain grouping, and alignment with the role hierarchy. Permissions that duplicate existing functionality are rejected or merged.

**Stage 3: Definition**
Once approved, the permission is formally defined with its name, description, domain group, default role assignments, and any conditional logic. The definition includes which policies and gates will enforce the permission and what audit logging is required.

**Stage 4: Implementation**
The permission is added to the Spatie Permission seeder, added to the permission matrix, enforced via policies and gates, and covered by automated tests. Code review requires at least two approvals from the authorization team.

**Stage 5: Deployment**
The permission is deployed with the feature it controls. Database migrations seed the permission into the system. Role assignments are updated as needed. Monitoring is set up to track permission usage and denial rates.

**Stage 6: Monitoring**
Post-deployment, the permission is monitored for usage patterns, unusual denial rates, and performance impact. Permissions with consistently low usage are flagged for potential consolidation.

### Permission Retirement Workflow

Permissions that are no longer needed follow a retirement workflow:

1. **Flag for deprecation**: Add `@deprecated` annotation with replacement permission or reason for removal
2. **Emit warnings**: In development environments, log deprecation warnings when the permission is checked
3. **Update policy/gate**: Maintain enforcement but log usage for migration tracking
4. **Migrate users**: Move all users from the deprecated permission to its replacement
5. **Remove enforcement**: Remove policy/gate checks for the deprecated permission
6. **Remove from seeder**: Remove from permission seeder and database
7. **Update matrix**: Remove from permission matrix documentation

This lifecycle ensures that no permission is removed without a complete migration path and that no user loses access unintentionally.

---

## Permission Inheritance Rules

### Role Hierarchy Inheritance

The role hierarchy defines a strict linear inheritance chain. Each role inherits all permissions from every role below it in the hierarchy:

```text
Guest (0 permissions)
  ↓ inherits nothing
User (5 base permissions: profile, dashboard, own-data)
  ↓ inherits all User permissions
Pro User (12 permissions: adds subscription, premium content)
  ↓ inherits all Pro User permissions
Creator (25 permissions: adds publishing, marketplace selling)
  ↓ inherits all Creator permissions
Moderator (35 permissions: adds content moderation, review management)
  ↓ inherits all Moderator permissions
Support (45 permissions: adds order management, customer support)
  ↓ inherits all Support permissions
Editor (55 permissions: adds content creation, CMS management)
  ↓ inherits all Editor permissions
Admin (75 permissions: adds full platform administration)
  ↓ inherits all Admin permissions
Super Admin (90 permissions: adds system-level administration)
```

### Permission Inheritance Implementation

```php
// app/Services/PermissionInheritanceResolver.php

namespace App\Services\Permissions;

use App\Models\User;
use Spatie\Permission\Models\Role;

class PermissionInheritanceResolver
{
    private const HIERARCHY = [
        'guest'       => 0,
        'user'        => 1,
        'pro_user'    => 2,
        'creator'     => 3,
        'moderator'   => 4,
        'support'     => 5,
        'editor'      => 6,
        'admin'       => 7,
        'super_admin' => 8,
    ];

    public function getInheritedPermissions(User $user): array
    {
        $roleLevel = $this->getRoleLevel($user);
        $permissions = [];

        foreach (self::HIERARCHY as $role => $level) {
            if ($level <= $roleLevel) {
                $rolePermissions = Role::where('name', $role)
                    ->first()?->permissions
                    ->pluck('name')
                    ->toArray() ?? [];
                $permissions = array_merge($permissions, $rolePermissions);
            }
        }

        return array_unique($permissions);
    }

    public function getRoleLevel(User $user): int
    {
        $highestLevel = 0;

        foreach ($user->roles as $role) {
            $level = self::HIERARCHY[$role->name] ?? 0;
            $highestLevel = max($highestLevel, $level);
        }

        return $highestLevel;
    }

    public function hasPermissionThroughInheritance(User $user, string $permission): bool
    {
        // Direct permission check first
        if ($user->hasPermissionTo($permission)) {
            return true;
        }

        // Inherited permission check
        $inheritedPermissions = $this->getInheritedPermissions($user);
        return in_array($permission, $inheritedPermissions);
    }
}
```

### Custom Role Inheritance

For enterprise scenarios, custom roles may define their own inheritance relationships beyond the standard hierarchy:

```php
// Custom role with explicit parent
$role = Role::create(['name' => 'team_lead']);
$role->setPermissionClass('App\Models\Permission');
$role->givePermissionTo(['team.manage', 'team.invite']);

// Define inheritance from parent roles
$role->inherits('member');
$role->inherits('content_creator');
```

### Conditional Inheritance

Some permissions may only be inherited under specific conditions:

```php
class ConditionalInheritanceResolver
{
    public function resolveConditionalPermissions(User $user, string $context): array
    {
        $basePermissions = $this->getInheritedPermissions($user);
        $conditionalPermissions = [];

        // Creator selling permissions only apply when in marketplace context
        if ($context === 'marketplace' && $user->hasRole('creator')) {
            $conditionalPermissions[] = 'marketplace.sell';
            $conditionalPermissions[] = 'marketplace.manage_own';
            $conditionalPermissions[] = 'marketplace.set_pricing';
        }

        // Support permissions only apply in support context
        if ($context === 'support' && $user->hasRole('support')) {
            $conditionalPermissions[] = 'orders.manage';
            $conditionalPermissions[] = 'orders.refund';
            $conditionalPermissions[] = 'users.view_all';
        }

        return array_unique(array_merge($basePermissions, $conditionalPermissions));
    }
}
```

---

## Permission Caching Strategy

### Cache Architecture

Permission caching is critical for performance since every request may involve multiple permission checks. GsmUi implements a multi-layer caching strategy:

**Layer 1: User Permission Cache**
Stores the complete set of permissions for a user. Invalidated when the user's roles or direct permissions change.

```php
// Cache key pattern: permissions:user:{user_id}
// TTL: 300 seconds (5 minutes)
// Store: Redis sorted set for O(1) membership checks
```

**Layer 2: Role Permission Cache**
Stores the permissions assigned to each role. Invalidated when role permissions change.

```php
// Cache key pattern: permissions:role:{role_name}
// TTL: 600 seconds (10 minutes)
// Store: Redis set
```

**Layer 3: Policy Decision Cache**
Caches the result of policy evaluations for specific user+resource combinations. Useful for repeated access to the same resource.

```php
// Cache key pattern: policy:{user_id}:{resource_type}:{resource_id}:{action}
// TTL: 60 seconds (1 minute)
// Store: Redis string with JSON value
```

**Layer 4: Query Cache**
Caches database queries that resolve permissions, such as "can this user edit this listing?" which may join multiple tables.

```php
// Cache key pattern: permission_query:{hash_of_query_params}
// TTL: 120 seconds (2 minutes)
// Store: Redis string with serialized result
```

### Cache Invalidation

Cache invalidation is the most critical aspect of permission caching. Incorrect invalidation can lead to either stale permissions (security risk) or excessive cache misses (performance risk).

```php
class PermissionCacheInvalidator
{
    public function invalidateForUser(User $user): void
    {
        // Clear user permission cache
        Cache::forget("permissions:user:{$user->id}");

        // Clear all policy decision caches for this user
        $pattern = "policy:{$user->id}:*";
        $keys = Redis::keys($pattern);
        if (!empty($keys)) {
            Redis::del($keys);
        }

        // Clear any conditional permission caches
        $conditionalPattern = "conditional:{$user->id}:*";
        $conditionalKeys = Redis::keys($conditionalPattern);
        if (!empty($conditionalKeys)) {
            Redis::del($conditionalKeys);
        }
    }

    public function invalidateForRole(string $roleName): void
    {
        // Clear role permission cache
        Cache::forget("permissions:role:{$roleName}");

        // Find all users with this role and clear their caches
        $users = User::role($roleName)->get();
        foreach ($users as $user) {
            $this->invalidateForUser($user);
        }
    }

    public function invalidateForResource(string $resourceType, $resourceId): void
    {
        // Clear all policy caches for this specific resource
        $pattern = "policy:*:{$resourceType}:{$resourceId}:*";
        $keys = Redis::keys($pattern);
        if (!empty($keys)) {
            Redis::del($keys);
        }
    }

    public function invalidateAll(): void
    {
        // Nuclear option: clear everything
        Cache::tags(['permissions', 'policies'])->flush();
    }
}
```

### Cache Warm-Up

For high-traffic scenarios, cache warm-up can prevent cold-start performance issues:

```php
class PermissionCacheWarmer
{
    public function warmUp(): void
    {
        // Warm up role permissions
        $roles = Role::with('permissions')->get();
        foreach ($roles as $role) {
            Cache::put(
                "permissions:role:{$role->name}",
                $role->permissions->pluck('name')->toArray(),
                600
            );
        }

        // Warm up active user permissions (last 24 hours)
        $activeUsers = User::where('last_active_at', '>=', now()->subDay())
            ->with('roles.permissions')
            ->get();

        foreach ($activeUsers as $user) {
            $permissions = $user->roles->flatMap(fn($role) => $role->permissions)->pluck('name')->unique()->toArray();
            Cache::put("permissions:user:{$user->id}", $permissions, 300);
        }
    }
}
```

---

## Multi-Tenant Permission Isolation

### Tenant Context

When GsmUi is deployed in a multi-tenant configuration (e.g., enterprise customers with isolated data), permissions must be scoped to the tenant context:

```php
class TenantPermissionResolver
{
    public function resolvePermissions(User $user, ?Tenant $tenant): array
    {
        // Global permissions (not tenant-scoped)
        $globalPermissions = $user->roles
            ->flatMap(fn($role) => $role->permissions)
            ->filter(fn($perm) => !$perm->is_tenant_scoped)
            ->pluck('name')
            ->toArray();

        if (!$tenant) {
            return $globalPermissions;
        }

        // Tenant-scoped permissions
        $tenantPermissions = $user->tenantRoles($tenant)
            ->flatMap(fn($role) => $role->permissions)
            ->filter(fn($perm) => $perm->is_tenant_scoped)
            ->pluck('name')
            ->toArray();

        return array_unique(array_merge($globalPermissions, $tenantPermissions));
    }
}
```

### Tenant Isolation Middleware

```php
class EnsureTenantIsolation
{
    public function handle(Request $request, Closure $next)
    {
        $tenant = $request->route('tenant');

        if ($tenant && !$this->userBelongsToTenant($request->user(), $tenant)) {
            abort(403, 'You do not have access to this tenant.');
        }

        // Set tenant context for permission resolution
        app(TenantPermissionResolver::class)
            ->setTenantContext($tenant);

        return $next($request);
    }

    protected function userBelongsToTenant(User $user, Tenant $tenant): bool
    {
        return $user->tenants()->where('tenants.id', $tenant->id)->exists();
    }
}
```

### Cross-Tenant Access Rules

| Scenario | Rule | Implementation |
|----------|------|----------------|
| User in Tenant A accesses Tenant B resource | Denied | Tenant middleware blocks |
| Admin needs cross-tenant access | Allowed with `admin.access_all_tenants` | Global permission override |
| Support needs limited cross-tenant access | Allowed for assigned tenants | `support.cross_tenant_limited` |
| API token with cross-tenant scope | Allowed if token has tenant scope | Token scope validation |

---

## Permission Testing Framework

### Unit Testing Permissions

```php
// tests/Unit/Permissions/PermissionResolutionTest.php

namespace Tests\Unit\Permissions;

use Tests\TestCase;
use App\Models\User;
use App\Services\Permissions\PermissionInheritanceResolver;

class PermissionResolutionTest extends TestCase
{
    private PermissionInheritanceResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = app(PermissionInheritanceResolver::class);
    }

    public function test_guest_has_no_permissions(): void
    {
        $guest = User::factory()->create();
        $guest->assignRole('guest');

        $permissions = $this->resolver->getInheritedPermissions($guest);
        $this->assertEmpty($permissions);
    }

    public function test_user_inherits_from_user_role(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $user->givePermissionTo('profile.view');

        $this->assertTrue(
            $this->resolver->hasPermissionThroughInheritance($user, 'profile.view')
        );
    }

    public function test_creator_inherits_user_permissions(): void
    {
        $creator = User::factory()->create();
        $creator->assignRole('creator');

        // Creator should inherit user-level permissions
        $this->assertTrue(
            $this->resolver->hasPermissionThroughInheritance($creator, 'profile.view')
        );
    }

    public function test_admin_inherits_all_lower_role_permissions(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->assertTrue(
            $this->resolver->hasPermissionThroughInheritance($admin, 'marketplace.purchase')
        );
        $this->assertTrue(
            $this->resolver->hasPermissionThroughInheritance($admin, 'themes.create')
        );
    }

    public function test_role_level_calculation(): void
    {
        $user = User::factory()->create();
        $user->assignRole('creator');

        $this->assertEquals(3, $this->resolver->getRoleLevel($user));
    }
}
```

### Integration Testing

```php
// tests/Feature/Permissions/MarketplaceAuthorizationTest.php

namespace Tests\Feature\Permissions;

use Tests\TestCase;
use App\Models\User;
use App\Models\MarketplaceListing;

class MarketplaceAuthorizationTest extends TestCase
{
    public function test_unauthenticated_user_can_browse(): void
    {
        $listing = MarketplaceListing::factory()->published()->create();

        $this->get('/marketplace')
            ->assertOk();
    }

    public function test_authenticated_user_can_purchase(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $user->givePermissionTo('marketplace.purchase');

        $listing = MarketplaceListing::factory()->published()->create(['price' => 29.99]);

        $this->actingAs($user)
            ->post('/marketplace/purchase', ['listing_id' => $listing->id])
            ->assertRedirect();
    }

    public function test_creator_cannot_purchase_own_listing(): void
    {
        $creator = User::factory()->create();
        $creator->assignRole('creator');

        $listing = MarketplaceListing::factory()->published()
            ->create(['user_id' => $creator->id]);

        $this->actingAs($creator)
            ->post('/marketplace/purchase', ['listing_id' => $listing->id])
            ->assertForbidden();
    }

    public function test_admin_can_feature_listing(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $listing = MarketplaceListing::factory()->published()->create();

        $this->actingAs($admin)
            ->post("/admin/marketplace/listings/{$listing->id}/feature")
            ->assertOk();
    }

    public function test_support_can_process_refund(): void
    {
        $support = User::factory()->create();
        $support->assignRole('support');

        $order = \App\Models\Order::factory()->completed()->create();

        $this->actingAs($support)
            ->post("/admin/marketplace/orders/{$order->id}/refund", ['amount' => 29.99])
            ->assertOk();
    }
}
```

### Authorization Testing Utilities

```php
// tests/AuthorizationTestHelper.php

trait AuthorizationTestHelper
{
    protected function assertUserCan(User $user, string $permission, $resource = null): void
    {
        if ($resource) {
            $this->assertTrue(
                $user->can($permission, $resource),
                "Expected user [{$user->id}] to have permission [{$permission}] on [{$resource}]"
            );
        } else {
            $this->assertTrue(
                $user->hasPermissionTo($permission),
                "Expected user [{$user->id}] to have permission [{$permission}]"
            );
        }
    }

    protected function assertUserCannot(User $user, string $permission, $resource = null): void
    {
        if ($resource) {
            $this->assertFalse(
                $user->can($permission, $resource),
                "Expected user [{$user->id}] NOT to have permission [{$permission}] on [{$resource}]"
            );
        } else {
            $this->assertFalse(
                $user->hasPermissionTo($permission),
                "Expected user [{$user->id}] NOT to have permission [{$permission}]"
            );
        }
    }

    protected function assertRoleHasPermission(string $role, string $permission): void
    {
        $roleModel = \Spatie\Permission\Models\Role::where('name', $role)->first();
        $this->assertNotNull($roleModel, "Role [{$role}] not found");
        $this->assertTrue(
            $roleModel->hasPermissionTo($permission),
            "Expected role [{$role}] to have permission [{$permission}]"
        );
    }

    protected function assertRoleDoesNotHavePermission(string $role, string $permission): void
    {
        $roleModel = \Spatie\Permission\Models\Role::where('name', $role)->first();
        $this->assertNotNull($roleModel, "Role [{$role}] not found");
        $this->assertFalse(
            $roleModel->hasPermissionTo($permission),
            "Expected role [{$role}] NOT to have permission [{$permission}]"
        );
    }
}
```

---

## Permission Monitoring and Analytics

### Permission Usage Tracking

Track how permissions are used across the platform for security auditing and optimization:

```php
class PermissionUsageTracker
{
    public function recordCheck(string $permission, User $user, bool $result, string $context): void
    {
        DB::table('permission_usage_log')->insert([
            'permission' => $permission,
            'user_id' => $user->id,
            'result' => $result ? 'allowed' : 'denied',
            'context' => $context,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    public function getUsageStats(string $permission, int $days = 30): array
    {
        return DB::table('permission_usage_log')
            ->where('permission', $permission)
            ->where('created_at', '>=', now()->subDays($days))
            ->selectRaw('
                COUNT(*) as total_checks,
                SUM(CASE WHEN result = "allowed" THEN 1 ELSE 0 END) as allowed,
                SUM(CASE WHEN result = "denied" THEN 1 ELSE 0 END) as denied,
                COUNT(DISTINCT user_id) as unique_users
            ')
            ->first();
    }

    public function getDeniedPermissions(int $days = 7): array
    {
        return DB::table('permission_usage_log')
            ->where('result', 'denied')
            ->where('created_at', '>=', now()->subDays($days))
            ->select('permission', DB::raw('COUNT(*) as count'))
            ->groupBy('permission')
            ->orderByDesc('count')
            ->get()
            ->toArray();
    }

    public function getHighFrequencyUsers(int $days = 7, int $threshold = 1000): Collection
    {
        return DB::table('permission_usage_log')
            ->where('created_at', '>=', now()->subDays($days))
            ->select('user_id', DB::raw('COUNT(*) as check_count'))
            ->groupBy('user_id')
            ->having('check_count', '>', $threshold)
            ->orderByDesc('check_count')
            ->get();
    }
}
```

### Permission Audit Dashboard

```php
class PermissionAuditController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_permissions' => Permission::count(),
            'total_roles' => Role::count(),
            'permissions_by_domain' => $this->getPermissionsByDomain(),
            'most_used_permissions' => $this->getMostUsedPermissions(),
            'least_used_permissions' => $this->getLeastUsedPermissions(),
            'denial_rate_by_permission' => $this->getDenialRates(),
            'users_with_most_permissions' => $this->getUsersWithMostPermissions(),
            'roles_with_most_permissions' => $this->getRolesWithMostPermissions(),
        ];

        return view('admin.permissions.audit', compact('stats'));
    }

    protected function getPermissionsByDomain(): array
    {
        return Permission::selectRaw('
            SUBSTRING_INDEX(name, ".", 1) as domain,
            COUNT(*) as count
        ')
        ->groupBy('domain')
        ->orderByDesc('count')
        ->get()
        ->toArray();
    }

    protected function getMostUsedPermissions(): array
    {
        return DB::table('permission_usage_log')
            ->select('permission', DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('permission')
            ->orderByDesc('count')
            ->limit(20)
            ->get()
            ->toArray();
    }

    protected function getDenialRates(): array
    {
        return DB::table('permission_usage_log')
            ->select('permission')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN result = "denied" THEN 1 ELSE 0 END) as denied,
                ROUND(SUM(CASE WHEN result = "denied" THEN 1 ELSE 0 END) / COUNT(*) * 100, 2) as denial_rate
            ')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('permission')
            ->having('total', '>', 100)
            ->orderByDesc('denial_rate')
            ->get()
            ->toArray();
    }
}
```

---

## Security Considerations

### Permission Escalation Prevention

Prevent users from granting themselves higher-level permissions:

```php
class PermissionEscalationGuard
{
    public function preventSelfEscalation(User $actor, User $target, array $permissions): void
    {
        // Prevent users from assigning permissions they don't have
        foreach ($permissions as $permission) {
            if (!$actor->hasPermissionTo($permission)) {
                throw new PermissionEscalationException(
                    "Cannot assign permission [{$permission}] you do not possess."
                );
            }
        }

        // Prevent users from modifying their own role assignments
        if ($actor->id === $target->id && $actor->id !== 1) {
            throw new PermissionEscalationException(
                'Cannot modify your own role assignments.'
            );
        }
    }

    public function preventRoleEscalation(User $actor, User $target, array $roles): void
    {
        $actorLevel = $this->getHighestRoleLevel($actor);

        foreach ($roles as $role) {
            $roleLevel = $this->getRoleLevel($role);
            if ($roleLevel >= $actorLevel) {
                throw new PermissionEscalationException(
                    "Cannot assign role [{$role}] at or above your own level."
                );
            }
        }
    }

    protected function getHighestRoleLevel(User $user): int
    {
        return $user->roles->max(fn($role) => $role->hierarchy_level ?? 0);
    }
}
```

### Permission Boundary Testing

```php
class PermissionBoundaryTest extends TestCase
{
    public function test_user_cannot_escalate_own_permissions(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $this->actingAs($user);
        $this->post('/admin/roles/assign', [
            'user_id' => $user->id,
            'role' => 'admin',
        ])->assertForbidden();
    }

    public function test_creator_cannot_assign_moderator_role(): void
    {
        $creator = User::factory()->create();
        $creator->assignRole('creator');
        $target = User::factory()->create();

        $this->actingAs($creator);
        $this->post("/admin/users/{$target->id}/role", [
            'role' => 'moderator',
        ])->assertForbidden();
    }

    public function test_admin_cannot_promote_to_super_admin(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $target = User::factory()->create();

        $this->actingAs($admin);
        $this->post("/admin/users/{$target->id}/role", [
            'role' => 'super_admin',
        ])->assertForbidden();
    }

    public function test_api_token_cannot_exceed_user_permissions(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $token = $user->createToken('test', ['marketplace.view']);
        $this->withHeader('Authorization', 'Bearer ' . $token->plainTextToken);

        $this->get('/admin/users')->assertForbidden();
    }
}
```

### Rate Limiting on Permission Checks

Prevent abuse of permission-checking endpoints:

```php
class PermissionRateLimiter
{
    private const LIMITS = [
        'permission_check' => [
            'max_per_minute' => 60,
            'max_per_hour' => 1000,
        ],
        'role_assignment' => [
            'max_per_minute' => 5,
            'max_per_hour' => 50,
        ],
        'permission_assignment' => [
            'max_per_minute' => 10,
            'max_per_hour' => 100,
        ],
    ];

    public function attempt(string $action, User $user): bool
    {
        $limits = self::LIMITS[$action] ?? ['max_per_minute' => 30, 'max_per_hour' => 500];

        $minuteKey = "rate_limit:{$action}:{$user->id}:minute";
        $hourKey = "rate_limit:{$action}:{$user->id}:hour";

        $minuteCount = Cache::get($minuteKey, 0);
        $hourCount = Cache::get($hourKey, 0);

        if ($minuteCount >= $limits['max_per_minute']) {
            Log::warning('Permission rate limit exceeded (minute)', [
                'user_id' => $user->id,
                'action' => $action,
                'count' => $minuteCount,
            ]);
            return false;
        }

        if ($hourCount >= $limits['max_per_hour']) {
            Log::warning('Permission rate limit exceeded (hour)', [
                'user_id' => $user->id,
                'action' => $action,
                'count' => $hourCount,
            ]);
            return false;
        }

        Cache::put($minuteKey, $minuteCount + 1, 60);
        Cache::put($hourKey, $hourCount + 1, 3600);

        return true;
    }
}
```

---

## Internationalization of Permission Messages

### Localized Permission Denial Messages

```php
// lang/en/permissions.php
return [
    'denied' => [
        'generic' => 'You do not have permission to perform this action.',
        'marketplace' => [
            'purchase' => 'You do not have permission to make purchases.',
            'sell' => 'You must be a verified creator to sell on the marketplace.',
            'refund' => 'Only support staff can process refunds.',
        ],
        'themes' => [
            'create' => 'You must be a verified creator to create themes.',
            'publish' => 'Only moderators can publish themes.',
            'delete' => 'You can only delete your own themes.',
        ],
        'admin' => [
            'access' => 'Administrative access is required.',
            'manage_users' => 'Only administrators can manage users.',
            'manage_roles' => 'Only super administrators can manage roles.',
        ],
    ],
    'hints' => [
        'upgrade_to_creator' => 'Upgrade to a Creator account to access this feature.',
        'contact_support' => 'Contact support for assistance with this action.',
        'request_access' => 'Request access from your team administrator.',
    ],
];

// lang/fa/permissions.php (Persian/Farsi)
return [
    'denied' => [
        'generic' => 'شما اجازه انجام این عمل را ندارید.',
        'marketplace' => [
            'purchase' => 'شما اجازه انجام خرید را ندارید.',
            'sell' => 'برای فروش در بازار باید سازنده تایید شده باشید.',
            'refund' => 'فقط کارکنان پشتیبانی می‌توانند بازپرداخت را پردازش کنند.',
        ],
    ],
];
```

### Permission Label Localization

```php
class LocalizedPermissionLabels
{
    public function getLabel(string $permission): string
    {
        $key = "permissions.labels." . str_replace('.', '_', $permission);
        return __($key);
    }

    public function getDescription(string $permission): string
    {
        $key = "permissions.descriptions." . str_replace('.', '_', $permission);
        return __($key);
    }

    public function getDeniedMessage(string $permission): string
    {
        $key = "permissions.denied." . str_replace('.', '_', $permission);
        return __($key, [], 'en');
    }
}
```

---

## Performance Benchmarks

### Permission Check Performance Targets

| Operation | Target | Measurement |
|-----------|--------|-------------|
| Single permission check (cached) | < 1ms | Redis GET + comparison |
| Single permission check (uncached) | < 10ms | Database query |
| Role resolution | < 5ms | Cached role lookup |
| Policy evaluation | < 15ms | Policy class + cache |
| Full authorization flow | < 25ms | Request to decision |
| Cache warm-up (1000 users) | < 5s | Background job |
| Cache invalidation (single user) | < 50ms | Redis DEL operations |

### Database Query Performance

```sql
-- Optimized permission lookup query
SELECT DISTINCT p.name
FROM permissions p
INNER JOIN permission_role pr ON pr.permission_id = p.id
INNER JOIN roles r ON r.id = pr.role_id
INNER JOIN role_user ru ON ru.role_id = r.id
WHERE ru.user_id = ?
AND p.name = ?;

-- Recommended indexes
CREATE INDEX idx_permission_role_permission_id ON permission_role(permission_id);
CREATE INDEX idx_permission_role_role_id ON permission_role(role_id);
CREATE INDEX idx_role_user_user_id ON role_user(user_id);
CREATE INDEX idx_role_user_role_id ON role_user(role_id);
CREATE INDEX idx_permissions_name ON permissions(name);
```

### Load Testing

```php
// tests/Performance/PermissionLoadTest.php

class PermissionLoadTest extends TestCase
{
    public function test_permission_check_under_load(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $user->givePermissionTo('marketplace.purchase');

        $start = microtime(true);

        for ($i = 0; $i < 10000; $i++) {
            $user->hasPermissionTo('marketplace.purchase');
        }

        $elapsed = microtime(true) - $start;

        $this->assertLessThan(5.0, $elapsed, '10000 permission checks should complete in under 5 seconds');
    }

    public function test_concurrent_permission_checks(): void
    {
        $users = User::factory()->count(100)->create();
        foreach ($users as $user) {
            $user->assignRole('user');
        }

        $start = microtime(true);

        $promises = [];
        foreach ($users as $user) {
            $promises[] = async(function () use ($user) {
                return $user->hasPermissionTo('marketplace.view');
            });
        }

        $results = await($promises);
        $elapsed = microtime(true) - $start;

        $this->assertLessThan(10.0, $elapsed);
        $this->assertTrue(collect($results)->every(fn($r) => $r === true));
    }
}
```

---

## Compliance and Regulatory

### GDPR Permission Data

Permission data may be subject to GDPR regulations when it can be linked to identifiable users:

| Data Type | GDPR Classification | Retention | Deletion |
|-----------|-------------------|-----------|----------|
| Permission assignments | Personal data | Account lifetime | On account deletion |
| Permission usage logs | Personal data | 90 days | Automatic purge |
| Role assignments | Personal data | Account lifetime | On account deletion |
| Audit logs | Personal data | 1 year | Automatic purge |

### SOC 2 Compliance Requirements

For SOC 2 Type II compliance, the permission system must:

1. **Access Controls**: Enforce least-privilege access across all system resources
2. **Audit Logging**: Maintain immutable audit logs of all permission changes
3. **Regular Reviews**: Quarterly access reviews for admin and super admin roles
4. **Segregation of Duties**: No single user can both create and approve permissions
5. **Monitoring**: Real-time alerting on unusual permission patterns
6. **Documentation**: Maintain up-to-date permission matrix and access policies

### PCI DSS Requirements (Marketplace)

For PCI DSS compliance in the marketplace payment processing:

1. **Restricted Access**: Only authorized personnel can access payment data
2. **Need-to-Know**: Payment permissions granted only to roles requiring payment access
3. **Multi-Factor Authentication**: Required for all payment-related permission changes
4. **Audit Trails**: Complete logging of all payment permission access
5. **Quarterly Reviews**: Regular review of payment access permissions

---

## Migration Guides

### Migrating from Legacy Permission System

If migrating from a custom permission system to the GsmUi RBAC architecture:

**Step 1: Audit Existing Permissions**
```bash
php artisan permissions:audit --export=csv
```

**Step 2: Map to GsmUi Permissions**
```php
$mappings = [
    'can_edit_posts' => 'blog.update',
    'can_delete_users' => 'users.delete',
    'is_admin' => 'admin.access',
];
```

**Step 3: Run Migration**
```bash
php artisan permissions:migrate --mapping-file=custom-mappings.php
```

**Step 4: Validate**
```bash
php artisan permissions:validate --fix-issues
```

### Migrating Between GsmUi Versions

When GsmUi introduces permission changes between versions:

```php
// Database migration for permission changes
public function up(): void
{
    // Add new permissions
    Permission::create(['name' => 'new.feature.access', 'guard_name' => 'web']);
    Permission::create(['name' => 'new.feature.manage', 'guard_name' => 'web']);

    // Migrate old permissions to new
    $oldPermission = Permission::where('name', 'old.permission')->first();
    $newPermission = Permission::where('name', 'new.feature.access')->first();

    if ($oldPermission && $newPermission) {
        // Move all role assignments
        DB::table('permission_role')
            ->where('permission_id', $oldPermission->id)
            ->update(['permission_id' => $newPermission->id]);

        // Remove old permission
        $oldPermission->delete();
    }
}
```

---

## Appendix A: Permission Naming Convention Reference

### Naming Rules

| Rule | Example | Anti-Example |
|------|---------|--------------|
| Use `resource.action` format | `themes.create` | `create_things` |
| Use snake_case | `marketplace.manage_own` | `marketplace.manageOwn` |
| Use plural resources | `users.view` | `user.view` |
| Use present tense actions | `themes.publish` | `themes.published` |
| Be specific | `themes.publish_pending` | `themes.manage` |
| Avoid abbreviations | `marketplace.purchase` | `mkt.purchase` |

### Action Vocabulary

| Action | Meaning | Implies |
|--------|---------|---------|
| `view` | Read-only access | No modification |
| `create` | Create new resource | Requires existence check |
| `update` | Modify existing resource | Ownership or admin |
| `delete` | Remove resource | Ownership or admin, soft-delete |
| `publish` | Make public/visible | Approval workflow |
| `unpublish` | Make private/hidden | Owner or admin |
| `manage` | Full CRUD access | Administrative |
| `assign` | Assign to user/resource | Administrative |
| `export` | Download data | Administrative |
| `feature` | Highlight/promote | Administrative |

## Appendix B: Complete Permission List by Domain

### Users Domain
| Permission | Description |
|------------|-------------|
| `users.view` | View user profiles |
| `users.view_all` | View all user profiles |
| `users.create` | Create user accounts |
| `users.update` | Update user profiles |
| `users.delete` | Delete user accounts |
| `users.export` | Export user data |
| `users.assign_role` | Assign roles to users |
| `users.remove_role` | Remove roles from users |

### Marketplace Domain
| Permission | Description |
|------------|-------------|
| `marketplace.view` | Browse marketplace |
| `marketplace.search` | Search marketplace |
| `marketplace.purchase` | Purchase items |
| `marketplace.gift` | Gift purchases |
| `marketplace.sell` | Sell items |
| `marketplace.manage_own` | Manage own listings |
| `marketplace.manage` | Manage all listings |
| `marketplace.approve_listing` | Approve listings |
| `marketplace.reject_listing` | Reject listings |
| `marketplace.feature` | Feature listings |
| `marketplace.refund` | Process refunds |
| `marketplace.ban_listing` | Ban listings |
| `marketplace.set_commission` | Set commission rates |
| `marketplace.manage_payouts` | Manage payouts |
| `marketplace.write_review` | Write reviews |
| `marketplace.edit_review` | Edit reviews |
| `marketplace.delete_review` | Delete reviews |
| `marketplace.flag_review` | Flag reviews |
| `marketplace.respond_review` | Respond to reviews |
| `marketplace.view_reviews` | View reviews |
| `marketplace.view_sales_stats` | View sales statistics |

### Themes Domain
| Permission | Description |
|------------|-------------|
| `themes.view` | View themes |
| `themes.create` | Create themes |
| `themes.update` | Update themes |
| `themes.delete` | Delete themes |
| `themes.publish` | Publish themes |
| `themes.unpublish` | Unpublish themes |
| `themes.feature` | Feature themes |
| `themes.export` | Export themes |

### Components Domain
| Permission | Description |
|------------|-------------|
| `components.view` | View components |
| `components.create` | Create components |
| `components.update` | Update components |
| `components.delete` | Delete components |
| `components.publish` | Publish components |
| `components.feature` | Feature components |

### Billing Domain
| Permission | Description |
|------------|-------------|
| `billing.view` | View billing info |
| `billing.manage` | Manage subscriptions |
| `billing.refund` | Process refunds |
| `billing.view_invoices` | View invoices |
| `billing.export` | Export billing data |

### System Domain
| Permission | Description |
|------------|-------------|
| `settings.view` | View settings |
| `settings.manage` | Manage settings |
| `system.health` | View health status |
| `system.logs` | View system logs |
| `system.maintenance` | Manage maintenance mode |
| `system.backup` | Manage backups |

## Appendix C: Permission Seeding Example

```php
// database/seeders/PermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Users Domain
        Permission::create(['name' => 'users.view', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.view_all', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.update', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.export', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.assign_role', 'guard_name' => 'web']);
        Permission::create(['name' => 'users.remove_role', 'guard_name' => 'web']);

        // Marketplace Domain
        Permission::create(['name' => 'marketplace.view', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.search', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.purchase', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.gift', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.sell', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.manage_own', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.approve_listing', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.reject_listing', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.feature', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.refund', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.ban_listing', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.set_commission', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.manage_payouts', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.write_review', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.edit_review', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.delete_review', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.flag_review', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.respond_review', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.view_reviews', 'guard_name' => 'web']);
        Permission::create(['name' => 'marketplace.view_sales_stats', 'guard_name' => 'web']);

        // Themes Domain
        Permission::create(['name' => 'themes.view', 'guard_name' => 'web']);
        Permission::create(['name' => 'themes.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'themes.update', 'guard_name' => 'web']);
        Permission::create(['name' => 'themes.delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'themes.publish', 'guard_name' => 'web']);
        Permission::create(['name' => 'themes.unpublish', 'guard_name' => 'web']);
        Permission::create(['name' => 'themes.feature', 'guard_name' => 'web']);
        Permission::create(['name' => 'themes.export', 'guard_name' => 'web']);

        // Components Domain
        Permission::create(['name' => 'components.view', 'guard_name' => 'web']);
        Permission::create(['name' => 'components.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'components.update', 'guard_name' => 'web']);
        Permission::create(['name' => 'components.delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'components.publish', 'guard_name' => 'web']);
        Permission::create(['name' => 'components.feature', 'guard_name' => 'web']);

        // Billing Domain
        Permission::create(['name' => 'billing.view', 'guard_name' => 'web']);
        Permission::create(['name' => 'billing.manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'billing.refund', 'guard_name' => 'web']);
        Permission::create(['name' => 'billing.view_invoices', 'guard_name' => 'web']);
        Permission::create(['name' => 'billing.export', 'guard_name' => 'web']);

        // System Domain
        Permission::create(['name' => 'settings.view', 'guard_name' => 'web']);
        Permission::create(['name' => 'settings.manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'system.health', 'guard_name' => 'web']);
        Permission::create(['name' => 'system.logs', 'guard_name' => 'web']);
        Permission::create(['name' => 'system.maintenance', 'guard_name' => 'web']);
        Permission::create(['name' => 'system.backup', 'guard_name' => 'web']);

        // Roles with inherited permissions
        $guestRole = Role::create(['name' => 'guest', 'guard_name' => 'web']);

        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo([
            'users.view', 'users.update', 'users.delete',
            'marketplace.view', 'marketplace.search', 'marketplace.purchase',
            'themes.view', 'components.view',
            'billing.view',
        ]);

        $proUserRole = Role::create(['name' => 'pro_user', 'guard_name' => 'web']);
        $proUserRole->givePermissionTo([
            'marketplace.gift', 'marketplace.write_review',
            'billing.manage',
        ]);

        $creatorRole = Role::create(['name' => 'creator', 'guard_name' => 'web']);
        $creatorRole->givePermissionTo([
            'marketplace.sell', 'marketplace.manage_own',
            'marketplace.set_pricing', 'marketplace.view_earnings',
            'marketplace.request_payout', 'marketplace.respond_review',
            'themes.create', 'themes.update', 'themes.delete', 'themes.publish',
            'components.create', 'components.update', 'components.delete',
        ]);

        $moderatorRole = Role::create(['name' => 'moderator', 'guard_name' => 'web']);
        $moderatorRole->givePermissionTo([
            'marketplace.approve_listing', 'marketplace.reject_listing',
            'marketplace.manage',
        ]);

        $supportRole = Role::create(['name' => 'support', 'guard_name' => 'web']);
        $supportRole->givePermissionTo([
            'marketplace.refund', 'orders.manage', 'orders.refund',
            'users.view_all',
        ]);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'users.create', 'users.export', 'users.assign_role', 'users.remove_role',
            'marketplace.feature', 'marketplace.ban_listing',
            'marketplace.set_commission', 'marketplace.manage_payouts',
            'themes.feature', 'themes.export', 'components.feature',
            'settings.view', 'settings.manage',
            'orders.export',
        ]);

        $superAdminRole = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdminRole->givePermissionTo([
            'system.health', 'system.logs', 'system.maintenance', 'system.backup',
        ]);

        // Assign super admin to first user
        $firstUser = \App\Models\User::first();
        if ($firstUser) {
            $firstUser->assignRole('super_admin');
        }
    }
}
```

## Appendix D: Troubleshooting Guide

### Common Permission Issues

| Issue | Cause | Solution |
|-------|-------|----------|
| User cannot access feature | Missing permission assignment | Check role permissions with `php artisan permission:list` |
| Cache inconsistency | Stale cache after role change | Run `php artisan permission:cache-clear` |
| Policy returns unexpected result | Missing policy method | Ensure policy method exists and is registered |
| Permission check always fails | Guard mismatch | Ensure guard name matches `'web'` or `'api'` |
| Performance degradation | Excessive permission checks | Enable permission caching and review check frequency |
| Migration fails | Duplicate permission names | Check for existing permissions before creating |

# Export permission audit report
php artisan permission:audit --format=csv --output=audit-report.csv
```

---

## Permission Best Practices

### Principle of Least Privilege

Always assign the minimum permissions required for a role to function:

| Role | Principle Applied | Example |
|------|-------------------|---------|
| Guest | View-only access | Can browse marketplace, cannot purchase |
| User | Personal resource access | Can manage own profile, view own orders |
| Pro User | Enhanced user access | Can gift purchases, save playground sessions |
| Creator | Content creation | Can create/publish themes, view own earnings |
| Moderator | Content moderation | Can approve/reject listings, manage reviews |
| Support | Customer assistance | Can view orders, process refunds |
| Editor | Content management | Can create/edit blog posts, documentation |
| Admin | Platform administration | Can manage users, configure settings |
| Super Admin | System administration | Can manage roles, system maintenance |

### Permission Denial Logging

```php
<?php

namespace App\Services\Permissions;

use Illuminate\Support\Facades\Log;

class PermissionDenialLogger
{
    public function logDenial(User $user, string $permission, $resource = null, string $context = ''): void
    {
        Log::warning('Permission denied', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_roles' => $user->roles->pluck('name')->toArray(),
            'permission' => $permission,
            'resource_type' => $resource ? get_class($resource) : null,
            'resource_id' => $resource?->id,
            'context' => $context,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->url(),
        ]);

        // Track for analytics
        DB::table('permission_denials')->insert([
            'user_id' => $user->id,
            'permission' => $permission,
            'resource_type' => $resource ? get_class($resource) : null,
            'resource_id' => $resource?->id,
            'context' => $context,
            'created_at' => now(),
        ]);
    }
}
```

### Permission Validation Middleware

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidatePermissionExists
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!$this->permissionExists($permission)) {
            abort(500, "Permission '{$permission}' does not exist in the system.");
        }

        return $next($request);
    }

    protected function permissionExists(string $permission): bool
    {
        return \Spatie\Permission\Models\Permission::where('name', $permission)->exists();
    }
}
```

### Role Permission Summary

| Role | Total Permissions | Key Permissions |
|------|-------------------|-----------------|
| Guest | 0 | None |
| User | 5 | profile.view, marketplace.view, marketplace.search |
| Pro User | 12 | + marketplace.gift, marketplace.view_premium |
| Creator | 25 | + themes.create, marketplace.sell |
| Moderator | 35 | + marketplace.approve_listing, marketplace.manage |
| Support | 45 | + marketplace.refund, orders.manage |
| Editor | 55 | + blog.create, documentation.create, cms.create |
| Admin | 75 | + users.create, settings.manage, marketplace.feature |
| Super Admin | 90 | + system.health, system.maintenance, roles.delete |

---

## Permission API Reference

### Permission Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `hasPermissionTo($permission)` | Check if user has permission | `$permission: string` | `bool` |
| `hasAnyPermission($permissions)` | Check if user has any of the permissions | `$permissions: array` | `bool` |
| `hasAllPermissions($permissions)` | Check if user has all permissions | `$permissions: array` | `bool` |
| `givePermissionTo($permission)` | Grant permission to user | `$permission: string` | `Permission` |
| `revokePermissionTo($permission)` | Revoke permission from user | `$permission: string` | `bool` |
| `syncPermissions($permissions)` | Sync user permissions | `$permissions: array` | `bool` |
| `getAllPermissions()` | Get all user permissions | None | `Collection` |

### Role Methods

| Method | Description | Parameters | Returns |
|--------|-------------|------------|---------|
| `hasRole($role)` | Check if user has role | `$role: string` | `bool` |
| `hasAnyRole($roles)` | Check if user has any of the roles | `$roles: array` | `bool` |
| `hasAllRoles($roles)` | Check if user has all roles | `$roles: array` | `bool` |
| `assignRole($role)` | Assign role to user | `$role: string` | `Role` |
| `removeRole($role)` | Remove role from user | `$role: string` | `bool` |
| `syncRoles($roles)` | Sync user roles | `$roles: array` | `bool` |
| `getRoles()` | Get all user roles | None | `Collection` |

### Blade Directive Examples

```blade
{{-- Check single permission --}}
@can('users.create')
    <button>Create User</button>
@endcan

{{-- Check role --}}
@role('admin')
    <a href="/admin">Admin Panel</a>
@endrole

{{-- Check multiple permissions --}}
@canany(['users.create', 'users.update'])
    <button>Manage Users</button>
@endcanany

{{-- Check all permissions --}}
@canall(['users.view', 'users.create'])
    <button>View & Create Users</button>
@endcanall

{{-- Permission in Livewire --}}
<div>
    @can('themes.create')
        <button wire:click="createTheme">Create Theme</button>
    @endcan
</div>
```

---

## Permission Testing Utilities

### Test Helpers

```php
<?php

namespace Tests\PermissionHelpers;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

trait PermissionTestHelpers
{
    protected function createUserWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);
        return $user;
    }

    protected function createUserWithPermissions(array $permissions): User
    {
        $user = User::factory()->create();
        foreach ($permissions as $permission) {
            $user->givePermissionTo($permission);
        }
        return $user;
    }

    protected function seedPermissionMatrix(): void
    {
        Artisan::call('db:seed', ['--class' => 'PermissionSeeder']);
    }

    protected function assertUserHasPermission(User $user, string $permission): void
    {
        $this->assertTrue(
            $user->hasPermissionTo($permission),
            "User {$user->id} expected to have permission {$permission}"
        );
    }

    protected function assertUserLacksPermission(User $user, string $permission): void
    {
        $this->assertFalse(
            $user->hasPermissionTo($permission),
            "User {$user->id} expected to lack permission {$permission}"
        );
    }

    protected function assertUserHasRole(User $user, string $role): void
    {
        $this->assertTrue(
            $user->hasRole($role),
            "User {$user->id} expected to have role {$role}"
        );
    }

    protected function assertUserLacksRole(User $user, string $role): void
    {
        $this->assertFalse(
            $user->hasRole($role),
            "User {$user->id} expected to lack role {$role}"
        );
    }
}
```

### Permission Test Cases

```php
<?php

namespace Tests\Feature\Permissions;

use Tests\TestCase;
use App\Models\User;
use Tests\PermissionHelpers\PermissionTestHelpers;

class PermissionAuthorizationTest extends TestCase
{
    use PermissionTestHelpers;

    /** @test */
    public function guest_cannot_access_protected_routes(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_cannot_access_admin_routes(): void
    {
        $user = $this->createUserWithRole('user');

        $this->actingAs($user)
             ->get(route('admin.dashboard'))
             ->assertForbidden();
    }

    /** @test */
    public function admin_can_access_admin_routes(): void
    {
        $admin = $this->createUserWithRole('admin');

        $this->actingAs($admin)
             ->get(route('admin.dashboard'))
             ->assertOk();
    }

    /** @test */
    public function creator_can_create_themes(): void
    {
        $creator = $this->createUserWithRole('creator');

        $this->actingAs($creator)
             ->post(route('themes.store'), [
                 'name' => 'Test Theme',
                 'description' => 'A test theme',
             ])
             ->assertOk();
    }

    /** @test */
    public function user_cannot_create_themes(): void
    {
        $user = $this->createUserWithRole('user');

        $this->actingAs($user)
             ->post(route('themes.store'), [
                 'name' => 'Test Theme',
                 'description' => 'A test theme',
             ])
             ->assertForbidden();
    }
}
```

---

## Permission Monitoring and Alerts

### Alert Configuration

```php
<?php

namespace App\Services\Permissions;

class PermissionAlertConfig
{
    private array $alerts = [
        'high_denial_rate' => [
            'threshold' => 0.20,
            'window' => '1 hour',
            'channel' => ['email', 'slack'],
        ],
        'slow_permission_check' => [
            'threshold' => 100,
            'window' => '5 minutes',
            'channel' => ['slack'],
        ],
        'role_change_spike' => [
            'threshold' => 50,
            'window' => '1 hour',
            'channel' => ['email'],
        ],
        'cache_miss_rate' => [
            'threshold' => 0.30,
            'window' => '1 hour',
            'channel' => ['slack'],
        ],
    ];

    public function shouldAlert(string $type, float $value): bool
    {
        if (!isset($this->alerts[$type])) {
            return false;
        }

        return $value >= $this->alerts[$type]['threshold'];
    }

    public function getAlertChannels(string $type): array
    {
        return $this->alerts[$type]['channels'] ?? [];
    }
}
```

### Monitoring Queries

```sql
-- Permission denial rate by hour
SELECT
    DATE_TRUNC('hour', created_at) as hour,
    COUNT(*) as total_checks,
    SUM(CASE WHEN granted = false THEN 1 ELSE 0 END) as denials,
    ROUND(SUM(CASE WHEN granted = false THEN 1 ELSE 0 END)::numeric / COUNT(*), 2) as denial_rate
FROM permission_audit_log
WHERE created_at > NOW() - INTERVAL '24 hours'
GROUP BY DATE_TRUNC('hour', created_at)
ORDER BY hour DESC;

-- Slowest permission checks
SELECT
    permission,
    AVG(duration_ms) as avg_duration,
    MAX(duration_ms) as max_duration,
    COUNT(*) as check_count
FROM permission_performance_log
WHERE created_at > NOW() - INTERVAL '1 hour'
GROUP BY permission
ORDER BY avg_duration DESC
LIMIT 10;

-- Most denied permissions
SELECT
    permission,
    COUNT(*) as denial_count
FROM permission_audit_log
WHERE granted = false
    AND created_at > NOW() - INTERVAL '24 hours'
GROUP BY permission
ORDER BY denial_count DESC
LIMIT 10;
```
