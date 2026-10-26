<?php

declare(strict_types=1);

namespace App\Shared\Contracts;

interface SearchableInterface
{
    /**
     * Get the data to be indexed for search.
     */
    public function searchableData(): array;

    /**
     * Get the search rank/weight.
     */
    public function searchableRank(): float;

    /**
     * Get the searchable title.
     */
    public function searchableTitle(): string;

    /**
     * Get the searchable body/content.
     */
    public function searchableBody(): string;

    /**
     * Get searchable keywords.
     */
    public function searchableKeywords(): array;
}
