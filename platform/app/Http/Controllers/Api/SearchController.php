<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\Template;
use App\Models\Theme;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json(['error' => 'Query must be at least 2 characters'], 400);
        }

        $results = [
            'components' => Component::where('name', 'like', "%{$query}%")->take(5)->get(),
            'templates' => Template::where('name', 'like', "%{$query}%")->take(5)->get(),
            'themes' => Theme::where('name', 'like', "%{$query}%")->take(5)->get(),
            'posts' => Post::published()->where('title', 'like', "%{$query}%")->take(5)->get(),
        ];

        return response()->json($results);
    }
}
