<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Services\DocumentationService;
use Illuminate\Http\JsonResponse;

class DocumentationController extends Controller
{
    public function __construct(
        protected DocumentationService $documentationService
    ) {}

    public function index(): JsonResponse
    {
        $documents = $this->documentationService->list([], 20);

        return response()->json([
            'data' => $documents->items(),
            'meta' => [
                'current_page' => $documents->currentPage(),
                'last_page' => $documents->lastPage(),
                'per_page' => $documents->perPage(),
                'total' => $documents->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $document = $this->documentationService->getBySlug($slug);

        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        return response()->json(['data' => $document]);
    }
}
