<?php

declare(strict_types=1);

namespace Tests\Feature\Documentation;

use Tests\TestCase;
use App\Models\User;
use App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_documentation_index_can_be_rendered(): void
    {
        $response = $this->get('/docs');

        $response->assertStatus(200);
    }

    public function test_user_can_view_published_documents(): void
    {
        Document::factory()->count(3)->create(['status' => 'published']);
        Document::factory()->create(['status' => 'draft']);

        $response = $this->get('/docs');

        $response->assertStatus(200);
    }

    public function test_user_can_create_document(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/docs', [
            'title' => 'Getting Started',
            'body' => 'Welcome to the documentation.',
            'category' => 'introduction',
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('documents', [
            'title' => 'Getting Started',
            'author_id' => $user->id,
        ]);
    }

    public function test_document_requires_authentication_to_create(): void
    {
        $response = $this->post('/docs', [
            'title' => 'Getting Started',
            'body' => 'Welcome to the documentation.',
            'category' => 'introduction',
            'status' => 'draft',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_document_requires_title(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/docs', [
            'title' => '',
            'body' => 'Welcome to the documentation.',
            'category' => 'introduction',
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_document_requires_body(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/docs', [
            'title' => 'Getting Started',
            'body' => '',
            'category' => 'introduction',
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('body');
    }

    public function test_user_can_update_own_document(): void
    {
        $user = $this->createUser();
        $document = Document::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put("/docs/{$document->slug}", [
            'title' => 'Updated Document',
            'body' => 'Updated content.',
            'category' => 'introduction',
            'status' => 'draft',
        ]);

        $document->refresh();
        $this->assertEquals('Updated Document', $document->title);
    }

    public function test_user_cannot_update_other_users_document(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $document = Document::factory()->create(['author_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->put("/docs/{$document->slug}", [
            'title' => 'Hacked Document',
            'body' => 'Hacked content.',
            'category' => 'introduction',
            'status' => 'draft',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_document(): void
    {
        $user = $this->createUser();
        $document = Document::factory()->create(['author_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete("/docs/{$document->slug}");

        $this->assertSoftDeleted('documents', ['id' => $document->id]);
    }

    public function test_document_can_be_versioned(): void
    {
        $user = $this->createUser();
        $document = Document::factory()->create([
            'author_id' => $user->id,
            'version' => '1.0.0',
        ]);
        $this->actingAs($user);

        $response = $this->post("/docs/{$document->slug}/version", [
            'version' => '1.1.0',
            'body' => 'Updated content for version 1.1.0',
        ]);

        $this->assertDatabaseHas('documents', [
            'title' => $document->title,
            'version' => '1.1.0',
        ]);
    }

    public function test_admin_can_manage_all_documents(): void
    {
        $admin = $this->createAdmin();
        $document = Document::factory()->create();
        $this->actingAs($admin);

        $response = $this->delete("/admin/docs/{$document->id}");

        $this->assertDatabaseMissing('documents', ['id' => $document->id]);
    }

    public function test_document_has_sort_order(): void
    {
        $document = Document::factory()->create(['sort_order' => 5]);

        $this->assertEquals(5, $document->sort_order);
    }

    public function test_document_tracks_views(): void
    {
        $document = Document::factory()->create(['views_count' => 0]);
        $document->increment('views_count');

        $this->assertEquals(1, $document->fresh()->views_count);
    }
}
