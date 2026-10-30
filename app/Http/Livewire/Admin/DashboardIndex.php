<?php

declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        $stats = [
            'total_users' => \App\Domains\Users\Models\User::count(),
            'active_users' => \App\Domains\Users\Models\User::where('created_at', '>=', now()->subDays(30))->count(),
            'total_components' => \App\Domains\Components\Models\Component::count(),
            'total_themes' => \App\Domains\Themes\Models\Theme::count(),
            'total_templates' => \App\Domains\Templates\Models\Template::count(),
            'total_downloads' => \App\Domains\Components\Models\Component::sum('downloads_count'),
            'revenue_this_month' => \App\Domains\Billing\Models\Invoice::where('status', 'paid')
                ->where('created_at', '>=', now()->startOfMonth())
                ->sum('amount'),
            'new_users_this_month' => \App\Domains\Users\Models\User::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
        ])->layout('components.layouts.app');
    }
}
