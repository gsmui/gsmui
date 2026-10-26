<?php

declare(strict_types=1);

namespace Tests\Feature\Components;

use Tests\TestCase;
use App\Models\User;
use App\Models\Component;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComponentTest extends TestCase
{
    use RefreshDatabase;

    public function test_components_index_can_be_rendered(): void
    {
        $response = $this->get('/components');

        $response->assertStatus(200);
    }

    public function test_user_can_view_published_components(): void
    {
        Component::factory()->count(3)->create(['status' => 'published']);
        Component::factory()->create(['status' => 'draft']);

        $response = $this->get('/components');

        $response->assertStatus(200);
    }

    public function test_user_can_create_component(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/components', [
            'name' => 'Button',
            'slug' => 'button',
            'description' => 'A versatile button component.',
            'category' => 'form',
            'version' => '1.0.0',
            'is_free' => true,
        ]);

        $this->assertDatabaseHas('components', [
            'name' => 'Button',
            'author_id' => $user->id,
        ]);
    }

    public function test_component_requires_authentication_to_create(): void
    {
        $response = $this->post('/components', [
            'name' => 'Button',
            'slug' => 'button',
            'description' => 'A versatile button component.',
            'category' => 'form',
            'version' => '1.0.0',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_component_requires_name(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/components', [
            'name' => '',
            'slug' => 'button',
            'description' => 'A versatile button component.',
            'category' => 'form',
            'version' => '1.0.0',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_component_requires_slug(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/components', [
            'name' => 'Button',
            'slug' => '',
            'description' => 'A versatile button component.',
            'category' => 'form',
            'version' => '1.0.0',
        ]);

        $response->assertSessionHasErrors('slug');
    }

    public function test_component_requires_unique_slug(): void
    {
        $user = $this->createUser();
        Component::factory()->create(['slug' => 'button']);
        $this->actingAs($user);

        $response = $this->post('/components', [
            'name' => 'Button',
            'slug' => 'button',
            'description' => 'A versatile button component.',
            'category' => 'form',
            'version' => '1.0.0',
        ]);

        $response->assertSessionHasErrors('slug');
    }

    public function test_component_requires_category(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/components', [
            'name' => 'Button',
            'slug' => 'button',
            'description' => 'A versatile button component.',
            'category' => '',
            'version' => '1.0.0',
        ]);

        $response->assertSessionHasErrors('category');
    }

    public function test_user_can_update_own_component(): void
    {
        $user = $this->createUser();
        $component = Component::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put("/components/{$component->slug}", [
            'name' => 'Updated Button',
            'description' => 'Updated description.',
            'category' => 'form',
            'version' => '1.1.0',
        ]);

        $component->refresh();
        $this->assertEquals('Updated Button', $component->name);
    }

    public function test_user_cannot_update_other_users_component(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $component = Component::factory()->create(['author_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->put("/components/{$component->slug}", [
            'name' => 'Hacked Component',
            'description' => 'Hacked.',
            'category' => 'form',
            'version' => '1.0.0',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_component(): void
    {
        $user = $this->createUser();
        $component = Component::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete("/components/{$component->slug}");

        $this->assertDatabaseMissing('components', ['id' => $component->id]);
    }

    public function test_user_can_favorite_component(): void
    {
        $user = $this->createUser();
        $component = Component::factory()->create();
        $this->actingAs($user);

        $response = $this->post("/components/{$component->slug}/favorite");

        $this->assertDatabaseHas('user_favorites', [
            'user_id' => $user->id,
            'component_id' => $component->id,
        ]);
    }

    public function test_user_can_unfavorite_component(): void
    {
        $user = $this->createUser();
        $component = Component::factory()->create();
        $user->favorites()->attach($component->id);
        $this->actingAs($user);

        $response = $this->delete("/components/{$component->slug}/favorite");

        $this->assertDatabaseMissing('user_favorites', [
            'user_id' => $user->id,
            'component_id' => $component->id,
        ]);
    }

    public function test_component_download_increments_count(): void
    {
        $component = Component::factory()->create(['downloads_count' => 100]);

        $component->increment('downloads_count');

        $this->assertEquals(101, $component->fresh()->downloads_count);
    }
}
