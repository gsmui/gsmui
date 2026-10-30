<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Billing\Models\Invoice;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'stripe_id' => fake()->optional()->uuid(),
            'amount' => fake()->randomFloat(2, 9, 299),
            'currency' => 'USD',
            'status' => 'pending',
            'description' => fake()->sentence(),
            'invoice_number' => 'INV-' . fake()->unique()->numberBetween(1000, 9999),
            'pdf_url' => null,
            'paid_at' => null,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn () => [
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }
}
