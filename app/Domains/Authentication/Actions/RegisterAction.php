<?php

declare(strict_types=1);

namespace App\Domains\Authentication\Actions;

use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;
use App\Infrastructure\Mail\EmailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function __construct(
        protected NotificationService $notificationService,
        protected EmailService $emailService
    ) {}

    public function execute(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'] ?? null,
        ]);

        $this->emailService->sendWelcome($user);

        $this->notificationService->send(
            $user,
            'welcome',
            'Welcome to GsmUI!',
            'Your account has been created successfully. Start exploring components and themes.',
            [],
            '/dashboard'
        );

        Auth::login($user);

        event(new \App\Domains\Users\Events\UserRegistered($user));

        return $user;
    }
}
