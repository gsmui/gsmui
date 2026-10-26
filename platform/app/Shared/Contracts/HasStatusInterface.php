<?php

declare(strict_types=1);

namespace App\Shared\Contracts;

interface HasStatusInterface
{
    /**
     * Get the current status.
     */
    public function getStatus(): string;

    /**
     * Check if the status matches the given value.
     */
    public function isStatus(string $status): bool;

    /**
     * Check if the entity is published.
     */
    public function isPublished(): bool;

    /**
     * Check if the entity is draft.
     */
    public function isDraft(): bool;

    /**
     * Check if the entity is archived.
     */
    public function isArchived(): bool;
}
