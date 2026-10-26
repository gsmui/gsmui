<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'is_free' => $this->is_free,
            'is_premium' => $this->is_premium,
            'price' => $this->price,
            'tokens' => $this->tokens,
            'preview_image' => $this->preview_image,
            'downloads_count' => $this->downloads_count,
            'rating' => $this->rating,
            'rating_count' => $this->rating_count,
            'is_featured' => $this->is_featured,
            'version' => $this->version,
            'changelog' => $this->changelog,
            'tags' => $this->tags,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author' => new UserResource($this->whenLoaded('author')),
        ];
    }
}
