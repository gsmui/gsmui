<?php

declare(strict_types=1);

namespace App\Domains\Documentation\Actions;

use App\Domains\Documentation\Models\Document;
use App\Domains\Services\DocumentationService;
use App\Infrastructure\Cache\CacheService;
use App\Infrastructure\Search\SearchService;

class UpdateDocumentAction
{
    public function __construct(
        protected DocumentationService $documentationService,
        protected CacheService $cache,
        protected SearchService $searchService
    ) {}

    public function execute(Document $document, array $data): Document
    {
        $updated = $this->documentationService->update($document, $data);

        $this->cache->invalidate("document:{$document->slug}");
        $this->cache->invalidate('documentation');

        $this->searchService->index($updated);

        return $updated;
    }
}
