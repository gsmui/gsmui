---
title: Content Management
description: Article editor, media library, publishing workflow, and scheduling.
order: 14.9
group: CMS
---

# Content Management

GsmUi includes a lightweight CMS for managing documentation content, blog posts, and marketing pages.

## CMS Features

| Feature | Description |
|---|---|
| Article Editor | Rich text editing |
| Media Library | Image and file management |
| Publishing Workflow | Draft → Review → Publish |
| Scheduling | Time-based publishing |
| Versioning | Content version history |

## Article Editor

### Editor Interface

```blade
<x-gsmui:cms-editor
    wire:model="content"
    :toolbar="['bold', 'italic', 'link', 'image', 'code', 'list']"
    :media-library="true"
    height="500"
/>
```

### Editor Features

| Feature | Description |
|---|---|
| Rich text | Bold, italic, headings |
| Markdown | Full Markdown support |
| Code blocks | Syntax highlighting |
| Images | Inline image insertion |
| Links | Internal/external links |
| Tables | Markdown tables |

### Editor Toolbar

```
┌─────────────────────────────────────────────────────────┐
│ B  I  H1 H2 H3  |  🔗  📷  <>  |  UL  OL  |  Preview │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  # Article Title                                        │
│                                                         │
│  Content here...                                        │
│                                                         │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

### Editor Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `wire:model` | string | — | Content binding |
| `toolbar` | array | All | Available tools |
| `media-library` | bool | `false` | Enable media |
| `height` | int | `400` | Editor height |
| `placeholder` | string | `Write something...` | Placeholder text |

## Media Library

### Upload Interface

```blade
<x-gsmui:media-library
    wire:model="selectedMedia"
    :accept="['image/*', 'video/*', 'application/pdf']"
    :max-size="10240"
    :multiple="true"
/>
```

### Media Management

| Action | Description |
|---|---|
| Upload | Drag & drop or click |
| Browse | Grid/list view |
| Search | Filter by type/name |
| Delete | Soft delete with restore |
| Organize | Folders and tags |

### Media Schema

| Field | Type | Description |
|---|---|---|
| `id` | int | Media ID |
| `name` | string | File name |
| `path` | string | Storage path |
| `type` | string | MIME type |
| `size` | int | File size (bytes) |
| `alt` | string | Alt text |
| `created_at` | timestamp | Upload time |

### Media Grid

```
┌────────┬────────┬────────┬────────┐
│ 📷     │ 📷     │ 🎬     │ 📄     │
│ logo   │ banner │ demo   │ spec   │
│ 240KB  │ 1.2MB  │ 4.5MB  │ 120KB  │
├────────┼────────┼────────┼────────┤
│ 📷     │ 📷     │ 📷     │ 🎬     │
│ hero   │ icon   │ thumb  │ intro  │
│ 800KB  │ 5KB    │ 15KB   │ 8MB    │
└────────┴────────┴────────┴────────┘
```

## Publishing Workflow

### Workflow Stages

| Stage | Status | Description |
|---|---|---|
| Draft | `draft` | Work in progress |
| Review | `review` | Awaiting approval |
| Approved | `approved` | Ready to publish |
| Published | `published` | Live content |
| Archived | `archived` | No longer active |

### Workflow UI

```blade
<gsmui:workflow-status
    :status="$article->status"
    :transitions="$article->allowedTransitions"
    wire:model="status"
/>
```

### Status Transitions

```
Draft → Review → Approved → Published → Archived
  ↑        ↓         ↓          ↓
  └── Return to draft ─────────┘
```

### Workflow Permissions

| Role | Draft | Review | Publish | Archive |
|---|---|---|---|---|
| Author | ✓ | Submit | — | — |
| Editor | ✓ | ✓ | ✓ | ✓ |
| Admin | ✓ | ✓ | ✓ | ✓ |

## Scheduling

### Schedule Interface

```blade
<x-gsmui:schedule-picker
    wire:model="publishAt"
    :min="now()->addHour()"
    timezone="UTC"
/>
```

### Schedule Options

| Option | Description |
|---|---|
| Immediate | Publish now |
| Scheduled | Set future date/time |
| Recurring | Repeat pattern |
| Draft | Save without publishing |

### Schedule Schema

```php
Article::create([
    'title' => 'New Feature Announcement',
    'content' => '...',
    'status' => 'approved',
    'publish_at' => '2024-02-01T09:00:00Z',
    'unpublish_at' => '2024-03-01T09:00:00Z',
]);
```

## Content Types

| Type | Template | Purpose |
|---|---|---|
| Documentation | `doc` | Technical docs |
| Blog Post | `blog` | Blog articles |
| Changelog | `changelog` | Release notes |
| Guide | `guide` | Tutorials |
| API Reference | `api` | API documentation |

## SEO Management

### Meta Fields

| Field | Purpose |
|---|---|
| `title` | Page title |
| `description` | Meta description |
| `keywords` | Meta keywords |
| `og:image` | Open Graph image |
| `canonical` | Canonical URL |

### SEO Preview

```blade
<x-gsmui:seo-preview
    :title="$article->meta_title"
    :description="$article->meta_description"
    :image="$article->og_image"
/>
```

## CMS Configuration

```php
// config/cms.php
return [
    'editor' => [
        'default' => 'markdown', // 'markdown', 'rich-text', 'block'
        'media' => [
            'disk' => 'public',
            'path' => 'media',
            'max_size' => 10240,
            'allowed_types' => ['image/*', 'video/*', 'application/pdf'],
        ],
    ],
    'workflow' => [
        'enabled' => true,
        'stages' => ['draft', 'review', 'approved', 'published', 'archived'],
    ],
    'seo' => [
        'auto_generate' => true,
        'social_preview' => true,
    ],
];
```
