<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Subscription extends Component
{
    public $user, $currentPlan = 'free';

    public function mount()
    {
        $this->user = auth()->user();
        $this->currentPlan = $this->user->subscription?->plan ?? 'free';
    }

    public function subscribe($plan) { session()->flash('info', 'Checkout will be available soon.'); }
    public function cancelSubscription()
    {
        if ($this->user->subscription) {
            $this->user->subscription->update(['status' => 'cancelled', 'cancelled_at' => now()]);
            session()->flash('success', 'Subscription cancelled.');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.subscription')->layout('components.layouts.dashboard', ['title' => 'Subscription']);
    }
}
