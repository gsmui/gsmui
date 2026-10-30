<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    /**
     * Store an uploaded file.
     */
    public function store(UploadedFile $file, string $directory = 'uploads', string $visibility = 'public'): string
    {
        return $file->store($directory, $visibility);
    }

    /**
     * Store multiple uploaded files.
     */
    public function storeMultiple(array $files, string $directory = 'uploads'): array
    {
        $paths = [];
        foreach ($files as $file) {
            $paths[] = $this->store($file, $directory);
        }
        return $paths;
    }

    /**
     * Get the URL for a file.
     */
    public function url(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    /**
     * Delete a file.
     */
    public function delete(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    /**
     * Check if a file exists.
     */
    public function exists(string $path): bool
    {
        return Storage::disk('public')->exists($path);
    }

    /**
     * Get file size.
     */
    public function size(string $path): int
    {
        return Storage::disk('public')->size($path);
    }

    /**
     * Copy a file.
     */
    public function copy(string $source, string $destination): bool
    {
        return Storage::disk('public')->copy($source, $destination);
    }

    /**
     * Move a file.
     */
    public function move(string $source, string $destination): bool
    {
        return Storage::disk('public')->move($source, $destination);
    }

    /**
     * Get a temporary URL for a file.
     */
    public function temporaryUrl(string $path, int $minutes = 60): string
    {
        return Storage::disk('public')->temporaryUrl($path, now()->addMinutes($minutes));
    }
}
