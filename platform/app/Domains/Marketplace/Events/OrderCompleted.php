<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Events;

use App\Domains\Users\Models\User;
use App\Domains\Marketplace\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCompleted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly Order $order
    ) {}
}
