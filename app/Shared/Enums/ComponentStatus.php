<?php

declare(strict_types=1);

namespace App\Shared\Enums;

enum ComponentStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Deprecated = 'deprecated';
    case Archived = 'archived';

    /**
     * Get the display label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Published',
            self::Deprecated => 'Deprecated',
            self::Archived => 'Archived',
        };
    }

    /**
     * Get the color for UI display.
     */
    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Published => 'green',
            self::Deprecated => 'yellow',
            self::Archived => 'red',
        };
    }

    /**
     * Check if the component is publicly visible.
     */
    public function isPublic(): bool
    {
        return $this === self::Published;
    }
}
