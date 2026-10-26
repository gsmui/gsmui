<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Component;
use App\Models\Post;
use App\Models\Theme;
use App\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_requires_authentication(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_requires_admin_role(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_dashboard_can_be_rendered(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->get('/admin');

        $response->assertStatus(200);
    }

    public function test_admin_dashboard_shows_user_count(): void
    {
        $admin = $this->createAdmin();
        User::factory()->count(10)->create();
        $this->actingAs($admin);

        $response = $this->get('/admin');

        $response->assertStatus(200);
    }

    public function test_admin_dashboard_shows_component_count(): void
    {
        $admin = $this->createAdmin();
        Component::factory()->count(5)->create();
        $this->actingAs($admin);

        $response = $this->get('/admin');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_user_management(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->get('/admin/users');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_user_management(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_component_management(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->get('/admin/components');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_post_management(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->get('/admin/posts');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_theme_management(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->get('/admin/themes');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_settings(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->get('/admin/settings');

        $response->assertStatus(200);
    }
}
