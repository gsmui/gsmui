# SEO

> Meta tags, structured data, sitemaps, canonical URLs, Open Graph, performance impact.

## Meta Tags

```blade
{{-- resources/views/components/seo.blade.php --}}
@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'url' => null,
    'type' => 'website',
])

@php
    $title = $title ? "{$title} - " . config('app.name') : config('app.name');
    $description = $description ?? config('app.description', 'A modern Laravel application');
    $url = $url ?? url()->current();
    $image = $image ?? config('app.url') . '/images/og-default.png';
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $url }}">

{{-- Open Graph --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

{{-- Additional meta --}}
<meta name="robots" content="index, follow">
<meta name="theme-color" content="#0ea5e9">
```

## Structured Data

```blade
{{-- Product structured data --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ $product->description }}",
    "image": "{{ $product->image }}",
    "sku": "{{ $product->sku }}",
    "brand": {
        "@type": "Brand",
        "name": "{{ $product->brand->name }}"
    },
    "offers": {
        "@type": "Offer",
        "url": "{{ route('products.show', $product) }}",
        "priceCurrency": "USD",
        "price": "{{ $product->price / 100 }}",
        "availability": "https://schema.org/{{ $product->in_stock ? 'InStock' : 'OutOfStock' }}"
    },
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ $product->average_rating }}",
        "reviewCount": "{{ $product->review_count }}"
    }
}
</script>

{{-- Breadcrumb structured data --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "Products",
            "item": "{{ route('products.index') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $product->name }}",
            "item": "{{ route('products.show', $product) }}"
        }
    ]
}
</script>
```

## Sitemap

```php
// routes/sitemap.php
Route::get('/sitemap.xml', function () {
    $products = Product::where('status', 'active')->get();
    $categories = Category::all();

    $sitemap = app(Sitemap::class)
        ->add(url('/'), now(), '1.0', 'daily')
        ->add(route('products.index'), now(), '0.8', 'weekly');

    foreach ($categories as $category) {
        $sitemap->add(
            route('products.index', ['category' => $category->slug]),
            $category->updated_at,
            '0.6',
            'weekly'
        );
    }

    foreach ($products as $product) {
        $sitemap->add(
            route('products.show', $product),
            $product->updated_at,
            '0.7',
            'weekly'
        );
    }

    return $sitemap->toXml();
});
```

```php
// app/Console/Commands/GenerateSitemap.php
class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    public function handle(): int
    {
        $products = Product::where('status', 'active')->get();

        $xml = $this->buildXml($products);

        file_put_contents(public_path('sitemap.xml'), $xml);

        $this->info("Sitemap generated with {$products->count()} products.");

        return self::SUCCESS;
    }

    protected function buildXml($products): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($products as $product) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('products.show', $product) . '</loc>';
            $xml .= '<lastmod>' . $product->updated_at->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
```

## Canonical URLs

```blade
{{-- In layout --}}
<link rel="canonical" href="{{ url()->current() }}">

{{-- For paginated pages --}}
@if($products->currentPage() > 1)
    <link rel="canonical" href="{{ $products->url($products->currentPage()) }}">
@endif

{{-- For filtered pages --}}
<link rel="canonical" href="{{ route('products.index', request()->query()) }}">
```

## Open Graph Images

```php
// app/Services/OgImageService.php
class OgImageService
{
    public function generate(Model $model): string
    {
        $template = match(class_basename($model)) {
            'Product' => 'og-product',
            'Article' => 'og-article',
            default => 'og-default',
        };

        return $this->renderTemplate($template, [
            'title' => $model->name,
            'description' => $model->description,
            'image' => $model->image ?? null,
        ]);
    }

    protected function renderTemplate(string $template, array $data): string
    {
        // Generate OG image using Intervention Image or similar
        $image = Image::make(resource_path("views/templates/{$template}.png"));
        $image->text($data['title'], 50, 50);
        $image->text($data['description'], 50, 100);

        $path = "og/{$template}-" . md5(serialize($data)) . '.png';
        $image->save(public_path($path));

        return url($path);
    }
}
```

## Performance Impact

| Factor | Impact | Recommendation |
|---|---|---|
| Page speed | High | Optimize load time < 3s |
| Mobile-first | High | Responsive design |
| HTTPS | Required | SSL certificate |
| Structured data | Medium | Schema.org markup |
| Meta tags | Medium | Unique per page |
| Sitemap | Medium | Auto-generated |
| Canonical | Low | Prevent duplicate content |

## SEO Checklist

- [ ] Unique title tags per page
- [ ] Meta descriptions on all pages
- [ ] Open Graph tags for social sharing
- [ ] Structured data for rich snippets
- [ ] XML sitemap generated
- [ ] Robots.txt configured
- [ ] Canonical URLs set
- [ ] Mobile-responsive design
- [ ] Page speed optimized
- [ ] HTTPS enabled
- [ ] Alt text on images
- [ ] Semantic HTML structure
