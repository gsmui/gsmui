<?php

declare(strict_types=1);

namespace App\Domains\Components\DTOs;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateComponentData
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $description,
        public readonly string $category,
        public readonly ?string $subcategory = null,
        public readonly string $version = '1.0.0',
        public readonly bool $isFree = true,
        public readonly bool $isPremium = false,
        public readonly ?float $price = null,
        public readonly ?string $codeExample = null,
        public readonly ?string $installationGuide = null,
        public readonly ?string $propsDocumentation = null,
        public readonly ?string $eventsDocumentation = null,
        public readonly ?string $slotsDocumentation = null,
        public readonly ?string $accessibilityNotes = null,
        public readonly ?array $dependencies = null,
        public readonly ?array $tags = null,
        public readonly int $authorId = 0,
    ) {}

    public static function fromArray(array $data): self
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:components,slug',
            'description' => 'required|string|max:5000',
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'version' => 'required|string|max:50',
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
            'author_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        return new self(
            name: $data['name'],
            slug: $data['slug'],
            description: $data['description'],
            category: $data['category'],
            subcategory: $data['subcategory'] ?? null,
            version: $data['version'] ?? '1.0.0',
            isFree: $data['is_free'] ?? true,
            isPremium: $data['is_premium'] ?? false,
            price: $data['price'] ?? null,
            codeExample: $data['code_example'] ?? null,
            installationGuide: $data['installation_guide'] ?? null,
            propsDocumentation: $data['props_documentation'] ?? null,
            eventsDocumentation: $data['events_documentation'] ?? null,
            slotsDocumentation: $data['slots_documentation'] ?? null,
            accessibilityNotes: $data['accessibility_notes'] ?? null,
            dependencies: $data['dependencies'] ?? null,
            tags: $data['tags'] ?? null,
            authorId: $data['author_id'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
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
            'author_id' => $this->authorId,
        ];
    }
}
