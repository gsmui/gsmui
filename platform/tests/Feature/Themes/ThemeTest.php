<?php

declare(strict_types=1);

namespace Tests\Feature\Themes;

use Tests\TestCase;
use App\Models\User;
use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_themes_index_can_be_rendered(): void
    {
        $response = $this->get('/themes');

        $response->assertStatus(200);
    }

    public function test_user_can_view_published_themes(): void
    {
        Theme::factory()->count(3)->create(['status' => 'published']);
        Theme::factory()->create(['status' => 'draft']);

        $response = $this->get('/themes');

        $response->assertStatus(200);
    }

    public function test_user_can_create_theme(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/themes', [
            'name' => 'Dark Theme',
            'description' => 'A beautiful dark theme.',
            'version' => '1.0.0',
            'is_free' => true,
            'config' => ['primary' => '#000000'],
        ]);

        $this->assertDatabaseHas('themes', [
            'name' => 'Dark Theme',
            'author_id' => $user->id,
        ]);
    }

    public function test_theme_requires_authentication_to_create(): void
    {
        $response = $this->post('/themes', [
            'name' => 'Dark Theme',
            'description' => 'A beautiful dark theme.',
            'version' => '1.0.0',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_theme_requires_name(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/themes', [
            'name' => '',
            'description' => 'A beautiful dark theme.',
            'version' => '1.0.0',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_theme_requires_description(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/themes', [
            'name' => 'Dark Theme',
            'description' => '',
            'version' => '1.0.0',
        ]);

        $response->assertSessionHasErrors('description');
    }

    public function test_user_can_update_own_theme(): void
    {
        $user = $this->createUser();
        $theme = Theme::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put("/themes/{$theme->slug}", [
            'name' => 'Updated Theme',
            'description' => 'Updated description.',
            'version' => '1.1.0',
        ]);

        $theme->refresh();
        $this->assertEquals('Updated Theme', $theme->name);
    }

    public function test_user_cannot_update_other_users_theme(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $theme = Theme::factory()->create(['author_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->put("/themes/{$theme->slug}", [
            'name' => 'Hacked Theme',
            'description' => 'Hacked.',
            'version' => '1.0.0',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_theme(): void
    {
        $user = $this->createUser();
        $theme = Theme::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete("/themes/{$theme->slug}");

        $this->assertDatabaseMissing('themes', ['id' => $theme->id]);
    }

    public function test_theme_can_be_installed(): void
    {
        $user = $this->createUser();
        $theme = Theme::factory()->published()->create();
        $this->actingAs($user);

        $response = $this->post("/themes/{$theme->slug}/install");

        $this->assertDatabaseHas('user_themes', [
            'user_id' => $user->id,
            'theme_id' => $theme->id,
        ]);
    }

    public function test_theme_scope_free_filters_free_themes(): void
    {
        Theme::factory()->create(['is_free' => true]);
        Theme::factory()->create(['is_free' => false]);

        $freeThemes = Theme::free()->get();

        $this->assertCount(1, $freeThemes);
    }

    public function test_theme_scope_premium_filters_premium_themes(): void
    {
        Theme::factory()->create(['is_premium' => true]);
        Theme::factory()->create(['is_premium' => false]);

        $premiumThemes = Theme::premium()->get();

        $this->assertCount(1, $premiumThemes);
    }

    public function test_theme_has_config_cast(): void
    {
        $theme = Theme::factory()->create([
            'config' => ['primary' => '#000000', 'secondary' => '#ffffff'],
        ]);

        $this->assertIsArray($theme->config);
        $this->assertEquals('#000000', $theme->config['primary']);
    }
}
