# Category Management

> PRD — Volume 21: CMS & Content — Categories

## Overview

The Category Management system provides hierarchical taxonomy organization for blog posts, pages, products, and other content types. It supports nested category trees, SEO metadata per category, and flexible ordering.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Category depth | Maximum nesting levels | 5 levels |
| Navigation speed | Time to find a category in tree | < 3 seconds |
| SEO completeness | Categories with meta fields filled | 95%+ |
| Tree operations | Drag-drop reorder response time | < 200ms |
| Category coverage | Posts assigned to at least one category | 100% |

## Category Tree Structure

### Tree Hierarchy

```
Technology
├── Frontend
│   ├── JavaScript
│   ├── TypeScript
│   └── CSS
├── Backend
│   ├── PHP
│   ├── Laravel
│   └── Node.js
├── DevOps
│   ├── Docker
│   └── CI/CD
└── Mobile
    ├── React Native
    └── Flutter
```

### Tree Node Schema

```php
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'parent_id',
        'seo', 'sort_order', 'is_active', 'content_type',
        'image_id', 'color',
    ];

    protected $casts = [
        'seo' => 'array',
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function allChildren(): HasManyRecursive
    {
        return $this->children()->with('allChildren');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function getBreadcrumbs(): Collection
    {
        $breadcrumbs = collect([$this]);
        $current = $this;

        while ($current->parent_id) {
            $current = $current->parent;
            $breadcrumbs->prepend($current);
        }

        return $breadcrumbs;
    }

    public function getDepth(): int
    {
        return $this->getBreadcrumbs()->count() - 1;
    }

    public function isDescendantOf(Category $category): bool
    {
        return $this->getBreadcrumbs()->contains('id', $category->id);
    }
}
```

## Category CRUD

### Create Category Form

| Field | Type | Validation | Required |
|-------|------|-----------|----------|
| `name` | `string` | `required|max:255` | Yes |
| `slug` | `string` | `required|alpha_dash|unique:categories,slug` | Auto-generated |
| `description` | `text` | `max:500` | No |
| `parent_id` | `select` | `exists:categories,id` | No |
| `content_type` | `select` | `in:post,page,product` | Yes |
| `image_id` | `media-picker` | — | No |
| `color` | `color-picker` | `nullable\|hex` | No |
| `is_active` | `toggle` | — | Default `true` |
| `sort_order` | `number` | `integer|min:0` | Default `0` |

### Livewire Component

```php
class CategoryForm extends Component
{
    public ?Category $category;
    public string $name = '';
    public string $slug = '';
    public ?string $description = null;
    public ?int $parentId = null;
    public string $contentType = 'post';
    public bool $isActive = true;
    public int $sortOrder = 0;
    public array $seo = [];

    protected $listeners = ['name-updated' => 'generateSlug'];

    public function generateSlug(): void
    {
        if (!$this->category) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function save(): Category
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|alpha_dash|unique:categories,slug,' . $this->category?->id,
            'parentId' => 'nullable|exists:categories,id',
            'contentType' => 'required|in:post,page,product',
        ]);

        // Prevent setting parent to self or descendant
        if ($this->parentId && $this->category) {
            $parent = Category::findOrFail($this->parentId);
            abort_if(
                $parent->isDescendantOf($this->category) || $parent->id === $this->category->id,
                422,
                'Cannot set parent to self or descendant.'
            );
        }

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $this->parentId,
            'content_type' => $this->contentType,
            'is_active' => $this->isActive,
            'sort_order' => $this->sortOrder,
            'seo' => $this->seo,
        ];

        if ($this->category) {
            $this->category->update($data);
        } else {
            $this->category = Category::create($data);
        }

        return $this->category;
    }
}
```

## Category Pages

### Frontend Category Page

Each category generates a paginated listing page at `/{content_type}/{category-slug}`.

```php
// Route: GET /blog/{category-slug}
class CategoryShow extends Component
{
    public Category $category;
    public int $perPage = 12;

    public function posts(): LengthAwarePaginator
    {
        return Post::whereHas('categories', fn($q) => $q->where('categories.id', $this->category->id))
            ->where('status', 'published')
            ->with(['author', 'categories', 'featuredImage'])
            ->orderBy('published_at', 'desc')
            ->paginate($this->perPage);
    }
}
```

### Category Page Settings

| Setting | Description | Default |
|---------|-------------|---------|
| `posts_per_page` | Items per page | 12 |
| `pagination_style` | `numbered`, `load-more`, `infinite` | `numbered` |
| `sort_by` | `latest`, `popular`, `alpha` | `latest` |
| `show_description` | Display category description | `true` |
| `show_breadcrumbs` | Display breadcrumb trail | `true` |
| `show_post_count` | Display post count badge | `true` |
| `layout` | `grid`, `list`, `magazine` | `grid` |

## Category SEO

| Field | Max Length | Validation |
|-------|-----------|-----------|
| `seo.meta_title` | 60 chars | `nullable|max:60` |
| `seo.meta_description` | 160 chars | `nullable|max:160` |
| `seo.og_title` | 95 chars | `nullable|max:95` |
| `seo.og_description` | 200 chars | `nullable|max:200` |
| `seo.og_image` | — | `nullable|image` |
| `seo.canonical_url` | 2048 chars | `nullable|url` |
| `seo.robots_index` | — | `boolean` (default: `true`) |
| `seo.schema_type` | — | `nullable|in:CollectionPage,ItemList` |

### Auto-Generated SEO

```php
class Category extends Model
{
    public function getSeoMeta(): array
    {
        $seo = $this->seo ?? [];

        return [
            'title' => $seo['meta_title'] ?? $this->name . ' — ' . config('app.name'),
            'description' => $seo['meta_description'] ?? $this->description,
            'og:title' => $seo['og_title'] ?? $this->name,
            'og:description' => $seo['og_description'] ?? $this->description,
            'og:image' => $seo['og_image'] ?? $this->image?->getUrl('large'),
            'canonical' => $seo['canonical_url'] ?? route('categories.show', $this->slug),
            'robots' => ($seo['robots_index'] ?? true) ? 'index, follow' : 'noindex, nofollow',
        ];
    }
}
```

## Category Tree Operations

### Drag-and-Drop Reordering

```php
class CategoryTree extends Component
{
    public Collection $categories;

    public function mount(string $contentType = 'post'): void
    {
        $this->categories = Category::where('content_type', $contentType)
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }

    public function move(string $categoryId, ?string $parentId, int $position): void
    {
        $category = Category::findOrFail($categoryId);

        // Prevent circular references
        if ($parentId && $category->children()->where('id', $parentId)->exists()) {
            abort(422, 'Cannot move a category under its own descendant.');
        }

        $category->update([
            'parent_id' => $parentId,
            'sort_order' => $position,
        ]);

        $this->refreshTree();
    }

    public function refreshTree(): void
    {
        $this->categories = Category::where('content_type', $this->contentType)
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
    }
}
```

## Database Schema

```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT NULL,
    parent_id BIGINT UNSIGNED NULL,
    content_type VARCHAR(50) NOT NULL DEFAULT 'post',
    image_id BIGINT UNSIGNED NULL,
    color VARCHAR(7) NULL,
    seo JSON NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    posts_count INT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY categories_slug_unique (slug),
    KEY categories_parent_index (parent_id),
    KEY categories_content_type_index (content_type),
    CONSTRAINT categories_parent FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);
```

## Access Control

| Permission | Description | Default Role |
|------------|-------------|-------------|
| `categories.create` | Create categories | Editor |
| `categories.edit-any` | Edit any category | Editor |
| `categories.edit-own` | Edit own categories | Author |
| `categories.delete` | Delete categories | Admin |
| `categories.reorder` | Reorder category tree | Editor |
| `categories.seo` | Edit category SEO | SEO Manager |

## Acceptance Criteria

- [ ] Categories support nested hierarchy up to 5 levels deep
- [ ] Drag-and-drop reordering works in the admin tree view
- [ ] Circular parent references are prevented
- [ ] Each category generates a paginated frontend listing page
- [ ] SEO metadata fields are available per category
- [ ] Categories can be filtered by content type
- [ ] Post count is accurately maintained per category
- [ ] Breadcrumb navigation reflects the full category path
- [ ] Soft-deleting a category preserves child categories (re-parents to grandparent)
- [ ] Category slugs are unique within their content type
