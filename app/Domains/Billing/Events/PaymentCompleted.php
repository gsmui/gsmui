<?php

declare(strict_types=1);

namespace App\Domains\Billing\Events;

use App\Domains\Users\Models\User;
use App\Domains\Billing\Models\Invoice;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentCompleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly Invoice $invoice
    ) {}
}
