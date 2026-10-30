<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Actions;

use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;
use App\Infrastructure\Payments\StripeService;

class ProcessPayoutAction
{
    public function __construct(
        protected StripeService $stripe,
        protected NotificationService $notificationService
    ) {}

    public function execute(User $creator, float $amount, ?string $notes = null): array
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Payout amount must be greater than zero.');
        }

        $availableBalance = $this->getAvailableBalance($creator);

        if ($amount > $availableBalance) {
            throw new \LogicException('Insufficient balance for payout.');
        }

        $payoutResult = $this->stripe->createPayout($creator, $amount);

        $this->notificationService->send(
            $creator,
            'payout_processed',
            'Payout Processed',
            "A payout of $" . number_format($amount, 2) . " has been processed.",
            ['amount' => $amount, 'payout_id' => $payoutResult['payout_id']],
            '/dashboard/earnings'
        );

        return $payoutResult;
    }

    public function getAvailableBalance(User $creator): float
    {
        $totalEarnings = $creator->orders()
            ->where('status', 'completed')
            ->sum('amount');

        $totalPayouts = $creator->payouts()
            ->where('status', 'completed')
            ->sum('amount');

        return $totalEarnings - $totalPayouts;
    }
}
