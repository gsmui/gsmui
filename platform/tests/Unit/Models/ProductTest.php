<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\MarketplaceProduct;
use App\Models\ProductReview;
use App\Models\Order;
use App\Models\User;
use App\Models\License;
use App\Models\Download;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_belongs_to_author(): void
    {
        $product = MarketplaceProduct::factory()->create();

        $this->assertInstanceOf(User::class, $product->author);
    }

    public function test_product_has_many_orders(): void
    {
        $product = MarketplaceProduct::factory()->create();
        Order::factory()->count(3)->create();
        $product->orders()->attach(Order::pluck('id')->take(3));

        $this->assertCount(3, $product->orders);
    }

    public function test_product_has_many_reviews(): void
    {
        $product = MarketplaceProduct::factory()->create();
        ProductReview::factory()->count(5)->create(['product_id' => $product->id]);

        $this->assertCount(5, $product->reviews);
    }

    public function test_product_has_many_licenses(): void
    {
        $product = MarketplaceProduct::factory()->create();
        License::factory()->count(2)->create(['product_id' => $product->id]);

        $this->assertCount(2, $product->licenses);
    }

    public function test_product_has_many_downloads(): void
    {
        $product = MarketplaceProduct::factory()->create();
        Download::factory()->count(4)->create(['product_id' => $product->id]);

        $this->assertCount(4, $product->downloads);
    }

    public function test_product_get_route_key_name_returns_slug(): void
    {
        $product = MarketplaceProduct::factory()->create();

        $this->assertEquals('slug', $product->getRouteKeyName());
    }

    public function test_product_uses_soft_deletes(): void
    {
        $product = MarketplaceProduct::factory()->create();
        $productId = $product->id;
        $product->delete();

        $this->assertSoftDeleted('marketplace_products', ['id' => $productId]);
    }

    public function test_product_casts_decimals(): void
    {
        $product = MarketplaceProduct::factory()->create([
            'price' => 29.99,
            'compare_price' => 49.99,
            'rating_avg' => 4.50,
            'commission_rate' => 20.00,
        ]);

        $this->assertEquals('29.99', $product->price);
        $this->assertEquals('49.99', $product->compare_price);
        $this->assertEquals('4.50', $product->rating_avg);
    }

    public function test_product_casts_booleans(): void
    {
        $product = MarketplaceProduct::factory()->create(['featured' => true]);

        $this->assertIsBool($product->featured);
        $this->assertTrue($product->featured);
    }

    public function test_product_fillable_attributes(): void
    {
        $product = new MarketplaceProduct();

        $this->assertContains('name', $product->getFillable());
        $this->assertContains('slug', $product->getFillable());
        $this->assertContains('description', $product->getFillable());
        $this->assertContains('price', $product->getFillable());
        $this->assertContains('type', $product->getFillable());
        $this->assertContains('status', $product->getFillable());
    }
}
