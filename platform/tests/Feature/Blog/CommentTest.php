<?php

declare(strict_types=1);

namespace Tests\Feature\Blog;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_comment_to_post(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create(['status' => 'published']);
        $this->actingAs($user);

        $response = $this->post("/blog/{$post->slug}/comments", [
            'body' => 'This is a great post!',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => 'This is a great post!',
        ]);
    }

    public function test_comment_requires_authentication(): void
    {
        $post = Post::factory()->create(['status' => 'published']);

        $response = $this->post("/blog/{$post->slug}/comments", [
            'body' => 'This is a great post!',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_comment_requires_body(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create(['status' => 'published']);
        $this->actingAs($user);

        $response = $this->post("/blog/{$post->slug}/comments", [
            'body' => '',
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_comment_requires_maximum_length(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create(['status' => 'published']);
        $this->actingAs($user);

        $response = $this->post("/blog/{$post->slug}/comments", [
            'body' => str_repeat('a', 1001),
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_user_can_delete_own_comment(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create(['status' => 'published']);
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'body' => 'My comment',
        ]);
        $this->actingAs($user);

        $response = $this->delete("/blog/{$post->slug}/comments/{$comment->id}");

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_user_cannot_delete_other_users_comment(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $post = Post::factory()->create(['status' => 'published']);
        $comment = $post->comments()->create([
            'user_id' => $otherUser->id,
            'body' => 'Other user comment',
        ]);
        $this->actingAs($user);

        $response = $this->delete("/blog/{$post->slug}/comments/{$comment->id}");

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_any_comment(): void
    {
        $admin = $this->createAdmin();
        $user = $this->createUser();
        $post = Post::factory()->create(['status' => 'published']);
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'body' => 'User comment',
        ]);
        $this->actingAs($admin);

        $response = $this->delete("/blog/{$post->slug}/comments/{$comment->id}");

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_comment_belongs_to_user(): void
    {
        $post = Post::factory()->create(['status' => 'published']);
        $user = User::factory()->create();
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'body' => 'Test comment',
        ]);

        $this->assertInstanceOf(User::class, $comment->user);
    }
}
