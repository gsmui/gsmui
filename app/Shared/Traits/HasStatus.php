<?php

declare(strict_types=1);

namespace App\Shared\Traits;

trait HasStatus
{
    /**
     * Get the current status.
     */
    public function getStatus(): string
    {
        return $this->status ?? 'draft';
    }

    /**
     * Check if the status matches the given value.
     */
    public function isStatus(string $status): bool
    {
        return $this->getStatus() === $status;
    }

    /**
     * Check if the entity is published.
     */
    public function isPublished(): bool
    {
        return $this->isStatus('published');
    }

    /**
     * Check if the entity is draft.
     */
    public function isDraft(): bool
    {
        return $this->isStatus('draft');
    }    /**
     * Check if the entity is archived.
     */
    public function isArchived(): bool
    {
        return $this->isStatus('archived');
    }
}
