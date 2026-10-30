<?php

declare(strict_types=1);

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class VerifyEmail extends Component
{
    public function resendVerificationEmail(): void
    {
        Auth::user()->sendEmailVerificationNotification();

        session()->flash('message', 'Verification link sent!');
    }

    public function render()
    {
        return view('livewire.auth.verify-email')->layout('components.layouts.app');
    }
}
