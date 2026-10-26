# Page Management

> PRD — Volume 21: CMS & Content — Pages

## Overview

The Page Management system provides a flexible, drag-and-drop page builder for creating and managing static and dynamic pages. It supports multiple page types, draft/scheduled publishing, revision history, and SEO metadata—all accessible through an intuitive Livewire-based admin interface.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Page creation speed | Time from click to published page | < 5 minutes |
| Page builder adoption | % of pages built with page builder vs. code | 80%+ |
| Revision accuracy | Successful rollback success rate | 100% |
| SEO completeness | Pages with all SEO fields filled | 95%+ |
| Draft-to-publish cycle | Average time in draft state | Tracked per page |

## Page Types

| Type | Slug | Description | Default Template |
|------|------|-------------|-----------------|
| Static | `static` | Free-form content pages | `pages.show` |
| Landing | `landing` | Marketing/conversion pages | `pages.landing` |
| Blog Index | `blog-index` | Blog listing page | `blog.index` |
| Category Index | `category-index` | Category listing page | `categories.index` |
| Search | `search` | Search results page | `pages.search` |
| 404 | `not-found` | Custom error page | `pages.404` |
| Home | `home` | Front page / homepage | `pages.home` |
| Custom | `custom` | Template-driven with custom slug | `pages.custom` |

### Page Type Configuration

```php
// config/pages.php
return [
    'types' => [
        'static' => [
            'label' => 'Static Page',
            'icon' => 'document-text',
            'template' => 'pages.show',
            'seo_enabled' => true,
            'schedule_enabled' => true,
            'builder_enabled' => true,
        ],
        'landing' => [
            'label' => 'Landing Page',
            'icon' => 'megaphone',
            'template' => 'pages.landing',
            'seo_enabled' => true,
            'schedule_enabled' => true,
            'builder_enabled' => true,
        ],
    ],
];
```

## Page Builder

### Available Blocks

| Block | Category | Description |
|-------|----------|-------------|
| `heading` | Content | H1–H6 with optional anchor |
| `paragraph` | Content | Rich text paragraph |
| `image` | Media | Single image with caption |
| `gallery` | Media | Image grid/carousel |
| `video` | Media | Embedded video (YouTube, Vimeo) |
| `button` | Interactive | CTA button with link |
| `form` | Interactive | Embed a Livewire form |
| `testimonial` | Social | Quote with author |
| `pricing` | Commercial | Pricing table |
| `faq` | Content | Accordion FAQ section |
| `hero` | Layout | Hero section with background |
| `columns` | Layout | Multi-column layout |
| `divider` | Layout | Horizontal rule/spacer |
| `code` | Content | Syntax-highlighted code block |
| `html` | Advanced | Raw HTML block |

### Block Schema

```json
{
  "id": "block-uuid",
  "type": "heading",
  "data": {
    "text": "Welcome to Our Platform",
    "level": "h1",
    "anchor": "welcome",
    "align": "left",
    "classes": ""
  },
  "conditions": {
    "show_on_desktop": true,
    "show_on_mobile": true,
    "show_after_date": null,
    "show_until_date": null
  }
}
```

### Page Builder Livewire Component

```php
class PageBuilder extends Component
{
    public ?Page $page;
    public array $blocks = [];
    public ?string $draggedBlock = null;
    public bool $isDirty = false;

    public function mount(?int $pageId = null): void
    {
        $this->page = $pageId ? Page::findOrFail($pageId) : null;
        $this->blocks = $this->page?->blocks ?? [];
    }

    public function addBlock(string $type, int $position): void
    {
        $block = BlockFactory::create($type);
        array_splice($this->blocks, $position, 0, [$block]);
        $this->isDirty = true;
        $this->dispatch('block-added', blockId: $block['id']);
    }

    public function removeBlock(string $blockId): void
    {
        $this->blocks = array_filter(
            $this->blocks,
            fn(array $b) => $b['id'] !== $blockId
        );
        $this->isDirty = true;
    }

    public function moveBlock(string $blockId, int $from, int $to): void
    {
        $block = $this->blocks[$from];
        array_splice($this->blocks, $from, 1);
        array_splice($this->blocks, $to, 0, [$block]);
        $this->isDirty = true;
    }

    public function save(): void
    {
        $this->validate([
            'page.title' => 'required|string|max:255',
            'page.slug' => 'required|alpha_dash|unique:pages,slug,' . $this->page?->id,
        ]);

        $this->page->update([
            'blocks' => $this->blocks,
            'title' => $this->page->title,
            'slug' => $this->page->slug,
        ]);

        $this->isDirty = false;
        $this->dispatch('page-saved');
    }

    public function saveDraft(): void
    {
        $this->page->update([
            'blocks' => $this->blocks,
            'status' => 'draft',
        ]);
        $this->isDirty = false;
    }
}
```

## Drafts & Scheduling

### Publishing States

| State | Description | Visible on Frontend |
|-------|-------------|-------------------|
| `draft` | Work in progress | No |
| `review` | Submitted for review | No |
| `scheduled` | Set to publish at a future date | No |
| `published` | Live on the site | Yes |
| `archived` | Removed from public view | No |
| `trashed` | Soft-deleted | No |

### Scheduling Configuration

```php
// Scheduled publishing via Laravel Scheduler
Schedule::command('pages:publish-scheduled')
    ->everyMinute()
    ->withoutOverlapping();

// In PublishScheduled command:
public function handle(): int
{
    $pages = Page::where('status', 'scheduled')
        ->where('publish_at', '<=', now())
        ->get();

    foreach ($pages as $page) {
        $page->update(['status' => 'published', 'published_at' => now()]);
        $page->createRevision('scheduled-publish');
    }

    return $pages->count();
}
```

### Draft Auto-Save

| Feature | Configuration | Default |
|---------|--------------|---------|
| Auto-save interval | `auto_save_interval` | 30 seconds |
| Auto-save on blur | `auto_save_on_blur` | `true` |
| Draft conflict detection | `conflict_detection` | `true` |
| Max drafts per page | `max_drafts` | 10 |
| Draft retention | `draft_retention_days` | 90 |

## Revisions

### Revision Tracking

| Field | Type | Description |
|-------|------|-------------|
| `id` | `bigint` | Primary key |
| `page_id` | `bigint` | Foreign key to pages |
| `user_id` | `bigint` | User who created the revision |
| `type` | `string` | `auto-save`, `manual`, `publish`, `rollback` |
| `payload` | `json` | Serialized page state |
| `summary` | `text` | Human-readable change summary |
| `created_at` | `timestamp` | Revision timestamp |

### Revision API

```php
class Page extends Model
{
    public function revisions(): HasMany
    {
        return $this->hasMany(PageRevision::class);
    }

    public function createRevision(string $type = 'manual'): PageRevision
    {
        return $this->revisions()->create([
            'user_id' => auth()->id(),
            'type' => $type,
            'payload' => [
                'title' => $this->title,
                'slug' => $this->slug,
                'blocks' => $this->blocks,
                'seo' => $this->seo,
                'settings' => $this->settings,
            ],
            'summary' => $this->generateRevisionSummary(),
        ]);
    }

    public function rollbackTo(int $revisionId): void
    {
        $revision = $this->revisions()->findOrFail($revisionId);
        $this->createRevision('pre-rollback');

        $this->update($revision->payload);
        $this->createRevision('rollback');
    }
}
```

## SEO Fields

| Field | Type | Max Length | Required |
|-------|------|-----------|----------|
| `meta_title` | `string` | 60 chars | Yes |
| `meta_description` | `string` | 160 chars | Yes |
| `meta_keywords` | `string` | 255 chars | No |
| `og_title` | `string` | 95 chars | No (falls back to `meta_title`) |
| `og_description` | `string` | 200 chars | No (falls back to `meta_description`) |
| `og_image` | `string` | — | No |
| `canonical_url` | `string` | 2048 chars | No |
| `robots_index` | `boolean` | — | Default `true` |
| `robots_follow` | `boolean` | — | Default `true` |
| `schema_type` | `string` | — | No |
| `schema_data` | `json` | — | No |

### SEO Schema Markup

```php
// Auto-generated JSON-LD from page data
$page->getSchemaMarkup();
// Returns: Article, WebPage, BreadcrumbList, etc.

// Custom schema override
$page->setSchemaMarkup([
    '@type' => 'FAQPage',
    'mainEntity' => $this->getFaqEntities(),
]);
```

## Database Schema

```sql
CREATE TABLE pages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL DEFAULT 'static',
    content LONGTEXT NULL,
    blocks JSON NULL,
    seo JSON NULL,
    settings JSON NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'draft',
    publish_at TIMESTAMP NULL,
    published_at TIMESTAMP NULL,
    template VARCHAR(100) NULL,
    author_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_homepage BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    UNIQUE KEY pages_slug_unique (slug),
    KEY pages_status_index (status),
    KEY pages_type_index (type),
    CONSTRAINT pages_author FOREIGN KEY (author_id) REFERENCES users(id),
    CONSTRAINT pages_parent FOREIGN KEY (parent_id) REFERENCES pages(id)
);
```

## Access Control

| Permission | Description | Default Role |
|------------|-------------|-------------|
| `pages.create` | Create new pages | Editor |
| `pages.edit-any` | Edit any page | Editor |
| `pages.edit-own` | Edit own pages | Author |
| `pages.delete` | Delete pages | Admin |
| `pages.publish` | Publish/unpublish pages | Editor |
| `pages.schedule` | Schedule page publishing | Editor |
| `pages.revisions` | View/restore revisions | Editor |
| `pages.seo` | Edit SEO fields | SEO Manager |
| `pages.builder` | Use page builder | Editor |
| `pages.assign-template` | Change page template | Admin |

## Livewire Components

| Component | Namespace | Description |
|-----------|-----------|-------------|
| `page-builder` | `App\Livewire\Cms\Pages\PageBuilder` | Drag-drop page builder |
| `page-list` | `App\Livewire\Cms\Pages\PageList` | Paginated page listing |
| `page-editor` | `App\Livewire\Cms\Pages\PageEditor` | Page metadata editor |
| `page-revisions` | `App\Livewire\Cms\Pages\PageRevisions` | Revision history panel |
| `page-seo` | `App\Livewire\Cms\Pages\PageSeo` | SEO fields editor |
| `page-preview` | `App\Livewire\Cms\Pages\PagePreview` | Live preview panel |

## Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/admin/pages` | `pages.index` | List all pages |
| GET | `/admin/pages/create` | `pages.create` | Create page form |
| POST | `/admin/pages` | `pages.store` | Store new page |
| GET | `/admin/pages/{page}` | `pages.show` | View page details |
| GET | `/admin/pages/{page}/edit` | `pages.edit` | Edit page form |
| PUT | `/admin/pages/{page}` | `pages.update` | Update page |
| DELETE | `/admin/pages/{page}` | `pages.destroy` | Delete page |
| POST | `/admin/pages/{page}/publish` | `pages.publish` | Publish page |
| POST | `/admin/pages/{page}/revisions` | `pages.revisions.index` | List revisions |
| POST | `/admin/pages/{page}/rollback/{revision}` | `pages.revisions.rollback` | Restore revision |
| GET | `/{slug}` | `pages.front.show` | Public page view |

## Acceptance Criteria

- [ ] Users can create pages from multiple predefined types
- [ ] Page builder supports drag-and-drop block arrangement
- [ ] Auto-save preserves work every 30 seconds
- [ ] All page changes are tracked as revisions
- [ ] Users can rollback to any previous revision
- [ ] Scheduling publishes pages at the specified time
- [ ] SEO fields validate character limits and required values
- [ ] Page slugs are unique and auto-generated from title
- [ ] Soft-deleted pages can be restored within 30 days
- [ ] Pages render correctly on the frontend with proper SEO tags
