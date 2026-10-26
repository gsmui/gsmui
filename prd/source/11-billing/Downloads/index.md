# Digital Downloads

## Overview

Digital downloads provide secure file delivery for purchased digital products. This document covers file storage, access control, download limits, versioning, and CDN delivery.

## Download Model

```php
class Download extends Model
{
    protected $fillable = [
        'product_id', 'name', 'file_path', 'file_size',
        'mime_type', 'version', 'is_active',
        'download_limit', 'metadata',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'is_active' => 'bool',
        'metadata' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(DownloadAccess::class);
    }
}
```

## File Storage

### Storage Configuration

```php
// config/downloads.php
return [
    'disk' => env('DOWNLOAD_DISK', 's3'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/downloads'),
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'visibility' => 'private',
        ],
    ],

    'allowed_extensions' => ['zip', 'pdf', 'exe', 'dmg', 'msi', 'pkg'],
    'max_file_size' => 524288000, // 500MB
];
```

### File Upload

```php
class DownloadUploader
{
    public function upload(Product $product, UploadedFile $file): Download
    {
        $this->validate($file);

        $path = $file->storeAs(
            "products/{$product->id}",
            $this->generateFilename($file),
            config('downloads.disk')
        );

        return $product->downloads()->create([
            'name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'version' => $this->getNextVersion($product),
            'is_active' => true,
        ]);
    }

    protected function validate(UploadedFile $file): void
    {
        $extensions = config('downloads.allowed_extensions');
        $maxSize = config('downloads.max_file_size');

        if (!in_array($file->getClientOriginalExtension(), $extensions)) {
            throw new InvalidFileException("File type not allowed.");
        }

        if ($file->getSize() > $maxSize) {
            throw new FileTooLargeException("File exceeds maximum size.");
        }
    }
}
```

## Access Control

### Access Verification

```php
class DownloadAccessControl
{
    public function canAccess(User $user, Download $download): bool
    {
        // Check if user purchased the product
        $hasPurchased = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereHas('items', fn ($q) => $q->where('product_id', $download->product_id))
            ->exists();

        if (!$hasPurchased) {
            return false;
        }

        // Check download limit
        if ($download->download_limit) {
            $downloadCount = $download->accessLogs()
                ->where('user_id', $user->id)
                ->count();

            if ($downloadCount >= $download->download_limit) {
                return false;
            }
        }

        // Check if download is active
        if (!$download->is_active) {
            return false;
        }

        return true;
    }
}
```

### Access Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `download_id` | `bigint` | FK to downloads |
| `user_id` | `bigint` | FK to users |
| `ip_address` | `string?` | |
| `user_agent` | `string?` | |
| `accessed_at` | `timestamp` | |

## Download Limits

### Limit Configuration

```php
'defaults' => [
    'download_limit' => null,  // unlimited
    'link_expiry_hours' => 24, // signed URL expiry
    'rate_limit' => 10,        // per hour
],
```

### Rate Limiting

```php
class DownloadRateLimiter
{
    public function attempt(User $user): bool
    {
        return RateLimiter::attempt(
            "downloads:{$user->id}",
            $perMinute = 10,
            function () use ($user) {
                return true;
            }
        );
    }

    remainingAttempts(User $user): int
    {
        return RateLimiter::remaining(
            "downloads:{$user->id}",
            $perMinute = 10
        );
    }
}
```

## Versioning

### Version Management

```php
class DownloadVersioning
{
    public function getLatest(Product $product): ?Download
    {
        return $product->downloads()
            ->where('is_active', true)
            ->orderByDesc('version')
            ->first();
    }

    public function getVersionHistory(Product $product): Collection
    {
        return $product->downloads()
            ->orderByDesc('version')
            ->get();
    }

    public function createVersion(Product $product, UploadedFile $file, string $changelog = ''): Download
    {
        // Deactivate previous versions
        $product->downloads()->update(['is_active' => false]);

        $download = DownloadUploader::upload($product, $file);

        $download->update([
            'metadata' => array_merge($download->metadata ?? [], [
                'changelog' => $changelog,
                'previous_version' => $this->getPreviousVersion($product),
            ]),
        ]);

        event(new DownloadVersionCreated($download));

        return $download;
    }
}
```

## CDN Delivery

### Signed URL Generation

```php
class DownloadUrlGenerator
{
    public function generate(Download $download, User $user): string
    {
        $disk = Storage::disk(config('downloads.disk'));

        return $disk->temporaryUrl(
            $download->file_path,
            now()->addHours(config('downloads.link_expiry_hours')),
            [
                'ResponseContentDisposition' => "attachment; filename=\"{$download->name}\"",
            ]
        );
    }

    public function generateDirect(Download $download): string
    {
        // For CDN-served files
        return config('app.url') . "/downloads/{$download->id}/file";
    }
}
```

### CDN Configuration

```php
// config/downloads.php
return [
    'cdn' => [
        'enabled' => env('CDN_ENABLED', false),
        'url' => env('CDN_URL'),
        'driver' => env('CDN_DRIVER', 'cloudfront'),
        'distribution_id' => env('CDN_DISTRIBUTION_ID'),
    ],
];
```

## Download Controller

```php
class DownloadController extends Controller
{
    public function download(Download $download)
    {
        $user = $this->user();

        if (!DownloadAccessControl::canAccess($user, $download)) {
            abort(403, 'You do not have access to this download.');
        }

        if (!DownloadRateLimiter::attempt($user)) {
            abort(429, 'Too many download attempts. Please try again later.');
        }

        // Log access
        $download->accessLogs()->create([
            'user_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'accessed_at' => now(),
        ]);

        // Generate download URL
        $url = DownloadUrlGenerator::generate($download, $user);

        return redirect($url);
    }

    public function index()
    {
        $purchasedProducts = $this->user()
            ->orders()
            ->where('status', 'completed')
            ->with('items.product.downloads')
            ->get()
            ->pluck('items.product')
            ->flatten()
            ->unique('id');

        return view('downloads.index', ['products' => $purchasedProducts]);
    }
}
```

## Download Schema

### Downloads Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `product_id` | `bigint` | FK to products |
| `name` | `string` | Original filename |
| `file_path` | `string` | Storage path |
| `file_size` | `bigint` | Bytes |
| `mime_type` | `string` | |
| `version` | `string` | Semantic version |
| `is_active` | `bool` | |
| `download_limit` | `int?` | Per-user limit |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Use signed URLs** — prevent link sharing and hotlinking
2. **Log all downloads** — track who downloaded what and when
3. **Rate limit downloads** — prevent abuse
4. **Version your files** — users should always get the latest version
5. **Use CDN** for large files — reduce server load
6. **Validate file types** — prevent malicious uploads
7. **Store files privately** — never expose S3 buckets directly
