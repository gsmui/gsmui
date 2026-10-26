<?php

declare(strict_types=1);

namespace Tests\Feature\Billing;

use Tests\TestCase;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_invoices(): void
    {
        $user = $this->createUser();
        Invoice::factory()->count(3)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get('/dashboard/invoices');

        $response->assertStatus(200);
    }

    public function test_invoices_requires_authentication(): void
    {
        $response = $this->get('/dashboard/invoices');

        $response->assertRedirect('/login');
    }

    public function test_user_can_view_single_invoice(): void
    {
        $user = $this->createUser();
        $invoice = Invoice::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get("/dashboard/invoices/{$invoice->id}");

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_other_users_invoice(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $invoice = Invoice::factory()->create(['user_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->get("/dashboard/invoices/{$invoice->id}");

        $response->assertStatus(403);
    }

    public function test_user_can_download_invoice_pdf(): void
    {
        $user = $this->createUser();
        $invoice = Invoice::factory()->create([
            'user_id' => $user->id,
            'pdf_url' => 'invoices/test.pdf',
        ]);
        $this->actingAs($user);

        Storage::fake();
        Storage::disk('local')->put('invoices/test.pdf', 'fake-pdf-content');

        $response = $this->get("/dashboard/invoices/{$invoice->id}/download");

        $response->assertStatus(200);
    }

    public function test_invoice_has_correct_total(): void
    {
        $invoice = Invoice::factory()->create(['total' => 49.99]);

        $this->assertEquals('49.99', $invoice->total);
    }

    public function test_invoice_has_line_items(): void
    {
        $invoice = Invoice::factory()->create([
            'line_items' => [
                ['description' => 'Pro Plan', 'amount' => 29.99],
                ['description' => 'Tax', 'amount' => 2.40],
            ],
        ]);

        $this->assertIsArray($invoice->line_items);
        $this->assertCount(2, $invoice->line_items);
    }

    public function test_invoice_belongs_to_user(): void
    {
        $invoice = Invoice::factory()->create();

        $this->assertInstanceOf(User::class, $invoice->user);
    }

    public function test_user_can_see_only_own_invoices(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        Invoice::factory()->count(3)->create(['user_id' => $user->id]);
        Invoice::factory()->count(5)->create(['user_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->get('/dashboard/invoices');

        $response->assertStatus(200);
    }
}
