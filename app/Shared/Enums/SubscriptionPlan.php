<?php

declare(strict_types=1);

namespace App\Shared\Enums;

enum SubscriptionPlan: string
{
    case Free = 'free';
    case Pro = 'pro';
    case Team = 'team';
    case Enterprise = 'enterprise';

    /**
     * Get the display label.
     */
    public function label(): string
    {
        return match ($this) {
            self::Free => 'Free',
            self::Pro => 'Pro',
            self::Team => 'Team',
            self::Enterprise => 'Enterprise',
        };
    }

    /**
     * Get the monthly price.
     */
    public function monthlyPrice(): float
    {
        return match ($this) {
            self::Free => 0.00,
            self::Pro => 19.00,
            self::Team => 49.00,
            self::Enterprise => 199.00,
        };
    }

    /**
     * Get the yearly price.
     */
    public function yearlyPrice(): float
    {
        return $this->monthlyPrice() * 10;
    }

    /**
     * Get the features included.
     */
    public function features(): array
    {
        return match ($this) {
            self::Free => [
                'access_free_components',
                'basic_documentation',
                'community_support',
            ],
            self::Pro => [
                'access_free_components',
                'access_premium_components',
                'full_documentation',
                'priority_support',
                'early_access',
                'export_code',
            ],
            self::Team => [
                'access_free_components',
                'access_premium_components',
                'full_documentation',
                'priority_support',
                'early_access',
                'export_code',
                'team_collaboration',
                'shared_projects',
                'team_billing',
            ],
            self::Enterprise => [
                'access_free_components',
                'access_premium_components',
                'full_documentation',
                'priority_support',
                'early_access',
                'export_code',
                'team_collaboration',
                'shared_projects',
                'team_billing',
                'custom_development',
                'dedicated_support',
                'sla_guarantee',
            ],
        };
    }
}
