<?php

declare(strict_types=1);

namespace Tests\Feature\Blog;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_can_be_rendered(): void
    {
        $response = $this->get('/blog');

        $response->assertStatus(200);
    }

    public function test_user_can_view_published_posts(): void
    {
        Post::factory()->count(3)->create(['status' => 'published', 'published_at' => now()]);
        Post::factory()->create(['status' => 'draft']);

        $response = $this->get('/blog');

        $response->assertStatus(200);
    }

    public function test_user_can_create_post(): void
    {
        $user = $this->createUser();
        $category = PostCategory::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/blog', [
            'title' => 'Test Post',
            'body' => 'This is a test post content.',
            'excerpt' => 'Test excerpt',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'author_id' => $user->id,
        ]);
    }

    public function test_post_requires_authentication_to_create(): void
    {
        $category = PostCategory::factory()->create();

        $response = $this->post('/blog', [
            'title' => 'Test Post',
            'body' => 'This is a test post content.',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_post_requires_title(): void
    {
        $user = $this->createUser();
        $category = PostCategory::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/blog', [
            'title' => '',
            'body' => 'This is a test post content.',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_post_requires_body(): void
    {
        $user = $this->createUser();
        $category = PostCategory::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/blog', [
            'title' => 'Test Post',
            'body' => '',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_post_requires_category(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/blog', [
            'title' => 'Test Post',
            'body' => 'This is a test post content.',
            'category_id' => '',
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('category_id');
    }

    public function test_user_can_update_own_post(): void
    {
        $user = $this->createUser();
        $category = PostCategory::factory()->create();
        $post = Post::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put("/blog/{$post->slug}", [
            'title' => 'Updated Post',
            'body' => 'Updated content.',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $post->refresh();
        $this->assertEquals('Updated Post', $post->title);
    }

    public function test_user_cannot_update_other_users_post(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $category = PostCategory::factory()->create();
        $post = Post::factory()->create(['author_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->put("/blog/{$post->slug}", [
            'title' => 'Hacked Post',
            'body' => 'Hacked content.',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_post(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete("/blog/{$post->slug}");

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_user_can_publish_post(): void
    {
        $user = $this->createUser();
        $category = PostCategory::factory()->create();
        $post = Post::factory()->create(['author_id' => $user->id, 'status' => 'draft']);
        $this->actingAs($user);

        $response = $this->post("/blog/{$post->slug}/publish");

        $post->refresh();
        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_admin_can_manage_all_posts(): void
    {
        $admin = $this->createAdmin();
        $post = Post::factory()->create();
        $this->actingAs($admin);

        $response = $this->delete("/admin/posts/{$post->id}");

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
