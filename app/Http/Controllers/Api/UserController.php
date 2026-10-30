<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json(['data' => $user]);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url',
        ]);

        $user->update($validated);

        return response()->json(['data' => $user->fresh()]);
    }

    public function addFavorite(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'component_id' => 'required|exists:components,id',
        ]);

        $request->user()->favorites()->attach($validated['component_id']);

        return response()->json(['message' => 'Added to favorites']);
    }

    public function removeFavorite(Request $request, int $id): JsonResponse
    {
        $request->user()->favorites()->detach($id);

        return response()->json(['message' => 'Removed from favorites']);
    }
}
