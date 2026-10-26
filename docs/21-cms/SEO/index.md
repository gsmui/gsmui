# SEO Tools

> PRD — Volume 21: CMS & Content — SEO

## Overview

The SEO Tools module provides comprehensive search engine optimization capabilities including meta tag management, XML sitemap generation, robots.txt configuration, schema.org markup, and redirect management. All features integrate with the CMS content system.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Meta completeness | Pages with all required meta fields | 98%+ |
| Sitemap freshness | Time from content change to sitemap update | < 5 minutes |
| Schema coverage | Pages with valid structured data | 90%+ |
| Redirect speed | Redirect processing time | < 5ms |
| SEO score | Average Lighthouse SEO score | 95+ |

## Meta Tag Editor

### Global SEO Defaults

```php
// config/seo.php
return [
    'defaults' => [
        'title_suffix' => ' — {site_name}',
        'title_separator' => ' | ',
        'meta_description' => '',
        'og_type' => 'website',
        'og_site_name' => config('app.name'),
        'twitter_site' => '@username',
        'twitter_creator' => '@username',
        'twitter_card' => 'summary_large_image',
        'robots_index' => true,
        'robots_follow' => true,
    ],
    'sitemap' => [
        'enabled' => true,
        'frequency' => 'weekly',
        'priority' => 0.8,
        'max_urls' => 50000,
        'excluded_patterns' => ['/admin/*', '/api/*'],
    ],
    'schema' => [
        'organization' => true,
        'website' => true,
        'breadcrumbs' => true,
        'articles' => true,
    ],
];
```

### Meta Field Specifications

| Field | Character Limit | Validation | Auto-Generated |
|-------|----------------|-----------|----------------|
| `title` | 60 chars | `required|max:60` | Fallback from content |
| `description` | 160 chars | `required|max:160` | Excerpt fallback |
| `keywords` | 255 chars | `max:255` | No |
| `og:title` | 95 chars | `nullable|max:95` | Falls back to `title` |
| `og:description` | 200 chars | `nullable|max:200` | Falls back to `description` |
| `og:image` | — | `nullable\|image` | Site default |
| `og:image:width` | — | `integer` | Auto-detected |
| `og:image:height` | — | `integer` | Auto-detected |
| `og:url` | — | `nullable\|url` | Current URL |
| `og:type` | — | `in:website,article,product` | Content type |
| `twitter:card` | — | `in:summary,summary_large_image` | Default |
| `canonical` | 2048 chars | `nullable\|url` | Auto-generated |
| `robots` | — | `nullable` | `index, follow` |
| `alternate` | — | `nullable\|url` | Alternate language URL |

### Meta Editor Component

```php
class MetaEditor extends Component
{
    public Model $model;
    public string $title = '';
    public string $description = '';
    public ?string $ogTitle = null;
    public ?string $ogDescription = null;
    public ?int $ogImageId = null;
    public ?string $canonical = null;
    public bool $robotsIndex = true;
    public bool $robotsFollow = true;
    public string $ogType = 'website';

    public function getPreviewData(): array
    {
        return [
            'title' => $this->title . config('seo.defaults.title_suffix'),
            'description' => $this->description,
            'og_title' => $this->ogTitle ?? $this->title,
            'og_description' => $this->ogDescription ?? $this->description,
            'og_image' => $this->ogImage?->getUrl('large'),
            'url' => $this->canonical ?? $this->model->getUrl(),
        ];
    }

    public function save(): void
    {
        $this->validate([
            'title' => 'required|max:60',
            'description' => 'required|max:160',
            'ogTitle' => 'nullable|max:95',
            'ogDescription' => 'nullable|max:200',
            'canonical' => 'nullable|url',
        ]);

        $this->model->update([
            'seo' => [
                'meta_title' => $this->title,
                'meta_description' => $this->description,
                'og_title' => $this->ogTitle,
                'og_description' => $this->ogDescription,
                'og_image_id' => $this->ogImageId,
                'og_type' => $this->ogType,
                'canonical_url' => $this->canonical,
                'robots_index' => $this->robotsIndex,
                'robots_follow' => $this->robotsFollow,
            ],
        ]);
    }
}
```

## XML Sitemap

### Sitemap Configuration

| Setting | Description | Default |
|---------|-------------|---------|
| `enabled` | Enable sitemap generation | `true` |
| `max_urls` | Max URLs per sitemap file | 50,000 |
| `frequency` | Default change frequency | `weekly` |
| `priority` | Default priority | `0.8` |
| `include_images` | Include image sitemap | `true` |
| `include_videos` | Include video sitemap | `true` |
| `include_news` | Include news sitemap | `false` |
| `excluded_patterns` | URL patterns to exclude | `['/admin/*']` |
| `auto_ping` | Ping search engines on update | `true` |

### Sitemap Generation

```php
class SitemapGenerator
{
    public function generate(): void
    {
        $urls = collect();

        // Pages
        Page::where('status', 'published')
            ->where('seo->robots_index', true)
            ->each(fn(Page $page) => $urls->push($this->mapPage($page)));

        // Blog posts
        Post::where('status', 'published')
            ->each(fn(Post $post) => $urls->push($this->mapPost($post)));

        // Categories
        Category::where('is_active', true)
            ->each(fn(Category $cat) => $urls->push($this->mapCategory($cat)));

        // Split into chunks of 50,000
        $chunks = $urls->chunk(config('sitemap.max_urls'));

        foreach ($chunks as $index => $chunk) {
            $filename = $chunks->count() === 1
                ? 'sitemap.xml'
                : "sitemap-{$index}.xml";

            $this->writeSitemap($filename, $chunk);
        }

        $this->writeSitemapIndex($chunks);
        $this->pingSearchEngines();
    }

    private function mapPage(Page $page): array
    {
        return [
            'loc' => $page->getUrl(),
            'lastmod' => $page->updated_at->toW3CDateString(),
            'changefreq' => $page->seo['change_freq'] ?? 'weekly',
            'priority' => $page->seo['priority'] ?? 0.8,
            'images' => $page->getSitemapImages(),
        ];
    }
}
```

### Sitemap Index Structure

```xml
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc>https://example.com/sitemap-pages.xml</loc>
    <lastmod>2026-07-15</lastmod>
  </sitemap>
  <sitemap>
    <loc>https://example.com/sitemap-posts.xml</loc>
    <lastmod>2026-07-15</lastmod>
  </sitemap>
  <sitemap>
    <loc>https://example.com/sitemap-categories.xml</loc>
    <lastmod>2026-07-15</lastmod>
  </sitemap>
</sitemapindex>
```

## Robots.txt

### Configuration

```php
// config/seo-robots.php
return [
    'rules' => [
        ['user-agent' => '*', 'allow' => '/'],
        ['user-agent' => '*', 'disallow' => '/admin/'],
        ['user-agent' => '*', 'disallow' => '/api/'],
        ['user-agent' => '*', 'disallow' => '/storage/'],
        ['user-agent' => 'AhrefsBot', 'disallow' => '/'],
        ['user-agent' => 'MJ12bot', 'disallow' => '/'],
    ],
    'sitemap_url' => '/sitemap.xml',
    'crawl_delay' => null,
    'host' => null,
];
```

### Dynamic Robots.txt

```php
Route::get('/robots.txt', function () {
    $rules = config('seo-robots.rules');
    $sitemapUrl = config('seo-robots.sitemap_url');

    $content = '';
    foreach ($rules as $rule) {
        $content .= "User-agent: {$rule['user-agent']}\n";
        if (isset($rule['allow'])) {
            $content .= "Allow: {$rule['allow']}\n";
        }
        if (isset($rule['disallow'])) {
            $content .= "Disallow: {$rule['disallow']}\n";
        }
        $content .= "\n";
    }

    if ($sitemapUrl) {
        $content .= "Sitemap: " . url($sitemapUrl) . "\n";
    }

    return response($content, 200)
        ->header('Content-Type', 'text/plain');
});
```

## Schema Markup

### Supported Schema Types

| Type | Content Types | Key Properties |
|------|--------------|----------------|
| `Organization` | Global | name, logo, url, contactPoint |
| `WebSite` | Global | name, url, searchAction |
| `WebPage` | Pages | name, url, breadcrumb |
| `Article` | Blog posts | headline, author, datePublished |
| `BlogPosting` | Blog posts | articleBody, wordCount |
| `BreadcrumbList` | All | itemListElement |
| `Product` | Products | name, price, availability |
| `FAQPage` | FAQ content | mainEntity |
| `HowTo` | Tutorials | step, tool, supply |
| `Event` | Events | startDate, location, organizer |

### Schema Generator

```php
class SchemaGenerator
{
    public function forPage(Page $page): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $page->getUrl() . '#webpage',
            'url' => $page->getUrl(),
            'name' => $page->title,
            'description' => $page->seo['meta_description'] ?? '',
            'isPartOf' => $this->getWebsiteSchema(),
            'breadcrumb' => $this->getBreadcrumbSchema($page),
            'datePublished' => $page->created_at->toIso8601String(),
            'dateModified' => $page->updated_at->toIso8601String(),
        ];

        if ($page->featured_image) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => $page->featured_image->getUrl('large'),
                'width' => 1200,
                'height' => 630,
            ];
        }

        return $schema;
    }

    public function forArticle(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => $post->excerpt,
            'author' => [
                '@type' => 'Person',
                'name' => $post->author->name,
                'url' => $post->author->getUrl(),
            ],
            'datePublished' => $post->published_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'mainEntityOfPage' => $post->getUrl(),
            'wordCount' => str_word_count(strip_tags($post->content)),
            'timeRequired' => 'PT' . $post->reading_time . 'M',
        ];
    }
}
```

## Database Schema

```sql
CREATE TABLE redirects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    from_url VARCHAR(2048) NOT NULL,
    to_url VARCHAR(2048) NOT NULL,
    type SMALLINT NOT NULL DEFAULT 301,
    is_pattern BOOLEAN NOT NULL DEFAULT FALSE,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    hits INT UNSIGNED NOT NULL DEFAULT 0,
    last_hit_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    KEY redirects_from_url_index (from_url(191)),
    KEY redirects_type_index (type)
);

CREATE TABLE seo_audits (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    auditable_type VARCHAR(255) NOT NULL,
    auditable_id BIGINT UNSIGNED NOT NULL,
    score INT NOT NULL DEFAULT 0,
    issues JSON NULL,
    recommendations JSON NULL,
    audited_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP NULL,
    KEY seo_audits_auditable_index (auditable_type, auditable_id)
);
```

## Livewire Components

| Component | Namespace | Description |
|-----------|-----------|-------------|
| `meta-editor` | `App\Livewire\Seo\MetaEditor` | Meta tag editor panel |
| `meta-preview` | `App\Livewire\Seo\MetaPreview` | Google SERP preview |
| `sitemap-manager` | `App\Livewire\Seo\SitemapManager` | Sitemap configuration |
| `schema-editor` | `App\Livewire\Seo\SchemaEditor` | Schema markup editor |
| `seo-audit` | `App\Livewire\Seo\SeoAudit` | SEO score checker |
| `robots-editor` | `App\Livewire\Seo\RobotsEditor` | Robots.txt editor |

## Acceptance Criteria

- [ ] Meta editor enforces character limits with live counter
- [ ] Google SERP preview shows accurate representation
- [ ] XML sitemap auto-generates on content change
- [ ] Sitemap handles 50,000+ URLs via index splitting
- [ ] Robots.txt is dynamically generated from config
- [ ] Schema markup validates against Google's Rich Results test
- [ ] Breadcrumb schema auto-generates from content hierarchy
- [ ] Canonical URLs prevent duplicate content indexing
- [ ] Open Graph images use proper dimensions (1200×630)
- [ ] SEO audit scores pages and suggests improvements
