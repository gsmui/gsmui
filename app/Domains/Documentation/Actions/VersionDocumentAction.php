<?php

declare(strict_types=1);

namespace App\Domains\Documentation\Actions;

use App\Domains\Documentation\Models\Document;
use App\Domains\Documentation\Models\DocumentVersion;
use App\Domains\Services\DocumentationService;

class VersionDocumentAction
{
    public function __construct(
        protected DocumentationService $documentationService
    ) {}

    public function execute(Document $document, ?string $version = null): DocumentVersion
    {
        $newVersion = $version ?? $this->getNextVersion($document->version);

        $previousVersion = DocumentVersion::where('document_id', $document->id)
            ->latest()
            ->first();

        $documentVersion = DocumentVersion::create([
            'document_id' => $document->id,
            'version' => $newVersion,
            'content' => $document->content,
            'title' => $document->title,
            'change_notes' => "Version {$newVersion}",
            'author_id' => $document->author_id,
        ]);

        $this->documentationService->update($document, [
            'version' => $newVersion,
            'current_version_id' => $documentVersion->id,
        ]);

        return $documentVersion;
    }

    protected function getNextVersion(string $currentVersion): string
    {
        $parts = explode('.', $currentVersion);
        $parts[2] = ($parts[2] ?? 0) + 1;
        return implode('.', $parts);
    }
}
