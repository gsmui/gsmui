<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Showcase;
use Illuminate\Http\JsonResponse;

class ShowcaseController extends Controller
{
    public function index(): JsonResponse
    {
        $showcases = Showcase::published()->latest()->paginate(20);
        return response()->json($showcases);
    }

    public function show(Showcase $showcase): JsonResponse
    {
        return response()->json($showcase);
    }
}
