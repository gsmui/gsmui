<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Services\ThemeService;
use Illuminate\Http\JsonResponse;

class ThemeController extends Controller
{
    public function __construct(
        protected ThemeService $themeService
    ) {}

    public function index(): JsonResponse
    {
        $themes = $this->themeService->list([], 20);

        return response()->json([
            'data' => $themes->items(),
            'meta' => [
                'current_page' => $themes->currentPage(),
                'last_page' => $themes->lastPage(),
                'per_page' => $themes->perPage(),
                'total' => $themes->total(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $theme = $this->themeService->getBySlug($slug);

        if (!$theme) {
            return response()->json(['message' => 'Theme not found'], 404);
        }

        return response()->json(['data' => $theme]);
    }
}
