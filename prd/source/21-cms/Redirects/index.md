# Redirect Management

> PRD — Volume 21: CMS & Content — Redirects

## Overview

The Redirect Management system handles URL redirections for migrated content, changed slugs, and site restructuring. It supports 301 (permanent) and 302 (temporary) redirects, bulk import/export, pattern matching with wildcards, and hit tracking analytics.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Redirect processing | Time from request to 301/302 | < 5ms |
| Bulk import speed | 10,000 redirects import time | < 30 seconds |
| Pattern matching | Wildcard redirect accuracy | 100% |
| Analytics accuracy | Hit tracking precision | 100% |
| Chain detection | Circular redirect detection | Real-time |

## Redirect Types

| Type | Code | Use Case | SEO Impact |
|------|------|----------|------------|
| Permanent | `301` | Content moved permanently | Passes full link juice |
| Temporary | `302` | Content temporarily relocated | Preserves original ranking |
| Temporary | `307` | Temporary, method-preserving | Preserves request method |
| Permanent | `308` | Permanent, method-preserving | Passes full link juice, preserves method |

### When to Use Each Type

| Scenario | Recommended Code | Reason |
|----------|-----------------|--------|
| Page slug changed | `301` | Permanent move, preserve SEO |
| A/B test variant | `302` | Temporary, original should rank |
| Site maintenance page | `302` | Temporary redirect |
| HTTP → HTTPS migration | `301` | Permanent protocol change |
| www → non-www | `301` | Permanent domain change |
| URL structure change | `301` | Permanent restructuring |

## Redirect Schema

### Database Schema

```sql
CREATE TABLE redirects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    from_url VARCHAR(2048) NOT NULL,
    to_url VARCHAR(2048) NOT NULL,
    type SMALLINT NOT NULL DEFAULT 301,
    is_pattern BOOLEAN NOT NULL DEFAULT FALSE,
    is_regex BOOLEAN NOT NULL DEFAULT FALSE,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    notes TEXT NULL,
    hits INT UNSIGNED NOT NULL DEFAULT 0,
    last_hit_at TIMESTAMP NULL,
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    KEY redirects_from_url_index (from_url(191)),
    KEY redirects_type_index (type),
    KEY redirects_active_index (is_active)
);
```

### Redirect Model

```php
class Redirect extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from_url', 'to_url', 'type', 'is_pattern',
        'is_regex', 'is_active', 'notes',
    ];

    protected $casts = [
        'is_pattern' => 'boolean',
        'is_regex' => 'boolean',
        'is_active' => 'boolean',
        'type' => 'integer',
    ];

    public function resolve(string $url): ?string
    {
        if (!$this->is_active) return null;

        if ($this->is_regex) {
            return $this->resolveRegex($url);
        }

        if ($this->is_pattern) {
            return $this->resolvePattern($url);
        }

        return $this->from_url === $url ? $this->to_url : null;
    }

    private function resolvePattern(string $url): ?string
    {
        $pattern = str_replace('*', '(.*)', $this->from_url);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $url, $matches)) {
            $toUrl = $this->to_url;
            foreach ($matches as $index => $match) {
                $toUrl = str_replace('$' . $index, $match, $toUrl);
            }
            return $toUrl;
        }

        return null;
    }

    private function resolveRegex(string $url): ?string
    {
        if (preg_match($this->from_url, $url, $matches)) {
            $toUrl = $this->to_url;
            foreach ($matches as $index => $match) {
                $toUrl = str_replace('$' . $index, $match, $toUrl);
            }
            return $toUrl;
        }

        return null;
    }

    public function recordHit(): void
    {
        $this->increment('hits');
        $this->update(['last_hit_at' => now()]);
    }
}
```

## Pattern Matching

### Pattern Syntax

| Pattern | Example From | Example To | Result |
|---------|-------------|------------|--------|
| Wildcard | `/old-blog/*` | `/blog/$1` | `/old-blog/post-1` → `/blog/post-1` |
| Double wildcard | `*/docs/*` | `/documentation/$2` | `/v2/docs/setup` → `/documentation/setup` |
| Regex | `/^\/products\/(\d+)$/` | `/items/$1` | `/products/42` → `/items/42` |
| Query preservation | `/search?old=1` | `/search?new=1` | Preserves other query params |

### Pattern Resolution

```php
class RedirectResolver
{
    public function resolve(string $url): ?RedirectResult
    {
        // Check exact matches first (fastest)
        $exact = Redirect::where('from_url', $url)
            ->where('is_active', true)
            ->where('is_pattern', false)
            ->first();

        if ($exact) {
            $exact->recordHit();
            return new RedirectResult($exact->to_url, $exact->type);
        }

        // Check pattern matches
        $patterns = Redirect::where('is_pattern', true)
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        foreach ($patterns as $pattern) {
            $resolved = $pattern->resolve($url);
            if ($resolved) {
                $pattern->recordHit();
                return new RedirectResult($resolved, $pattern->type);
            }
        }

        // Check regex matches
        $regexes = Redirect::where('is_regex', true)
            ->where('is_active', true)
            ->get();

        foreach ($regexes as $regex) {
            $resolved = $regex->resolve($url);
            if ($resolved) {
                $regex->recordHit();
                return new RedirectResult($resolved, $regex->type);
            }
        }

        return null;
    }
}
```

## Bulk Import/Export

### Import Format

| Format | Description | Delimiter |
|--------|-------------|-----------|
| CSV | Standard CSV with headers | Comma |
| TSV | Tab-separated values | Tab |
| JSON | JSON array of redirect objects | — |
| Nginx | Nginx rewrite rules | Space |
| Apache | Apache .htaccess format | Space |

### CSV Import Schema

```csv
from_url,to_url,type,is_pattern,notes
/old-page,/new-page,301,false,Migrated from old site
/blog/*,/news/$1,301,true,Blog to news migration
/old-cat/*,/category/$1,301,true,Category restructuring
```

### Import Component

```php
class RedirectImport extends Component
{
    public ?UploadedFile $file = null;
    public string $format = 'csv';
    public bool $overwriteExisting = false;
    public int $importedCount = 0;
    public int $skippedCount = 0;
    public array $errors = [];

    public function import(): void
    {
        $this->validate([
            'file' => 'required|file|max:10240',
            'format' => 'required|in:csv,tsv,json',
        ]);

        $rows = $this->parseFile();
        $this->errors = [];
        $this->importedCount = 0;
        $this->skippedCount = 0;

        DB::transaction(function () use ($rows) {
            foreach ($rows as $index => $row) {
                try {
                    $this->validateRow($row, $index + 1);

                    $existing = Redirect::where('from_url', $row['from_url'])->first();

                    if ($existing && !$this->overwriteExisting) {
                        $this->skippedCount++;
                        continue;
                    }

                    if ($existing) {
                        $existing->update($row);
                    } else {
                        Redirect::create($row);
                    }

                    $this->importedCount++;
                } catch (ValidationException $e) {
                    $this->errors[] = "Row {$index}: " . $e->getMessage();
                }
            }
        });

        $this->dispatch('import-completed', [
            'imported' => $this->importedCount,
            'skipped' => $this->skippedCount,
            'errors' => count($this->errors),
        ]);
    }
}
```

## Analytics

### Hit Tracking

| Metric | Description | Granularity |
|--------|-------------|-------------|
| Total hits | Total redirect invocations | Cumulative |
| Daily hits | Hits per redirect per day | Daily |
| Source URLs | Most redirected-from URLs | Top 100 |
| Destination URLs | Most redirected-to URLs | Top 100 |
| Response codes | Breakdown of 301 vs 302 usage | Cumulative |
| Last hit | When redirect was last triggered | Per redirect |

### Analytics Dashboard

```php
class RedirectAnalytics extends Component
{
    public int $totalHits = 0;
    public int $activeRedirects = 0;
    public array $topRedirects = [];
    public array $dailyHits = [];

    public function mount(): void
    {
        $this->totalHits = Redirect::sum('hits');
        $this->activeRedirects = Redirect::where('is_active', true)->count();
        $this->topRedirects = Redirect::orderByDesc('hits')
            ->limit(20)
            ->get()
            ->toArray();
        $this->dailyHits = RedirectHit::selectRaw('DATE(created_at) as date, COUNT(*) as hits')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }
}
```

### Chain Detection

```php
class RedirectChainDetector
{
    public function detectChains(): array
    {
        $chains = [];
        $redirects = Redirect::where('is_active', true)
            ->get()
            ->keyBy('from_url');

        foreach ($redirects as $redirect) {
            $chain = [$redirect->from_url];
            $currentTo = $redirect->to_url;
            $visited = [$redirect->from_url];

            while (isset($redirects[$currentTo]) && !in_array($currentTo, $visited)) {
                $chain[] = $currentTo;
                $visited[] = $currentTo;
                $currentTo = $redirects[$currentTo]->to_url;
            }

            if (count($chain) > 1) {
                $chains[] = $chain;
            }
        }

        return $chains;
    }

    public function detectLoops(): array
    {
        $loops = [];
        $redirects = Redirect::where('is_active', true)->get();

        foreach ($redirects as $redirect) {
            $visited = [];
            $current = $redirect->from_url;

            while (true) {
                if (in_array($current, $visited)) {
                    $loops[] = array_slice($visited, array_search($current, $visited));
                    break;
                }

                $visited[] = $current;
                $match = $redirects->firstWhere('from_url', $current);

                if (!$match) break;

                $current = $match->to_url;
            }
        }

        return $loops;
    }
}
```

## Livewire Components

| Component | Namespace | Description |
|-----------|-----------|-------------|
| `redirect-list` | `App\Livewire\Cms\Redirects\RedirectList` | Redirect listing with search |
| `redirect-create` | `App\Livewire\Cms\Redirects\RedirectCreate` | Single redirect creation form |
| `redirect-import` | `App\Livewire\Cms\Redirects\RedirectImport` | Bulk import interface |
| `redirect-analytics` | `App\Livewire\Cms\Redirects\RedirectAnalytics` | Hit tracking dashboard |
| `redirect-tester` | `App\Livewire\Cms\Redirects\RedirectTester` | Test redirect resolution |

## Access Control

| Permission | Description | Default Role |
|------------|-------------|-------------|
| `redirects.create` | Create redirects | Editor |
| `redirects.edit` | Edit existing redirects | Editor |
| `redirects.delete` | Delete redirects | Admin |
| `redirects.import` | Bulk import redirects | Admin |
| `redirects.export` | Export redirect data | Admin |
| `redirects.analytics` | View redirect analytics | Editor |

## Acceptance Criteria

- [ ] Exact URL matches resolve in under 5ms
- [ ] Wildcard patterns correctly capture and substitute URL segments
- [ ] Regex redirects support full PCRE syntax
- [ ] Bulk import handles 10,000+ rows within 30 seconds
- [ ] Import validates all rows before committing
- [ ] Chain detection identifies multi-hop redirect chains
- [ ] Loop detection prevents infinite redirect loops
- [ ] Hit tracking increments accurately on each redirect
- [ ] Analytics dashboard shows daily hit trends
- [ ] Export produces valid CSV/JSON that can be re-imported
