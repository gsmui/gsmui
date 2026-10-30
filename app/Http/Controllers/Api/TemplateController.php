<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domains\Templates\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Template::where('status', 'active');

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $templates = $query->latest()->paginate($request->get('per_page', 20));

        return response()->json($templates);
    }

    public function show(Template $template): JsonResponse
    {
        return response()->json($template);
    }
}
