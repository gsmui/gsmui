<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Post::published()->latest()->paginate(20);
        return response()->json($posts);
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json($post);
    }
}
