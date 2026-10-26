# Feature Testing

> PRD — Volume 23: Quality Assurance — Feature Testing

## Overview

Feature testing validates complete user flows including HTTP requests, database operations, authentication, mail sending, and queue processing. Tests simulate real user interactions against the full application stack.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Feature coverage | Critical paths covered | 100% |
| Test execution | Full feature test suite | < 5 minutes |
| Authentication tests | All auth flows tested | 100% |
| Authorization tests | All permission checks | 100% |
| API tests | All endpoints tested | 100% |

## HTTP Tests

### Controller Tests

```php
class PageControllerTest extends TestCase
{
    public function test_it_displays_page_listing(): void
    {
        Page::factory()->count(5)->published()->create();

        $response = $this->get('/pages');

        $response->assertStatus(200);
        $response->assertSee('Pages');
        $response->assertSeelivewire('page-list');
    }

    public function test_it_displays_single_page(): void
    {
        $page = Page::factory()->published()->create(['title' => 'About Us']);

        $response = $this->get('/pages/about-us');

        $response->assertStatus(200);
        $response->assertSee('About Us');
    }

    public function test_it_returns_404_for_missing_page(): void
    {
        $response = $this->get('/pages/nonexistent');

        $response->assertStatus(404);
    }

    public function test_it_creates_page_with_valid_data(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/admin/pages', [
            'title' => 'New Page',
            'slug' => 'new-page',
            'content' => 'Page content here',
            'type' => 'static',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pages', ['slug' => 'new-page']);
    }

    public function test_it_validates_required_fields(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/admin/pages', []);

        $response->assertSessionHasErrors(['title', 'slug']);
    }
}
```

### Livewire Component Tests

```php
class PageBuilderTest extends TestCase
{
    public function test_it_adds_block(): void
    {
        $page = Page::factory()->create();

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->call('addBlock', 'heading', 0)
            ->assertSet('blocks.0.type', 'heading')
            ->assertSet('isDirty', true);
    }

    public function test_it_removes_block(): void
    {
        $page = Page::factory()->create(['blocks' => [
            ['id' => 'block-1', 'type' => 'heading', 'data' => ['text' => 'Test']],
        ]]);

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->call('removeBlock', 'block-1')
            ->assertSet('blocks', [])
            ->assertSet('isDirty', true);
    }

    public function test_it_saves_page(): void
    {
        $page = Page::factory()->create();

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->set('page.title', 'Updated Title')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'title' => 'Updated Title',
        ]);
    }
}
```

## Database Tests

### Model Tests

```php
class PostTest extends TestCase
{
    public function test_it_has_correct_fillable_fields(): void
    {
        $post = new Post();

        $this->assertEquals([
            'title', 'slug', 'excerpt', 'content', 'blocks',
            'featured_image_id', 'author_id', 'status',
        ], $post->getFillable());
    }

    public function test_it_belongs_to_author(): void
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->author);
        $this->assertNotNull($post->author_id);
    }

    public function test_it_belongs_to_many_categories(): void
    {
        $post = Post::factory()->create();
        $categories = Category::factory()->count(3)->create();
        $post->categories()->sync($categories->pluck('id'));

        $this->assertCount(3, $post->categories);
    }

    public function test_it_soft_deletes(): void
    {
        $post = Post::factory()->create();
        $postId = $post->id;

        $post->delete();

        $this->assertSoftDeleted('posts', ['id' => $postId]);
        $this->assertDatabaseHas('posts', ['id' => $postId, 'deleted_at' => now()]);
    }

    public function test_it_scopes_published(): void
    {
        Post::factory()->count(3)->published()->create();
        Post::factory()->count(2)->draft()->create();

        $published = Post::published()->get();

        $this->assertCount(3, $published);
    }
}
```

### Migration Tests

```php
class DatabaseTest extends TestCase
{
    public function test_pages_table_has_required_columns(): void
    {
        Schema::assertTableHasColumns('pages', [
            'id', 'title', 'slug', 'type', 'content', 'blocks',
            'status', 'publish_at', 'published_at', 'author_id',
            'created_at', 'updated_at', 'deleted_at',
        ]);
    }

    public function test_pages_slug_is_unique(): void
    {
        Page::factory()->create(['slug' => 'about']);

        $this->expectException(QueryException::class);
        DB::table('pages')->insert([
            'title' => 'Another About',
            'slug' => 'about',
            'type' => 'static',
            'author_id' => 1,
        ]);
    }
}
```

## Authentication Tests

```php
class AuthenticationTest extends TestCase
{
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/pages');

        $response->assertRedirect('/login');
    }

    public function test_email_verification_is_required(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertRedirect('/verify-email');
    }
}
```

## Authorization Tests

```php
class AuthorizationTest extends TestCase
{
    public function test_admin_can_access_admin_panel(): void
    {
        $this->actingAsAdmin();

        $response = $this->get('/admin/pages');

        $response->assertStatus(200);
    }

    public function test_regular_user_cannot_access_admin_panel(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/pages');

        $response->assertForbidden();
    }

    public function test_editor_can_create_pages(): void
    {
        $this->actingAs(User::factory()->editor()->create());

        $response = $this->post('/admin/pages', [
            'title' => 'New Page',
            'slug' => 'new-page',
        ]);

        $response->assertStatus(200); // Redirect
    }

    public function test_author_cannot_delete_others_pages(): void
    {
        $author = User::factory()->author()->create();
        $otherPage = Page::factory()->create(['author_id' => 999]);

        $this->actingAs($author);

        $response = $this->delete("/admin/pages/{$otherPage->id}");

        $response->assertForbidden();
    }
}
```

## Mail Tests

```php
class MailTest extends TestCase
{
    public function test_welcome_email_is_sent_on_registration(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        Mail::assertSent(WelcomeEmail::class, function ($email) use ($user) {
            return $email->hasTo($user->email);
        });
    }

    public function test_password_reset_email_is_sent(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Mail::assertSent(ResetPasswordEmail::class, function ($email) use ($user) {
            return $email->hasTo($user->email);
        });
    }
}
```

## Queue Tests

```php
class QueueTest extends TestCase
{
    public function test_image_processing_job_is_dispatched(): void
    {
        Queue::fake();

        $media = Media::factory()->image()->create();

        ProcessImage::dispatch($media);

        Queue::assertPushed(ProcessImage::class);
    }

    public function test_email_job_is_dispatched_on_comment(): void
    {
        Queue::fake();

        $post = Post::factory()->create();
        Comment::factory()->create(['post_id' => $post->id]);

        Queue::assertPushed(SendCommentNotification::class);
    }

    public function test_jobs_are_dispatched_to_correct_queue(): void
    {
        Queue::fake();

        SendBulkEmail::dispatch($users)->onQueue('emails');

        Queue::assertPushed(SendBulkEmail::class, function ($job) {
            return $job->queue === 'emails';
        });
    }
}
```

## Acceptance Criteria

- [ ] All controllers have corresponding test files
- [ ] Authentication flows are fully tested
- [ ] Authorization checks are verified for all routes
- [ ] Database operations use model assertions
- [ ] Mail fakes verify email sending
- [ ] Queue fakes verify job dispatching
- [ ] HTTP status codes are asserted correctly
- [ ] Session/flash messages are validated
- [ ] Redirect behavior is tested
- [ ] Validation rules are tested with valid and invalid data
