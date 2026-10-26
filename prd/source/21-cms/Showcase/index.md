# Showcase / Portfolio

> PRD — Volume 21: CMS & Content — Showcase

## Overview

The Showcase module provides a portfolio and case study system for displaying client work, project galleries, testimonials, and client logos. It supports rich project detail pages, filterable galleries, and configurable display layouts.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Gallery load time | Time to render project grid | < 1 second |
| Filter accuracy | Correct filter results | 100% |
| Image loading | Lazy-loaded image display | < 200ms per image |
| SEO coverage | Projects with complete meta data | 95%+ |
| Mobile experience | Touch-friendly gallery interaction | 100% |

## Project Types

| Type | Description | Fields |
|------|-------------|--------|
| `case-study` | In-depth project analysis | client, challenge, solution, results, testimonial |
| `portfolio` | Visual project showcase | images, description, tech stack |
| `client-work` | Client project display | client, services, outcome |
| `personal` | Personal project showcase | description, tech, repo_url |

## Project Schema

```php
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'description',
        'client_name', 'client_logo_id', 'client_url',
        'challenge', 'solution', 'results',
        'featured_image_id', 'gallery', 'blocks',
        'category', 'tags', 'tech_stack',
        'project_url', 'project_date',
        'is_featured', 'is_published', 'sort_order',
        'seo', 'settings',
    ];

    protected $casts = [
        'gallery' => 'array',
        'blocks' => 'array',
        'tags' => 'array',
        'tech_stack' => 'array',
        'seo' => 'array',
        'settings' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'project_date' => 'date',
    ];

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function clientLogo(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'client_logo_id');
    }

    public function testimonials(): MorphMany
    {
        return $this->morphMany(Testimonial::class, 'testable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }
}
```

## Project Gallery

### Gallery Configuration

| Setting | Description | Default |
|---------|-------------|---------|
| `layout` | Grid, masonry, carousel, slideshow | `grid` |
| `columns` | Grid columns (desktop) | 3 |
| `columns_tablet` | Grid columns (tablet) | 2 |
| `columns_mobile` | Grid columns (mobile) | 1 |
| `gap` | Grid gap in pixels | 24 |
| `aspect_ratio` | Image aspect ratio | `16:9` |
| `hover_effect` | Zoom, overlay, none | `zoom` |
| `lightbox` | Enable lightbox on click | `true` |
| `lazy_load` | Lazy load images | `true` |
| `infinite_scroll` | Load more on scroll | `false` |
| `per_page` | Items per page/load | 12 |

### Gallery Component

```html
<gsmui:showcase-gallery
    :layout="$layout"
    :columns="$columns"
    :gap="$gap"
    :lazy-load="true"
    :lightbox="true"
>
    @foreach($project->gallery as $image)
        <gsmui:showcase-image
            :src="$image['url']"
            :alt="$image['alt']"
            :caption="$image['caption']"
            :focal-point="$image['focal_point']"
        />
    @endforeach
</gsmui:showcase-gallery>
```

## Case Studies

### Case Study Structure

| Section | Description | Required |
|---------|-------------|----------|
| Hero | Featured image + title + client | Yes |
| Overview | Project summary and key facts | Yes |
| Challenge | Problem statement and constraints | Yes |
| Solution | Approach and implementation details | Yes |
| Results | Outcomes, metrics, and impact | Yes |
| Gallery | Visual project documentation | No |
| Testimonial | Client quote and attribution | No |
| Related | Links to related projects | No |

### Key Facts Sidebar

```php
class CaseStudyFacts
{
    public function getFacts(Project $project): array
    {
        return [
            ['label' => 'Client', 'value' => $project->client_name],
            ['label' => 'Industry', 'value' => $project->industry ?? '—'],
            ['label' => 'Timeline', 'value' => $project->timeline ?? '—'],
            ['label' => 'Team Size', 'value' => $project->team_size ?? '—'],
            ['label' => 'Services', 'value' => implode(', ', $project->services ?? [])],
            ['label' => 'Tech Stack', 'value' => implode(', ', $project->tech_stack ?? [])],
        ];
    }
}
```

## Testimonials

### Testimonial Schema

```sql
CREATE TABLE testimonials (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    testable_type VARCHAR(255) NOT NULL,
    testable_id BIGINT UNSIGNED NOT NULL,
    author_name VARCHAR(255) NOT NULL,
    author_title VARCHAR(255) NULL,
    author_company VARCHAR(255) NULL,
    author_avatar_id BIGINT UNSIGNED NULL,
    body TEXT NOT NULL,
    rating TINYINT UNSIGNED NULL,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    KEY testimonials_testable_index (testable_type, testable_id)
);
```

### Testimonial Component

```html
<gsmui:testimonial
    :author="$testimonial->author_name"
    :title="$testimonial->author_title"
    :company="$testimonial->author_company"
    :avatar="$testimonial->author_avatar?->getUrl('thumb')"
    :rating="$testimonial->rating"
>
    {{ $testimonial->body }}
</gsmui:testimonial>
```

## Client Logos

### Client Logo Management

| Field | Type | Description |
|-------|------|-------------|
| `name` | `string` | Client/company name |
| `logo_id` | `media` | Logo image |
| `url` | `string` | Client website URL |
| `industry` | `string` | Client industry |
| `is_active` | `boolean` | Show/hide in logo wall |
| `sort_order` | `int` | Display order |

### Logo Wall Component

```html
<gsmui:logo-wall
    :speed="30"
    :pause-on-hover="true"
    :show-logos="10"
>
    @foreach($clientLogos as $logo)
        <gsmui:logo-wall-item
            :src="$logo->logo->getUrl('medium')"
            :alt="$logo->name"
            :url="$logo->url"
        />
    @endforeach
</gsmui:logo-wall>
```

## Database Schema

```sql
CREATE TABLE projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    excerpt TEXT NULL,
    description LONGTEXT NULL,
    client_name VARCHAR(255) NULL,
    client_logo_id BIGINT UNSIGNED NULL,
    client_url VARCHAR(2048) NULL,
    challenge TEXT NULL,
    solution TEXT NULL,
    results TEXT NULL,
    featured_image_id BIGINT UNSIGNED NULL,
    gallery JSON NULL,
    blocks JSON NULL,
    category VARCHAR(100) NULL,
    tags JSON NULL,
    tech_stack JSON NULL,
    project_url VARCHAR(2048) NULL,
    project_date DATE NULL,
    is_featured BOOLEAN NOT NULL DEFAULT FALSE,
    is_published BOOLEAN NOT NULL DEFAULT FALSE,
    sort_order INT NOT NULL DEFAULT 0,
    views_count INT UNSIGNED NOT NULL DEFAULT 0,
    seo JSON NULL,
    settings JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    UNIQUE KEY projects_slug_unique (slug),
    KEY projects_published_index (is_published),
    KEY projects_category_index (category),
    KEY projects_featured_index (is_featured)
);
```

## Livewire Components

| Component | Namespace | Description |
|-----------|-----------|-------------|
| `showcase-grid` | `App\Livewire\Cms\Showcase\ShowcaseGrid` | Filterable project grid |
| `showcase-project` | `App\Livewire\Cms\Showcase\ShowcaseProject` | Single project detail |
| `showcase-gallery` | `App\Livewire\Cms\Showcase\ShowcaseGallery` | Image gallery |
| `showcase-filter` | `App\Livewire\Cms\Showcase\ShowcaseFilter` | Category/tech filter bar |
| `logo-wall` | `App\Livewire\Cms\Showcase\LogoWall` | Client logo carousel |
| `testimonial-carousel` | `App\Livewire\Cms\Showcase\TestimonialCarousel` | Testimonial slider |

## Access Control

| Permission | Description | Default Role |
|------------|-------------|-------------|
| `projects.create` | Create projects | Editor |
| `projects.edit` | Edit projects | Editor |
| `projects.delete` | Delete projects | Admin |
| `projects.publish` | Publish/unpublish projects | Editor |
| `projects.feature` | Mark as featured | Admin |
| `testimonials.manage` | Manage testimonials | Editor |
| `client-logos.manage` | Manage client logos | Editor |

## Acceptance Criteria

- [ ] Project grid supports filtering by category and tech stack
- [ ] Masonry layout adjusts to image aspect ratios
- [ ] Lightbox supports keyboard navigation and swipe gestures
- [ ] Case studies display all structured sections (challenge, solution, results)
- [ ] Testimonials display with author info and optional rating
- [ ] Logo wall animates smoothly and pauses on hover
- [ ] Images lazy-load and display blur-up placeholders
- [ ] SEO meta fields are available per project
- [ ] Projects can be marked as featured for homepage display
- [ ] Gallery images are responsive with srcset support
