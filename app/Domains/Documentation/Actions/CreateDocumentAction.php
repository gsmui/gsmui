<?php

declare(strict_types=1);

namespace App\Domains\Documentation\Actions;

use App\Domains\Documentation\Models\Document;
use App\Domains\Services\DocumentationService;
use App\Infrastructure\Search\SearchService;

class CreateDocumentAction
{
    public function __construct(
        protected DocumentationService $documentationService,
        protected SearchService $searchService
    ) {}

    public function execute(array $data): Document
    {
        $document = $this->documentationService->create([
            'title' => $data['title'],
            'slug' => $data['slug'] ?? \Str::slug($data['title']),
            'content' => $data['content'] ?? '',
            'category' => $data['category'] ?? null,
            'version' => $data['version'] ?? '1.0.0',
            'status' => $data['status'] ?? 'draft',
            'author_id' => $data['author_id'] ?? null,
        ]);

        $this->searchService->index($document);

        return $document;
    }
}
