<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => $this->type,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'status' => $this->status,
            'preview_image' => $this->preview_image,
            'demo_url' => $this->demo_url,
            'version' => $this->version,
            'changelog' => $this->changelog,
            'tags' => $this->tags,
            'downloads_count' => $this->downloads_count,
            'rating' => $this->rating,
            'rating_count' => $this->rating_count,
            'is_featured' => $this->is_featured,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author' => new UserResource($this->whenLoaded('author')),
        ];
    }
}
