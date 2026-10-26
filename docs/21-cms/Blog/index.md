# Blog System

> PRD — Volume 21: CMS & Content — Blog

## Overview

The Blog system provides a full-featured content publishing platform with a rich text editor, taxonomies, featured images, comment moderation, and social sharing integration. Built on Livewire for real-time editing and management.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Post creation time | Time to draft and publish a post | < 10 minutes |
| Editor performance | Keystroke-to-render latency | < 50ms |
| Comment moderation | Time to approve/reject comments | < 1 minute |
| SEO coverage | Posts with complete meta fields | 98%+ |
| Social share rate | Posts shared via social buttons | Tracked |

## Post Editor

### Editor Features

| Feature | Description | Priority |
|---------|-------------|----------|
| Rich text (Tiptap/ProseMirror) | Block-based content editing | P0 |
| Markdown mode | Toggle between WYSIWYG and Markdown | P1 |
| Featured image | Hero image with focal point picker | P0 |
| Excerpt | Short summary for listings | P0 |
| Custom fields | ACF-style field groups | P1 |
| Code blocks | Syntax-highlighted code snippets | P1 |
| Embed support | OEmbed for tweets, YouTube, etc. | P1 |
| Table editor | Inline table creation and editing | P2 |
| Footnotes | Academic-style footnotes | P2 |
| Reading time | Auto-calculated estimated read time | P2 |

### Editor Block Types

| Block | Description |
|-------|-------------|
| `paragraph` | Standard text paragraph |
| `heading` | H2–H6 with anchor links |
| `image` | Inline image with caption and alt text |
| `gallery` | Multi-image grid |
| `code` | Syntax-highlighted code block |
| `quote` | Blockquote with attribution |
| `list` | Ordered/unordered list |
| `divider` | Horizontal rule |
| `embed` | OEmbed (YouTube, Twitter, etc.) |
| `callout` | Highlighted callout box |
| `table` | Data table |

### Post Schema

```php
class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'blocks',
        'featured_image_id', 'featured_image_alt',
        'author_id', 'status', 'publish_at', 'published_at',
        'seo', 'settings', 'allow_comments', 'is_featured',
        'reading_time',
    ];

    protected $casts = [
        'blocks' => 'array',
        'seo' => 'array',
        'settings' => 'array',
        'allow_comments' => 'boolean',
        'is_featured' => 'boolean',
        'publish_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    protected function readingTime(): Attribute
    {
        return Attribute::get(function () {
            $wordCount = str_word_count(strip_tags($this->content ?? ''));
            return max(1, (int) ceil($wordCount / 200));
        });
    }
}
```

## Categories & Tags

### Category Management

| Field | Type | Description |
|-------|------|-------------|
| `name` | `string` | Category display name |
| `slug` | `string` | URL-safe slug |
| `description` | `text` | Optional description |
| `parent_id` | `bigint` | Parent category (nullable) |
| `seo` | `json` | SEO metadata |
| `sort_order` | `int` | Display order |

### Tag Management

| Field | Type | Description |
|-------|------|-------------|
| `name` | `string` | Tag display name |
| `slug` | `string` | URL-safe slug |
| `color` | `string` | Hex color for badge display |

### Post-Category Relationship

```php
// Posts belong to many categories
Post::with('categories')->get();

// Category scoped queries
Category::withCount('posts')
    ->where('is_active', true)
    ->orderBy('sort_order')
    ->get();
```

## Featured Images

| Property | Description |
|----------|-------------|
| Upload | Drag-and-drop or media library picker |
| Focal point | Click-to-set focal point for crop |
| Alt text | Required for accessibility |
| Sizes | Auto-generated: thumbnail, medium, large, full |
| Formats | WebP preferred, JPEG fallback |

### Image Processing

```php
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class FeaturedImageObserver
{
    public function saved(Post $post): void
    {
        if ($post->wasChanged('featured_image_id') && $post->featured_image) {
            $post->featured_image->updateSizes([
                'thumbnail' => ['width' => 150, 'height' => 150, 'crop' => true],
                'medium' => ['width' => 600, 'height' => 400, 'crop' => false],
                'large' => ['width' => 1200, 'height' => 630, 'crop' => true],
            ]);
        }
    }
}
```

## Comments

### Comment System

| Feature | Configuration | Default |
|---------|--------------|---------|
| Enable/disable per post | `allow_comments` | `true` |
| Moderation required | `moderation_required` | `true` |
| Max nesting depth | `max_depth` | 3 |
| Flood protection | `flood_interval` | 60 seconds |
| Max length | `max_length` | 2000 chars |
| Spam detection | `spam_filter_enabled` | `true` |
| Guest comments | `allow_guests` | `false` |

### Comment States

| State | Description |
|-------|-------------|
| `pending` | Awaiting moderation |
| `approved` | Visible on frontend |
| `spam` | Marked as spam |
| `trashed` | Soft-deleted |

### Comment Moderation

```php
class CommentModeration extends Component
{
    public function approve(Comment $comment): void
    {
        $comment->update(['status' => 'approved']);
        $this->dispatch('comment-moderated', commentId: $comment->id);
    }

    public function bulkModerate(array $ids, string $action): void
    {
        $validActions = ['approve', 'spam', 'trash'];
        abort_unless(in_array($action, $validActions), 400);

        Comment::whereIn('id', $ids)->update([
            'status' => $action === 'approve' ? 'approved' : $action,
        ]);
    }
}
```

## Social Sharing

| Platform | Share URL Format | Icon |
|----------|-----------------|------|
| Twitter/X | `https://twitter.com/intent/tweet?url={url}&text={title}` | `twitter` |
| Facebook | `https://www.facebook.com/sharer/sharer.php?u={url}` | `facebook` |
| LinkedIn | `https://www.linkedin.com/sharing/share-offsite/?url={url}` | `linkedin` |
| Reddit | `https://reddit.com/submit?url={url}&title={title}` | `reddit` |
| Hacker News | `https://news.ycombinator.com/submitlink?u={url}&t={title}` | `hacker-news` |
| Email | `mailto:?subject={title}&body={url}` | `envelope` |
| Copy Link | Clipboard API copy | `clipboard` |

### Social Meta Tags

```php
// Auto-generated Open Graph and Twitter Card meta
$post->getSocialMeta();
// Returns:
// og:title, og:description, og:image, og:url, og:type
// twitter:card, twitter:title, twitter:description, twitter:image
```

## Database Schema

```sql
CREATE TABLE posts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    excerpt TEXT NULL,
    content LONGTEXT NULL,
    blocks JSON NULL,
    featured_image_id BIGINT UNSIGNED NULL,
    featured_image_alt VARCHAR(255) NULL,
    author_id BIGINT UNSIGNED NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'draft',
    publish_at TIMESTAMP NULL,
    published_at TIMESTAMP NULL,
    reading_time INT UNSIGNED NOT NULL DEFAULT 1,
    seo JSON NULL,
    settings JSON NULL,
    allow_comments BOOLEAN NOT NULL DEFAULT TRUE,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    views_count INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    UNIQUE KEY posts_slug_unique (slug),
    KEY posts_status_index (status),
    KEY posts_author_index (author_id),
    KEY posts_publish_at_index (publish_at),
    CONSTRAINT posts_author FOREIGN KEY (author_id) REFERENCES users(id)
);

CREATE TABLE post_categories (
    post_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, category_id),
    CONSTRAINT pc_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    CONSTRAINT pc_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE post_tags (
    post_id BIGINT UNSIGNED NOT NULL,
    tag_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    CONSTRAINT pt_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    CONSTRAINT pt_tag FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    parent_id BIGINT UNSIGNED NULL,
    body TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    author_name VARCHAR(100) NULL,
    author_email VARCHAR(255) NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    KEY comments_post_index (post_id),
    KEY comments_status_index (status),
    CONSTRAINT comments_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
```

## Livewire Components

| Component | Namespace | Description |
|-----------|-----------|-------------|
| `post-editor` | `App\Livewire\Cms\Blog\PostEditor` | Rich text post editor |
| `post-list` | `App\Livewire\Cms\Blog\PostList` | Post listing with filters |
| `post-card` | `App\Livewire\Cms\Blog\PostCard` | Post preview card |
| `comment-list` | `App\Livewire\Cms\Blog\CommentList` | Comment moderation list |
| `comment-form` | `App\Livewire\Cms\Blog\CommentForm` | Comment submission form |
| `category-picker` | `App\Livewire\Cms\Blog\CategoryPicker` | Category selection widget |
| `tag-input` | `App\Livewire\Cms\Blog\TagInput` | Tag autocomplete input |
| `social-share` | `App\Livewire\Cms\Blog\SocialShare` | Social sharing buttons |

## Acceptance Criteria

- [ ] Rich text editor supports all block types listed above
- [ ] Posts can be categorized and tagged
- [ ] Featured images are processed into multiple sizes
- [ ] Comments support nested replies up to 3 levels deep
- [ ] Comment moderation queue supports bulk actions
- [ ] Social sharing buttons generate correct URLs per platform
- [ ] Reading time auto-calculates from content word count
- [ ] Posts can be scheduled for future publishing
- [ ] SEO fields validate and enforce character limits
- [ ] Post listings support pagination and category/tag filtering
