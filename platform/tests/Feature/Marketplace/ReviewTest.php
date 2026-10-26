<?php

declare(strict_types=1);

namespace Tests\Feature\Marketplace;

use Tests\TestCase;
use App\Models\User;
use App\Models\MarketplaceProduct;
use App\Models\ProductReview;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_review(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create();
        $order = Order::factory()->completed()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->post('/marketplace/reviews', [
            'product_id' => $product->id,
            'rating' => 5,
            'title' => 'Great product',
            'body' => 'Really enjoyed using this.',
        ]);

        $this->assertDatabaseHas('product_reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 5,
        ]);
    }

    public function test_review_requires_authentication(): void
    {
        $product = MarketplaceProduct::factory()->published()->create();

        $response = $this->post('/marketplace/reviews', [
            'product_id' => $product->id,
            'rating' => 5,
            'title' => 'Great product',
            'body' => 'Really enjoyed using this.',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_review_requires_rating(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create();
        $this->actingAs($user);

        $response = $this->post('/marketplace/reviews', [
            'product_id' => $product->id,
            'rating' => '',
            'title' => 'Great product',
            'body' => 'Really enjoyed using this.',
        ]);

        $response->assertSessionHasErrors('rating');
    }

    public function test_review_requires_valid_rating(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create();
        $this->actingAs($user);

        $response = $this->post('/marketplace/reviews', [
            'product_id' => $product->id,
            'rating' => 6,
            'title' => 'Great product',
            'body' => 'Really enjoyed using this.',
        ]);

        $response->assertSessionHasErrors('rating');
    }

    public function test_review_requires_title(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create();
        $this->actingAs($user);

        $response = $this->post('/marketplace/reviews', [
            'product_id' => $product->id,
            'rating' => 5,
            'title' => '',
            'body' => 'Really enjoyed using this.',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_review_requires_body(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create();
        $this->actingAs($user);

        $response = $this->post('/marketplace/reviews', [
            'product_id' => $product->id,
            'rating' => 5,
            'title' => 'Great product',
            'body' => '',
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_user_can_delete_own_review(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create();
        $review = ProductReview::factory()->create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $this->actingAs($user);

        $response = $this->delete("/marketplace/reviews/{$review->id}");

        $this->assertSoftDeleted('product_reviews', ['id' => $review->id]);
    }

    public function test_user_cannot_delete_other_users_review(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create();
        $review = ProductReview::factory()->create([
            'user_id' => $otherUser->id,
            'product_id' => $product->id,
        ]);
        $this->actingAs($user);

        $response = $this->delete("/marketplace/reviews/{$review->id}");

        $response->assertStatus(403);
    }

    public function test_review_belongs_to_user(): void
    {
        $review = ProductReview::factory()->create();

        $this->assertInstanceOf(User::class, $review->user);
    }

    public function test_review_belongs_to_product(): void
    {
        $review = ProductReview::factory()->create();

        $this->assertInstanceOf(MarketplaceProduct::class, $review->product);
    }
}
