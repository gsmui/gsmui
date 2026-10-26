# Performance

> Lazy loading, code splitting, asset optimization, critical CSS, image optimization, Core Web Vitals.

## Lazy Loading

```blade
{{-- Lazy load images --}}
<img src="{{ $product->image }}"
     alt="{{ $product->name }}"
     loading="lazy"
     decoding="async"
     class="h-auto w-full">

{{-- Lazy load sections --}}
<div x-data="{ loaded: false }" x-intersect.once="loaded = true">
    <template x-if="loaded">
        <div>
            {{-- Heavy content --}}
            <livewire:products.product-reviews :product="$product" />
        </div>
    </template>
</div>

{{-- Lazy load charts --}}
<div x-data="{ visible: false }" x-intersect.once="visible = true">
    <template x-if="visible">
        <div x-data="chart()" x-init="initChart()">
            {{-- Chart content --}}
        </div>
    </template>
</div>
```

## Code Splitting

```js
// resources/js/app.js
import('./modules/dashboard').then(module => {
    module.init();
});

// Dynamic imports
const loadChart = () => import('chart.js').then(m => m.default);
const loadEditor = () => import('@tiptap/core').then(m => m.Editor);

// Route-based splitting
const routes = {
    '/dashboard': () => import('./pages/dashboard'),
    '/products': () => import('./pages/products'),
    '/settings': () => import('./pages/settings'),
};
```

## Asset Optimization

```php
// config/vite.php
return [
    'build_time' => [
        'css' => [
            'purge' => true,
            'minify' => true,
        ],
        'js' => [
            'minify' => true,
            'treeshake' => true,
        ],
    ],
];
```

```blade
{{-- Preload critical assets --}}
<link rel="preload" href="{{ asset('fonts/inter-var.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::asset('resources/css/app.css') }}" as="style">

{{-- Preconnect to external domains --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://cdn.example.com">

{{-- DNS prefetch --}}
<link rel="dns-prefetch" href="https://analytics.example.com">
```

## Critical CSS

```php
// app/Services/CriticalCssService.php
class CriticalCssService
{
    public function getForRoute(string $route): ?string
    {
        $cacheKey = "critical-css:{$route}";

        return Cache::remember($cacheKey, 86400, function () use ($route) {
            return $this->generate($route);
        });
    }

    protected function generate(string $route): string
    {
        // Use PurgeCSS or similar to extract critical CSS
        $css = file_get_contents(public_path('build/assets/app.css'));

        // Extract above-the-fold CSS
        $critical = $this->extractCritical($css);

        return $critical;
    }
}
```

```blade
{{-- Inline critical CSS --}}
<style>
    {!! app(CriticalCssService::class)->getForRoute(request()->route()->getName()) !!}
</style>

{{-- Defer non-critical CSS --}}
<link rel="preload" href="{{ Vite::asset('resources/css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}"></noscript>
```

## Image Optimization

```blade
{{-- Responsive images with Art Direction --}}
<picture>
    <source media="(min-width: 1024px)" srcset="{{ $product->image_large }}">
    <source media="(min-width: 640px)" srcset="{{ $product->image_medium }}">
    <img src="{{ $product->image_small }}"
         alt="{{ $product->name }}"
         loading="lazy"
         decoding="async"
         class="h-auto w-full">
</picture>

{{-- WebP with fallback --}}
<picture>
    <source srcset="{{ $product->image_webp }}" type="image/webp">
    <img src="{{ $product->image_jpg }}"
         alt="{{ $product->name }}"
         loading="lazy"
         decoding="async">
</picture>

{{-- Responsive image sizes --}}
<img src="{{ $product->image }}"
     alt="{{ $product->name }}"
     loading="lazy"
     decoding="async"
     width="800"
     height="600"
     class="h-auto w-full"
     style="aspect-ratio: 800/600; object-fit: cover;">
```

## Core Web Vitals

```php
// app/Services/WebVitalsService.php
class WebVitalsService
{
    public function record(string $metric, float $value, array $meta = []): void
    {
        Metric::create([
            'metric' => $metric,
            'value' => $value,
            'url' => request()->url(),
            'user_agent' => request()->userAgent(),
            'connection' => request()->header('ECT', 'unknown'),
            'meta' => $meta,
        ]);
    }
}
```

```js
// resources/js/vitals.js
import { onLCP, onFID, onCLS, onFCP, onTTFB } from 'web-vitals';

function sendMetric(metric) {
    fetch('/api/vitals', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            metric: metric.name,
            value: metric.value,
            id: metric.id,
            navigationType: metric.navigationType,
        }),
    });
}

onLCP(sendMetric);
onFID(sendMetric);
onCLS(sendMetric);
onFCP(sendMetric);
onTTFB(sendMetric);
```

## Performance Targets

| Metric | Good | Needs Improvement | Poor |
|---|---|---|---|
| LCP | < 2.5s | 2.5-4s | > 4s |
| FID | < 100ms | 100-300ms | > 300ms |
| CLS | < 0.1 | 0.1-0.25 | > 0.25 |
| FCP | < 1.8s | 1.8-3s | > 3s |
| TTFB | < 800ms | 800-1800ms | > 1800ms |

## Caching Strategy

```php
// Route caching
Route::middleware(['cache.headers:public;max_age=31536000'])->group(function () {
    Route::get('/products/{product}', [ProductController::class, 'show']);
});

// Response caching
class ProductController extends Controller
{
    public function show(Product $product)
    {
        return Cache::remember("product:{$product->id}", 3600, function () use ($product) {
            return view('products.show', compact('product'));
        });
    }
}

// Asset versioning
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="{{ mix('js/app.js') }}"></script>
```

## Performance Checklist

- [ ] Images lazy loaded
- [ ] Critical CSS inlined
- [ ] JavaScript deferred
- [ ] Fonts preloaded
- [ ] Assets compressed
- [ ] CDN configured
- [ ] Browser caching enabled
- [ ] Core Web Vitals monitored
- [ ] Page speed < 3s on 3G
- [ ] No layout shift (CLS < 0.1)
