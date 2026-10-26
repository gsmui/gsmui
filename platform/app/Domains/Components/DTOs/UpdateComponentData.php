<?php

declare(strict_types=1);

namespace App\Domains\Components\DTOs;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateComponentData
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?string $category = null,
        public readonly ?string $subcategory = null,
        public readonly ?string $version = null,
        public readonly ?bool $isFree = null,
        public readonly ?bool $isPremium = null,
        public readonly ?float $price = null,
        public readonly ?string $codeExample = null,
        public readonly ?string $installationGuide = null,
        public readonly ?string $propsDocumentation = null,
        public readonly ?string $eventsDocumentation = null,
        public readonly ?string $slotsDocumentation = null,
        public readonly ?string $accessibilityNotes = null,
        public readonly ?array $dependencies = null,
        public readonly ?array $tags = null,
        public readonly ?string $status = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:5000',
            'category' => 'sometimes|required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'version' => 'sometimes|required|string|max:50',
            'is_free' => 'boolean',
            'is_premium' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'code_example' => 'nullable|string',
            'installation_guide' => 'nullable|string',
            'props_documentation' => 'nullable|string',
            'events_documentation' => 'nullable|string',
            'slots_documentation' => 'nullable|string',
            'accessibility_notes' => 'nullable|string',
            'dependencies' => 'nullable|array',
            'tags' => 'nullable|array',
            'status' => 'sometimes|string|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return new self(
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            category: $data['category'] ?? null,
            subcategory: $data['subcategory'] ?? null,
            version: $data['version'] ?? null,
            isFree: $data['is_free'] ?? null,
            isPremium: $data['is_premium'] ?? null,
            price: $data['price'] ?? null,
            codeExample: $data['code_example'] ?? null,
            installationGuide: $data['installation_guide'] ?? null,
            propsDocumentation: $data['props_documentation'] ?? null,
            eventsDocumentation: $data['events_documentation'] ?? null,
            slotsDocumentation: $data['slots_documentation'] ?? null,
            accessibilityNotes: $data['accessibility_notes'] ?? null,
            dependencies: $data['dependencies'] ?? null,
            tags: $data['tags'] ?? null,
            status: $data['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'version' => $this->version,
            'is_free' => $this->isFree,
            'is_premium' => $this->isPremium,
            'price' => $this->price,
            'code_example' => $this->codeExample,
            'installation_guide' => $this->installationGuide,
            'props_documentation' => $this->propsDocumentation,
            'events_documentation' => $this->eventsDocumentation,
            'slots_documentation' => $this->slotsDocumentation,
            'accessibility_notes' => $this->accessibilityNotes,
            'dependencies' => $this->dependencies,
            'tags' => $this->tags,
            'status' => $this->status,
        ], fn ($v) => $v !== null);
    }
}
