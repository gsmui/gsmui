# Gate Definitions

## Overview

Gates provide a closure-based or class-based mechanism for authorizing actions that don't map to a specific Eloquent model. Gates are defined in `AuthServiceProvider` or via dedicated gate classes.

## Closure-Based Gates

### Basic Definition

```php
// app/Providers/AuthServiceProvider.php
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    // Simple permission check
    Gate::define('manage-users', function (User $user) {
        return $user->hasPermission('users.manage');
    });

    // With arguments
    Gate::define('update-post', function (User $user, Post $post) {
        return $user->id === $post->author_id
            || $user->hasPermission('posts.update.any');
    });

    // Multiple arguments
    Gate::define('assign-role', function (User $user, User $target, string $role) {
        if (!$user->hasPermission('roles.manage')) {
            return false;
        }

        // Cannot assign roles higher than your own
        return $user->hierarchyLevel() < Role::where('name', $role)->hierarchy_level;
    });
}
```

### Defining Gates Globally

```php
// routes/web.php — available after AuthServiceProvider boots
Gate::define('view-dashboard', function (User $user) {
    return $user->hasAnyPermission([
        'dashboard.view',
        'dashboard.admin',
    ]);
});

Gate::define('access-api', function (User $user) {
    return $user->hasPermission('api.access')
        && !$user->isSuspended();
});
```

## Class-Based Gates

### Gate Policy Class

```php
// app/Gates/DashboardGate.php
namespace App\Gates;

use App\Models\User;
use Illuminate\Auth\Access\Gate;

class DashboardGate
{
    public function viewDashboard(User $user): bool
    {
        return $user->hasAnyPermission([
            'dashboard.view',
            'dashboard.admin',
        ]);
    }

    public function manageSettings(User $user): bool
    {
        return $user->hasPermission('settings.manage')
            && $user->isVerified();
    }

    public function accessAnalytics(User $user): bool
    {
        return $user->hasPermission('analytics.view')
            && $user->isOrganizationMember();
    }
}
```

### Registering Class-Based Gates

```php
// app/Providers/AuthServiceProvider.php
use App\Gates\DashboardGate;
use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    Gate::policyMethods(DashboardGate::class);
}
```

## Gate for Abilities

Gates are frequently used for abilities that don't correspond to model operations.

### Common Abilities

| Ability | Description | Typical Check |
|---------|-------------|---------------|
| `view-dashboard` | Access the dashboard | Role or permission |
| `manage-users` | Admin user management | Permission |
| `access-api` | Use API endpoints | Permission + verification |
| `export-data` | Export system data | Permission + rate limit |
| `impersonate-user` | Login as another user | Super admin only |
| `view-audit-log` | View audit trail | Permission |
| `manage-billing` | Access billing settings | Permission |
| `configure-sso` | Set up SSO | Admin + organization owner |

### Gate with Response Messages

```php
Gate::define('export-data', function (User $user) {
    if (!$user->hasPermission('export.data')) {
        return Response::deny('You do not have permission to export data.');
    }

    if ($user->lastExportAt()->diffInHours(now()) < 1) {
        return Response::deny('Please wait 1 hour between exports.');
    }

    return Response::allow();
});
```

## Guest Gates

Gates for unauthenticated users.

```php
// View published content
Gate::define('view-post', function (?User $user, Post $post) {
    if ($post->isPublished()) {
        return true;
    }

    return $user && $user->id === $post->author_id;
});

// Access public API
Gate::define('access-public-api', function (?User $user) {
    return true; // always allowed
});

// Submit contact form
Gate::define('submit-contact', function (?User $user) {
    return RateLimiter::attempt('contact-form:' . request()->ip(), 5, function () {
        return true;
    });
});
```

### Guest Gate Middleware

```php
Route::middleware(['guest_gate:view-post'])->group(function () {
    Route::get('/posts/{post}', [PostController::class, 'show']);
});
```

## Inline Gate Tests

### In Controllers

```php
class PostController extends Controller
{
    public function export(Post $post)
    {
        if (Gate::denies('export-post', $post)) {
            abort(403, 'You cannot export this post.');
        }

        // proceed with export
    }

    public function store(StorePostRequest $request)
    {
        if (Gate::denies('create-post')) {
            abort(403);
        }

        return Post::create($request->validated());
    }
}
```

### In Blade

```php
@can('manage-users')
    <a href="{{ route('admin.users.index') }}">Manage Users</a>
@endcan

@can('export-data')
    <button wire:click="export">Export</button>
@endcan

@cannot('impersonate-user')
    <span class="text-gray-400">Impersonation disabled</span>
@endcannot

@gate('view-dashboard')
    <a href="/dashboard">Dashboard</a>
@endgate
```

### In Livewire

```php
class UserManagement extends Component
{
    public function impersonate(User $user): void
    {
        abort_unless(Gate::allows('impersonate-user', $user), 403);

        Auth::login($user);
        redirect()->route('dashboard');
    }

    public function exportUsers(): StreamedResponse
    {
        abort_unless(Gate::allows('export-data'), 403);

        return UserExport::download();
    }
}
```

## Gate Testing

```php
use Illuminate\Support\Facades\Gate;

class GateTest extends TestCase
{
    public function test_gate_allows_authorized_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        Gate::define('manage-users', fn (User $u) => $u->hasPermission('users.manage'));

        $this->actingAs($user);
        $this->assertTrue(Gate::allows('manage-users'));
    }

    public function test_gate_denies_unauthorized_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('viewer');

        Gate::define('manage-users', fn (User $u) => $u->hasPermission('users.manage'));

        $this->actingAs($user);
        $this->assertFalse(Gate::allows('manage-users'));
    }

    public function test_gate_returns_response_message(): void
    {
        $user = User::factory()->create();

        Gate::define('test-ability', function (User $u) {
            return Response::deny('Not allowed');
        });

        $this->actingAs($user);
        $response = Gate::inspect('test-ability');

        $this->assertFalse($response->allowed());
        $this->assertEquals('Not allowed', $response->message());
    }

    public function test_gate_with_arguments(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['author_id' => $user->id]);

        Gate::define('update-post', fn (User $u, Post $p) => $u->id === $p->author_id);

        $this->actingAs($user);
        $this->assertTrue(Gate::allows('update-post', $post));
    }
}
```

## Gate Events

Gates fire events that can be listened to for logging and auditing.

```php
// Listen for gate denials
Gate::after(function (User $user, string $ability, ?string $result) {
    if ($result === false) {
        ActivityLog::create([
            'user_id' => $user->id,
            'action'  => "gate.denied.{$ability}",
            'ip'      => request()->ip(),
        ]);
    }
});

// Listen for all gate checks
Event::listen(GateChecked::class, function ($event) {
    Log::debug("Gate check", [
        'user'    => $event->user->id,
        'ability' => $event->ability,
        'result'  => $event->result,
    ]);
});
```

## Best Practices

1. **Use gates for non-model abilities** — model-specific logic belongs in policies
2. **Return `Response::deny()`** with descriptive messages for user-facing gates
3. **Test gate responses, not just booleans** — inspect messages and status codes
4. **Keep gate logic simple** — delegate complex checks to service classes
5. **Use `Gate::before()`** for global overrides like super-admin bypass
6. **Avoid duplicating policy logic in gates** — pick one approach per authorization check
