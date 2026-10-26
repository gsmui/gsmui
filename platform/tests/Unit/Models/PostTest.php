<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_belongs_to_author(): void
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->author);
    }

    public function test_post_scope_published_filters_published_posts(): void
    {
        Post::factory()->create(['status' => 'published', 'published_at' => now()]);
        Post::factory()->create(['status' => 'draft']);
        Post::factory()->create(['status' => 'published', 'published_at' => now()]);

        $publishedPosts = Post::published()->get();

        $this->assertCount(2, $publishedPosts);
    }

    public function test_post_scope_featured_filters_featured_posts(): void
    {
        Post::factory()->create(['is_featured' => true]);
        Post::factory()->create(['is_featured' => false]);

        $featuredPosts = Post::featured()->get();

        $this->assertCount(1, $featuredPosts);
        $this->assertTrue($featuredPosts->first()->is_featured);
    }

    public function test_post_get_route_key_name_returns_slug(): void
    {
        $post = Post::factory()->create();

        $this->assertEquals('slug', $post->getRouteKeyName());
    }

    public function test_post_casts_datetimes(): void
    {
        $post = Post::factory()->create(['published_at' => '2024-01-15 10:30:00']);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $post->published_at);
    }

    public function test_post_casts_booleans(): void
    {
        $post = Post::factory()->create(['is_featured' => true]);

        $this->assertIsBool($post->is_featured);
    }

    public function test_post_views_count_is_integer(): void
    {
        $post = Post::factory()->create(['views_count' => 1500]);

        $this->assertIsInt($post->views_count);
    }

    public function test_post_fillable_attributes(): void
    {
        $post = new Post();

        $this->assertContains('title', $post->getFillable());
        $this->assertContains('slug', $post->getFillable());
        $this->assertContains('body', $post->getFillable());
        $this->assertContains('author_id', $post->getFillable());
        $this->assertContains('status', $post->getFillable());
        $this->assertContains('published_at', $post->getFillable());
    }

    public function test_post_has_excerpt_field(): void
    {
        $post = Post::factory()->create(['excerpt' => 'This is a test excerpt']);

        $this->assertEquals('This is a test excerpt', $post->excerpt);
    }

    public function test_post_has_meta_fields(): void
    {
        $post = Post::factory()->create([
            'meta_title' => 'Test Meta Title',
            'meta_description' => 'Test meta description',
        ]);

        $this->assertEquals('Test Meta Title', $post->meta_title);
        $this->assertEquals('Test meta description', $post->meta_description);
    }
}
