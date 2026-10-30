<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComponentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'version' => $this->version,
            'status' => $this->status,
            'is_free' => $this->is_free,
            'is_premium' => $this->is_premium,
            'price' => $this->price,
            'preview_image' => $this->preview_image,
            'code_example' => $this->code_example,
            'installation_guide' => $this->installation_guide,
            'props_documentation' => $this->props_documentation,
            'events_documentation' => $this->events_documentation,
            'slots_documentation' => $this->slots_documentation,
            'accessibility_notes' => $this->accessibility_notes,
            'dependencies' => $this->dependencies,
            'tags' => $this->tags,
            'changelog' => $this->changelog,
            'downloads_count' => $this->downloads_count,
            'rating' => $this->rating,
            'rating_count' => $this->rating_count,
            'is_featured' => $this->is_featured,
            'is_deprecated' => $this->is_deprecated,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author' => new UserResource($this->whenLoaded('author')),
        ];
    }
}
