<?php

declare(strict_types=1);

namespace Tests\Feature\Marketplace;

use Tests\TestCase;
use App\Models\User;
use App\Models\MarketplaceProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_marketplace_index_can_be_rendered(): void
    {
        $response = $this->get('/marketplace');

        $response->assertStatus(200);
    }

    public function test_user_can_view_marketplace_products(): void
    {
        MarketplaceProduct::factory()->count(5)->create(['status' => 'published']);

        $response = $this->get('/marketplace');

        $response->assertStatus(200);
    }

    public function test_user_can_create_product(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/marketplace', [
            'name' => 'Test Product',
            'description' => 'A great product',
            'price' => 29.99,
            'type' => 'digital',
        ]);

        $this->assertDatabaseHas('marketplace_products', [
            'name' => 'Test Product',
            'user_id' => $user->id,
        ]);
    }

    public function test_product_requires_authentication_to_create(): void
    {
        $response = $this->post('/marketplace', [
            'name' => 'Test Product',
            'description' => 'A great product',
            'price' => 29.99,
            'type' => 'digital',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_user_can_update_own_product(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put("/marketplace/{$product->slug}", [
            'name' => 'Updated Product',
            'description' => 'Updated description',
            'price' => 39.99,
            'type' => 'digital',
        ]);

        $product->refresh();
        $this->assertEquals('Updated Product', $product->name);
    }

    public function test_user_cannot_update_other_users_product(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $product = MarketplaceProduct::factory()->create(['user_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->put("/marketplace/{$product->slug}", [
            'name' => 'Hacked Product',
            'description' => 'Hacked',
            'price' => 0.01,
            'type' => 'digital',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_product(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete("/marketplace/{$product->slug}");

        $this->assertSoftDeleted('marketplace_products', ['id' => $product->id]);
    }

    public function test_user_cannot_delete_other_users_product(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $product = MarketplaceProduct::factory()->create(['user_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->delete("/marketplace/{$product->slug}");

        $response->assertStatus(403);
    }

    public function test_product_requires_name(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/marketplace', [
            'name' => '',
            'description' => 'A great product',
            'price' => 29.99,
            'type' => 'digital',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_product_requires_price(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/marketplace', [
            'name' => 'Test Product',
            'description' => 'A great product',
            'price' => '',
            'type' => 'digital',
        ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_product_requires_valid_type(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/marketplace', [
            'name' => 'Test Product',
            'description' => 'A great product',
            'price' => 29.99,
            'type' => 'invalid-type',
        ]);

        $response->assertSessionHasErrors('type');
    }

    public function test_admin_can_approve_product(): void
    {
        $admin = $this->createAdmin();
        $product = MarketplaceProduct::factory()->create(['status' => 'pending']);
        $this->actingAs($admin);

        $response = $this->put("/admin/marketplace/{$product->id}/approve");

        $product->refresh();
        $this->assertEquals('published', $product->status);
    }
}
