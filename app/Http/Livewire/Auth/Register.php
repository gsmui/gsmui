<?php

declare(strict_types=1);

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Domains\Users\Models\User;

class Register extends Component
{
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.guest');
    }
}
