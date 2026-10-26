# 14 - Documentation Engine

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The Documentation Engine is the structured knowledge platform for GsmUi. It provides interactive, searchable, versioned documentation for every component, template, theme, and feature in the ecosystem.

---

# Vision

GsmUi documentation should be the gold standard for Laravel UI library documentation — interactive, beautiful, searchable, and always up-to-date.

---

# Core Features

## Content Types

* Component documentation
* Getting started guides
* Installation instructions
* API reference
* Theming guides
* Migration guides
* Tutorials
* Changelog
* FAQ

---

## Interactive Elements

* Live component previews
* Editable code examples
* Copy-to-clipboard
* Syntax highlighting
* Version switcher
* Dark mode support
* Playground integration

---

## Search

* Full-text search
* Component search
* API search
* Keyboard shortcuts (Cmd+K)
* Search suggestions
* Recent searches

---

# Documentation Structure

```text
Documentation Engine

├── Pages (hierarchical)
│   ├── Getting Started
│   ├── Installation
│   ├── Core Concepts
│   ├── Components
│   │   ├── Actions
│   │   ├── Forms
│   │   ├── Layout
│   │   ├── Navigation
│   │   ├── Data Display
│   │   ├── Feedback
│   │   ├── Overlays
│   │   ├── Media
│   │   └── Charts
│   ├── Templates
│   ├── Themes
│   ├── Blog
│   ├── API Reference
│   └── Changelog
├── Search Index
├── Version Manager
└── Analytics
```

---

# Page Components

Every documentation page should include:

## Header

* Breadcrumb navigation
* Page title
* Edit link
* Last updated

## Sidebar

* Table of contents
* Category navigation
* Version selector
* Search

## Content

* Markdown renderer
* Code blocks with syntax highlighting
* Live previews
* Props/Events tables
* Accessibility notes

## Footer

* Previous/Next navigation
* Contributing link
* Feedback widget

---

# Code Examples

Every component page should provide:

## Basic Example

```blade
<x-gsm-button variant="primary">
    Click me
</x-gsm-button>
```

## Livewire Example

```php
// Livewire component
public $count = 0;

public function increment()
{
    $this->count++;
}
```

```blade
<x-gsm-button wire:click="increment">
    Count: {{ $count }}
</x-gsm-button>
```

## Alpine.js Example

```html
<div x-data="{ open: false }">
    <x-gsm-button @click="open = !open">
        Toggle
    </x-gsm-button>
</div>
```

---

# Version Management

## Version Strategy

| Version | Status | Support |
|---------|--------|---------|
| v1.x | Active | Full support |
| v0.9 | Maintenance | Security only |
| v0.8 | Deprecated | None |

## Version Features

* Version selector dropdown
* URL-based versioning (`/docs/v1/components/button`)
* Cross-version search
* Migration guides between versions
* Deprecation warnings

---

# Search Architecture

## Index Structure

```text
Search Index

├── Component Pages
│   ├── Name
│   ├── Description
│   ├── Category
│   ├── Props
│   └── Examples
├── Guide Pages
│   ├── Title
│   ├── Content
│   └── Tags
├── API Reference
│   ├── Endpoint
│   ├── Parameters
│   └── Response
└── Blog Posts
    ├── Title
    ├── Content
    └── Tags
```

## Search Features

* Instant results
* Fuzzy matching
* Category filtering
* Keyboard navigation
* Search history
* Saved searches

---

# Live Preview System

## Preview Architecture

```text
User edits code
    ↓
Code parser
    ↓
Sandbox renderer
    ↓
Preview iframe
    ↓
Real-time update
```

## Preview Features

* Real-time rendering
* Responsive preview (desktop/tablet/mobile)
* Dark/light mode toggle
* Copy rendered markup
* Export to playground

---

# Documentation CMS

## Content Management

* Markdown editor
* WYSIWYG fallback
* Media management
* Draft/Published states
* Scheduled publishing
* Version control

## Content Pipeline

```text
Author writes Markdown
    ↓
Front-matter parsing
    ↓
Content validation
    ↓
Search index update
    ↓
Cache invalidation
    ↓
Live deployment
```

---

# SEO Optimization

## Technical SEO

* Server-side rendering
* Semantic HTML
* Meta tags
* Open Graph
* Twitter Cards
* Sitemap.xml
* Robots.txt

## Content SEO

* Keyword optimization
* Internal linking
* Breadcrumbs
* Structured data
* Fast loading

---

# Analytics & Metrics

Track documentation effectiveness:

* Page views
* Time on page
* Search queries
* Zero-result searches
* Code example copies
* Playground usage
* Feedback scores

---

# API Reference

## Auto-generated Documentation

The documentation engine should auto-generate API reference from:

* Route definitions
* Form Request classes
* Resource transformers
* Policy methods
* Event classes

## API Page Structure

```text
Endpoint

├── Method + URL
├── Description
├── Authentication
├── Parameters
│   ├── Path
│   ├── Query
│   └── Body
├── Request Example
├── Response Schema
├── Response Example
├── Error Codes
└── Code Samples
```

---

# Internationalization

## Supported Languages (Future)

* English (default)
* Spanish
* French
* German
* Japanese
* Chinese
* Portuguese

## i18n Features

* RTL support
* Locale-based routing
* Translation management
* Community translations

---

# Performance Requirements

| Metric | Target |
|--------|--------|
| First Contentful Paint | <1.0s |
| Largest Contentful Paint | <2.5s |
| Time to Interactive | <3.0s |
| Search Response | <100ms |
| Page Navigation | <200ms |

---

# Technical Stack

| Layer | Technology |
|-------|------------|
| Framework | Laravel 13 |
| Rendering | Livewire 4 |
| UI | GsmUi Components |
| Styling | Tailwind CSS v4 |
| Search | Laravel Scout + Meilisearch |
| Markdown | CommonMark |
| Code Highlighting | Highlight.js |
| Editor | Monaco Editor |
| Caching | Redis |

---

# Database Schema

Key tables:

* `doc_pages` — Documentation pages
* `doc_categories` — Page categories
* `doc_versions` — Documentation versions
* `doc_search_index` — Search index
* `doc_feedback` — User feedback

---

# Admin Features

* Page editor
* Category management
* Version management
* Search analytics
* Feedback review
* SEO tools
* Redirect manager

---

# Success Metrics

* 5,000+ documentation pages
* <100ms search response
* 95%+ user satisfaction
* 50%+ code example usage
* <2% bounce rate on component pages

---

# Detailed Component Documentation Pages

Every component documentation page follows a standardized structure to ensure consistency and completeness.

## Page Layout Structure

```text
Component Page Layout

├── Hero Section
│   ├── Component Name
│   ├── Brief Description
│   ├── Version Badge
│   └── Quick Actions (Copy, Edit, GitHub)
├── Preview Section
│   ├── Live Component Preview
│   ├── Responsive Toggle (Desktop/Tablet/Mobile)
│   ├── Theme Toggle (Light/Dark)
│   └── Full Screen Preview
├── Usage Section
│   ├── Basic Usage
│   ├── With Props
│   ├── With Events
│   ├── With Slots
│   └── With Livewire
├── Props Table
│   ├── Prop Name
│   ├── Type
│   ├── Default Value
│   ├── Required
│   └── Description
├── Events Table
│   ├── Event Name
│   ├── Payload
│   ├── Description
│   └── Example
├── Slots Table
│   ├── Slot Name
│   ├── Scope
│   ├── Description
│   └── Example
├── Examples Section
│   ├── Basic Examples
│   ├── Advanced Examples
│   ├── Real-world Examples
│   └── Copy-paste Examples
├── Accessibility Section
│   ├── ARIA Attributes
│   ├── Keyboard Navigation
│   ├── Screen Reader Support
│   └── Color Contrast
├── Best Practices
│   ├── Do's
│   ├── Don'ts
│   └── Common Patterns
├── Related Components
│   ├── Similar Components
│   ├── Complementary Components
│   └── Alternatives
└── Footer Navigation
    ├── Previous Component
    └── Next Component
```

## Component Page Template

```blade
<x-docs.layout>
    <x-slot:title>{{ $component->name }}</x-slot:title>
    
    {{-- Hero Section --}}
    <section class="docs-hero">
        <h1>{{ $component->name }}</h1>
        <p>{{ $component->description }}</p>
        <div class="badges">
            <span class="badge">v{{ $component->version }}</span>
            <span class="badge">{{ $component->category }}</span>
        </div>
    </section>
    
    {{-- Preview Section --}}
    <section class="docs-preview">
        <x-docs.component-preview 
            :component="$component"
            :responsive="true"
            :themes="['light', 'dark']"
        />
    </section>
    
    {{-- Usage Section --}}
    <section class="docs-usage">
        <h2>Usage</h2>
        <x-docs.code-block 
            :code="$component->basic_usage"
            language="blade"
        />
    </section>
    
    {{-- Props Table --}}
    <section class="docs-props">
        <h2>Props</h2>
        <x-docs.props-table :props="$component->props" />
    </section>
    
    {{-- Events Table --}}
    <section class="docs-events">
        <h2>Events</h2>
        <x-docs.events-table :events="$component->events" />
    </section>
    
    {{-- Slots Table --}}
    <section class="docs-slots">
        <h2>Slots</h2>
        <x-docs.slots-table :slots="$component->slots" />
    </section>
    
    {{-- Examples Section --}}
    <section class="docs-examples">
        <h2>Examples</h2>
        @foreach($component->examples as $example)
            <x-docs.example 
                :title="$example->title"
                :code="$example->code"
                :description="$example->description"
            />
        @endforeach
    </section>
    
    {{-- Accessibility Section --}}
    <section class="docs-accessibility">
        <h2>Accessibility</h2>
        <x-docs.accessibility-guide :component="$component" />
    </section>
    
    {{-- Best Practices --}}
    <section class="docs-best-practices">
        <h2>Best Practices</h2>
        <x-docs.best-practices :component="$component" />
    </section>
    
    {{-- Related Components --}}
    <section class="docs-related">
        <h2>Related Components</h2>
        <x-docs.related-components :components="$component->related" />
    </section>
</x-docs.layout>
```

## Component Data Structure

```php
class ComponentDocumentation
{
    public string $name;
    public string $slug;
    public string $description;
    public string $category;
    public string $version;
    public array $props;
    public array $events;
    public array $slots;
    public array $examples;
    public array $related;
    public array $accessibility;
    public array $bestPractices;
    public array $changelog;
}
```

## Props Table Structure

```php
class PropDocumentation
{
    public string $name;
    public string $type;
    public mixed $default;
    public bool $required;
    public string $description;
    public array $acceptedValues;
    public ?string $deprecation;
    public ?string $since;
}
```

## Events Table Structure

```php
class EventDocumentation
{
    public string $name;
    public string $description;
    public array $payload;
    public string $since;
    public ?string $deprecation;
}
```

## Slots Table Structure

```php
class SlotDocumentation
{
    public string $name;
    public string $description;
    public array $scope;
    public bool $required;
    public string $fallback;
}
```

---

# Search Implementation Details

## Search Index Structure

```json
{
  "index": "gsmui_docs",
  "fields": [
    {
      "name": "id",
      "type": "identifier",
      "sortable": true
    },
    {
      "name": "title",
      "type": "text",
      "searchable": true,
      "sortable": true,
      "weight": 10
    },
    {
      "name": "content",
      "type": "text",
      "searchable": true,
      "weight": 5
    },
    {
      "name": "category",
      "type": "facet",
      "sortable": true
    },
    {
      "name": "type",
      "type": "facet",
      "sortable": true
    },
    {
      "name": "tags",
      "type": "facet",
      "multi": true
    },
    {
      "name": "props",
      "type": "text",
      "searchable": true,
      "weight": 8
    },
    {
      "name": "examples",
      "type": "text",
      "searchable": true,
      "weight": 3
    },
    {
      "name": "updated_at",
      "type": "datetime",
      "sortable": true
    }
  ],
  "filterableAttributes": [
    "category",
    "type",
    "tags"
  ],
  "sortableAttributes": [
    "title",
    "updated_at",
    "category"
  ],
  "pagination": {
    "maxTotalHits": 1000,
    "maxValuesPerFacet": 100
  }
}
```

## Search Query Builder

```php
class DocumentationSearch
{
    public function search(string $query, array $filters = []): SearchResult
    {
        $search = new SearchQuery();
        
        $search->setQuery($query)
            ->setAttributesToHighlight(['title', 'content', 'props'])
            ->setAttributesToCrop(['content:200'])
            ->setFilter($this->buildFilters($filters))
            ->setSort($this->buildSort($filters));
        
        return $this->meilisearch->index('gsmui_docs')->search($search);
    }
    
    private function buildFilters(array $filters): array
    {
        $filterBuilder = FilterBuilder::and();
        
        if (isset($filters['category'])) {
            $filterBuilder->addFilter(
                Filter::attribute('category')->isEqualTo($filters['category'])
            );
        }
        
        if (isset($filters['type'])) {
            $filterBuilder->addFilter(
                Filter::attribute('type')->isEqualTo($filters['type'])
            );
        }
        
        if (isset($filters['tags'])) {
            foreach ($filters['tags'] as $tag) {
                $filterBuilder->addFilter(
                    Filter::attribute('tags')->contains($tag)
                );
            }
        }
        
        return $filterBuilder->getFilters();
    }
    
    private function buildSort(array $filters): array
    {
        $sort = match ($filters['sort'] ?? 'relevance') {
            'newest' => ['updated_at:desc'],
            'oldest' => ['updated_at:asc'],
            'title' => ['title:asc'],
            default => [],
        };
        
        return $sort;
    }
}
```

## Search Autocomplete

```php
class SearchAutocomplete
{
    public function getSuggestions(string $query): array
    {
        $suggestions = [];
        
        // Component suggestions
        $components = $this->searchComponents($query, 5);
        foreach ($components as $component) {
            $suggestions[] = [
                'type' => 'component',
                'title' => $component->name,
                'description' => $component->description,
                'url' => route('docs.component', $component->slug),
                'icon' => 'component',
            ];
        }
        
        // Guide suggestions
        $guides = $this->searchGuides($query, 5);
        foreach ($guides as $guide) {
            $suggestions[] = [
                'type' => 'guide',
                'title' => $guide->title,
                'description' => $guide->excerpt,
                'url' => route('docs.guide', $guide->slug),
                'icon' => 'guide',
            ];
        }
        
        // API reference suggestions
        $api = $this->searchApi($query, 5);
        foreach ($api as $endpoint) {
            $suggestions[] = [
                'type' => 'api',
                'title' => $endpoint->method . ' ' . $endpoint->path,
                'description' => $endpoint->description,
                'url' => route('docs.api', $endpoint->slug),
                'icon' => 'api',
            ];
        }
        
        return $suggestions;
    }
    
    public function getRecentSearches(string $userId): array
    {
        return Cache::remember(
            "recent_searches_{$userId}",
            3600,
            fn () => DB::table('doc_search_history')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->pluck('query')
                ->toArray()
        );
    }
    
    public function saveSearch(string $userId, string $query): void
    {
        DB::table('doc_search_history')->insert([
            'user_id' => $userId,
            'query' => $query,
            'created_at' => now(),
        ]);
        
        // Trim old searches
        DB::table('doc_search_history')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->skip(50)
            ->delete();
    }
}
```

## Search Analytics

```php
class SearchAnalytics
{
    public function trackSearch(string $query, int $resultsCount, string $userId): void
    {
        DB::table('doc_search_analytics')->insert([
            'query' => $query,
            'results_count' => $resultsCount,
            'user_id' => $userId,
            'created_at' => now(),
        ]);
    }
    
    public function getZeroResultSearches(int $days = 30): Collection
    {
        return DB::table('doc_search_analytics')
            ->select('query', DB::raw('COUNT(*) as count'))
            ->where('results_count', 0)
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('query')
            ->orderBy('count', 'desc')
            ->limit(100)
            ->get();
    }
    
    public function getPopularSearches(int $days = 30): Collection
    {
        return DB::table('doc_search_analytics')
            ->select('query', DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('query')
            ->orderBy('count', 'desc')
            ->limit(100)
            ->get();
    }
}
```

---

# Live Preview System Architecture

## Preview Rendering Pipeline

```text
User Input
    ↓
Code Parser
    ├── Blade Parser
    ├── HTML Parser
    └── Component Parser
    ↓
Sandbox Builder
    ├── CSS Injection
    ├── JS Injection
    ├── Component Registration
    └── State Initialization
    ↓
Iframe Renderer
    ├── Content Security Policy
    ├── Sandboxed Context
    ├── Responsive Container
    └── Theme Application
    ↓
Preview Output
    ├── Visual Render
    ├── Error Display
    └── Interaction Handler
```

## Preview Iframe Security

```php
class PreviewSandbox
{
    private const CSP_DIRECTIVES = [
        'default-src' => ["'none'"],
        'script-src' => ["'self'", "'unsafe-inline'"],
        'style-src' => ["'self'", "'unsafe-inline'"],
        'img-src' => ["'self'", 'data:'],
        'font-src' => ["'self'"],
        'connect-src' => ["'none'"],
        'frame-src' => ["'none'"],
        'object-src' => ["'none'"],
    ];
    
    public function render(string $code, array $context = []): string
    {
        $html = $this->buildSandboxHtml($code, $context);
        
        return view('docs.partials.preview-iframe', [
            'html' => $html,
            'csp' => $this->buildCspHeader(),
            'nonce' => $this->generateNonce(),
        ])->render();
    }
    
    private function buildSandboxHtml(string $code, array $context): string
    {
        $blade = Blade::compileString($code);
        
        $compiled = $this->compiler->compile($code);
        
        $sandboxed = str_replace(
            ['@extends', '@section', '@yield'],
            ['{{-- @extends --}}', '{{-- @section --}}', '{{-- @yield --}}'],
            $compiled
        );
        
        return $this->wrapInSandbox($sandboxed, $context);
    }
    
    private function wrapInSandbox(string $html, array $context): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="/css/gsmui.css">
            <style>
                body { 
                    margin: 0; 
                    padding: 16px; 
                    font-family: system-ui, sans-serif;
                    background: var(--gsm-bg, white);
                    color: var(--gsm-text, #1f2937);
                }
            </style>
        </head>
        <body>
            {$html}
            <script src="/js/gsmui.js"></script>
            <script>
                // Prevent navigation
                document.addEventListener('click', (e) => {
                    if (e.target.closest('a[href]')) {
                        e.preventDefault();
                    }
                });
                
                // Prevent form submission
                document.addEventListener('submit', (e) => {
                    e.preventDefault();
                });
                
                // Send events to parent
                window.parent.postMessage({
                    type: 'preview:ready',
                    height: document.body.scrollHeight
                }, '*');
            </script>
        </body>
        </html>
        HTML;
    }
}
```

## Preview Component Registry

```php
class PreviewComponentRegistry
{
    private array $components = [];
    
    public function register(string $name, string $class): void
    {
        $this->components[$name] = [
            'class' => $class,
            'props' => $this->extractProps($class),
            'events' => $this->extractEvents($class),
            'slots' => $this->extractSlots($class),
        ];
    }
    
    public function getComponent(string $name): ?array
    {
        return $this->components[$name] ?? null;
    }
    
    public function getAllComponents(): array
    {
        return $this->components;
    }
    
    public function getComponentsByCategory(string $category): array
    {
        return array_filter(
            $this->components,
            fn ($component) => $component['category'] === $category
        );
    }
    
    private function extractProps(string $class): array
    {
        $reflection = new ReflectionClass($class);
        $props = [];
        
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $props[] = [
                'name' => $property->getName(),
                'type' => $property->getType()?->getName() ?? 'mixed',
                'default' => $property->getDefaultValue(),
                'required' => !$property->hasDefaultValue(),
            ];
        }
        
        return $props;
    }
}
```

## Preview Error Handling

```php
class PreviewErrorHandler
{
    public function handleThrowable(Throwable $e): array
    {
        return [
            'error' => true,
            'type' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $this->sanitizeTrace($e->getTrace()),
        ];
    }
    
    public function handleBladeError(CompilationException $e): array
    {
        return [
            'error' => true,
            'type' => 'blade_compilation',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'hint' => $this->extractHint($e),
        ];
    }
    
    private function sanitizeTrace(array $trace): array
    {
        return array_map(fn ($frame) => [
            'file' => $frame['file'] ?? 'unknown',
            'line' => $frame['line'] ?? 0,
            'function' => $frame['function'] ?? 'unknown',
        ], array_slice($trace, 0, 10));
    }
}
```

---

# Version Management System

## Version Strategy Details

```php
class VersionManager
{
    private const VERSION_PATTERN = '/^v(\d+)\.(\d+)\.(\d+)$/';
    
    public function getCurrentVersion(): string
    {
        return config('docs.current_version', 'v1');
    }
    
    public function getVersions(): array
    {
        return Cache::remember('doc_versions', 3600, function () {
            return Version::orderBy('major', 'desc')
                ->orderBy('minor', 'desc')
                ->get()
                ->map(fn ($v) => [
                    'version' => $v->version,
                    'status' => $v->status,
                    'released_at' => $v->released_at,
                    'is_current' => $v->version === $this->getCurrentVersion(),
                ])
                ->toArray();
        });
    }
    
    public function getVersionDiff(string $from, string $to): array
    {
        return Cache::remember(
            "version_diff_{$from}_{$to}",
            3600,
            fn () => $this->calculateDiff($from, $to)
        );
    }
    
    private function calculateDiff(string $from, string $to): array
    {
        $fromPages = $this->getVersionPages($from);
        $toPages = $this->getVersionPages($to);
        
        return [
            'added' => array_diff_key($toPages, $fromPages),
            'removed' => array_diff_key($fromPages, $toPages),
            'modified' => $this->findModified($fromPages, $toPages),
        ];
    }
    
    private function getVersionPages(string $version): array
    {
        return DB::table('doc_pages')
            ->where('version', $version)
            ->pluck('slug', 'id')
            ->toArray();
    }
    
    private function findModified(array $from, array $to): array
    {
        $modified = [];
        $common = array_intersect_key($from, $to);
        
        foreach ($common as $id => $slug) {
            $fromPage = $this->getPageContent($id, 'from');
            $toPage = $this->getPageContent($id, 'to');
            
            if ($fromPage !== $toPage) {
                $modified[] = [
                    'id' => $id,
                    'slug' => $slug,
                    'changes' => $this->diffContent($fromPage, $toPage),
                ];
            }
        }
        
        return $modified;
    }
}
```

## URL-Based Versioning

```php
class VersionedRouteRegistrar
{
    public function register(): void
    {
        Route::middleware(['doc.version'])->prefix('{version?}')->group(function () {
            Route::get('/', [DocsController::class, 'index'])->name('docs.index');
            Route::get('/{category}', [DocsController::class, 'category'])->name('docs.category');
            Route::get('/{category}/{component}', [DocsController::class, 'component'])->name('docs.component');
            Route::get('/api/{endpoint}', [DocsController::class, 'api'])->name('docs.api');
            Route::get('/guides/{guide}', [DocsController::class, 'guide'])->name('docs.guide');
        });
    }
}

class VersionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $version = $request->route('version');
        
        if ($version && !$this->isValidVersion($version)) {
            abort(404, 'Version not found');
        }
        
        $request->attributes->set('doc_version', $version ?? config('docs.current_version'));
        
        return $next($request);
    }
    
    private function isValidVersion(string $version): bool
    {
        return in_array($version, $this->getAvailableVersions());
    }
    
    private function getAvailableVersions(): array
    {
        return Cache::remember('available_versions', 3600, function () {
            return DB::table('doc_versions')
                ->where('status', '!=', 'deprecated')
                ->pluck('version')
                ->toArray();
        });
    }
}
```

## Cross-Version Search

```php
class CrossVersionSearch
{
    public function search(string $query, ?string $targetVersion = null): array
    {
        $versions = $targetVersion 
            ? [$targetVersion] 
            : array_slice($this->getSearchableVersions(), 0, 3);
        
        $results = [];
        
        foreach ($versions as $version) {
            $index = $this->meilisearch->index("docs_{$version}");
            $versionResults = $index->search($query, [
                'limit' => 10,
                'attributesToHighlight' => ['title', 'content'],
            ]);
            
            foreach ($versionResults['hits'] as $hit) {
                $results[] = [
                    'version' => $version,
                    'title' => $hit['title'],
                    'content' => $hit['content'],
                    'url' => route('docs.component', [
                        'version' => $version,
                        'component' => $hit['slug'],
                    ]),
                    'score' => $hit['_rankingScore'] ?? 0,
                ];
            }
        }
        
        usort($results, fn ($a, $b) => $b['score'] <=> $a['score']);
        
        return array_slice($results, 0, 20);
    }
    
    private function getSearchableVersions(): array
    {
        return DB::table('doc_versions')
            ->where('status', '!=', 'deprecated')
            ->orderBy('major', 'desc')
            ->pluck('version')
            ->toArray();
    }
}
```

## Deprecation Warnings

```php
class DeprecationWarning
{
    public function check(string $component, string $version): ?array
    {
        $deprecation = DB::table('doc_deprecations')
            ->where('component', $component)
            ->where('since_version', '<=', $version)
            ->whereNull('removed_in')
            ->orWhere('removed_in', '>', $version)
            ->first();
        
        if (!$deprecation) {
            return null;
        }
        
        return [
            'component' => $component,
            'since' => $deprecation->since_version,
            'removed_in' => $deprecation->removed_in,
            'message' => $deprecation->message,
            'alternative' => $deprecation->alternative,
            'documentation' => $deprecation->documentation_url,
        ];
    }
    
    public function renderWarning(array $deprecation): string
    {
        return <<<HTML
        <div class="deprecation-warning">
            <strong>⚠️ Deprecated since v{$deprecation['since']}</strong>
            <p>{$deprecation['message']}</p>
            <p><strong>Alternative:</strong> {$deprecation['alternative']}</p>
            <a href="{$deprecation['documentation']}">View migration guide</a>
        </div>
        HTML;
    }
}
```

---

# CMS Content Pipeline

## Content Management System

```php
class DocumentationCms
{
    public function createPage(array $data): DocPage
    {
        $validated = $this->validate($data);
        
        $page = DocPage::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'type' => $validated['type'],
            'version' => $validated['version'],
            'status' => 'draft',
            'author_id' => auth()->id(),
            'published_at' => null,
        ]);
        
        $this->updateSearchIndex($page);
        
        return $page;
    }
    
    public function publishPage(DocPage $page): DocPage
    {
        $page->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
        
        $this->updateSearchIndex($page);
        $this->invalidateCache($page);
        $this->notifySubscribers($page);
        
        return $page;
    }
    
    public function schedulePage(DocPage $page, Carbon $publishAt): DocPage
    {
        $page->update([
            'status' => 'scheduled',
            'scheduled_at' => $publishAt,
        ]);
        
        Schedule::job(new PublishScheduledPage($page))
            ->at($publishAt);
        
        return $page;
    }
    
    public function updatePage(DocPage $page, array $data): DocPage
    {
        $validated = $this->validate($data);
        
        $page->update($validated);
        
        $this->createRevision($page);
        $this->updateSearchIndex($page);
        $this->invalidateCache($page);
        
        return $page;
    }
    
    private function createRevision(DocPage $page): void
    {
        DocPageRevision::create([
            'page_id' => $page->id,
            'content' => $page->content,
            'author_id' => auth()->id(),
            'created_at' => now(),
        ]);
    }
    
    private function updateSearchIndex(DocPage $page): void
    {
        $index = $this->meilisearch->index('gsmui_docs');
        
        $index->addDocuments([
            [
                'id' => $page->id,
                'title' => $page->title,
                'content' => $page->content,
                'category' => $page->category,
                'type' => $page->type,
                'tags' => $page->tags,
                'updated_at' => $page->updated_at,
            ],
        ]);
    }
    
    private function invalidateCache(DocPage $page): void
    {
        Cache::forget("doc_page_{$page->slug}");
        Cache::forget("doc_category_{$page->category}");
        Cache::forget("doc_sitemap");
    }
}
```

## Content Validation

```php
class DocumentationValidator
{
    public function validate(array $data): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:doc_pages,slug,' . ($data['id'] ?? null),
            'content' => 'required|string',
            'category' => 'required|in:' . implode(',', $this->getCategories()),
            'type' => 'required|in:component,guide,api,reference',
            'version' => 'required|string|exists:doc_versions,version',
            'tags' => 'sometimes|array',
            'tags.*' => 'string|max:50',
        ];
        
        return Validator::validate($data, $rules);
    }
    
    public function validateMarkdown(string $content): array
    {
        $errors = [];
        
        // Check for broken links
        preg_match_all('/\[([^\]]+)\]\(([^)]+)\)/', $content, $links);
        foreach ($links[2] as $link) {
            if (!$this->isValidLink($link)) {
                $errors[] = "Broken link: {$link}";
            }
        }
        
        // Check for missing headings
        if (!str_contains($content, '# ')) {
            $errors[] = 'Missing H1 heading';
        }
        
        // Check for code blocks without language
        preg_match_all('/```(\w*)/', $content, $codeBlocks);
        foreach ($codeBlocks[1] as $language) {
            if (empty($language)) {
                $errors[] = 'Code block without language specified';
            }
        }
        
        return $errors;
    }
    
    private function isValidLink(string $link): bool
    {
        if (Str::startsWith($link, '#')) {
            return true;
        }
        
        if (Str::startsWith($link, 'http')) {
            return filter_var($link, FILTER_VALIDATE_URL) !== false;
        }
        
        return DB::table('doc_pages')
            ->where('slug', $link)
            ->exists();
    }
}
```

## Media Management

```php
class DocumentationMedia
{
    public function upload(UploadedFile $file, string $type = 'image'): array
    {
        $path = $file->store('docs/media', 's3');
        
        $metadata = $this->extractMetadata($file, $path);
        
        return [
            'url' => Storage::disk('s3')->url($path),
            'path' => $path,
            'type' => $type,
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
            'metadata' => $metadata,
        ];
    }
    
    private function extractMetadata(UploadedFile $file, string $path): array
    {
        if (Str::startsWith($file->getMimeType(), 'image/')) {
            $imageInfo = getimagesize($file->getPathname());
            
            return [
                'width' => $imageInfo[0],
                'height' => $imageInfo[1],
            ];
        }
        
        return [];
    }
    
    public function optimize(string $path): void
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        match ($extension) {
            'jpg', 'jpeg' => $this->optimizeJpeg($path),
            'png' => $this->optimizePng($path),
            'gif' => $this->optimizeGif($path),
            'svg' => $this->optimizeSvg($path),
            default => null,
        };
    }
    
    private function optimizeJpeg(string $path): void
    {
        // Use Intervention Image or similar
    }
    
    private function optimizeSvg(string $path): void
    {
        $svg = Storage::disk('s3')->get($path);
        $optimized = $this->svgOptimizer->optimize($svg);
        Storage::disk('s3')->put($path, $optimized);
    }
}
```

## Cache Strategy

```php
class DocumentationCache
{
    private const CACHE_TTL = 3600; // 1 hour
    
    public function getPage(string $slug): ?DocPage
    {
        return Cache::remember(
            "doc_page_{$slug}",
            self::CACHE_TTL,
            fn () => DocPage::where('slug', $slug)->first()
        );
    }
    
    public function getCategory(string $category): Collection
    {
        return Cache::remember(
            "doc_category_{$category}",
            self::CACHE_TTL,
            fn () => DocPage::where('category', $category)->get()
        );
    }
    
    public function getSitemap(): array
    {
        return Cache::remember('doc_sitemap', self::CACHE_TTL, function () {
            return DocPage::where('status', 'published')
                ->get()
                ->map(fn ($page) => [
                    'loc' => route('docs.component', $page->slug),
                    'lastmod' => $page->updated_at->toIso8601String(),
                    'priority' => $page->type === 'component' ? '0.8' : '0.6',
                ])
                ->toArray();
        });
    }
    
    public function invalidate(DocPage $page): void
    {
        Cache::forget("doc_page_{$page->slug}");
        Cache::forget("doc_category_{$page->category}");
        Cache::forget('doc_sitemap');
        
        // Invalidate version cache
        Cache::forget("doc_version_{$page->version}");
    }
    
    public function warm(): void
    {
        $pages = DocPage::where('status', 'published')->get();
        
        foreach ($pages as $page) {
            Cache::put("doc_page_{$page->slug}", $page, self::CACHE_TTL);
        }
        
        $categories = $pages->pluck('category')->unique();
        foreach ($categories as $category) {
            $this->getCategory($category);
        }
        
        $this->getSitemap();
    }
}
```

---

# SEO Optimization Details

## Structured Data Implementation

```php
class DocumentationSeo
{
    public function getSchema(DocPage $page): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TechArticle',
            'headline' => $page->title,
            'description' => $page->description,
            'url' => route('docs.component', $page->slug),
            'datePublished' => $page->published_at->toIso8601String(),
            'dateModified' => $page->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => 'GsmUi',
                'url' => 'https://gsmui.com',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'GsmUi',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://gsmui.com/logo.png',
                ],
            ],
        ];
        
        if ($page->type === 'component') {
            $schema['@type'] = 'SoftwareApplication';
            $schema['applicationCategory'] = 'DeveloperApplication';
            $schema['operatingSystem'] = 'Laravel';
        }
        
        return $schema;
    }
    
    public function getMetaTags(DocPage $page): array
    {
        return [
            'title' => $page->seo_title ?? "{$page->title} - GsmUi Documentation",
            'description' => $page->seo_description ?? $page->description,
            'og:title' => $page->seo_title ?? $page->title,
            'og:description' => $page->seo_description ?? $page->description,
            'og:image' => $page->seo_image ?? 'https://gsmui.com/og-default.png',
            'og:url' => route('docs.component', $page->slug),
            'og:type' => 'article',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $page->seo_title ?? $page->title,
            'twitter:description' => $page->seo_description ?? $page->description,
            'twitter:image' => $page->seo_image ?? 'https://gsmui.com/og-default.png',
            'canonical' => route('docs.component', $page->slug),
        ];
    }
    
    public function generateSitemap(): string
    {
        $pages = DocPage::where('status', 'published')->get();
        
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        
        $urlset = $xml->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        
        foreach ($pages as $page) {
            $url = $xml->createElement('url');
            $url->appendChild($xml->createElement('loc', route('docs.component', $page->slug)));
            $url->appendChild($xml->createElement('lastmod', $page->updated_at->format('Y-m-d')));
            $url->appendChild($xml->createElement('priority', $page->type === 'component' ? '0.8' : '0.6'));
            $urlset->appendChild($url);
        }
        
        $xml->appendChild($urlset);
        
        return $xml->saveXML();
    }
}
```

## Internal Linking Strategy

```php
class InternalLinker
{
    public function getRelatedLinks(DocPage $page): array
    {
        $links = [];
        
        // Same category links
        $sameCategory = DocPage::where('category', $page->category)
            ->where('id', '!=', $page->id)
            ->where('status', 'published')
            ->limit(5)
            ->get();
        
        foreach ($sameCategory as $related) {
            $links[] = [
                'type' => 'category',
                'title' => $related->title,
                'url' => route('docs.component', $related->slug),
            ];
        }
        
        // Component relationship links
        if ($page->type === 'component') {
            $related = $this->getRelatedComponents($page);
            foreach ($related as $component) {
                $links[] = [
                    'type' => 'component',
                    'title' => $component->name,
                    'url' => route('docs.component', $component->slug),
                ];
            }
        }
        
        // Content-based links
        $contentLinks = $this->extractContentLinks($page->content);
        $links = array_merge($links, $contentLinks);
        
        return array_unique($links, SORT_REGULAR);
    }
    
    private function getRelatedComponents(DocPage $page): Collection
    {
        $componentName = Str::before($page->slug, '-');
        
        return DocPage::where('type', 'component')
            ->where('slug', 'like', "{$componentName}%")
            ->where('id', '!=', $page->id)
            ->where('status', 'published')
            ->get();
    }
    
    private function extractContentLinks(string $content): array
    {
        $links = [];
        
        preg_match_all('/\[\[([^\]]+)\]\]/', $content, $matches);
        
        foreach ($matches[1] as $match) {
            $page = DocPage::where('slug', $match)->first();
            
            if ($page) {
                $links[] = [
                    'type' => 'inline',
                    'title' => $page->title,
                    'url' => route('docs.component', $page->slug),
                ];
            }
        }
        
        return $links;
    }
}
```

---

# Analytics & Metrics Details

## Page Analytics

```php
class DocumentationAnalytics
{
    public function trackPageView(string $pageSlug, string $userId = null): void
    {
        DB::table('doc_analytics')->insert([
            'page_slug' => $pageSlug,
            'user_id' => $userId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->headers->get('referer'),
            'created_at' => now(),
        ]);
        
        Cache::increment("doc_views_{$pageSlug}");
    }
    
    public function trackCodeCopy(string $pageSlug, string $language): void
    {
        DB::table('doc_code_copies')->insert([
            'page_slug' => $pageSlug,
            'language' => $language,
            'user_id' => auth()->id(),
            'created_at' => now(),
        ]);
    }
    
    public function trackPlaygroundUsage(string $component, string $userId): void
    {
        DB::table('doc_playground_usage')->insert([
            'component' => $component,
            'user_id' => $userId,
            'created_at' => now(),
        ]);
    }
    
    public function getPageMetrics(string $pageSlug, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $views = DB::table('doc_analytics')
            ->where('page_slug', $pageSlug)
            ->where('created_at', '>=', $startDate)
            ->count();
        
        $uniqueVisitors = DB::table('doc_analytics')
            ->where('page_slug', $pageSlug)
            ->where('created_at', '>=', $startDate)
            ->distinct('ip_address')
            ->count();
        
        $codeCopies = DB::table('doc_code_copies')
            ->where('page_slug', $pageSlug)
            ->where('created_at', '>=', $startDate)
            ->count();
        
        $playgroundUsage = DB::table('doc_playground_usage')
            ->where('component', $pageSlug)
            ->where('created_at', '>=', $startDate)
            ->count();
        
        return [
            'views' => $views,
            'unique_visitors' => $uniqueVisitors,
            'code_copies' => $codeCopies,
            'playground_usage' => $playgroundUsage,
            'bounce_rate' => $this->calculateBounceRate($pageSlug, $startDate),
            'avg_time_on_page' => $this->calculateAvgTimeOnPage($pageSlug, $startDate),
        ];
    }
    
    private function calculateBounceRate(string $pageSlug, Carbon $startDate): float
    {
        $totalSessions = DB::table('doc_analytics')
            ->where('page_slug', $pageSlug)
            ->where('created_at', '>=', $startDate)
            ->count();
        
        $singlePageSessions = DB::table('doc_analytics')
            ->where('page_slug', $pageSlug)
            ->where('created_at', '>=', $startDate)
            ->where('pages_viewed', 1)
            ->count();
        
        return $totalSessions > 0 ? $singlePageSessions / $totalSessions : 0;
    }
    
    private function calculateAvgTimeOnPage(string $pageSlug, Carbon $startDate): float
    {
        $times = DB::table('doc_page_times')
            ->where('page_slug', $pageSlug)
            ->where('created_at', '>=', $startDate)
            ->pluck('time_seconds')
            ->toArray();
        
        return count($times) > 0 ? array_sum($times) / count($times) : 0;
    }
}
```

## Search Analytics Dashboard

```php
class SearchAnalyticsDashboard
{
    public function getMetrics(int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        return [
            'total_searches' => $this->getTotalSearches($startDate),
            'unique_queries' => $this->getUniqueQueries($startDate),
            'zero_result_rate' => $this->getZeroResultRate($startDate),
            'top_queries' => $this->getTopQueries($startDate),
            'zero_result_queries' => $this->getZeroResultQueries($startDate),
            'search_ctr' => $this->getSearchCtr($startDate),
            'avg_results_clicked' => $this->getAvgResultsClicked($startDate),
        ];
    }
    
    private function getTotalSearches(Carbon $startDate): int
    {
        return DB::table('doc_search_analytics')
            ->where('created_at', '>=', $startDate)
            ->count();
    }
    
    private function getUniqueQueries(Carbon $startDate): int
    {
        return DB::table('doc_search_analytics')
            ->where('created_at', '>=', $startDate)
            ->distinct('query')
            ->count();
    }
    
    private function getZeroResultRate(Carbon $startDate): float
    {
        $total = $this->getTotalSearches($startDate);
        $zeroResults = DB::table('doc_search_analytics')
            ->where('created_at', '>=', $startDate)
            ->where('results_count', 0)
            ->count();
        
        return $total > 0 ? $zeroResults / $total : 0;
    }
    
    private function getTopQueries(Carbon $startDate, int $limit = 20): array
    {
        return DB::table('doc_search_analytics')
            ->select('query', DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('query')
            ->orderBy('count', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
```

---

# User Flows

## Documentation Reader Flow

```text
User arrives at documentation
    ↓
Lands on Getting Started page
    ↓
Uses search to find component
    ↓
Views component documentation
    ├── Reads description
    ├── Views live preview
    ├── Copies code example
    ├── Reads props table
    └── Checks accessibility notes
    ↓
Tries component in Playground
    ↓
Exports code to clipboard
    ↓
Integrates into project
```

## Content Author Flow

```text
Author logs into CMS
    ↓
Creates new documentation page
    ├── Enters title and metadata
    ├── Writes content in Markdown
    ├── Adds code examples
    ├── Embeds live previews
    └── Sets SEO metadata
    ↓
Previews documentation page
    ↓
Submits for review
    ↓
Reviewer checks content
    ├── Validates code examples
    ├── Tests live previews
    ├── Checks accessibility
    └── Reviews SEO
    ↓
Approved and published
    ↓
Search index updated
    ↓
Cache invalidated
    ↓
Page live for users
```

## Version Migration Flow

```text
User views old version documentation
    ↓
Sees deprecation warning
    ↓
Clicks migration guide link
    ↓
Views version diff
    ├── Added features
    ├── Removed features
    └── Modified features
    ↓
Follows migration steps
    ↓
Updates code to new version
    ↓
Validates with new documentation
```

---

# API Contracts

## Documentation API

```yaml
openapi: 3.0.0
info:
  title: GsmUi Documentation API
  version: 1.0.0

paths:
  /api/docs/pages:
    get:
      summary: List documentation pages
      parameters:
        - name: category
          in: query
          schema:
            type: string
        - name: type
          in: query
          schema:
            type: string
            enum: [component, guide, api, reference]
        - name: version
          in: query
          schema:
            type: string
        - name: search
          in: query
          schema:
            type: string
        - name: page
          in: query
          schema:
            type: integer
        - name: per_page
          in: query
          schema:
            type: integer
      responses:
        '200':
          description: Successful response
          content:
            application/json:
              schema:
                type: object
                properties:
                  data:
                    type: array
                    items:
                      $ref: '#/components/schemas/DocPage'
                  meta:
                    $ref: '#/components/schemas/PaginationMeta'

  /api/docs/pages/{slug}:
    get:
      summary: Get documentation page
      parameters:
        - name: slug
          in: path
          required: true
          schema:
            type: string
      responses:
        '200':
          description: Successful response
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/DocPage'
        '404':
          description: Page not found

  /api/docs/search:
    get:
      summary: Search documentation
      parameters:
        - name: q
          in: query
          required: true
          schema:
            type: string
        - name: category
          in: query
          schema:
            type: string
        - name: type
          in: query
          schema:
            type: string
      responses:
        '200':
          description: Search results
          content:
            application/json:
              schema:
                $ref: '#/components/schemas/SearchResult'

components:
  schemas:
    DocPage:
      type: object
      properties:
        id:
          type: integer
        title:
          type: string
        slug:
          type: string
        description:
          type: string
        content:
          type: string
        category:
          type: string
        type:
          type: string
        version:
          type: string
        props:
          type: array
          items:
            $ref: '#/components/schemas/Prop'
        events:
          type: array
          items:
            $ref: '#/components/schemas/Event'
        slots:
          type: array
          items:
            $ref: '#/components/schemas/Slot'
        examples:
          type: array
          items:
            $ref: '#/components/schemas/Example'
        seo:
          $ref: '#/components/schemas/SeoMeta'
        published_at:
          type: string
          format: date-time
        updated_at:
          type: string
          format: date-time

    Prop:
      type: object
      properties:
        name:
          type: string
        type:
          type: string
        default:
          type: string
        required:
          type: boolean
        description:
          type: string

    Event:
      type: object
      properties:
        name:
          type: string
        description:
          type: string
        payload:
          type: array
          items:
            type: object

    Slot:
      type: object
      properties:
        name:
          type: string
        description:
          type: string
        scope:
          type: object

    Example:
      type: object
      properties:
        title:
          type: string
        description:
          type: string
        code:
          type: string
        language:
          type: string

    SearchResult:
      type: object
      properties:
        query:
          type: string
        results:
          type: array
          items:
            type: object
            properties:
              title:
                type: string
              url:
                type: string
              excerpt:
                type: string
              score:
                type: number

    PaginationMeta:
      type: object
      properties:
        current_page:
          type: integer
        last_page:
          type: integer
        per_page:
          type: integer
        total:
          type: integer
```

## Preview API

```yaml
openapi: 3.0.0
info:
  title: GsmUi Preview API
  version: 1.0.0

paths:
  /api/docs/preview:
    post:
      summary: Render component preview
      requestBody:
        required: true
        content:
          application/json:
            schema:
              type: object
              properties:
                code:
                  type: string
                component:
                  type: string
                props:
                  type: object
                theme:
                  type: string
                  enum: [light, dark]
                viewport:
                  type: string
                  enum: [desktop, tablet, mobile]
      responses:
        '200':
          description: Preview rendered
          content:
            application/json:
              schema:
                type: object
                properties:
                  html:
                    type: string
                  errors:
                    type: array
                    items:
                      type: object
                  warnings:
                    type: array
                    items:
                      type: object

  /api/docs/components:
    get:
      summary: List available components for preview
      responses:
        '200':
          description: Component list
          content:
            application/json:
              schema:
                type: array
                items:
                  $ref: '#/components/schemas/ComponentInfo'

components:
  schemas:
    ComponentInfo:
      type: object
      properties:
        name:
          type: string
        category:
          type: string
        description:
          type: string
        props:
          type: array
          items:
            type: object
        events:
          type: array
          items:
            type: object
        slots:
          type: array
          items:
            type: object
```

---

# Implementation Details

## Markdown Parser

```php
class DocumentationMarkdown
{
    private CommonMarkConverter $converter;
    
    public function __construct()
    {
        $this->converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'nunjucks_safe' => true,
        ], [
            new TableExtension(),
            new AutolinkExtension(),
            new StrikethroughExtension(),
            new FrontMatterExtension(),
            new TocExtension(),
        ]);
    }
    
    public function parse(string $markdown): array
    {
        $env = new Environment([]);
        $env->addExtension(new FrontMatterExtension());
        
        $document = $env->convert($markdown);
        
        $frontMatter = $document->data['front_matter'] ?? [];
        $content = $document->getContent();
        
        $html = $this->converter->convert($content)->getContent();
        
        $html = $this->addCodeHighlighting($html);
        $html = $this->addAnchors($html);
        $html = $this->addCopyButtons($html);
        
        return [
            'front_matter' => $frontMatter,
            'html' => $html,
            'toc' => $this->extractToc($html),
        ];
    }
    
    private function addCodeHighlighting(string $html): string
    {
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        
        $codeBlocks = $dom->getElementsByTagName('code');
        
        foreach ($codeBlocks as $code) {
            if ($code->parentNode->tagName === 'pre') {
                $language = $code->getAttribute('class');
                $language = str_replace('language-', '', $language);
                
                $highlighted = Highlighter::highlight($code->textContent, $language);
                
                $code->removeAttribute('class');
                $code->innerHTML = $highlighted->value;
            }
        }
        
        return $dom->saveHTML();
    }
    
    private function addAnchors(string $html): string
    {
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        
        $headings = $dom->getElementsByTagName('h1');
        $headings->merge($dom->getElementsByTagName('h2'));
        $headings->merge($dom->getElementsByTagName('h3'));
        $headings->merge($dom->getElementsByTagName('h4'));
        $headings->merge($dom->getElementsByTagName('h5'));
        $headings->merge($dom->getElementsByTagName('h6'));
        
        foreach ($headings as $heading) {
            $id = Str::slug($heading->textContent);
            $heading->setAttribute('id', $id);
            
            $anchor = $dom->createElement('a');
            $anchor->setAttribute('href', "#{$id}");
            $anchor->setAttribute('class', 'heading-anchor');
            $anchor->textContent = '#';
            
            $heading->appendChild($anchor);
        }
        
        return $dom->saveHTML();
    }
    
    private function addCopyButtons(string $html): string
    {
        return str_replace(
            '<pre>',
            '<pre><button class="copy-button" onclick="copyCode(this)">Copy</button>',
            $html
        );
    }
    
    private function extractToc(string $html): array
    {
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        
        $toc = [];
        $headings = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
        
        foreach ($headings as $heading) {
            $elements = $dom->getElementsByTagName($heading);
            
            foreach ($elements as $element) {
                $toc[] = [
                    'level' => (int) str_replace('h', '', $heading),
                    'text' => $element->textContent,
                    'id' => $element->getAttribute('id'),
                ];
            }
        }
        
        return $toc;
    }
}
```

## Code Example Generator

```php
class CodeExampleGenerator
{
    public function generateBladeExample(string $component, array $props = []): string
    {
        $componentClass = $this->getComponentClass($component);
        $tag = $this->getBladeTag($component);
        
        $attributes = $this->buildAttributes($props);
        
        if ($this->hasSlots($component)) {
            return $this->generateWithSlots($tag, $attributes, $props);
        }
        
        return "<{$tag}{$attributes} />";
    }
    
    public function generateLivewireExample(string $component, array $props = []): array
    {
        $blade = $this->generateBladeExample($component, $props);
        
        $className = Str::studly($component);
        
        $php = <<<PHP
        <?php
        
        namespace App\\Livewire;
        
        use Livewire\\Component;
        
        class {$className} extends Component
        {
            public \$state = [];
            
            public function render()
            {
                return view('livewire.' . Str::kebab('{$className}'));
            }
        }
        PHP;
        
        return [
            'blade' => $blade,
            'php' => $php,
        ];
    }
    
    private function buildAttributes(array $props): string
    {
        $attributes = [];
        
        foreach ($props as $key => $value) {
            if (is_bool($value)) {
                $attributes[] = $value ? ":{$key}" : '';
            } elseif (is_string($value)) {
                $attributes[] = "{$key}=\"{$value}\"";
            } elseif (is_array($value)) {
                $attributes[] = ":{$key}=\"" . addslashes(json_encode($value)) . "\"";
            }
        }
        
        return ' ' . implode(' ', array_filter($attributes));
    }
}
```

---

# Success Metrics Details

## Performance Targets

| Metric | Current | Target | Measurement |
|--------|---------|--------|-------------|
| First Contentful Paint | 1.2s | <1.0s | Lighthouse |
| Largest Contentful Paint | 2.8s | <2.5s | Lighthouse |
| Time to Interactive | 3.5s | <3.0s | Lighthouse |
| Search Response | 150ms | <100ms | API monitoring |
| Page Navigation | 250ms | <200ms | User timing |
| Code Example Load | 200ms | <150ms | API monitoring |
| Preview Render | 300ms | <200ms | Browser timing |

## User Engagement Metrics

| Metric | Target | Measurement |
|--------|--------|-------------|
| Pages per session | >3 | Analytics |
| Average session duration | >5 minutes | Analytics |
| Search usage | >30% of sessions | Analytics |
| Code copy rate | >50% of page views | Tracking |
| Playground usage | >20% of sessions | Tracking |
| Bounce rate | <2% on component pages | Analytics |
| Return visitor rate | >40% | Analytics |

## Content Quality Metrics

| Metric | Target | Measurement |
|--------|--------|-------------|
| User satisfaction rating | >4.5/5 | Feedback |
| Code example accuracy | 100% | Automated testing |
| Accessibility score | WCAG 2.2 AA | Audit |
| SEO score | >90/100 | Lighthouse |
| Documentation coverage | 100% of components | Audit |
| Update frequency | <7 days for new releases | Tracking |

---

# Next Document

**15 - Template Marketplace** — The commercial platform for selling and distributing GsmUi templates.
