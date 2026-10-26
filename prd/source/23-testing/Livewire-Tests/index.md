# Livewire Testing

> PRD — Volume 23: Quality Assurance — Livewire Testing

## Overview

Livewire testing provides component-level testing with assertion APIs, event testing, form validation testing, and service mocking for Livewire components in the gsmui platform.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Component coverage | All Livewire components tested | 100% |
| Assertion accuracy | Tests match real behavior | 100% |
| Event testing | All dispatched events verified | 100% |
| Form validation | All validation rules tested | 100% |
| Mock isolation | External services mocked | 100% |

## Component Testing

### Basic Component Test

```php
use Livewire\Livewire;

class PageBuilderTest extends TestCase
{
    public function test_it_renders(): void
    {
        $page = Page::factory()->create();

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->assertStatus(200)
            ->assertSee('Page Builder');
    }

    public function test_it_can_set_properties(): void
    {
        $page = Page::factory()->create();

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->set('page.title', 'Updated Title')
            ->assertSet('page.title', 'Updated Title');
    }

    public function test_it_can_call_methods(): void
    {
        $page = Page::factory()->create();

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->call('addBlock', 'heading', 0)
            ->assertSet('blocks.0.type', 'heading');
    }
}
```

## Assertion API

### Available Assertions

| Assertion | Description |
|-----------|-------------|
| `assertStatus($code)` | Component HTTP status |
| `assertSee($value)` | Text visible in output |
| `assertDontSee($value)` | Text not visible |
| `assertSet($property, $value)` | Property value check |
| `assertSet($property, fn($val) => ...)` | Property closure check |
| `assertHasErrors($field)` | Validation errors present |
| `assertHasNoErrors($field)` | No validation errors |
| `assertDispatched($event)` | Event was dispatched |
| `assertNotDispatched($event)` | Event was not dispatched |
| `assertRedirect($url)` | Component redirected |
| `assertViewHas($key, $value)` | View variable present |
| `assertViewIs($view)` | View name check |
| `assertEmitted($event)` | Browser event emitted |
| `assertNotEmitted($event)` | Browser event not emitted |

### Advanced Assertions

```php
class CommentFormTest extends TestCase
{
    public function test_it_validates_required_fields(): void
    {
        Livewire::test(CommentForm::class, ['postId' => 1])
            ->call('submit')
            ->assertHasErrors(['body']);
    }

    public function test_it_validates_email_format(): void
    {
        Livewire::test(CommentForm::class, ['postId' => 1])
            ->set('authorEmail', 'invalid-email')
            ->call('submit')
            ->assertHasErrors(['authorEmail']);
    }

    public function test_it_dispatches_event_on_success(): void
    {
        $post = Post::factory()->create();

        Livewire::test(CommentForm::class, ['postId' => $post->id])
            ->set('body', 'Great post!')
            ->set('authorName', 'John')
            ->set('authorEmail', 'john@example.com')
            ->call('submit')
            ->assertDispatched('comment-submitted')
            ->assertHasNoErrors();
    }

    public function test_it_clears_form_after_submission(): void
    {
        Livewire::test(CommentForm::class, ['postId' => 1])
            ->set('body', 'Great post!')
            ->call('submit')
            ->assertSet('body', '');
    }
}
```

## Event Testing

### Dispatched Events

```php
class PageBuilderEventTest extends TestCase
{
    public function test_it_dispatches_block_added_event(): void
    {
        $page = Page::factory()->create();

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->call('addBlock', 'heading', 0)
            ->assertDispatched('block-added', function ($event) {
                return isset($event->blockId);
            });
    }

    public function test_it_dispatches_page_saved_event(): void
    {
        $page = Page::factory()->create();

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->call('save')
            ->assertDispatched('page-saved');
    }

    public function test_it_dispatches_multiple_events_in_order(): void
    {
        $page = Page::factory()->create();

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->call('addBlock', 'heading', 0)
            ->call('save')
            ->assertDispatched('block-added')
            ->assertDispatched('page-saved');
    }
}
```

### Browser Events (Emit)

```php
class ModalTest extends TestCase
{
    public function test_it_emits_open_event(): void
    {
        Livewire::test(Modal::class)
            ->call('open')
            ->assertEmitted('open-modal');
    }

    public function test_it_emits_close_event(): void
    {
        Livewire::test(Modal::class)
            ->set('isOpen', true)
            ->call('close')
            ->assertEmitted('close-modal')
            ->assertSet('isOpen', false);
    }
}
```

## Form Testing

### Form Validation

```php
class ContactFormTest extends TestCase
{
    public function test_it_requires_name(): void
    {
        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors(['name']);
    }

    public function test_it_requires_valid_email(): void
    {
        Livewire::test(ContactForm::class)
            ->set('email', 'not-an-email')
            ->call('submit')
            ->assertHasErrors(['email']);
    }

    public function test_it_validates_email_uniqueness(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        Livewire::test(ContactForm::class)
            ->set('email', 'taken@example.com')
            ->call('submit')
            ->assertHasErrors(['email']);
    }

    public function test_it_validates_max_length(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', str_repeat('a', 256))
            ->call('submit')
            ->assertHasErrors(['name']);
    }

    public function test_it_passes_with_valid_data(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('message', 'Hello!')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertDispatched('contact-submitted');
    }
}
```

### File Upload Testing

```php
class ImageUploadTest extends TestCase
{
    public function test_it_can_upload_image(): void
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->image('photo.jpg', 800, 600);

        Livewire::test(MediaUpload::class)
            ->call('handleUpload', $file)
            ->assertDispatched('media-uploaded');

        Storage::disk('local')->assertExists('media/' . $file->hashName());
    }

    public function test_it_rejects_invalid_file_type(): void
    {
        $file = UploadedFile::fake()->create('document.exe', 100, 'application/x-executable');

        Livewire::test(MediaUpload::class)
            ->call('handleUpload', $file)
            ->assertHasErrors(['upload']);
    }
}
```

## Mock Services

### Service Mocking

```php
class SeoAuditTest extends TestCase
{
    public function test_it_uses_seo_service(): void
    {
        $mockSeoService = $this->mock(SeoService::class);
        $mockSeoService->shouldReceive('analyze')
            ->once()
            ->andReturn(['score' => 85, 'issues' => []]);

        Livewire::test(SeoAudit::class, ['pageId' => 1])
            ->call('runAudit')
            ->assertSet('score', 85);
    }

    public function test_it_handles_service_failure(): void
    {
        $mockSeoService = $this->mock(SeoService::class);
        $mockSeoService->shouldReceive('analyze')
            ->once()
            ->andThrow(new \Exception('API unavailable'));

        Livewire::test(SeoAudit::class, ['pageId' => 1])
            ->call('runAudit')
            ->assertHasErrors(['service']);
    }
}
```

### Facade Mocking

```php
class CacheTest extends TestCase
{
    public function test_it_caches_seo_data(): void
    {
        Cache::shouldReceive('get')
            ->with('seo:page:1')
            ->once()
            ->andReturn(null);

        Cache::shouldReceive('put')
            ->with('seo:page:1', \Mockery::type('array'), \Mockery::type('int'))
            ->once();

        Livewire::test(PageSeo::class, ['pageId' => 1])
            ->call('loadSeoData');
    }
}
```

## Livewire Test Helpers

### Helper Methods

```php
class LivewireTestHelpers extends TestCase
{
    public function test_with_dispatch(): void
    {
        Livewire::test(PageBuilder::class, ['pageId' => 1])
            ->dispatch('block-added', blockId: 'block-123')
            ->assertSet('selectedBlock', 'block-123');
    }

    public function test_with_mount_data(): void
    {
        $page = Page::factory()->create(['title' => 'Test Page']);

        Livewire::test(PageBuilder::class, ['pageId' => $page->id])
            ->assertSet('page.title', 'Test Page');
    }

    public function test_with_view_assertions(): void
    {
        Livewire::test(PageBuilder::class, ['pageId' => 1])
            ->assertSee('Add Block')
            ->assertSee('Save')
            ->assertDontSee('Delete');
    }
}
```

## Acceptance Criteria

- [ ] All Livewire components have test files
- [ ] Property setting and getting is tested
- [ ] Method calls and their effects are verified
- [ ] Event dispatching is asserted correctly
- [ ] Form validation rules are tested with valid/invalid data
- [ ] File uploads are tested with Storage::fake()
- [ ] External services are mocked appropriately
- [ ] Browser events (emit) are verified
- [ ] Component rendering (assertSee) is tested
- [ ] Edge cases like empty states are covered
