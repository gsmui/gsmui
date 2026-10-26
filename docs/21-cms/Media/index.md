# Media Library

> PRD — Volume 21: CMS & Content — Media

## Overview

The Media Library provides centralized file management for all content across the platform. It supports drag-and-drop uploads, folder organization, image editing, metadata management, and media collections for reusable asset groups.

## Objectives

| Goal | Metric | Target |
|------|--------|--------|
| Upload speed | 10MB file upload time | < 3 seconds |
| Storage efficiency | Image optimization savings | 30-50% size reduction |
| Search accuracy | Find correct media by query | 95%+ |
| Alt text coverage | Images with alt text | 100% |
| Collection usage | Reusable collections created | Tracked |

## Upload Specifications

### Supported File Types

| Category | Extensions | Max Size | MIME Types |
|----------|-----------|----------|------------|
| Images | `.jpg`, `.jpeg`, `.png`, `.gif`, `.webp`, `.svg`, `.avif` | 10 MB | `image/*` |
| Videos | `.mp4`, `.webm`, `.mov`, `.avi` | 100 MB | `video/*` |
| Documents | `.pdf`, `.doc`, `.docx`, `.xls`, `.xlsx`, `.ppt`, `.pptx` | 25 MB | `application/*` |
| Audio | `.mp3`, `.wav`, `.ogg`, `.flac` | 50 MB | `audio/*` |
| Archives | `.zip`, `.tar`, `.gz` | 50 MB | `application/zip` |
| Fonts | `.woff`, `.woff2`, `.ttf`, `.otf` | 5 MB | `font/*` |

### Upload Configuration

```php
// config/media.php
return [
    'disk' => env('MEDIA_DISK', 'public'),
    'prefix' => 'media',
    'max_upload_size' => 100 * 1024 * 1024, // 100MB
    'allowed_mime_types' => [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'],
        'video' => ['mp4', 'webm', 'mov'],
        'document' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
        'audio' => ['mp3', 'wav', 'ogg'],
    ],
    'image_optimization' => [
        'enabled' => true,
        'quality' => 85,
        'max_width' => 3840,
        'max_height' => 2160,
        'generate_thumbnails' => true,
        'thumbnails' => [
            'thumb' => ['width' => 150, 'height' => 150, 'crop' => true],
            'small' => ['width' => 300, 'height' => 200, 'crop' => false],
            'medium' => ['width' => 600, 'height' => 400, 'crop' => false],
            'large' => ['width' => 1200, 'height' => 800, 'crop' => false],
        ],
    ],
    'svg' => [
        'sanitize' => true,
        'allowed_tags' => ['path', 'circle', 'rect', 'line', 'g', 'svg'],
    ],
];
```

### Upload Livewire Component

```php
class MediaUpload extends Component
{
    public ?string $collection = null;
    public ?string $directory = null;
    public bool $multiple = false;
    public int $maxFiles = 10;
    public array $uploadedFiles = [];

    public function handleUpload(TempFileUpload $upload): void
    {
        $this->validate([
            'upload' => [
                'required',
                'file',
                'max:' . config('media.max_upload_size') / 1024,
                'mimes:' . implode(',', $this->getAllowedExtensions()),
            ],
        ]);

        $media = MediaUploader::fromUpload($upload)
            ->toDirectory($this->directory ?? '/')
            ->useCollection($this->collection)
            ->optimize()
            ->withMetadata()
            ->upload();

        $this->uploadedFiles[] = $media->toArray();
        $this->dispatch('media-uploaded', media: $media->id);
    }
}
```

## Folder Organization

### Folder Structure

```
media/
├── uploads/
│   ├── 2026/
│   │   ├── 01/
│   │   ├── 02/
│   │   └── ...
│   └── ...
├── logos/
├── banners/
├── documents/
├── avatars/
└── temp/
```

### Folder Operations

| Operation | Description | Access Required |
|-----------|-------------|-----------------|
| Create folder | Add new organizational folder | `media.create` |
| Rename folder | Change folder name | `media.edit` |
| Move folder | Reparent folder | `media.edit` |
| Delete folder | Delete folder and contents | `media.delete` |
| Move files | Move files between folders | `media.edit` |
| Bulk move | Move multiple files at once | `media.edit` |

## Image Editing

### Edit Operations

| Operation | Description | Undoable |
|-----------|-------------|----------|
| Crop | Free-form or aspect ratio crop | Yes |
| Resize | Scale to target dimensions | Yes |
| Rotate | 90° clockwise/counterclockwise | Yes |
| Flip | Horizontal/vertical flip | Yes |
| Filters | Brightness, contrast, saturation | Yes |
| Focus point | Set focal point for responsive crop | Yes |
| Watermark | Add configurable watermark | Yes |
| Format convert | Convert between formats | Yes |

### Image Editor Component

```php
class ImageEditor extends Component
{
    public Media $media;
    public ?int $cropX = null;
    public ?int $cropY = null;
    public ?int $cropWidth = null;
    public ?int $cropHeight = null;
    public float $brightness = 1.0;
    public float $contrast = 1.0;
    public float $saturation = 1.0;

    public function saveEdits(): void
    {
        $editor = ImageEditor::load($this->media->getPath());

        if ($this->cropWidth && $this->cropHeight) {
            $editor->crop($this->cropX, $this->cropY, $this->cropWidth, $this->cropHeight);
        }

        $editor->adjust(
            brightness: $this->brightness,
            contrast: $this->contrast,
            saturation: $this->saturation
        );

        $editor->save($this->media->getPath());

        // Regenerate thumbnails
        $this->media->regenerateThumbnails();

        $this->dispatch('image-edited', mediaId: $this->media->id);
    }
}
```

## Alt Text & Metadata

### Required Metadata

| Field | Type | Validation | Required |
|-------|------|-----------|----------|
| `alt_text` | `string` | `max:255` | Yes (images) |
| `title` | `string` | `max:255` | No |
| `caption` | `string` | `max:500` | No |
| `description` | `text` | `max:2000` | No |
| `credit` | `string` | `max:255` | No |
| `tags` | `array` | `max:20 items` | No |

### Auto-Generated Metadata

| Field | Source |
|-------|--------|
| `file_name` | Original upload filename |
| `file_size` | File size in bytes |
| `mime_type` | Detected MIME type |
| `dimensions` | Image width × height |
| `created_at` | Upload timestamp |
| `uploaded_by` | Authenticated user |

## Media Collections

### Collection Types

| Collection | Description | Max Items |
|------------|-------------|-----------|
| `default` | General-purpose collection | Unlimited |
| `featured-images` | Post/page featured images | Unlimited |
| `gallery` | Image galleries | 50 per gallery |
| `logos` | Brand/company logos | 100 |
| `banners` | Marketing banners | 50 |
| `documents` | Downloadable files | Unlimited |
| `avatars` | User profile photos | Unlimited |
| `emails` | Email template images | 200 |

### Collection Management

```php
class MediaCollection extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'type',
        'max_items', 'allowed_types', 'settings',
    ];

    public function items(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function canAddItem(): bool
    {
        if (!$this->max_items) return true;
        return $this->items()->count() < $this->max_items;
    }

    public function isTypeAllowed(string $mimeType): bool
    {
        if (empty($this->allowed_types)) return true;
        return in_array($mimeType, $this->allowed_types);
    }
}
```

## Database Schema

```sql
CREATE TABLE media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL,
    name VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    size BIGINT UNSIGNED NOT NULL,
    disk VARCHAR(50) NOT NULL DEFAULT 'public',
    directory VARCHAR(255) NOT NULL DEFAULT '/',
    alt_text VARCHAR(255) NULL,
    title VARCHAR(255) NULL,
    caption TEXT NULL,
    description TEXT NULL,
    credit VARCHAR(255) NULL,
    tags JSON NULL,
    meta JSON NULL,
    manipulations JSON NULL,
    custom_properties JSON NULL,
    responsive_images JSON NULL,
    uploaded_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY media_uuid_unique (uuid),
    KEY media_type_index (mime_type),
    KEY media_directory_index (directory)
);

CREATE TABLE media_collections (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT NULL,
    type VARCHAR(50) NOT NULL DEFAULT 'default',
    max_items INT UNSIGNED NULL,
    allowed_types JSON NULL,
    settings JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY media_collections_slug_unique (slug)
);

CREATE TABLE mediables (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    media_id BIGINT UNSIGNED NOT NULL,
    mediable_type VARCHAR(255) NOT NULL,
    mediable_id BIGINT UNSIGNED NOT NULL,
    collection_name VARCHAR(100) NOT NULL DEFAULT 'default',
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    KEY mediables_mediable_index (mediable_type, mediable_id),
    CONSTRAINT mediables_media FOREIGN KEY (media_id) REFERENCES media(id) ON DELETE CASCADE
);
```

## Livewire Components

| Component | Namespace | Description |
|-----------|-----------|-------------|
| `media-browser` | `App\Livewire\Media\MediaBrowser` | Main library browser |
| `media-upload` | `App\Livewire\Media\MediaUpload` | Upload handler |
| `media-picker` | `App\Livewire\Media\MediaPicker` | Inline media selector |
| `media-editor` | `App\Livewire\Media\MediaEditor` | Image editing panel |
| `media-detail` | `App\Livewire\Media\MediaDetail` | File detail sidebar |
| `media-collection` | `App\Livewire\Media\MediaCollectionManager` | Collection manager |

## Access Control

| Permission | Description | Default Role |
|------------|-------------|-------------|
| `media.view` | View media library | Editor |
| `media.create` | Upload new media | Editor |
| `media.edit` | Edit media metadata | Editor |
| `media.delete` | Delete media files | Admin |
| `media.manage-collections` | Create/manage collections | Admin |
| `media.edit-images` | Use image editor | Editor |
| `media.bulk-actions` | Bulk upload/delete/move | Editor |

## Acceptance Criteria

- [ ] Drag-and-drop upload works for all supported file types
- [ ] Images are automatically optimized and thumbnails generated
- [ ] SVG files are sanitized before storage
- [ ] Folder hierarchy supports unlimited nesting
- [ ] Image editor supports crop, resize, rotate, and filters
- [ ] Alt text is required for all image uploads
- [ ] Media collections enforce type and count limits
- [ ] Search finds media by name, tags, and alt text
- [ ] Media picker works inline in page/post editors
- [ ] Responsive images use `srcset` for optimal loading
