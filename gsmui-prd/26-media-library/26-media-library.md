# 26 - Media Library

**Project:** GsmUi
**Version:** 1.0.0

---

# Purpose

The Media Library provides centralized management for all binary assets: images, videos, documents, and files used across the platform.

---

# Vision

Offer a fast, organized, and powerful media management experience that makes finding and using assets effortless.

---

# Core Features

## Upload

* Drag-and-drop upload
* Multi-file upload
* Paste from clipboard
* URL import
* Camera upload (mobile)

## Organization

* Folders
* Tags
* Favorites
* Search
* Filters

## Management

* Preview
* Edit (basic)
* Rename
* Move
* Copy
* Delete
* Download

## Usage

* Insert into editor
* Copy URL
* Copy embed code
* Share link

---

# Media Library Layout

```text
┌─────────────────────────────────────────────────────┐
│ Media Library                     [Upload Files ▼]  │
├───────────┬─────────────────────────────────────────┤
│           │                                         │
│ Sidebar   │        Grid View                        │
│           │                                         │
│ 📁 All    │  ┌─────┐ ┌─────┐ ┌─────┐ ┌─────┐     │
│ 📁 Images │  │     │ │     │ │     │ │     │     │
│ 📁 Videos │  │ 🖼️  │ │ 🖼️  │ │ 🎬  │ │ 📄  │     │
│ 📁 Docs   │  │     │ │     │ │     │ │     │     │
│ 📁 Other  │  └─────┘ └─────┘ └─────┘ └─────┘     │
│           │                                         │
│ Folders   │  ┌─────┐ ┌─────┐ ┌─────┐ ┌─────┐     │
│ ─────────│  │     │ │     │ │     │ │     │     │
│ 📁 Blog  │  │ 🖼️  │ │ 🖼️  │ │ 🖼️  │ │ 🎬  │     │
│ 📁 Templates│ │     │ │     │ │     │ │     │     │
│ 📁 Logos  │  └─────┘ └─────┘ └─────┘ └─────┘     │
│           │                                         │
│ Tags      │  Showing 1-12 of 245 files             │
│ ─────────│  [Grid] [List]  Sort: [Date ▼]          │
│ #hero     │                                         │
│ #logo     │                                         │
│ #banner   │                                         │
└───────────┴─────────────────────────────────────────┘
```

---

# Upload Process

```text
Drag files to upload area
    ↓
File validation
├── Size check (< 10MB)
├── Type check (allowed types)
├── Virus scan
└── Duplicate detection
    ↓
Upload to storage (S3)
    ↓
Generate thumbnails
├── Small (150px)
├── Medium (300px)
├── Large (600px)
└── Original
    ↓
Extract metadata
├── Dimensions
├── Duration (video)
├── File size
└── EXIF data
    ↓
Index for search
    ↓
Available in library
```

---

# File Types

## Supported Types

| Type | Extensions | Max Size |
|------|------------|----------|
| Images | jpg, png, gif, webp, svg | 10MB |
| Videos | mp4, webm, mov | 100MB |
| Documents | pdf, doc, docx | 25MB |
| Archives | zip, rar | 50MB |
| Audio | mp3, wav, ogg | 25MB |

## Image Features

* Format conversion (WebP)
* Quality optimization
* Responsive sizes
* Lazy loading support

---

# Folder Structure

```text
Media Library
├── / (root)
│   ├── blog/
│   │   ├── posts/
│   │   └── covers/
│   ├── templates/
│   │   ├── thumbnails/
│   │   └── previews/
│   ├── themes/
│   │   └── previews/
│   ├── components/
│   │   └── screenshots/
│   ├── logos/
│   ├── avatars/
│   └── uploads/
```

---

# Search & Filters

## Search

* Filename search
* Tag search
* Type filter
* Date filter
* Size filter
* Folder filter

## Filters

```text
Filter By
─────────
Type:      [Images] [Videos] [Docs] [Other]
Size:      [<1MB] [1-5MB] [5-10MB] [>10MB]
Date:      [Today] [This Week] [This Month] [Custom]
Folder:    [All] [Blog] [Templates] [Logos]
Tags:      [hero] [logo] [banner]
```

---

# Preview & Details

## Image Preview

```text
┌─────────────────────────────────────┐
│ [Image Preview]                     │
│                                     │
│                                     │
│                                     │
└─────────────────────────────────────┘

File Details
────────────
Name: hero-image.jpg
Type: image/jpeg
Size: 2.4 MB
Dimensions: 1920 × 1080
Created: January 15, 2024
Folder: /blog/covers

Tags: [hero] [banner] [+ Add]

Actions
├── [Copy URL]
├── [Download]
├── [Edit]
├── [Move]
├── [Share]
└── [Delete]
```

---

# Integration Points

## Blog Editor

```text
Insert Media
────────────
[Upload] [Media Library]

Recent Files
├── hero-image.jpg
├── logo.png
└── banner.webp

[Insert Selected]
```

## Component Builder

* Screenshot upload
* Preview images
* Icon uploads

## Template Builder

* Template thumbnails
* Preview screenshots
* Documentation images

---

# Image Editing

## Basic Operations

* Crop
* Rotate
* Flip
* Resize
* Quality adjustment

## Filters

* Grayscale
* Sepia
* Blur
* Brightness
* Contrast

---

# Storage Architecture

```text
Upload Flow
───────────
Client → API → Validation → S3 → CDN
                    ↓
              Thumbnail Queue
                    ↓
              Thumbnail Generation
                    ↓
              Metadata Extraction
                    ↓
              Search Index Update
```

## Storage Tiers

| Tier | Storage | CDN | Use Case |
|------|---------|-----|----------|
| Hot | S3 Standard | CloudFront | Recent uploads |
| Warm | S3 IA | CloudFront | 30-90 days |
| Cold | Glacier | None | 90+ days |

---

# Technical Architecture

```text
Frontend (Livewire)
├── Upload Component
├── Grid Component
├── Preview Component
└── Editor Component

Backend
├── Media Service
├── Upload Service
├── Thumbnail Service
├── Search Service
└── Storage Service

Infrastructure
├── Storage (S3)
├── CDN (CloudFront)
├── Queue (Horizon)
└── Cache (Redis)
```

---

# Database Schema

Key tables:

* `media` — File records
* `media_folders` — Folder structure
* `media_tags` — File tags
* `media_thumbnails` — Generated thumbnails
* `media_usage` — Usage tracking

---

# Admin Features

* Storage analytics
* Cleanup tools
* Format management
* Quality settings
* Storage tier management

---

# Success Metrics

* <2s upload time (5MB file)
* <100ms search response
* 99.9% availability
* 50% storage optimization
* 95%+ user satisfaction

---

# Database Schema (Extended)

## media

```sql
CREATE TABLE media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) UNIQUE NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    filename VARCHAR(500) NOT NULL,
    original_filename VARCHAR(500) NOT NULL,
    mime_type VARCHAR(255) NOT NULL,
    file_type ENUM('image','video','document','audio','archive','other') NOT NULL,
    file_size BIGINT UNSIGNED NOT NULL,
    path VARCHAR(500) NOT NULL,
    disk VARCHAR(50) DEFAULT 's3',
    directory VARCHAR(255) DEFAULT '/',
    alt_text VARCHAR(255) NULL,
    title VARCHAR(255) NULL,
    caption TEXT NULL,
    description TEXT NULL,
    folder_id BIGINT UNSIGNED NULL,
    is_favorite BOOLEAN DEFAULT FALSE,
    is_public BOOLEAN DEFAULT FALSE,
    metadata JSON NULL,
    exif_data JSON NULL,
    responsive_images JSON NULL,
    disk_size BIGINT UNSIGNED NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_file_type (file_type),
    INDEX idx_mime_type (mime_type),
    INDEX idx_folder (folder_id),
    INDEX idx_directory (directory),
    INDEX idx_filename (filename),
    INDEX idx_created (created_at),
    INDEX idx_favorites (is_favorite),
    FULLTEXT idx_search (filename, title, alt_text, caption, description),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (folder_id) REFERENCES media_folders(id) ON DELETE SET NULL
);
```

## media_folders

```sql
CREATE TABLE media_folders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    path VARCHAR(500) NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    description TEXT NULL,
    color VARCHAR(7) NULL,
    icon VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_parent (parent_id),
    INDEX idx_user (user_id),
    INDEX idx_path (path),
    INDEX idx_slug (slug),
    FOREIGN KEY (parent_id) REFERENCES media_folders(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## media_tags

```sql
CREATE TABLE media_tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    color VARCHAR(7) NULL,
    usage_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_name (name)
);
```

## media_taggables

```sql
CREATE TABLE media_taggables (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    media_id BIGINT UNSIGNED NOT NULL,
    tag_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX idx_unique (media_id, tag_id),
    INDEX idx_media (media_id),
    INDEX idx_tag (tag_id),
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES media_tags(id) ON DELETE CASCADE
);
```

## media_thumbnails

```sql
CREATE TABLE media_thumbnails (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    media_id BIGINT UNSIGNED NOT NULL,
    size VARCHAR(50) NOT NULL,
    width INT NOT NULL,
    height INT NOT NULL,
    path VARCHAR(500) NOT NULL,
    file_size BIGINT UNSIGNED NOT NULL,
    disk VARCHAR(50) DEFAULT 's3',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE INDEX idx_unique (media_id, size),
    INDEX idx_media (media_id),
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
);
```

## media_usage

```sql
CREATE TABLE media_usage (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    media_id BIGINT UNSIGNED NOT NULL,
    usable_type VARCHAR(255) NOT NULL,
    usable_id BIGINT UNSIGNED NOT NULL,
    field_name VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_media (media_id),
    INDEX idx_usable (usable_type, usable_id),
    FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
);
```

## media_directories

```sql
CREATE TABLE media_directories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    path VARCHAR(500) NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    disk VARCHAR(50) DEFAULT 's3',
    visibility ENUM('public','private') DEFAULT 'private',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_parent (parent_id),
    INDEX idx_path (path),
    FOREIGN KEY (parent_id) REFERENCES media_directories(id) ON DELETE CASCADE
);
```

---

# Media Service Layer

## MediaService

```php
<?php

namespace App\Services\Media;

use App\Models\Media;
use App\Models\MediaFolder;
use App\Models\MediaTag;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MediaService
{
    public function __construct(
        protected UploadService $uploadService,
        protected ThumbnailService $thumbnailService,
        protected MetadataService $metadataService,
        protected SearchService $searchService,
    ) {}

    public function upload(UploadedFile $file, array $options = []): Media
    {
        $validated = $this->uploadService->validate($file, $options);

        $path = $this->uploadService->store($file, $options['directory'] ?? '/', $options['disk'] ?? 's3');

        $media = Media::create([
            'uuid' => Str::uuid(),
            'user_id' => auth()->id(),
            'filename' => $path,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_type' => $this->uploadService->getFileType($file->getMimeType()),
            'file_size' => $file->getSize(),
            'path' => $path,
            'disk' => $options['disk'] ?? 's3',
            'directory' => $options['directory'] ?? '/',
            'folder_id' => $options['folder_id'] ?? null,
            'metadata' => $this->metadataService->extract($file),
            'responsive_images' => null,
        ]);

        if ($media->file_type === 'image') {
            $this->thumbnailService->generate($media);
            $media->update([
                'responsive_images' => $this->thumbnailService->getResponsiveSet($media),
            ]);
        }

        $this->searchService->index($media);

        return $media;
    }

    public function getById(int $id): ?Media
    {
        return Media::with(['folder', 'tags', 'thumbnails'])->find($id);
    }

    public function getByUuid(string $uuid): ?Media
    {
        return Media::with(['folder', 'tags', 'thumbnails'])
            ->where('uuid', $uuid)
            ->first();
    }

    public function list(array $filters = [], int $limit = 24, int $offset = 0): array
    {
        $query = Media::with(['folder', 'tags'])
            ->whereNull('deleted_at');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (!empty($filters['file_type'])) {
            $query->where('file_type', $filters['file_type']);
        }
        if (!empty($filters['folder_id'])) {
            $query->where('folder_id', $filters['folder_id']);
        }
        if (!empty($filters['search'])) {
            $query->whereFullText(['filename', 'title', 'alt_text', 'caption'], $filters['search']);
        }
        if (!empty($filters['tags'])) {
            $query->whereHas('tags', function ($q) use ($filters) {
                $q->whereIn('media_tags.slug', $filters['tags']);
            });
        }
        if (!empty($filters['min_size'])) {
            $query->where('file_size', '>=', $filters['min_size']);
        }
        if (!empty($filters['max_size'])) {
            $query->where('file_size', '<=', $filters['max_size']);
        }
        if (!empty($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }
        if (!empty($filters['mime_type'])) {
            $query->where('mime_type', $filters['mime_type']);
        }

        $sortField = $filters['sort'] ?? 'created_at';
        $sortDirection = $filters['direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        $total = $query->count();
        $items = $query->limit($limit)->offset($offset)->get();

        return [
            'total' => $total,
            'items' => $items,
            'has_more' => ($offset + $limit) < $total,
        ];
    }

    public function update(Media $media, array $data): Media
    {
        $media->update(collect($data)->only([
            'alt_text', 'title', 'caption', 'description',
            'folder_id', 'is_favorite', 'is_public',
        ])->toArray());

        if (isset($data['tags'])) {
            $this->syncTags($media, $data['tags']);
        }

        $this->searchService->update($media);

        return $media->fresh(['folder', 'tags', 'thumbnails']);
    }

    public function delete(Media $media): bool
    {
        $this->thumbnailService->deleteAll($media);
        $this->searchService->remove($media);

        Storage::disk($media->disk)->delete($media->path);

        $media->delete();

        return true;
    }

    public function forceDelete(Media $media): bool
    {
        $this->thumbnailService->deleteAll($media);
        $this->searchService->remove($media);

        Storage::disk($media->disk)->delete($media->path);

        $media->forceDelete();

        return true;
    }

    public function restore(Media $media): bool
    {
        $media->restore();
        $this->searchService->index($media);
        return true;
    }

    public function move(Media $media, ?int $folderId): Media
    {
        $media->update(['folder_id' => $folderId]);
        return $media->fresh('folder');
    }

    public function copy(Media $media, ?int $folderId): Media
    {
        $newPath = Storage::disk($media->disk)->copy(
            $media->path,
            $this->generateCopyPath($media)
        );

        $newMedia = $media->replicate();
        $newMedia->uuid = Str::uuid();
        $newMedia->filename = $newPath;
        $newMedia->original_filename = "Copy of {$media->original_filename}";
        $newMedia->folder_id = $folderId;
        $newMedia->save();

        if ($newMedia->file_type === 'image') {
            $this->thumbnailService->generate($newMedia);
        }

        $this->searchService->index($newMedia);

        return $newMedia;
    }

    public function rename(Media $media, string $newName): Media
    {
        $extension = pathinfo($media->original_filename, PATHINFO_EXTENSION);
        $newOriginalName = "{$newName}.{$extension}";

        $media->update([
            'original_filename' => $newOriginalName,
            'title' => $newName,
        ]);

        $this->searchService->update($media);

        return $media;
    }

    public function toggleFavorite(Media $media): bool
    {
        $media->update(['is_favorite' => !$media->is_favorite]);
        return $media->is_favorite;
    }

    public function syncTags(Media $media, array $tagNames): void
    {
        $tags = collect($tagNames)->map(function ($name) {
            return MediaTag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        });

        $media->tags()->sync($tags->pluck('id'));

        MediaTag::withCount('media')->get()->each(function ($tag) {
            $tag->update(['usage_count' => $tag->media_count]);
        });
    }

    public function getUrl(Media $media, string $disk = null): string
    {
        $disk = $disk ?? $media->disk;
        return Storage::disk($disk)->url($media->path);
    }

    public function getTemporaryUrl(Media $media, int $expiration = 3600): string
    {
        return Storage::disk($media->disk)->temporaryUrl(
            $media->path,
            now()->addSeconds($expiration)
        );
    }

    public function getResponsiveImages(Media $media): array
    {
        if (!$media->responsive_images) {
            return [];
        }

        $responsive = $media->responsive_images;
        $result = [];

        foreach ($responsive as $size => $path) {
            $result[$size] = [
                'url' => Storage::disk($media->disk)->url($path),
                'width' => $this->thumbnailService->getSizeWidth($size),
            ];
        }

        return $result;
    }

    public function getEmbedCode(Media $media, array $options = []): string
    {
        if ($media->file_type === 'image') {
            return $this->getImageEmbed($media, $options);
        }
        if ($media->file_type === 'video') {
            return $this->getVideoEmbed($media, $options);
        }
        return '';
    }

    protected function getImageEmbed(Media $media, array $options): string
    {
        $url = $this->getUrl($media);
        $alt = $media->alt_text ?? $media->title ?? '';
        $width = $options['width'] ?? '';
        $height = $options['height'] ?? '';
        $class = $options['class'] ?? '';

        $attrs = "src=\"{$url}\" alt=\"{$alt}\"";
        if ($width) $attrs .= " width=\"{$width}\"";
        if ($height) $attrs .= " height=\"{$height}\"";
        if ($class) $attrs .= " class=\"{$class}\"";

        $img = "<img {$attrs} loading=\"lazy\">";

        if (!empty($options['link'])) {
            $target = $options['link_target'] ?? '_blank';
            $img = "<a href=\"{$options['link']}\" target=\"{$target}\">{$img}</a>";
        }

        return $img;
    }

    protected function getVideoEmbed(Media $media, array $options): string
    {
        $url = $this->getUrl($media);
        $width = $options['width'] ?? '640';
        $height = $options['height'] ?? '360';
        $autoplay = $options['autoplay'] ?? false;
        $controls = $options['controls'] ?? true;
        $muted = $options['muted'] ?? false;

        $attrStr = "width=\"{$width}\" height=\"{$height}\"";
        if ($autoplay) $attrStr .= " autoplay";
        if ($controls) $attrStr .= " controls";
        if ($muted) $attrStr .= " muted";

        return "<video {$attrStr} src=\"{$url}\"></video>";
    }

    protected function generateCopyPath(Media $media): string
    {
        $directory = dirname($media->path);
        $filename = pathinfo($media->path, PATHINFO_FILENAME);
        $extension = pathinfo($media->path, PATHINFO_EXTENSION);
        $copyNumber = 1;

        do {
            $newFilename = "{$filename}_copy{$copyNumber}.{$extension}";
            $newPath = "{$directory}/{$newFilename}";
            $copyNumber++;
        } while (Storage::disk($media->disk)->exists($newPath));

        return $newPath;
    }

    public function getStorageStats(int $userId): array
    {
        $cacheKey = "media:stats:{$userId}";
        return Cache::remember($cacheKey, now()->addHour(), function () use ($userId) {
            $media = Media::where('user_id', $userId)->whereNull('deleted_at');

            return [
                'total_files' => (clone $media)->count(),
                'total_size' => (clone $media)->sum('file_size'),
                'by_type' => [
                    'images' => [
                        'count' => (clone $media)->where('file_type', 'image')->count(),
                        'size' => (clone $media)->where('file_type', 'image')->sum('file_size'),
                    ],
                    'videos' => [
                        'count' => (clone $media)->where('file_type', 'video')->count(),
                        'size' => (clone $media)->where('file_type', 'video')->sum('file_size'),
                    ],
                    'documents' => [
                        'count' => (clone $media)->where('file_type', 'document')->count(),
                        'size' => (clone $media)->where('file_type', 'document')->sum('file_size'),
                    ],
                    'other' => [
                        'count' => (clone $media)->whereNotIn('file_type', ['image','video','document'])->count(),
                        'size' => (clone $media)->whereNotIn('file_type', ['image','video','document'])->sum('file_size'),
                    ],
                ],
            ];
        });
    }
}
```

## UploadService

```php
<?php

namespace App\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService
{
    protected array $allowedMimeTypes = [
        'image' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'],
        'video' => ['video/mp4', 'video/webm', 'video/quicktime'],
        'document' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        'audio' => ['audio/mpeg', 'audio/wav', 'audio/ogg'],
        'archive' => ['application/zip', 'application/x-rar-compressed'],
    ];

    protected array $maxSizes = [
        'image' => 10 * 1024 * 1024,
        'video' => 100 * 1024 * 1024,
        'document' => 25 * 1024 * 1024,
        'audio' => 25 * 1024 * 1024,
        'archive' => 50 * 1024 * 1024,
    ];

    public function validate(UploadedFile $file, array $options = []): bool
    {
        $mimeType = $file->getMimeType();
        $fileType = $this->getFileType($mimeType);

        if ($fileType === 'other') {
            throw new \InvalidArgumentException("File type not allowed: {$mimeType}");
        }

        $maxSize = $options['max_size'] ?? $this->maxSizes[$fileType];
        if ($file->getSize() > $maxSize) {
            $maxMb = round($maxSize / 1024 / 1024);
            throw new \InvalidArgumentException("File exceeds maximum size of {$maxMb}MB");
        }

        return true;
    }

    public function store(UploadedFile $file, string $directory = '/', string $disk = 's3'): string
    {
        $filename = $this->generateFilename($file);
        $path = ltrim("{$directory}/{$filename}", '/');

        Storage::disk($disk)->put($path, file_get_contents($file), 'public');

        return $path;
    }

    public function storeFromUrl(string $url, string $directory = '/', string $disk = 's3'): array
    {
        $contents = file_get_contents($url);
        if ($contents === false) {
            throw new \RuntimeException("Failed to fetch URL: {$url}");
        }

        $filename = $this->generateFilenameFromUrl($url);
        $path = ltrim("{$directory}/{$filename}", '/');

        $mimeType = mime_content_type($url) ?: 'application/octet-stream';

        Storage::disk($disk)->put($path, $contents, 'public');

        return [
            'path' => $path,
            'mime_type' => $mimeType,
            'file_size' => strlen($contents),
        ];
    }

    public function getFileType(string $mimeType): string
    {
        foreach ($this->allowedMimeTypes as $type => $mimes) {
            if (in_array($mimeType, $mimes)) {
                return $type;
            }
        }
        return 'other';
    }

    public function generateFilename(UploadedFile $file): string
    {
        $hash = Str::random(40);
        $extension = $file->getClientOriginalExtension();
        $datePath = now()->format('Y/m');

        return "{$datePath}/{$hash}.{$extension}";
    }

    protected function generateFilenameFromUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'bin';
        $hash = Str::random(40);
        $datePath = now()->format('Y/m');

        return "{$datePath}/{$hash}.{$extension}";
    }

    public function checkDuplicate(string $hash, int $userId): ?array
    {
        return \App\Models\Media::where('user_id', $userId)
            ->where('metadata->hash', $hash)
            ->first()
            ?->toArray();
    }

    public function computeHash(UploadedFile $file): string
    {
        return hash_file('sha256', $file->getRealPath());
    }
}
```

## ThumbnailService

```php
<?php

namespace App\Services\Media;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ThumbnailService
{
    protected array $sizes = [
        'small' => ['width' => 150, 'height' => 150],
        'medium' => ['width' => 300, 'height' => 300],
        'large' => ['width' => 600, 'height' => 600],
    ];

    public function generate(Media $media): void
    {
        if ($media->file_type !== 'image') {
            return;
        }

        $imagePath = $media->path;
        $imageContents = Storage::disk($media->disk)->get($imagePath);
        $image = Image::make($imageContents);

        foreach ($this->sizes as $sizeName => $dimensions) {
            $thumbnail = clone $image;
            $thumbnail->fit($dimensions['width'], $dimensions['height'], function ($constraint) {
                $constraint->upsize();
            });

            $thumbnailPath = $this->getThumbnailPath($media, $sizeName);
            $thumbnailBinary = $thumbnail->encode(null, 85);

            Storage::disk($media->disk)->put($thumbnailPath, $thumbnailBinary, 'public');

            $media->thumbnails()->create([
                'size' => $sizeName,
                'width' => $thumbnail->width(),
                'height' => $thumbnail->height(),
                'path' => $thumbnailPath,
                'file_size' => strlen($thumbnailBinary),
                'disk' => $media->disk,
            ]);
        }
    }

    public function deleteAll(Media $media): void
    {
        foreach ($media->thumbnails as $thumbnail) {
            Storage::disk($thumbnail->disk)->delete($thumbnail->path);
            $thumbnail->delete();
        }
    }

    public function getThumbnailPath(Media $media, string $size): string
    {
        $directory = dirname($media->path);
        $filename = pathinfo($media->path, PATHINFO_FILENAME);

        return "{$directory}/thumbs/{$filename}_{$size}.webp";
    }

    public function getSizeWidth(string $size): int
    {
        return $this->sizes[$size]['width'] ?? 300;
    }

    public function getResponsiveSet(Media $media): array
    {
        $result = [];
        foreach ($this->sizes as $sizeName => $dimensions) {
            $result[$sizeName] = $this->getThumbnailPath($media, $sizeName);
        }
        return $result;
    }
}
```

## MetadataService

```php
<?php

namespace App\Services\Media;

use Illuminate\Http\UploadedFile;

class MetadataService
{
    public function extract(UploadedFile $file): array
    {
        $metadata = [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'extension' => $file->getClientOriginalExtension(),
        ];

        $mimeType = $file->getMimeType();

        if (str_starts_with($mimeType, 'image/')) {
            $imageInfo = @getimagesize($file->getRealPath());
            if ($imageInfo) {
                $metadata['width'] = $imageInfo[0];
                $metadata['height'] = $imageInfo[1];
                $metadata['bits'] = $imageInfo['bits'] ?? null;
                $metadata['channels'] = $imageInfo['channels'] ?? null;
            }
        }

        if (str_starts_with($mimeType, 'video/') || str_starts_with($mimeType, 'audio/')) {
            $metadata['duration'] = $this->getMediaDuration($file);
        }

        if (str_starts_with($mimeType, 'image/')) {
            $exif = @exif_read_data($file->getRealPath());
            if ($exif) {
                $metadata['exif'] = $this->filterExif($exif);
            }
        }

        return $metadata;
    }

    protected function getMediaDuration(UploadedFile $file): ?float
    {
        $ffprobe = config('media.ffprobe_path', 'ffprobe');
        $command = sprintf(
            '%s -v quiet -print_format json -show_format "%s"',
            $ffprobe,
            $file->getRealPath()
        );

        $output = shell_exec($command);
        if ($output) {
            $data = json_decode($output, true);
            return $data['format']['duration'] ?? null;
        }

        return null;
    }

    protected function filterExif(array $exif): array
    {
        $allowed = [
            'Make', 'Model', 'DateTime', 'DateTimeOriginal',
            'ExposureTime', 'FNumber', 'ISOSpeedRatings',
            'FocalLength', 'ImageWidth', 'ImageLength',
            'GPSLatitude', 'GPSLongitude', 'Orientation',
        ];

        return array_filter($exif, fn ($key) => in_array($key, $allowed), ARRAY_FILTER_USE_KEY);
    }
}
```

## SearchService

```php
<?php

namespace App\Services\Media;

use App\Models\Media;
use Illuminate\Support\Facades\DB;

class SearchService
{
    public function index(Media $media): void
    {
        DB::table('media_search')->updateOrInsert(
            ['media_id' => $media->id],
            [
                'title' => $media->title ?? $media->original_filename,
                'alt_text' => $media->alt_text ?? '',
                'caption' => $media->caption ?? '',
                'description' => $media->description ?? '',
                'filename' => $media->original_filename,
                'tags' => $media->tags->pluck('name')->join(' '),
                'created_at' => $media->created_at,
            ]
        );
    }

    public function update(Media $media): void
    {
        $this->index($media);
    }

    public function remove(Media $media): void
    {
        DB::table('media_search')->where('media_id', $media->id)->delete();
    }

    public function search(string $query, int $limit = 24, int $offset = 0): array
    {
        $results = DB::table('media_search')
            ->select('media_id')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('alt_text', 'LIKE', "%{$query}%")
                  ->orWhere('caption', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('filename', 'LIKE', "%{$query}%")
                  ->orWhere('tags', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->pluck('media_id')
            ->toArray();

        $total = DB::table('media_search')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('alt_text', 'LIKE', "%{$query}%")
                  ->orWhere('filename', 'LIKE', "%{$query}%");
            })
            ->count();

        $items = Media::whereIn('id', $results)
            ->with(['folder', 'tags', 'thumbnails'])
            ->get();

        return [
            'total' => $total,
            'items' => $items,
        ];
    }
}
```

---

# Folder Service

## FolderService

```php
<?php

namespace App\Services\Media;

use App\Models\MediaFolder;
use Illuminate\Support\Str;

class FolderService
{
    public function create(array $data, int $userId): MediaFolder
    {
        $parentPath = '/';
        if (!empty($data['parent_id'])) {
            $parent = MediaFolder::find($data['parent_id']);
            $parentPath = $parent->path;
        }

        $slug = Str::slug($data['name']);
        $path = rtrim("{$parentPath}/{$slug}", '/');

        return MediaFolder::create([
            'name' => $data['name'],
            'slug' => $slug,
            'path' => $path,
            'parent_id' => $data['parent_id'] ?? null,
            'user_id' => $userId,
            'description' => $data['description'] ?? null,
            'color' => $data['color'] ?? null,
            'icon' => $data['icon'] ?? null,
        ]);
    }

    public function update(MediaFolder $folder, array $data): MediaFolder
    {
        $folder->update(collect($data)->only([
            'name', 'description', 'color', 'icon',
        ])->toArray());

        if (isset($data['name'])) {
            $slug = Str::slug($data['name']);
            $parentPath = $folder->parent ? $folder->parent->path : '/';
            $folder->update([
                'slug' => $slug,
                'path' => rtrim("{$parentPath}/{$slug}", '/'),
            ]);
        }

        return $folder;
    }

    public function delete(MediaFolder $folder): bool
    {
        $folder->media()->update(['folder_id' => null]);
        $folder->children()->update(['parent_id' => $folder->parent_id]);
        $folder->delete();
        return true;
    }

    public function getTree(int $userId): array
    {
        $folders = MediaFolder::where('user_id', $userId)
            ->orderBy('path')
            ->get();

        return $this->buildTree($folders);
    }

    protected function buildTree($folders, $parentId = null): array
    {
        $tree = [];
        foreach ($folders as $folder) {
            if ($folder->parent_id === $parentId) {
                $children = $this->buildTree($folders, $folder->id);
                $node = [
                    'id' => $folder->id,
                    'name' => $folder->name,
                    'slug' => $folder->slug,
                    'path' => $folder->path,
                    'color' => $folder->color,
                    'icon' => $folder->icon,
                    'media_count' => $folder->media()->count(),
                ];
                if (!empty($children)) {
                    $node['children'] = $children;
                }
                $tree[] = $node;
            }
        }
        return $tree;
    }
}
```

---

# Tag Service

## TagService

```php
<?php

namespace App\Services\Media;

use App\Models\MediaTag;
use Illuminate\Support\Str;

class TagService
{
    public function create(string $name, string $color = null): MediaTag
    {
        return MediaTag::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'color' => $color,
        ]);
    }

    public function getAll(): \Illuminate\Support\Collection
    {
        return MediaTag::orderBy('name')->get();
    }

    public function getPopular(int $limit = 20): \Illuminate\Support\Collection
    {
        return MediaTag::orderBy('usage_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function update(MediaTag $tag, array $data): MediaTag
    {
        $tag->update(collect($data)->only(['name', 'color'])->toArray());
        if (isset($data['name'])) {
            $tag->update(['slug' => Str::slug($data['name'])]);
        }
        return $tag;
    }

    public function delete(MediaTag $tag): bool
    {
        $tag->media()->detach();
        $tag->delete();
        return true;
    }

    public function search(string $query, int $limit = 10): \Illuminate\Support\Collection
    {
        return MediaTag::where('name', 'LIKE', "%{$query}%")
            ->orderBy('usage_count', 'desc')
            ->limit($limit)
            ->get();
    }
}
```

---

# Media API Routes

```php
<?php

use App\Http\Controllers\Media\MediaController;
use App\Http\Controllers\Media\FolderController;
use App\Http\Controllers\Media\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('media')->middleware(['auth', 'verified'])->group(function () {
    // Media CRUD
    Route::get('/', [MediaController::class, 'index'])->name('media.index');
    Route::post('/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::post('/upload-url', [MediaController::class, 'uploadFromUrl'])->name('media.upload-url');
    Route::get('/{media}', [MediaController::class, 'show'])->name('media.show');
    Route::put('/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::post('/{media}/restore', [MediaController::class, 'restore'])->name('media.restore');
    Route::delete('/{media}/force-delete', [MediaController::class, 'forceDelete'])->name('media.force-delete');
    Route::post('/{media}/move', [MediaController::class, 'move'])->name('media.move');
    Route::post('/{media}/copy', [MediaController::class, 'copy'])->name('media.copy');
    Route::put('/{media}/rename', [MediaController::class, 'rename'])->name('media.rename');
    Route::post('/{media}/favorite', [MediaController::class, 'toggleFavorite'])->name('media.favorite');
    Route::get('/{media}/download', [MediaController::class, 'download'])->name('media.download');
    Route::get('/{media}/embed', [MediaController::class, 'embed'])->name('media.embed');
    Route::get('/{media}/url', [MediaController::class, 'url'])->name('media.url');

    // Bulk operations
    Route::post('/bulk/delete', [MediaController::class, 'bulkDelete'])->name('media.bulk.delete');
    Route::post('/bulk/move', [MediaController::class, 'bulkMove'])->name('media.bulk.move');
    Route::post('/bulk/tag', [MediaController::class, 'bulkTag'])->name('media.bulk.tag');

    // Search
    Route::get('/search', [MediaController::class, 'search'])->name('media.search');

    // Folders
    Route::get('/folders', [FolderController::class, 'index'])->name('media.folders.index');
    Route::post('/folders', [FolderController::class, 'store'])->name('media.folders.store');
    Route::put('/folders/{folder}', [FolderController::class, 'update'])->name('media.folders.update');
    Route::delete('/folders/{folder}', [FolderController::class, 'destroy'])->name('media.folders.destroy');
    Route::get('/folders/{folder}/contents', [FolderController::class, 'contents'])->name('media.folders.contents');

    // Tags
    Route::get('/tags', [TagController::class, 'index'])->name('media.tags.index');
    Route::post('/tags', [TagController::class, 'store'])->name('media.tags.store');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('media.tags.update');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('media.tags.destroy');
    Route::get('/tags/search', [TagController::class, 'search'])->name('media.tags.search');

    // Statistics
    Route::get('/stats', [MediaController::class, 'stats'])->name('media.stats');
});
```

---

# Media Controller

```php
<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Services\Media\MediaService;
use App\Models\Media;
use App\Http\Requests\Media\UploadRequest;
use App\Http\Requests\Media\UpdateMediaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only([
            'file_type', 'folder_id', 'search', 'tags',
            'min_size', 'max_size', 'date_from', 'date_to',
            'mime_type', 'sort', 'direction',
        ]);
        $filters['user_id'] = $request->user()->id;

        $perPage = $request->input('per_page', 24);
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $result = $this->mediaService->list($filters, $perPage, $offset);

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return view('media.index', $result);
    }

    public function upload(UploadRequest $request): JsonResponse
    {
        $media = $this->mediaService->upload(
            $request->file('file'),
            [
                'directory' => $request->input('directory', '/'),
                'disk' => $request->input('disk', 's3'),
                'folder_id' => $request->input('folder_id'),
            ]
        );

        return response()->json([
            'id' => $media->id,
            'uuid' => $media->uuid,
            'url' => $this->mediaService->getUrl($media),
            'name' => $media->original_filename,
            'type' => $media->file_type,
            'size' => $media->file_size,
            'mime_type' => $media->mime_type,
        ], 201);
    }

    public function uploadFromUrl(Request $request): JsonResponse
    {
        $request->validate([
            'url' => 'required|url',
            'directory' => 'nullable|string',
            'folder_id' => 'nullable|integer',
        ]);

        $contents = file_get_contents($request->input('url'));
        $filename = basename(parse_url($request->input('url'), PHP_URL_PATH));
        $tempFile = tempnam(sys_get_temp_dir(), 'upload_');
        file_put_contents($tempFile, $contents);

        $uploadedFile = new \Illuminate\Http\UploadedFile(
            $tempFile,
            $filename,
            mime_content_type($tempFile),
            null,
            true
        );

        $media = $this->mediaService->upload($uploadedFile, [
            'directory' => $request->input('directory', '/'),
            'folder_id' => $request->input('folder_id'),
        ]);

        @unlink($tempFile);

        return response()->json([
            'id' => $media->id,
            'uuid' => $media->uuid,
            'url' => $this->mediaService->getUrl($media),
        ], 201);
    }

    public function show(Media $media)
    {
        if (!auth()->user()->can('view', $media)) {
            abort(403);
        }

        $media->load(['folder', 'tags', 'thumbnails', 'usage']);
        $media->append('url', 'embed_code');

        if (request()->wantsJson()) {
            return response()->json($media);
        }

        return view('media.show', compact('media'));
    }

    public function update(UpdateMediaRequest $request, Media $media): JsonResponse
    {
        $media = $this->mediaService->update($media, $request->validated());

        return response()->json($media);
    }

    public function destroy(Media $media): JsonResponse
    {
        $this->mediaService->delete($media);
        return response()->json(null, 204);
    }

    public function restore(Media $media): JsonResponse
    {
        $this->mediaService->restore($media);
        return response()->json($media);
    }

    public function forceDelete(Media $media): JsonResponse
    {
        $this->mediaService->forceDelete($media);
        return response()->json(null, 204);
    }

    public function move(Request $request, Media $media): JsonResponse
    {
        $request->validate(['folder_id' => 'nullable|integer']);
        $media = $this->mediaService->move($media, $request->input('folder_id'));
        return response()->json($media);
    }

    public function copy(Request $request, Media $media): JsonResponse
    {
        $request->validate(['folder_id' => 'nullable|integer']);
        $newMedia = $this->mediaService->copy($media, $request->input('folder_id'));
        return response()->json($newMedia, 201);
    }

    public function rename(Request $request, Media $media): JsonResponse
    {
        $request->validate(['name' => 'required|string|max:255']);
        $media = $this->mediaService->rename($media, $request->input('name'));
        return response()->json($media);
    }

    public function toggleFavorite(Media $media): JsonResponse
    {
        $isFavorite = $this->mediaService->toggleFavorite($media);
        return response()->json(['is_favorite' => $isFavorite]);
    }

    public function download(Media $media)
    {
        $url = $this->mediaService->getUrl($media);
        return redirect($url);
    }

    public function embed(Media $media): JsonResponse
    {
        $embedCode = $this->mediaService->getEmbedCode($media);
        return response()->json(['embed_code' => $embedCode]);
    }

    public function url(Media $media): JsonResponse
    {
        $url = $this->mediaService->getUrl($media);
        return response()->json(['url' => $url]);
    }

    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['ids' => 'required|array']);
        $mediaItems = Media::whereIn('id', $request->input('ids'))->get();
        foreach ($mediaItems as $media) {
            $this->mediaService->delete($media);
        }
        return response()->json(null, 204);
    }

    public function bulkMove(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'folder_id' => 'nullable|integer',
        ]);
        Media::whereIn('id', $request->input('ids'))
            ->update(['folder_id' => $request->input('folder_id')]);
        return response()->json(null, 204);
    }

    public function bulkTag(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'tags' => 'required|array',
        ]);
        $mediaItems = Media::whereIn('id', $request->input('ids'))->get();
        foreach ($mediaItems as $media) {
            $this->mediaService->syncTags($media, $request->input('tags'));
        }
        return response()->json(null, 204);
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:2']);
        $result = $this->mediaService->search($request->input('q'));
        return response()->json($result);
    }

    public function stats(Request $request): JsonResponse
    {
        $stats = $this->mediaService->getStorageStats($request->user()->id);
        return response()->json($stats);
    }
}
```

---

# Livewire Components

## MediaGrid Component

```php
<?php

namespace App\Http\Livewire\Media;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Services\Media\MediaService;

class MediaGrid extends Component
{
    use WithPagination, WithFileUploads;

    public $viewMode = 'grid';
    public $search = '';
    public $fileType = '';
    public $folderId = null;
    public $selectedTags = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $selectedMedia = [];
    public $showUpload = false;
    public $showPreview = false;
    public $previewMedia = null;
    public $uploadProgress = 0;
    public $isUploading = false;

    protected MediaService $mediaService;

    public function boot(MediaService $mediaService): void
    {
        $this->mediaService = $mediaService;
    }

    public function getMediaProperty()
    {
        $filters = [
            'user_id' => auth()->id(),
            'search' => $this->search ?: null,
            'file_type' => $this->fileType ?: null,
            'folder_id' => $this->folderId,
            'tags' => $this->selectedTags,
            'sort' => $this->sortBy,
            'direction' => $this->sortDirection,
        ];

        return $this->mediaService->list($filters, 24, ($this->page - 1) * 24);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFileType(): void
    {
        $this->resetPage();
    }

    public function updatedFolderId(): void
    {
        $this->resetPage();
    }

    public function uploadFiles(): void
    {
        $this->validate(['files' => 'required|array|max:10']);
        $this->isUploading = true;
        $this->uploadProgress = 0;

        $files = $this->files;
        $total = count($files);

        foreach ($files as $index => $file) {
            $this->mediaService->upload($file, [
                'directory' => '/',
                'folder_id' => $this->folderId,
            ]);
            $this->uploadProgress = (($index + 1) / $total) * 100;
        }

        $this->isUploading = false;
        $this->showUpload = false;
        $this->dispatch('media-uploaded');
    }

    public function selectMedia(int $mediaId): void
    {
        if (in_array($mediaId, $this->selectedMedia)) {
            $this->selectedMedia = array_diff($this->selectedMedia, [$mediaId]);
        } else {
            $this->selectedMedia[] = $mediaId;
        }
    }

    public function openPreview(int $mediaId): void
    {
        $this->previewMedia = $this->mediaService->getById($mediaId);
        $this->showPreview = true;
    }

    public function deleteSelected(): void
    {
        $this->mediaService->bulkDelete($this->selectedMedia);
        $this->selectedMedia = [];
        $this->dispatch('media-deleted');
    }

    public function render()
    {
        return view('livewire.media.grid', [
            'media' => $this->media,
        ]);
    }
}
```

---

# Media Caching Strategy

| Cache Key | TTL | Invalidation |
|-----------|-----|--------------|
| `media:{id}` | 1 hour | On update/delete |
| `media:stats:{user_id}` | 1 hour | On upload/delete |
| `media:tags:popular` | 15 min | On tag sync |
| `media:folders:{user_id}` | 15 min | On folder CRUD |
| `media:search:{query}` | 15 min | On index update |

---

# Media Events

```php
<?php

namespace App\Events\Media;

use App\Models\Media;
use Illuminate\Foundation\Events\Dispatchable;

class MediaUploaded
{
    use Dispatchable;
    public function __construct(public Media $media) {}
}
```

```php
<?php

namespace App\Events\Media;

use App\Models\Media;
use Illuminate\Foundation\Events\Dispatchable;

class MediaDeleted
{
    use Dispatchable;
    public function __construct(public int $mediaId, public array $data) {}
}
```

---

# Media Listeners

```php
<?php

namespace App\Listeners\Media;

use App\Events\Media\MediaUploaded;
use App\Events\Media\MediaDeleted;
use Illuminate\Support\Facades\Cache;

class InvalidateMediaCache
{
    public function handle(MediaUploaded|MediaDeleted $event): void
    {
        $media = $event->media ?? null;
        if ($media) {
            Cache::forget("media:{$media->id}");
            Cache::forget("media:stats:{$media->user_id}");
        }
        Cache::tags(['media'])->flush();
    }
}
```

---

# User Flow: Upload Media

```text
User opens Media Library
    ↓
Clicks "Upload Files" or drags files
    ↓
Files validated
├── Type check
├── Size check
├── Duplicate detection
└── Virus scan
    ↓
Files uploaded to S3
    ↓
Thumbnails generated (images)
    ↓
Metadata extracted
    ↓
Files indexed for search
    ↓
Media grid updated
```

---

# User Flow: Organize Media

```text
User creates folder
    ├── Enter folder name
    ├── Select parent folder (optional)
    └── Choose color/icon
    ↓
Folder created
    ↓
User moves files to folder
    ├── Select files
    ├── Click "Move"
    └── Select destination folder
    ↓
Files moved, paths updated
    ↓
User adds tags
    ├── Select files
    ├── Click "Add Tags"
    ├── Enter/select tags
    └── Tags applied
    ↓
Files now searchable by tag
```

---

# User Flow: Edit Image

```text
User clicks image to open preview
    ↓
Preview modal shows image
    ↓
User clicks "Edit"
    ↓
Image editor loads
├── Crop tool
│   ├── Free crop
│   ├── Square crop
│   ├── Custom ratio
│   └── Apply
├── Resize tool
│   ├── Enter dimensions
│   ├── Maintain aspect ratio
│   └── Apply
├── Rotate/Flip
│   ├── Rotate 90° CW/CCW
│   ├── Flip horizontal/vertical
│   └── Apply
└── Filters
    ├── Grayscale
    ├── Sepia
    ├── Blur
    └── Apply
    ↓
Changes applied
    ↓
New version saved (original preserved)
    ↓
Thumbnails regenerated
```

---

# Storage Configuration

```php
// config/media.php

return [
    'default_disk' => env('MEDIA_DISK', 's3'),
    'disks' => [
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
        ],
    ],
    'max_upload_size' => [
        'image' => 10 * 1024 * 1024,
        'video' => 100 * 1024 * 1024,
        'document' => 25 * 1024 * 1024,
        'audio' => 25 * 1024 * 1024,
        'archive' => 50 * 1024 * 1024,
    ],
    'thumbnail_sizes' => [
        'small' => ['width' => 150, 'height' => 150],
        'medium' => ['width' => 300, 'height' => 300],
        'large' => ['width' => 600, 'height' => 600],
    ],
    'allowed_mime_types' => [
        'image' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'],
        'video' => ['video/mp4', 'video/webm', 'video/quicktime'],
        'document' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        'audio' => ['audio/mpeg', 'audio/wav', 'audio/ogg'],
    ],
    'cleanup' => [
        'trashed_days' => 30,
        'thumbnail_days' => 90,
    ],
];
```

---

# Media Testing Strategy

## Unit Tests

* UploadService validation
* UploadService file storage
* ThumbnailService generation
* MetadataService extraction
* SearchService indexing
* FolderService tree building
* TagService CRUD
* MediaService URL generation

## Feature Tests

* File upload flow
* Media CRUD operations
* Folder management
* Tag management
* Bulk operations
* Search functionality
* Image editing
* Download flow

## Integration Tests

* S3 storage integration
* Thumbnail pipeline
* Search index synchronization
* CDN cache invalidation
* Queue job processing

---

# Media Security

* File type validation on upload
* File size limits per type
* Virus scanning (optional)
* CSRF protection on all forms
* Authorization checks (own media only)
* Signed URLs for private files
* Rate limiting on uploads
* Duplicate detection via hash
* EXIF data stripping (optional)
* Content Security Policy headers

---

# Next Document

**27 - API** — RESTful API architecture and documentation.
