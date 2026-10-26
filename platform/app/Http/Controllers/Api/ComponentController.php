<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Services\ComponentService;
use Illuminate\Http\JsonResponse;

class ComponentController extends Controller
{
    public function __construct(
        protected ComponentService $componentService
    ) {}

    public function index(): JsonResponse
    {
        $components = $this->componentService->list([], 20);

        return response()->json([
            'data' => $components->items(),
            'meta' => [
                'current_page' => $components->currentPage(),
                'last_page' => $components->lastPage(),
                'per_page' => $components->perPage(),
                'total' => $components->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $component = $this->componentService->getBySlug($slug);

        if (!$component) {
            return response()->json(['message' => 'Component not found'], 404);
        }

        return response()->json(['data' => $component]);
    }
}
