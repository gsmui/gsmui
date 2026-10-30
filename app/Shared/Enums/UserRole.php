<?php

declare(strict_types=1);

namespace App\Shared\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';
    case User = 'user';

    /**
     * Get the display label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Editor => 'Editor',
            self::User => 'User',
        };
    }

    /**
     * Get the description.
     */
    public function description(): string
    {
        return match ($this) {
            self::Admin => 'Full platform access and administration',
            self::Editor => 'Content editing and management',
            self::User => 'Standard user access',
        };
    }

    /**
     * Check if this role can access admin features.
     */
    public function canAccessAdmin(): bool
    {
        return $this === self::Admin;
    }

    /**
     * Check if this role can edit content.
     */
    public function canEditContent(): bool
    {
        return in_array($this, [self::Admin, self::Editor]);
    }
}
