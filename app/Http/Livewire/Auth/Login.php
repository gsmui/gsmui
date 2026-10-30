<?php

declare(strict_types=1);

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public ?string $status = null;

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ];

    public function updatedEmail(): void
    {
        $this->validateOnly('email');
    }

    public function updatedPassword(): void
    {
        $this->validateOnly('password');
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        session()->flash('error', 'Invalid credentials.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }
}
