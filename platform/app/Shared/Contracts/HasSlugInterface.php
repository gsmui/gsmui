<?php

declare(strict_types=1);

namespace App\Shared\Contracts;

interface HasSlugInterface
{
    /**
     * Get the slug column name.
     */
    public function getSlugColumn(): string;

    /**
     * Generate a unique slug from the given value.
     */
    public function generateSlug(string $value): string;

    /**
     * Check if the slug is unique.
     */
    public function isSlugUnique(string $slug, ?int $excludeId = null): bool;
}
