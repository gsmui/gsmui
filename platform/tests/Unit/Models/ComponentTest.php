<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Component;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_belongs_to_author(): void
    {
        $component = Component::factory()->create();

        $this->assertInstanceOf(User::class, $component->author);
    }

    public function test_component_scope_free_filters_free_components(): void
    {
        Component::factory()->create(['is_free' => true]);
        Component::factory()->create(['is_free' => false]);

        $freeComponents = Component::free()->get();

        $this->assertCount(1, $freeComponents);
        $this->assertTrue($freeComponents->first()->is_free);
    }

    public function test_component_scope_premium_filters_premium_components(): void
    {
        Component::factory()->create(['is_premium' => true]);
        Component::factory()->create(['is_premium' => false]);

        $premiumComponents = Component::premium()->get();

        $this->assertCount(1, $premiumComponents);
        $this->assertTrue($premiumComponents->first()->is_premium);
    }

    public function test_component_scope_featured_filters_featured_components(): void
    {
        Component::factory()->create(['is_featured' => true]);
        Component::factory()->create(['is_featured' => false]);

        $featuredComponents = Component::featured()->get();

        $this->assertCount(1, $featuredComponents);
        $this->assertTrue($featuredComponents->first()->is_featured);
    }

    public function test_component_scope_by_category_filters_by_category(): void
    {
        Component::factory()->create(['category' => 'form']);
        Component::factory()->create(['category' => 'navigation']);
        Component::factory()->create(['category' => 'form']);

        $formComponents = Component::byCategory('form')->get();

        $this->assertCount(2, $formComponents);
    }

    public function test_component_get_route_key_name_returns_slug(): void
    {
        $component = Component::factory()->create();

        $this->assertEquals('slug', $component->getRouteKeyName());
    }

    public function test_component_fillable_attributes(): void
    {
        $component = new Component();

        $this->assertContains('name', $component->getFillable());
        $this->assertContains('slug', $component->getFillable());
        $this->assertContains('description', $component->getFillable());
        $this->assertContains('category', $component->getFillable());
        $this->assertContains('version', $component->getFillable());
        $this->assertContains('price', $component->getFillable());
    }

    public function test_component_casts_arrays(): void
    {
        $component = Component::factory()->create([
            'dependencies' => ['tailwindcss'],
            'tags' => ['ui', 'form'],
            'changelog' => ['1.0.0' => 'Initial release'],
        ]);

        $this->assertIsArray($component->dependencies);
        $this->assertIsArray($component->tags);
        $this->assertIsArray($component->changelog);
    }

    public function test_component_casts_booleans(): void
    {
        $component = Component::factory()->create([
            'is_free' => true,
            'is_premium' => false,
            'is_featured' => true,
            'is_deprecated' => false,
        ]);

        $this->assertIsBool($component->is_free);
        $this->assertIsBool($component->is_premium);
        $this->assertIsBool($component->is_featured);
        $this->assertIsBool($component->is_deprecated);
    }

    public function test_component_downloads_count_is_integer(): void
    {
        $component = Component::factory()->create(['downloads_count' => 150]);

        $this->assertIsInt($component->downloads_count);
        $this->assertEquals(150, $component->downloads_count);
    }

    public function test_component_rating_is_float(): void
    {
        $component = Component::factory()->create(['rating' => 4.5]);

        $this->assertIsFloat($component->rating);
    }
}
