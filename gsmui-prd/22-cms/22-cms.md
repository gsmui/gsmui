# 22 - CMS

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The CMS manages static pages, navigation menus, and reusable content blocks for the GsmUi platform.

---

# Vision

Provide a flexible, block-based content management system that powers all static content while remaining simple enough for non-technical users.

---

# Core Features

## Content Types

* Static pages
* Landing pages
* Legal pages (terms, privacy)
* FAQ pages
* About pages
* Contact pages
* Custom pages

## Block System

* Heading blocks
* Rich text blocks
* Image blocks
* Video blocks
* Code blocks
* Component blocks
* CTA blocks
* Testimonial blocks
* Feature grid blocks
* FAQ blocks

## Navigation

* Main navigation
* Footer navigation
* Sidebar navigation
* Breadcrumbs
* Mega menus

---

# CMS Architecture

```text
CMS

├── Pages
│   ├── Static Pages
│   ├── Landing Pages
│   └── Legal Pages
├── Blocks
│   ├── Text Blocks
│   ├── Media Blocks
│   ├── Component Blocks
│   └── Custom Blocks
├── Navigation
│   ├── Primary Menu
│   ├── Footer Menu
│   └── Sidebar Menu
└── Media
    ├── Images
    ├── Videos
    └── Documents
```

---

# Page Builder

## Visual Editor

```text
┌─────────────────────────────────────────────────────┐
│ Page Editor: Home                    [Preview] [Save]│
├───────────┬─────────────────────────────────────────┤
│           │                                         │
│ Blocks    │        Canvas                           │
│           │                                         │
│ ─────────│  ┌─────────────────────────────────┐   │
│ Text     │  │ [Hero Block]                     │   │
│ Heading  │  │ Title: Welcome to GsmUi          │   │
│ Image    │  │ Subtitle: Build faster...        │   │
│ Video    │  │ CTA: [Get Started]               │   │
│ Code     │  └─────────────────────────────────┘   │
│ CTA      │                                         │
│ Feature  │  ┌─────────────────────────────────┐   │
│ Testimony │  │ [Features Block]                │   │
│ FAQ      │  │ 3-column grid                    │   │
│ Component│  │ [Feature] [Feature] [Feature]    │   │
│ Divider  │  └─────────────────────────────────┘   │
│ Spacer   │                                         │
│          │  ┌─────────────────────────────────┐   │
│ Settings │  │ [CTA Block]                      │   │
│ ─────────│  │ Ready to start?                  │   │
│ SEO      │  │ [Sign Up Free]                   │   │
│ Layout   │  └─────────────────────────────────┘   │
│ Style    │                                         │
│          │                                         │
└───────────┴─────────────────────────────────────────┘
```

---

# Block Types

## Text Blocks

```yaml
heading:
  level: [h1, h2, h3, h4, h5, h6]
  text: "Welcome"
  align: [left, center, right]

rich_text:
  content: "HTML/Markdown content"
  align: [left, center, right]
```

## Media Blocks

```yaml
image:
  src: "/images/hero.jpg"
  alt: "Hero image"
  caption: "Optional caption"
  width: [full, contained]
  lazy: true

video:
  src: "https://youtube.com/..."
  poster: "/images/poster.jpg"
  autoplay: false
```

## Component Blocks

```yaml
component:
  name: "gsmui:button"
  props:
    variant: "primary"
    size: "lg"
  slot: "Get Started"
```

## Layout Blocks

```yaml
grid:
  columns: [1, 2, 3, 4]
  gap: 4
  responsive:
    mobile: 1
    tablet: 2
    desktop: 3

section:
  padding: [sm, md, lg, xl]
  background: [white, gray, primary]
```

---

# Navigation Management

## Menu Structure

```yaml
primary:
  - label: "Components"
    url: "/components"
    children:
      - label: "Actions"
        url: "/components/actions"
      - label: "Forms"
        url: "/components/forms"
  - label: "Templates"
    url: "/templates"
  - label: "Pricing"
    url: "/pricing"
  - label: "Blog"
    url: "/blog"

footer:
  - label: "Product"
    links:
      - label: "Components"
        url: "/components"
      - label: "Templates"
        url: "/templates"
  - label: "Company"
    links:
      - label: "About"
        url: "/about"
      - label: "Blog"
        url: "/blog"
```

---

# SEO Management

## Per-Page SEO

```yaml
seo:
  title: "GsmUi - Laravel UI Components"
  description: "Build beautiful Laravel applications faster"
  og_image: "/images/og-home.png"
  canonical: "https://gsmui.com"
  robots: "index, follow"
  schema: "Organization"
```

## Global SEO

* Default title pattern
* Default description
* Social media profiles
* Structured data
* Sitemap settings

---

# Revision System

## Features

* Automatic revisions on save
* Manual revision points
* Diff viewer
* Restore previous versions
* Compare revisions

---

# User Roles

| Role | Permissions |
|------|-------------|
| Admin | Full access |
| Editor | Create/edit/publish |
| Author | Create/edit own |
| Viewer | Read only |

---

# Technical Architecture

```text
Frontend (Livewire)
    ↓
CMS Service
    ├── Page Service
    ├── Block Service
    ├── Navigation Service
    ├── Media Service
    └── Revision Service
    ↓
Database (MySQL)
Storage (S3 - media)
Cache (Redis)
```

---

# Database Schema

Key tables:

* `cms_pages` — Page records
* `cms_blocks` — Page blocks
* `cms_block_types` — Block definitions
* `cms_navigations` — Menu structures
* `cms_revisions` — Page revisions
* `cms_media` — Media library

---

# Admin Features

* Visual page editor
* Block manager
* Navigation manager
* Media manager
* SEO tools
* Revision history
* Preview mode
* Publish workflow

---

# Success Metrics

* 100+ managed pages
* <100ms page load
* 90%+ content team satisfaction
* 100% SEO score
* Zero downtime publishing

---

# Database Schema (Extended)

## cms_pages

```sql
CREATE TABLE cms_pages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) UNIQUE NOT NULL,
    slug VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) NULL,
    content LONGTEXT NULL,
    excerpt TEXT NULL,
    page_type ENUM('static','landing','legal','faq','about','contact','custom') NOT NULL DEFAULT 'static',
    status ENUM('draft','review','published','archived') NOT NULL DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    featured_image VARCHAR(500) NULL,
    template VARCHAR(255) NULL,
    layout VARCHAR(255) NULL,
    author_id BIGINT UNSIGNED NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    og_image VARCHAR(500) NULL,
    canonical_url VARCHAR(500) NULL,
    robots_index BOOLEAN DEFAULT TRUE,
    robots_follow BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    is_homepage BOOLEAN DEFAULT FALSE,
    custom_fields JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    INDEX idx_slug (slug),
    INDEX idx_page_type (page_type),
    INDEX idx_status (status),
    INDEX idx_author (author_id),
    INDEX idx_published_at (published_at),
    FULLTEXT idx_fulltext (title, content, excerpt)
);
```

## cms_blocks

```sql
CREATE TABLE cms_blocks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) UNIQUE NOT NULL,
    page_id BIGINT UNSIGNED NOT NULL,
    block_type VARCHAR(255) NOT NULL,
    block_key VARCHAR(255) NOT NULL,
    data JSON NOT NULL,
    sort_order INT DEFAULT 0,
    is_visible BOOLEAN DEFAULT TRUE,
    conditions JSON NULL,
    styles JSON NULL,
    animations JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_page (page_id),
    INDEX idx_type (block_type),
    INDEX idx_sort (sort_order),
    FOREIGN KEY (page_id) REFERENCES cms_pages(id) ON DELETE CASCADE
);
```

## cms_block_types

```sql
CREATE TABLE cms_block_types (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    category VARCHAR(255) NOT NULL,
    icon VARCHAR(255) NULL,
    component VARCHAR(255) NOT NULL,
    preview_component VARCHAR(255) NULL,
    schema JSON NOT NULL,
    defaults JSON NULL,
    is_repeatable BOOLEAN DEFAULT TRUE,
    max_per_page INT NULL,
    allowed_parents JSON NULL,
    allowed_children JSON NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_slug (slug)
);
```

## cms_navigations

```sql
CREATE TABLE cms_navigations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    items JSON NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
);
```

## cms_navigation_items

```sql
CREATE TABLE cms_navigation_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    navigation_id BIGINT UNSIGNED NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    label VARCHAR(255) NOT NULL,
    url VARCHAR(500) NULL,
    page_id BIGINT UNSIGNED NULL,
    icon VARCHAR(255) NULL,
    target ENUM('_self','_blank','_parent','_top') DEFAULT '_self',
    css_class VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    conditions JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_navigation (navigation_id),
    INDEX idx_parent (parent_id),
    INDEX idx_sort (sort_order),
    FOREIGN KEY (navigation_id) REFERENCES cms_navigations(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES cms_navigation_items(id) ON DELETE CASCADE,
    FOREIGN KEY (page_id) REFERENCES cms_pages(id) ON DELETE SET NULL
);
```

## cms_revisions

```sql
CREATE TABLE cms_revisions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    revision_type ENUM('auto','manual','publish','restore') NOT NULL DEFAULT 'auto',
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    content LONGTEXT NULL,
    blocks JSON NOT NULL,
    metadata JSON NULL,
    diff JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_page (page_id),
    INDEX idx_user (user_id),
    INDEX idx_created (created_at),
    FOREIGN KEY (page_id) REFERENCES cms_pages(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## cms_media

```sql
CREATE TABLE cms_media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) UNIQUE NOT NULL,
    filename VARCHAR(500) NOT NULL,
    original_filename VARCHAR(500) NOT NULL,
    mime_type VARCHAR(255) NOT NULL,
    file_size BIGINT UNSIGNED NOT NULL,
    path VARCHAR(500) NOT NULL,
    disk VARCHAR(50) DEFAULT 'public',
    alt_text VARCHAR(255) NULL,
    caption TEXT NULL,
    folder VARCHAR(255) NULL,
    tags JSON NULL,
    metadata JSON NULL,
    uploaded_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_mime (mime_type),
    INDEX idx_folder (folder),
    INDEX idx_uploaded (uploaded_by),
    FULLTEXT idx_search (filename, alt_text, caption)
);
```

## cms_page_media

```sql
CREATE TABLE cms_page_media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id BIGINT UNSIGNED NOT NULL,
    media_id BIGINT UNSIGNED NOT NULL,
    field_name VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_page (page_id),
    INDEX idx_media (media_id),
    FOREIGN KEY (page_id) REFERENCES cms_pages(id) ON DELETE CASCADE,
    FOREIGN KEY (media_id) REFERENCES cms_media(id) ON DELETE CASCADE
);
```

## cms_seo_settings

```sql
CREATE TABLE cms_seo_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id BIGINT UNSIGNED NULL,
    route_name VARCHAR(255) NULL,
    title_pattern VARCHAR(255) NULL,
    description TEXT NULL,
    og_title VARCHAR(255) NULL,
    og_description TEXT NULL,
    og_image VARCHAR(500) NULL,
    twitter_title VARCHAR(255) NULL,
    twitter_description TEXT NULL,
    twitter_image VARCHAR(500) NULL,
    canonical_url VARCHAR(500) NULL,
    robots_index BOOLEAN DEFAULT TRUE,
    robots_follow BOOLEAN DEFAULT TRUE,
    robots_noarchive BOOLEAN DEFAULT FALSE,
    robots_nosnippet BOOLEAN DEFAULT FALSE,
    structured_data JSON NULL,
    hreflang JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_page (page_id),
    INDEX idx_route (route_name),
    FOREIGN KEY (page_id) REFERENCES cms_pages(id) ON DELETE CASCADE
);
```

---

# Block System (Extended)

## Block Registry

```php
<?php

namespace App\Cms\Blocks;

class BlockRegistry
{
    protected array $blocks = [];

    public function register(string $type, string $class): void
    {
        $this->blocks[$type] = $class;
    }

    public function get(string $type): ?string
    {
        return $this->blocks[$type] ?? null;
    }

    public function all(): array
    {
        return $this->blocks;
    }

    public function getByCategory(string $category): array
    {
        return array_filter($this->blocks, function ($class) use ($category) {
            return $class::category() === $category;
        });
    }
}
```

## Block Interface

```php
<?php

namespace App\Cms\Blocks;

use Illuminate\View\View;

interface BlockInterface
{
    public static function type(): string;
    public static function name(): string;
    public static function description(): string;
    public static function category(): string;
    public static function icon(): string;
    public static function schema(): array;
    public static function defaults(): array;
    public static function preview(array $data): View;
    public static function edit(array $data): View;
    public static function validate(array $data): array;
    public static function toHtml(array $data): string;
    public static function isRepeatable(): bool;
    public static function maxPerPage(): ?int;
    public static function allowedParents(): ?array;
    public static function allowedChildren(): ?array;
}
```

## Block Base Class

```php
<?php

namespace App\Cms\Blocks;

abstract class BaseBlock implements BlockInterface
{
    public static function icon(): string
    {
        return 'heroicon-o-squares-2x2';
    }

    public static function defaults(): array
    {
        return [];
    }

    public static function isRepeatable(): bool
    {
        return true;
    }

    public static function maxPerPage(): ?int
    {
        return null;
    }

    public static function allowedParents(): ?array
    {
        return null;
    }

    public static function allowedChildren(): ?array
    {
        return null;
    }

    public static function validate(array $data): array
    {
        return [];
    }

    protected static function mergeDefaults(array $data): array
    {
        return array_merge(static::defaults(), $data);
    }

    protected static function sanitizeHtml(string $html): string
    {
        return strip_tags($html, '<p><br><strong><em><u><a><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote><code><pre><img><figure><figcaption><table><thead><tbody><tr><th><td><div><span><hr>');
    }
}
```

## Concrete Block Examples

### Heading Block

```php
<?php

namespace App\Cms\Blocks;

use Illuminate\View\View;

class HeadingBlock extends BaseBlock
{
    public static function type(): string
    {
        return 'heading';
    }

    public static function name(): string
    {
        return 'Heading';
    }

    public static function description(): string
    {
        return 'A heading element with configurable level and alignment.';
    }

    public static function category(): string
    {
        return 'text';
    }

    public static function icon(): string
    {
        return 'heroicon-o-bars-3-bottom-left';
    }

    public static function schema(): array
    {
        return [
            'level' => ['type' => 'enum', 'values' => ['h1','h2','h3','h4','h5','h6'], 'default' => 'h2'],
            'text' => ['type' => 'string', 'required' => true],
            'align' => ['type' => 'enum', 'values' => ['left','center','right'], 'default' => 'left'],
            'color' => ['type' => 'color', 'default' => null],
            'id' => ['type' => 'string', 'default' => null],
            'classes' => ['type' => 'string', 'default' => null],
        ];
    }

    public static function defaults(): array
    {
        return [
            'level' => 'h2',
            'text' => '',
            'align' => 'left',
            'color' => null,
            'id' => null,
            'classes' => null,
        ];
    }

    public static function preview(array $data): View
    {
        return view('cms.blocks.heading', static::mergeDefaults($data));
    }

    public static function edit(array $data): View
    {
        return view('cms.blocks.heading-edit', static::mergeDefaults($data));
    }

    public static function validate(array $data): array
    {
        return [
            'text' => 'required|string|max:500',
            'level' => 'required|in:h1,h2,h3,h4,h5,h6',
            'align' => 'required|in:left,center,right',
        ];
    }

    public static function toHtml(array $data): string
    {
        $data = static::mergeDefaults($data);
        $tag = $data['level'];
        $id = $data['id'] ? " id=\"{$data['id']}\"" : '';
        $class = $data['classes'] ? " {$data['classes']}" : '';
        $align = " text-{$data['align']}";
        return "<{$tag}{$id} class=\"font-bold{$align}{$class}\">{$data['text']}</{$tag}>";
    }
}
```

### Rich Text Block

```php
<?php

namespace App\Cms\Blocks;

use Illuminate\View\View;

class RichTextBlock extends BaseBlock
{
    public static function type(): string
    {
        return 'rich_text';
    }

    public static function name(): string
    {
        return 'Rich Text';
    }

    public static function description(): string
    {
        return 'A rich text editor with full formatting options.';
    }

    public static function category(): string
    {
        return 'text';
    }

    public static function schema(): array
    {
        return [
            'content' => ['type' => 'html', 'required' => true],
            'align' => ['type' => 'enum', 'values' => ['left','center','right','justify'], 'default' => 'left'],
            'columns' => ['type' => 'int', 'min' => 1, 'max' => 4, 'default' => 1],
        ];
    }

    public static function defaults(): array
    {
        return [
            'content' => '',
            'align' => 'left',
            'columns' => 1,
        ];
    }

    public static function preview(array $data): View
    {
        return view('cms.blocks.rich-text', static::mergeDefaults($data));
    }

    public static function edit(array $data): View
    {
        return view('cms.blocks.rich-text-edit', static::mergeDefaults($data));
    }

    public static function validate(array $data): array
    {
        return [
            'content' => 'required|string',
            'align' => 'required|in:left,center,right,justify',
            'columns' => 'required|integer|min:1|max:4',
        ];
    }

    public static function toHtml(array $data): string
    {
        $data = static::mergeDefaults($data);
        $content = static::sanitizeHtml($data['content']);
        $align = " text-{$data['align']}";
        $columns = $data['columns'] > 1 ? " columns-{$data['columns']}" : '';
        return "<div class=\"prose prose-zinc dark:prose-invert{$align}{$columns}\">{$content}</div>";
    }
}
```

### Image Block

```php
<?php

namespace App\Cms\Blocks;

use Illuminate\View\View;

class ImageBlock extends BaseBlock
{
    public static function type(): string
    {
        return 'image';
    }

    public static function name(): string
    {
        return 'Image';
    }

    public static function description(): string
    {
        return 'An image with optional caption and responsive sizing.';
    }

    public static function category(): string
    {
        return 'media';
    }

    public static function schema(): array
    {
        return [
            'src' => ['type' => 'image', 'required' => true],
            'alt' => ['type' => 'string', 'default' => ''],
            'caption' => ['type' => 'string', 'default' => null],
            'width' => ['type' => 'enum', 'values' => ['full','contained','custom'], 'default' => 'full'],
            'custom_width' => ['type' => 'int', 'default' => null],
            'height' => ['type' => 'enum', 'values' => ['auto','custom'], 'default' => 'auto'],
            'custom_height' => ['type' => 'int', 'default' => null],
            'object_fit' => ['type' => 'enum', 'values' => ['cover','contain','fill','none','scale-down'], 'default' => 'cover'],
            'lazy' => ['type' => 'boolean', 'default' => true],
            'link_url' => ['type' => 'url', 'default' => null],
            'link_target' => ['type' => 'enum', 'values' => ['_self','_blank'], 'default' => '_self'],
        ];
    }

    public static function defaults(): array
    {
        return [
            'src' => '',
            'alt' => '',
            'caption' => null,
            'width' => 'full',
            'custom_width' => null,
            'height' => 'auto',
            'custom_height' => null,
            'object_fit' => 'cover',
            'lazy' => true,
            'link_url' => null,
            'link_target' => '_self',
        ];
    }

    public static function preview(array $data): View
    {
        return view('cms.blocks.image', static::mergeDefaults($data));
    }

    public static function edit(array $data): View
    {
        return view('cms.blocks.image-edit', static::mergeDefaults($data));
    }

    public static function validate(array $data): array
    {
        return [
            'src' => 'required|string',
            'alt' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'width' => 'required|in:full,contained,custom',
            'object_fit' => 'required|in:cover,contain,fill,none,scale-down',
        ];
    }

    public static function toHtml(array $data): string
    {
        $data = static::mergeDefaults($data);
        $loading = $data['lazy'] ? 'loading="lazy"' : '';
        $width = $data['width'] === 'custom' ? "width=\"{$data['custom_width']}\"" : '';
        $height = $data['height'] === 'custom' ? "height=\"{$data['custom_height']}\"" : '';
        $img = "<img src=\"{$data['src']}\" alt=\"{$data['alt']}\" class=\"object-{$data['object_fit']}\" {$loading} {$width} {$height}>";
        if ($data['link_url']) {
            $img = "<a href=\"{$data['link_url']}\" target=\"{$data['link_target']}\">{$img}</a>";
        }
        if ($data['caption']) {
            $img .= "<figcaption class=\"text-sm text-zinc-500 mt-2\">{$data['caption']}</figcaption>";
        }
        return "<figure>{$img}</figure>";
    }
}
```

---

# Page Builder Service

## PageService

```php
<?php

namespace App\Cms\Services;

use App\Cms\Models\Page;
use App\Cms\Models\Revision;
use App\Events\Cms\PageCreated;
use App\Events\Cms\PageUpdated;
use App\Events\Cms\PagePublished;
use App\Events\Cms\PageArchived;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PageService
{
    public function __construct(
        protected BlockService $blockService,
        protected RevisionService $revisionService,
        protected SeoService $seoService,
        protected MediaService $mediaService,
    ) {}

    public function create(array $data): Page
    {
        return DB::transaction(function () use ($data) {
            $page = Page::create([
                'slug' => $this->generateSlug($data['title']),
                'title' => $data['title'],
                'subtitle' => $data['subtitle'] ?? null,
                'page_type' => $data['page_type'] ?? 'static',
                'status' => 'draft',
                'author_id' => auth()->id(),
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'template' => $data['template'] ?? null,
                'layout' => $data['layout'] ?? null,
            ]);

            if (!empty($data['blocks'])) {
                $this->blockService->syncBlocks($page, $data['blocks']);
            }

            if (!empty($data['seo'])) {
                $this->seoService->updateSeo($page, $data['seo']);
            }

            $this->revisionService->createRevision($page, 'auto', 'Page created');
            event(new PageCreated($page->id, $page->toArray()));
            return $page;
        });
    }

    public function update(Page $page, array $data): Page
    {
        return DB::transaction(function () use ($page, $data) {
            $page->update(collect($data)->only([
                'title', 'subtitle', 'page_type', 'slug',
                'meta_title', 'meta_description', 'template', 'layout',
                'featured_image', 'custom_fields',
            ])->toArray());

            if (isset($data['blocks'])) {
                $this->blockService->syncBlocks($page, $data['blocks']);
            }

            if (isset($data['seo'])) {
                $this->seoService->updateSeo($page, $data['seo']);
            }

            $this->revisionService->createRevision($page, 'auto', 'Page updated');
            event(new PageUpdated($page->id, $page->toArray()));
            return $page;
        });
    }

    public function publish(Page $page): Page
    {
        return DB::transaction(function () use ($page) {
            $page->update([
                'status' => 'published',
                'published_at' => now(),
            ]);
            $this->revisionService->createRevision($page, 'publish', 'Page published');
            event(new PagePublished($page->id, $page->toArray()));
            return $page;
        });
    }

    public function archive(Page $page): Page
    {
        return DB::transaction(function () use ($page) {
            $page->update(['status' => 'archived']);
            $this->revisionService->createRevision($page, 'auto', 'Page archived');
            event(new PageArchived($page->id, $page->toArray()));
            return $page;
        });
    }

    public function restore(Page $page, Revision $revision): Page
    {
        return DB::transaction(function () use ($page, $revision) {
            $page->update([
                'title' => $revision->title,
                'slug' => $revision->slug,
                'content' => $revision->content,
            ]);
            $this->blockService->syncBlocks($page, $revision->blocks);
            $this->revisionService->createRevision($page, 'restore', "Restored to revision {$revision->id}");
            return $page;
        });
    }

    public function getBySlug(string $slug): ?Page
    {
        return Cache::remember("page:{$slug}", now()->addHours(24), function () use ($slug) {
            return Page::where('slug', $slug)
                ->where('status', 'published')
                ->with(['blocks', 'seo'])
                ->first();
        });
    }

    public function getByType(string $type, int $limit = 20, int $offset = 0): array
    {
        $cacheKey = "pages:type:{$type}:{$limit}:{$offset}";
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($type, $limit, $offset) {
            return Page::where('page_type', $type)
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->orderBy('published_at', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->toArray();
        });
    }

    public function search(string $query, int $limit = 20): array
    {
        return Page::where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%")
                  ->orWhere('excerpt', 'LIKE', "%{$query}%");
            })
            ->limit($limit)
            ->get()
            ->toArray();
    }

    protected function generateSlug(string $title): string
    {
        $slug = str($title)->slug()->toString();
        $originalSlug = $slug;
        $counter = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        return $slug;
    }
}
```

## BlockService

```php
<?php

namespace App\Cms\Services;

use App\Cms\Models\Page;
use App\Cms\Models\Block;
use App\Cms\Blocks\BlockRegistry;

class BlockService
{
    public function __construct(
        protected BlockRegistry $registry
    ) {}

    public function syncBlocks(Page $page, array $blocksData): void
    {
        $existingIds = collect($blocksData)->pluck('id')->filter()->toArray();
        $page->blocks()->whereNotIn('id', $existingIds)->delete();

        foreach ($blocksData as $index => $blockData) {
            $block = $page->blocks()->updateOrCreate(
                ['id' => $blockData['id'] ?? null],
                [
                    'block_type' => $blockData['type'],
                    'block_key' => $blockData['key'] ?? $blockData['type'] . '_' . ($index + 1),
                    'data' => $blockData['data'] ?? [],
                    'sort_order' => $index,
                    'is_visible' => $blockData['visible'] ?? true,
                    'conditions' => $blockData['conditions'] ?? null,
                    'styles' => $blockData['styles'] ?? null,
                    'animations' => $blockData['animations'] ?? null,
                ]
            );

            if (!empty($blockData['children'])) {
                $this->syncBlocks($block, $blockData['children']);
            }
        }
    }

    public function renderBlock(Block $block): string
    {
        $blockClass = $this->registry->get($block->block_type);
        if (!$blockClass) {
            return "<!-- Unknown block type: {$block->block_type} -->";
        }
        return $blockClass::toHtml($block->data);
    }

    public function renderPage(Page $page): string
    {
        $blocks = $page->blocks()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
        return $blocks->map(fn ($block) => $this->renderBlock($block))->implode("\n");
    }

    public function getBlockTypes(): array
    {
        return $this->registry->all();
    }

    public function getBlockTypesByCategory(): array
    {
        $blocks = $this->registry->all();
        $grouped = [];
        foreach ($blocks as $type => $class) {
            $category = $class::category();
            $grouped[$category][] = [
                'type' => $type,
                'name' => $class::name(),
                'description' => $class::description(),
                'icon' => $class::icon(),
                'schema' => $class::schema(),
            ];
        }
        return $grouped;
    }
}
```

---

# Navigation Manager

## NavigationService

```php
<?php

namespace App\Cms\Services;

use App\Cms\Models\Navigation;
use App\Cms\Models\NavigationItem;
use Illuminate\Support\Facades\Cache;

class NavigationService
{
    public function create(array $data): Navigation
    {
        $navigation = Navigation::create([
            'name' => $data['name'],
            'slug' => $this->generateSlug($data['name']),
            'description' => $data['description'] ?? null,
            'items' => $data['items'] ?? [],
            'is_active' => $data['is_active'] ?? true,
        ]);
        $this->syncItems($navigation, $data['items'] ?? []);
        return $navigation;
    }

    public function update(Navigation $navigation, array $data): Navigation
    {
        $navigation->update(collect($data)->only([
            'name', 'description', 'is_active',
        ])->toArray());
        $this->syncItems($navigation, $data['items'] ?? []);
        return $navigation;
    }

    public function syncItems(Navigation $navigation, array $items): void
    {
        $navigation->items()->delete();
        foreach ($items as $index => $item) {
            $this->createItem($navigation, $item, null, $index);
        }
    }

    protected function createItem(Navigation $navigation, array $data, ?int $parentId, int $sortOrder): NavigationItem
    {
        $item = NavigationItem::create([
            'navigation_id' => $navigation->id,
            'parent_id' => $parentId,
            'label' => $data['label'],
            'url' => $data['url'] ?? null,
            'page_id' => $data['page_id'] ?? null,
            'icon' => $data['icon'] ?? null,
            'target' => $data['target'] ?? '_self',
            'css_class' => $data['css_class'] ?? null,
            'sort_order' => $sortOrder,
            'is_active' => $data['is_active'] ?? true,
            'conditions' => $data['conditions'] ?? null,
        ]);

        if (!empty($data['children'])) {
            foreach ($data['children'] as $childIndex => $child) {
                $this->createItem($navigation, $child, $item->id, $childIndex);
            }
        }
        return $item;
    }

    public function getForRendering(string $slug): array
    {
        return Cache::remember("navigation:{$slug}", now()->addHours(24), function () use ($slug) {
            $navigation = Navigation::where('slug', $slug)
                ->where('is_active', true)
                ->first();
            if (!$navigation) {
                return [];
            }
            return $this->buildTree($navigation->items()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get());
        });
    }

    protected function buildTree($items, $parentId = null): array
    {
        $tree = [];
        foreach ($items as $item) {
            if ($item->parent_id === $parentId) {
                $children = $this->buildTree($items, $item->id);
                $node = [
                    'label' => $item->label,
                    'url' => $item->url,
                    'page_id' => $item->page_id,
                    'icon' => $item->icon,
                    'target' => $item->target,
                    'css_class' => $item->css_class,
                ];
                if (!empty($children)) {
                    $node['children'] = $children;
                }
                $tree[] = $node;
            }
        }
        return $tree;
    }

    protected function generateSlug(string $name): string
    {
        $slug = str($name)->slug()->toString();
        $originalSlug = $slug;
        $counter = 1;
        while (Navigation::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        return $slug;
    }
}
```

---

# SEO Service

## SeoService

```php
<?php

namespace App\Cms\Services;

use App\Cms\Models\Page;
use App\Cms\Models\SeoSetting;
use Illuminate\Support\Facades\Cache;

class SeoService
{
    public function updateSeo(Page $page, array $data): SeoSetting
    {
        return SeoSetting::updateOrCreate(
            ['page_id' => $page->id],
            [
                'title_pattern' => $data['title_pattern'] ?? null,
                'description' => $data['description'] ?? null,
                'og_title' => $data['og_title'] ?? null,
                'og_description' => $data['og_description'] ?? null,
                'og_image' => $data['og_image'] ?? null,
                'twitter_title' => $data['twitter_title'] ?? null,
                'twitter_description' => $data['twitter_description'] ?? null,
                'twitter_image' => $data['twitter_image'] ?? null,
                'canonical_url' => $data['canonical_url'] ?? null,
                'robots_index' => $data['robots_index'] ?? true,
                'robots_follow' => $data['robots_follow'] ?? true,
                'robots_noarchive' => $data['robots_noarchive'] ?? false,
                'robots_nosnippet' => $data['robots_nosnippet'] ?? false,
                'structured_data' => $data['structured_data'] ?? null,
                'hreflang' => $data['hreflang'] ?? null,
            ]
        );
    }

    public function getSeoData(Page $page): array
    {
        $seo = $page->seo;
        $global = $this->getGlobalSeo();

        return [
            'title' => $this->resolveTitle($seo, $page, $global),
            'description' => $this->resolveDescription($seo, $page, $global),
            'og_title' => $seo->og_title ?? $global['og_title'] ?? $page->title,
            'og_description' => $seo->og_description ?? $global['og_description'] ?? $page->excerpt,
            'og_image' => $seo->og_image ?? $global['og_image'] ?? null,
            'twitter_title' => $seo->twitter_title ?? $global['twitter_title'] ?? null,
            'twitter_description' => $seo->twitter_description ?? $global['twitter_description'] ?? null,
            'twitter_image' => $seo->twitter_image ?? $global['twitter_image'] ?? null,
            'canonical_url' => $seo->canonical_url ?? url($page->slug),
            'robots' => $this->resolveRobots($seo),
            'structured_data' => $seo->structured_data ?? $global['structured_data'] ?? null,
            'hreflang' => $seo->hreflang ?? $global['hreflang'] ?? null,
        ];
    }

    protected function resolveTitle(?SeoSetting $seo, Page $page, array $global): string
    {
        if ($seo && $seo->title_pattern) {
            return str_replace(
                ['{title}', '{site_name}'],
                [$page->title, config('app.name', 'GsmUi')],
                $seo->title_pattern
            );
        }
        $prefix = $global['title_pattern'] ?? '{title} - ' . config('app.name', 'GsmUi');
        return str_replace('{title}', $page->title, $prefix);
    }

    protected function resolveDescription(?SeoSetting $seo, Page $page, array $global): string
    {
        return $seo->description ?? $global['description'] ?? $page->excerpt ?? '';
    }

    protected function resolveRobots(?SeoSetting $seo): string
    {
        $directives = [];
        $directives[] = ($seo->robots_index ?? true) ? 'index' : 'noindex';
        $directives[] = ($seo->robots_follow ?? true) ? 'follow' : 'nofollow';
        if ($seo->robots_noarchive ?? false) {
            $directives[] = 'noarchive';
        }
        if ($seo->robots_nosnippet ?? false) {
            $directives[] = 'nosnippet';
        }
        return implode(', ', $directives);
    }

    protected function getGlobalSeo(): array
    {
        return Cache::remember('seo:global', now()->addHours(24), function () {
            return SeoSetting::whereNull('page_id')
                ->whereNull('route_name')
                ->first()
                ?->toArray() ?? [];
        });
    }

    public function generateSitemap(): string
    {
        $pages = Page::where('status', 'published')
            ->where('robots_index', true)
            ->orderBy('published_at', 'desc')
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($pages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . url($page->slug) . '</loc>';
            $xml .= '<lastmod>' . $page->updated_at->format('Y-m-d') . '</lastmod>';
            $xml .= '<changefreq>' . $this->getChangeFreq($page->page_type) . '</changefreq>';
            $xml .= '<priority>' . $this->getPriority($page->page_type) . '</priority>';
            $xml .= '</url>';
        }
        $xml .= '</urlset>';
        return $xml;
    }

    protected function getChangeFreq(string $pageType): string
    {
        return match ($pageType) {
            'blog' => 'weekly',
            'landing' => 'monthly',
            'legal' => 'yearly',
            default => 'monthly',
        };
    }

    protected function getPriority(string $pageType): string
    {
        return match ($pageType) {
            'landing' => '0.8',
            'about' => '0.7',
            'blog' => '0.6',
            'legal' => '0.3',
            default => '0.5',
        };
    }
}
```

---

# Revision Service

## RevisionService

```php
<?php

namespace App\Cms\Services;

use App\Cms\Models\Page;
use App\Cms\Models\Revision;

class RevisionService
{
    public function createRevision(Page $page, string $type, string $note = null): Revision
    {
        $previousRevision = $page->revisions()->latest()->first();
        $currentBlocks = $page->blocks()->orderBy('sort_order')->get()->toArray();
        $diff = $previousRevision ? $this->computeDiff($previousRevision, $page, $currentBlocks) : null;

        return Revision::create([
            'page_id' => $page->id,
            'user_id' => auth()->id(),
            'revision_type' => $type,
            'title' => $page->title,
            'slug' => $page->slug,
            'content' => $page->content,
            'blocks' => $currentBlocks,
            'metadata' => ['note' => $note],
            'diff' => $diff,
        ]);
    }

    public function getRevisions(Page $page, int $limit = 50): \Illuminate\Support\Collection
    {
        return $page->revisions()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function compare(Revision $a, Revision $b): array
    {
        return [
            'title' => $this->diffValue($a->title, $b->title),
            'slug' => $this->diffValue($a->slug, $b->slug),
            'content' => $this->diffText($a->content, $b->content),
            'blocks' => $this->diffBlocks($a->blocks, $b->blocks),
        ];
    }

    protected function computeDiff(Revision $previous, Page $current, array $currentBlocks): array
    {
        $diff = [];
        if ($previous->title !== $current->title) {
            $diff['title'] = ['old' => $previous->title, 'new' => $current->title];
        }
        if ($previous->slug !== $current->slug) {
            $diff['slug'] = ['old' => $previous->slug, 'new' => $current->slug];
        }
        if ($previous->content !== $current->content) {
            $diff['content'] = ['changed' => true, 'length' => strlen($current->content ?? '')];
        }
        $diff['blocks'] = $this->diffBlocks($previous->blocks, $currentBlocks);
        return $diff;
    }

    protected function diffValue(mixed $old, mixed $new): array
    {
        return ['old' => $old, 'new' => $new, 'changed' => $old !== $new];
    }

    protected function diffText(?string $old, ?string $new): array
    {
        return [
            'old_length' => strlen($old ?? ''),
            'new_length' => strlen($new ?? ''),
            'changed' => $old !== $new,
        ];
    }

    protected function diffBlocks(array $oldBlocks, array $newBlocks): array
    {
        $oldIds = array_column($oldBlocks, 'id');
        $newIds = array_column($newBlocks, 'id');
        return [
            'added' => count(array_diff($newIds, $oldIds)),
            'removed' => count(array_diff($oldIds, $newIds)),
            'total_before' => count($oldBlocks),
            'total_after' => count($newBlocks),
        ];
    }

    public function restoreToRevision(Page $page, Revision $revision): Page
    {
        return app(PageService::class)->restore($page, $revision);
    }
}
```

---

# User Flow: Create and Publish a Page

```text
User clicks "New Page"
    ↓
Page creation form appears
    ├── Enter title (auto-generates slug)
    ├── Select page type (static/landing/legal/etc.)
    ├── Choose template
    └── Set layout
    ↓
Page created in "draft" status
    ↓
User enters page editor
    ├── Add blocks from sidebar
    │   ├── Drag block to canvas
    │   ├── Configure block settings
    │   └── Reorder blocks
    ├── Configure page settings
    │   ├── SEO metadata
    │   ├── Featured image
    │   └── Custom fields
    └── Preview page
    ↓
User clicks "Save"
    ├── Auto-revision created
    ├── Blocks synced to database
    └── Page remains in draft
    ↓
User clicks "Publish"
    ├── Status changes to "published"
    ├── published_at timestamp set
    ├── Cache invalidated
    ├── Sitemap updated
    └── Page is live
```

---

# User Flow: Edit Navigation Menu

```text
Admin opens Navigation Manager
    ↓
Selects menu to edit (e.g., "primary")
    ↓
Menu editor shows tree structure
    ├── Add menu item
    │   ├── Enter label
    │   ├── Set URL or select page
    │   ├── Choose icon
    │   └── Set target (_self/_blank)
    ├── Drag to reorder
    ├── Nest items for submenus
    ├── Edit existing items
    └── Delete items
    ↓
User clicks "Save Menu"
    ├── Menu items synced
    ├── Cache invalidated
    └── Navigation updated on frontend
```

---

# User Flow: Manage Revisions

```text
Editor opens page history panel
    ↓
List of revisions displayed
    ├── Auto-revisions (on each save)
    ├── Manual revisions (named points)
    └── Publish revisions
    ↓
User selects two revisions to compare
    ↓
Diff viewer shows:
    ├── Title changes
    ├── Content changes (side-by-side)
    ├── Block additions/removals
    └── Timestamp and author
    ↓
User clicks "Restore" on a revision
    ├── Confirmation dialog
    ├── Page content reverted
    ├── Blocks restored
    ├── New revision created (type: restore)
    └── Page remains in current status
```

---

# Livewire Component Architecture

## PageEditor Component

```php
<?php

namespace App\Http\Livewire\Cms;

use Livewire\Component;
use App\Cms\Services\PageService;
use App\Cms\Services\BlockService;

class PageEditor extends Component
{
    public $pageId;
    public $page;
    public $blocks = [];
    public $selectedBlock = null;
    public $showPreview = false;
    public $showSettings = false;
    public $activeTab = 'blocks';

    protected PageService $pageService;
    protected BlockService $blockService;

    public function boot(PageService $pageService, BlockService $blockService): void
    {
        $this->pageService = $pageService;
        $this->blockService = $blockService;
    }

    public function mount(int $pageId): void
    {
        $this->pageId = $pageId;
        $this->loadPage();
    }

    public function loadPage(): void
    {
        $this->page = $this->pageService->find($this->pageId);
        $this->blocks = $this->page->blocks()
            ->orderBy('sort_order')
            ->get()
            ->toArray();
    }

    public function addBlock(string $type): void
    {
        $blockClass = $this->blockService->getBlockTypes()[$type];
        $this->blocks[] = [
            'type' => $type,
            'key' => $type . '_' . (count($this->blocks) + 1),
            'data' => $blockClass::defaults(),
            'visible' => true,
        ];
        $this->selectedBlock = count($this->blocks) - 1;
    }

    public function updateBlockData(int $index, array $data): void
    {
        $this->blocks[$index]['data'] = array_merge(
            $this->blocks[$index]['data'],
            $data
        );
    }

    public function removeBlock(int $index): void
    {
        unset($this->blocks[$index]);
        $this->blocks = array_values($this->blocks);
        if ($this->selectedBlock === $index) {
            $this->selectedBlock = null;
        }
    }

    public function moveBlock(int $from, int $to): void
    {
        $block = $this->blocks[$from];
        unset($this->blocks[$from]);
        array_splice($this->blocks, $to, 0, [$block]);
        $this->blocks = array_values($this->blocks);
    }

    public function save(): void
    {
        $this->pageService->update($this->page, [
            'blocks' => $this->blocks,
        ]);
        $this->dispatch('page-saved');
    }

    public function publish(): void
    {
        $this->save();
        $this->pageService->publish($this->page);
        $this->dispatch('page-published');
    }

    public function render()
    {
        return view('livewire.cms.page-editor', [
            'blockTypes' => $this->blockService->getBlockTypesByCategory(),
        ]);
    }
}
```

---

# Livewire Component: NavigationManager

```php
<?php

namespace App\Http\Livewire\Cms;

use Livewire\Component;
use App\Cms\Services\NavigationService;
use App\Cms\Models\Navigation;

class NavigationManager extends Component
{
    public $navigations = [];
    public $selectedNav = null;
    public $navItems = [];
    public $editingItem = null;
    public $showItemForm = false;

    protected NavigationService $navigationService;

    public function boot(NavigationService $navigationService): void
    {
        $this->navigationService = $navigationService;
    }

    public function mount(): void
    {
        $this->loadNavigations();
    }

    public function loadNavigations(): void
    {
        $this->navigations = Navigation::all()->toArray();
    }

    public function selectNavigation(int $id): void
    {
        $this->selectedNav = Navigation::find($id);
        $this->navItems = $this->navigationService->getForRendering($this->selectedNav->slug);
    }

    public function addItem(array $data): void
    {
        $this->navItems[] = $data;
        $this->saveNavigation();
    }

    public function updateItem(int $index, array $data): void
    {
        $this->navItems[$index] = array_merge($this->navItems[$index], $data);
        $this->saveNavigation();
    }

    public function removeItem(int $index): void
    {
        unset($this->navItems[$index]);
        $this->navItems = array_values($this->navItems);
        $this->saveNavigation();
    }

    public function saveNavigation(): void
    {
        $this->navigationService->update($this->selectedNav, [
            'items' => $this->navItems,
        ]);
        $this->dispatch('navigation-saved');
    }

    public function render()
    {
        return view('livewire.cms.navigation-manager');
    }
}
```

---

# Livewire Component: RevisionHistory

```php
<?php

namespace App\Http\Livewire\Cms;

use Livewire\Component;
use App\Cms\Services\RevisionService;
use App\Cms\Models\Page;

class RevisionHistory extends Component
{
    public $pageId;
    public $revisions = [];
    public $compareA = null;
    public $compareB = null;
    public $diff = null;

    protected RevisionService $revisionService;

    public function boot(RevisionService $revisionService): void
    {
        $this->revisionService = $revisionService;
    }

    public function mount(int $pageId): void
    {
        $this->pageId = $pageId;
        $this->loadRevisions();
    }

    public function loadRevisions(): void
    {
        $page = Page::find($this->pageId);
        $this->revisions = $this->revisionService->getRevisions($page)->toArray();
    }

    public function selectForCompare(int $revisionId): void
    {
        if ($this->compareA === null) {
            $this->compareA = $revisionId;
        } elseif ($this->compareB === null) {
            $this->compareB = $revisionId;
            $this->computeDiff();
        } else {
            $this->compareA = $revisionId;
            $this->compareB = null;
            $this->diff = null;
        }
    }

    public function computeDiff(): void
    {
        $a = \App\Cms\Models\Revision::find($this->compareA);
        $b = \App\Cms\Models\Revision::find($this->compareB);
        $this->diff = $this->revisionService->compare($a, $b);
    }

    public function restore(int $revisionId): void
    {
        $page = Page::find($this->pageId);
        $revision = \App\Cms\Models\Revision::find($revisionId);
        $this->revisionService->restoreToRevision($page, $revision);
        $this->loadRevisions();
        $this->dispatch('revision-restored');
    }

    public function render()
    {
        return view('livewire.cms.revision-history');
    }
}
```

---

# CMS API Routes

```php
<?php

use App\Http\Controllers\Cms\PageController;
use App\Http\Controllers\Cms\BlockController;
use App\Http\Controllers\Cms\NavigationController;
use App\Http\Controllers\Cms\RevisionController;
use App\Http\Controllers\Cms\SeoController;
use Illuminate\Support\Facades\Route;

Route::prefix('cms')->middleware(['auth', 'verified'])->group(function () {
    // Pages
    Route::get('/pages', [PageController::class, 'index'])->name('cms.pages.index');
    Route::get('/pages/create', [PageController::class, 'create'])->name('cms.pages.create');
    Route::post('/pages', [PageController::class, 'store'])->name('cms.pages.store');
    Route::get('/pages/{page}', [PageController::class, 'show'])->name('cms.pages.show');
    Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('cms.pages.edit');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('cms.pages.update');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('cms.pages.destroy');
    Route::post('/pages/{page}/publish', [PageController::class, 'publish'])->name('cms.pages.publish');
    Route::post('/pages/{page}/archive', [PageController::class, 'archive'])->name('cms.pages.archive');
    Route::get('/pages/{page}/preview', [PageController::class, 'preview'])->name('cms.pages.preview');

    // Blocks
    Route::get('/blocks/types', [BlockController::class, 'types'])->name('cms.blocks.types');
    Route::post('/pages/{page}/blocks', [BlockController::class, 'store'])->name('cms.blocks.store');
    Route::put('/blocks/{block}', [BlockController::class, 'update'])->name('cms.blocks.update');
    Route::delete('/blocks/{block}', [BlockController::class, 'destroy'])->name('cms.blocks.destroy');
    Route::post('/blocks/reorder', [BlockController::class, 'reorder'])->name('cms.blocks.reorder');

    // Navigation
    Route::get('/navigations', [NavigationController::class, 'index'])->name('cms.navigations.index');
    Route::post('/navigations', [NavigationController::class, 'store'])->name('cms.navigations.store');
    Route::put('/navigations/{navigation}', [NavigationController::class, 'update'])->name('cms.navigations.update');
    Route::delete('/navigations/{navigation}', [NavigationController::class, 'destroy'])->name('cms.navigations.destroy');

    // Revisions
    Route::get('/pages/{page}/revisions', [RevisionController::class, 'index'])->name('cms.revisions.index');
    Route::get('/revisions/{revision}', [RevisionController::class, 'show'])->name('cms.revisions.show');
    Route::post('/revisions/{revision}/restore', [RevisionController::class, 'restore'])->name('cms.revisions.restore');
    Route::post('/revisions/compare', [RevisionController::class, 'compare'])->name('cms.revisions.compare');

    // SEO
    Route::put('/pages/{page}/seo', [SeoController::class, 'update'])->name('cms.seo.update');
    Route::get('/pages/{page}/seo', [SeoController::class, 'show'])->name('cms.seo.show');
});
```

---

# CMS PageController

```php
<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Cms\Models\Page;
use App\Cms\Services\PageService;
use App\Http\Requests\Cms\StorePageRequest;
use App\Http\Requests\Cms\UpdatePageRequest;

class PageController extends Controller
{
    public function __construct(
        protected PageService $pageService
    ) {}

    public function index()
    {
        $pages = Page::with('author')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
        return view('cms.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('cms.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $page = $this->pageService->create($request->validated());
        return redirect()->route('cms.pages.edit', $page)
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page)
    {
        return view('cms.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $page->load(['blocks', 'seo', 'media']);
        return view('cms.pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page = $this->pageService->update($page, $request->validated());
        return redirect()->route('cms.pages.edit', $page)
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('cms.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    public function publish(Page $page)
    {
        $this->pageService->publish($page);
        return back()->with('success', 'Page published successfully.');
    }

    public function archive(Page $page)
    {
        $this->pageService->archive($page);
        return back()->with('success', 'Page archived successfully.');
    }

    public function preview(Page $page)
    {
        $page->load(['blocks', 'seo']);
        return view('cms.pages.preview', compact('page'));
    }
}
```

---

# CMS Middleware

```php
<?php

namespace App\Http\Middleware\Cms;

use Closure;
use Illuminate\Http\Request;

class EnsurePageEditable
{
    public function handle(Request $request, Closure $next)
    {
        $page = $request->route('page');

        if ($page->status === 'published' && !$request->user()->can('publish-pages')) {
            return back()->with('error', 'You cannot edit published pages.');
        }

        return $next($request);
    }
}
```

```php
<?php

namespace App\Http\Middleware\Cms;

use Closure;
use Illuminate\Http\Request;

class EnsurePageAuthor
{
    public function handle(Request $request, Closure $next)
    {
        $page = $request->route('page');
        $user = $request->user();

        if ($page->author_id !== $user->id && !$user->can('edit-all-pages')) {
            return back()->with('error', 'You can only edit your own pages.');
        }

        return $next($request);
    }
}
```

---

# Blade Components

## Page Editor Layout

```blade
{{-- resources/views/cms/layouts/editor.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CMS Editor')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-zinc-100 dark:bg-zinc-900">
    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700 flex flex-col">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <a href="{{ route('cms.pages.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700">
                    &larr; Back to Pages
                </a>
                <h1 class="text-lg font-semibold mt-2">@yield('heading')</h1>
            </div>
            <nav class="flex-1 p-4 space-y-1">
                @yield('sidebar')
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 flex flex-col overflow-hidden">
            @yield('content')
        </main>
    </div>
    @livewireScripts
</body>
</html>
```

## Block Editor Component

```blade
{{-- resources/views/cms/components/block-editor.blade.php --}}
<div class="block-editor" wire:ignore.self>
    <div class="flex items-center justify-between p-4 border-b">
        <h2 class="text-lg font-semibold">Blocks</h2>
        <div class="flex gap-2">
            <button wire:click="save" class="btn btn-primary">Save</button>
            <button wire:click="publish" class="btn btn-success">Publish</button>
        </div>
    </div>

    <div class="flex flex-1 overflow-hidden">
        {{-- Block Sidebar --}}
        <div class="w-48 border-r p-4 space-y-2">
            @foreach($blockTypes as $category => $blocks)
                <div class="mb-4">
                    <h3 class="text-xs font-medium text-zinc-500 uppercase mb-2">{{ $category }}</h3>
                    @foreach($blocks as $block)
                        <button
                            wire:click="addBlock('{{ $block['type'] }}')"
                            class="w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-zinc-100 flex items-center gap-2"
                        >
                            <x-dynamic-component :component="$block['icon']" class="w-4 h-4" />
                            {{ $block['name'] }}
                        </button>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{-- Canvas --}}
        <div class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-4xl mx-auto space-y-4">
                @forelse($blocks as $index => $block)
                    <div
                        class="block-item border-2 rounded-lg p-4 {{ $selectedBlock === $index ? 'border-blue-500' : 'border-transparent hover:border-zinc-300' }}"
                        wire:click="selectBlock({{ $index }})"
                        draggable="true"
                        wire:dragstart="startDrag({{ $index }})"
                        wire:drop="dropBlock({{ $index }})"
                    >
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-zinc-500">{{ $block['type'] }}</span>
                            <div class="flex gap-1">
                                <button wire:click="moveBlock({{ $index }}, {{ $index - 1 }})" class="p-1 hover:bg-zinc-100 rounded">&uarr;</button>
                                <button wire:click="moveBlock({{ $index }}, {{ $index + 1 }})" class="p-1 hover:bg-zinc-100 rounded">&darr;</button>
                                <button wire:click="removeBlock({{ $index }})" class="p-1 hover:bg-red-100 text-red-600 rounded">&times;</button>
                            </div>
                        </div>
                        <x-dynamic-component
                            :component="'cms.blocks.' . $block['type']"
                            :data="$block['data']"
                        />
                    </div>
                @empty
                    <div class="text-center py-16 text-zinc-400">
                        <p>No blocks yet. Add a block from the sidebar.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Settings Panel --}}
        @if($selectedBlock !== null)
            <div class="w-80 border-l p-4 overflow-y-auto">
                <h3 class="font-medium mb-4">Block Settings</h3>
                @php $blockData = $blocks[$selectedBlock]; @endphp
                @foreach($blockTypes[$blockData['type']]??[] as $field)
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">{{ $field['label'] }}</label>
                        @if($field['type'] === 'text')
                            <input
                                type="text"
                                wire:model="blocks.{{ $selectedBlock }}.data.{{ $field['key'] }}"
                                class="input"
                            >
                        @elseif($field['type'] === 'textarea')
                            <textarea
                                wire:model="blocks.{{ $selectedBlock }}.data.{{ $field['key'] }}"
                                class="input"
                                rows="3"
                            ></textarea>
                        @elseif($field['type'] === 'select')
                            <select wire:model="blocks.{{ $selectedBlock }}.data.{{ $field['key'] }}" class="input">
                                @foreach($field['options'] as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
```

---

# CMS Events

```php
<?php

namespace App\Events\Cms;

use Illuminate\Foundation\Events\Dispatchable;

class PageCreated
{
    use Dispatchable;

    public function __construct(
        public int $pageId,
        public array $data
    ) {}
}
```

```php
<?php

namespace App\Events\Cms;

use Illuminate\Foundation\Events\Dispatchable;

class PagePublished
{
    use Dispatchable;

    public function __construct(
        public int $pageId,
        public array $data
    ) {}
}
```

```php
<?php

namespace App\Events\Cms;

use Illuminate\Foundation\Events\Dispatchable;

class PageUpdated
{
    use Dispatchable;

    public function __construct(
        public int $pageId,
        public array $data
    ) {}
}
```

```php
<?php

namespace App\Events\Cms;

use Illuminate\Foundation\Events\Dispatchable;

class PageArchived
{
    use Dispatchable;

    public function __construct(
        public int $pageId,
        public array $data
    ) {}
}
```

---

# CMS Listeners

```php
<?php

namespace App\Listeners\Cms;

use App\Events\Cms\PagePublished;
use Illuminate\Support\Facades\Cache;

class InvalidatePageCache
{
    public function handle(PagePublished $event): void
    {
        Cache::forget("page:{$event->data['slug']}");
        Cache::forget("pages:type:{$event->data['page_type']}");
        Cache::tags(['cms', 'pages'])->flush();
    }
}
```

```php
<?php

namespace App\Listeners\Cms;

use App\Events\Cms\PagePublished;
use App\Jobs\Cms\GenerateSitemap;

class RegenerateSitemap
{
    public function handle(PagePublished $event): void
    {
        GenerateSitemap::dispatch();
    }
}
```

```php
<?php

namespace App\Listeners\Cms;

use App\Events\Cms\PagePublished;
use App\Jobs\Search\IndexPage;

class IndexPageForSearch
{
    public function handle(PagePublished $event): void
    {
        IndexPage::dispatch($event->pageId);
    }
}
```

---

# Caching Strategy

```text
Cache Keys:
    page:{slug}                     → 24 hours (single page)
    pages:type:{type}               → 1 hour (page list by type)
    navigation:{slug}               → 24 hours (navigation menu)
    seo:global                      → 24 hours (global SEO settings)
    cms:blocks:types                → 24 hours (block type registry)
    cms:sitemap                     → 24 hours (generated sitemap)

Invalidation:
    On page publish → forget page:{slug}, pages:type:*
    On page update  → forget page:{slug}
    On nav update   → forget navigation:{slug}
    On seo update   → forget seo:global
```

---

# Testing Strategy

## Unit Tests

* Block validation rules
* Block HTML rendering
* Block schema compliance
* Slug generation uniqueness
* Revision diff computation

## Feature Tests

* Page CRUD operations
* Block sync operations
* Navigation CRUD and tree building
* SEO data resolution
* Revision creation and restoration
* Publish/archive workflow

## Integration Tests

* Full page creation to publish flow
* Cache invalidation on publish
* Sitemap regeneration
* Search index updates
* Event dispatching

---

# Permissions Matrix

| Action | Admin | Editor | Author | Viewer |
|--------|-------|--------|--------|--------|
| Create page | Yes | Yes | Yes | No |
| Edit own page | Yes | Yes | Yes | No |
| Edit any page | Yes | Yes | No | No |
| Delete page | Yes | Yes | No | No |
| Publish page | Yes | Yes | No | No |
| Archive page | Yes | Yes | No | No |
| View revisions | Yes | Yes | Yes | Yes |
| Restore revision | Yes | Yes | No | No |
| Manage navigation | Yes | Yes | No | No |
| Manage SEO | Yes | Yes | No | No |
| Manage media | Yes | Yes | Yes | No |

---

# Error Handling

| Error | Response | Recovery |
|-------|----------|----------|
| Invalid block data | 422 Validation Error | Show validation messages |
| Page not found | 404 | Redirect to page list |
| Unauthorized access | 403 | Show forbidden message |
| Slug conflict | 422 | Auto-append counter |
| Block render failure | 200 with placeholder | Log error, show comment |
| Revision restore failure | 500 | Log error, show message |

---

# Performance Considerations

* Pages cached by slug for 24 hours
* Block types cached in registry
* Navigation trees cached after first render
* Sitemap generated daily via queue
* Search index updated async via queue
* Revision diffs computed lazily
* Media thumbnails generated in background
* Page list queries paginated (20 per page)

---

# Migration Strategy

1. Create database tables (migrations)
2. Register block types in BlockRegistry
3. Seed default navigation menus
4. Configure SEO defaults
5. Set up cache keys and TTLs
6. Register event listeners
7. Define routes and middleware
8. Build Livewire components
9. Create Blade templates
10. Test full workflow

---

# Security Considerations

* CSRF protection on all forms
* Authorization checks on all actions
* Input sanitization on block HTML
* File upload validation for media
* Rate limiting on page creation
* Audit logging on publish/archive
* Revision integrity (no tampering)
* Slug uniqueness enforcement

---

# Next Document

**23 - Search** — Full-text search across all platform content.
