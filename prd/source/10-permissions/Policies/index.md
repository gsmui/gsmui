# Policy Authorization

## Overview

Policies are classes that organize authorization logic around a specific model. Each policy method corresponds to an action that can be performed on the model. Policies provide a clean, testable way to define who can do what.

## Policy Structure

```php
// app/Policies/PostPolicy.php
namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Run before all authorization checks.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        return null; // fall through to method check
    }

    /**
     * Determine if the user can view any posts.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('posts.read');
    }

    /**
     * Determine if the user can view the post.
     */
    public function view(User $user, Post $post): bool
    {
        if ($post->isPublished()) {
            return true;
        }

        return $user->id === $post->author_id
            || $user->hasPermission('posts.read.any');
    }

    /**
     * Determine if the user can create posts.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('posts.create');
    }

    /**
     * Determine if the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->hasPermission('posts.update.any')) {
            return true;
        }

        return $user->hasPermission('posts.update.own')
            && $user->id === $post->author_id;
    }

    /**
     * Determine if the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->hasPermission('posts.delete.any')) {
            return true;
        }

        return $user->hasPermission('posts.delete.own')
            && $user->id === $post->author_id
            && !$post->isPublished();
    }

    /**
     * Determine if the user can publish the post.
     */
    public function publish(User $user, Post $post): bool
    {
        return $user->hasPermission('posts.publish')
            && ($user->id === $post->author_id || $user->hasPermission('posts.publish.any'));
    }

    /**
     * Define abilities that map to non-standard methods.
     */
    public function map(): array
    {
        return [
            'feature' => 'feature',
            'sticky'  => 'sticky',
            'archive' => 'archive',
        ];
    }

    public function feature(User $user, Post $post): bool
    {
        return $user->hasPermission('posts.feature')
            && $post->isPublished();
    }

    public function sticky(User $user, Post $post): bool
    {
        return $user->hasPermission('posts.sticky');
    }

    public function archive(User $user, Post $post): bool
    {
        return $post->author_id === $user->id
            || $user->hasPermission('posts.delete.any');
    }
}
```

## Policy Registration

### Auto-Discovery

Policies in `App\Policies` are auto-discovered by convention:

| Model | Policy |
|-------|--------|
| `App\Models\User` | `App\Policies\UserPolicy` |
| `App\Models\Post` | `App\Policies\PostPolicy` |
| `App\Models\Comment` | `App\Policies\CommentPolicy` |

### Manual Registration

```php
// app/Providers/AuthServiceProvider.php
namespace App\Providers;

use App\Models\Team;
use App\Models\CustomModel;
use App\Policies\TeamPolicy;
use App\Policies\CustomModelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class AuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Team::class => TeamPolicy::class,
        CustomModel::class => CustomModelPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
```

### Registration with Gsmui

```php
// app/Providers/GsmuiServiceProvider.php
use Gsmui\Facades\Gsmui;

public function boot(): void
{
    Gsmui::policies([
        \App\Models\Post::class => \App\Policies\PostPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ]);
}
```

## Before/After Hooks

### Before Hook

Runs before any policy method. Useful for super-admin bypass.

```php
public function before(User $user, string $ability): ?bool
{
    // Super admin can do everything
    if ($user->isSuperAdmin()) {
        return true;
    }

    // Banned users can do nothing
    if ($user->isBanned()) {
        return false;
    }

    // Return null to continue to policy method
    return null;
}
```

### After Hook

Runs after the policy method returns `false`. Useful for logging and debugging.

```php
public function after(User $user, string $ability, ?Post $post): void
{
    if (!$user->isSuperAdmin()) {
        ActivityLog::create([
            'user_id'    => $user->id,
            'action'     => "denied:{$ability}",
            'model_type' => get_class($post),
            'model_id'   => $post?->id,
        ]);
    }
}
```

### Hook Execution Order

```
┌─────────────┐
│  before()   │ ← runs first
└──────┬──────┘
       │ null? continue
       ▼
┌─────────────┐
│ method()    │ ← e.g., update(), delete()
└──────┬──────┘
       │ false? continue
       ▼
┌─────────────┐
│  after()    │ ← runs after denial
└─────────────┘
```

## Using Policies

### In Controllers

```php
class PostController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Post::class);

        return Post::all();
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return $post;
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        return redirect()->route('posts.show', $post);
    }
}
```

### In Blade

```php
@can('view', $post)
    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
@endcan

@can('update', $post)
    <a href="{{ route('posts.edit', $post) }}">Edit</a>
@endcan

@can('publish', $post)
    <button wire:click="publish({{ $post->id }})">Publish</button>
@endcan

@cannot('delete', $post)
    <span class="text-gray-400">Cannot delete published posts</span>
@endcannot
```

### In Livewire

```php
class PostShow extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        abort_unless($this->user->can('view', $post), 403);
        $this->post = $post;
    }

    public function delete(): void
    {
        abort_unless($this->user->can('delete', $this->post), 403);

        $this->post->delete();
        redirect()->route('posts.index');
    }
}
```

## Testing Policies

```php
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostPolicyTest extends TestCase
{
    protected User $admin;
    protected User $author;
    protected User $viewer;
    protected Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->author = User::factory()->create();
        $this->author->assignRole('creator');

        $this->viewer = User::factory()->create();
        $this->viewer->assignRole('viewer');

        $this->post = Post::factory()->create([
            'author_id' => $this->author->id,
        ]);
    }

    public function test_admin_can_update_any_post(): void
    {
        $this->assertTrue($this->admin->can('update', $this->post));
    }

    public function test_author_can_update_own_post(): void
    {
        $this->assertTrue($this->author->can('update', $this->post));
    }

    public function test_viewer_cannot_update_post(): void
    {
        $this->assertFalse($this->viewer->can('update', $this->post));
    }

    public function test_author_cannot_delete_published_post(): void
    {
        $this->post->update(['status' => 'published']);

        $this->assertFalse($this->author->can('delete', $this->post));
    }

    public function test_guest_can_view_published_post(): void
    {
        $this->post->update(['status' => 'published']);

        $guest = User::factory()->guest()->create();
        $this->assertTrue($guest->can('view', $this->post));
    }
}
```

## Best Practices

1. **Keep policies thin** — delegate complex logic to service classes
2. **Use `before()` for global overrides** — super admin, bans
3. **Test every policy method** — policies are critical security code
4. **Map custom abilities** with `map()` for non-standard actions
5. **Use model scopes** in policies — `$post->isPublished()` reads better than raw queries
6. **Never trust client input** — always authorize server-side regardless of UI visibility
