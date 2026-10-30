<?php

declare(strict_types=1);

namespace App\Shared\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the has slug trait.
     */
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getSlugColumn()})) {
                $model->{$model->getSlugColumn()} = $model->generateSlug($model->name);
            }
        });
    }

    /**
     * Get the slug column name.
     */
    public function getSlugColumn(): string
    {
        return 'slug';
    }

    /**
     * Generate a unique slug from the given value.
     */
    public function generateSlug(string $value): string
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $counter = 1;

        while (!$this->isSlugUnique($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if the slug is unique.
     */
    public function isSlugUnique(string $slug, ?int $excludeId = null): bool
    {
        $query = static::where($this->getSlugColumn(), $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }
}
