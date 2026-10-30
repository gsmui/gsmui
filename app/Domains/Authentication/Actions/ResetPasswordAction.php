<?php

declare(strict_types=1);

namespace App\Domains\Authentication\Actions;

use App\Domains\Users\Models\User;
use App\Infrastructure\Mail\EmailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction
{
    public function __construct(
        protected EmailService $emailService
    ) {}

    public function sendResetLink(string $email): string
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return __('A password reset link will be sent if the account exists.');
        }

        $status = Password::sendResetLink(
            ['email' => $email],
            function (User $user, string $token) {
                $this->emailService->sendPasswordReset($user, $token);
            }
        );

        return __('A password reset link will be sent if the account exists.');
    }

    public function reset(string $email, string $token, string $password): bool
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        $status = Password::reset(
            ['email' => $email, 'password' => $password, 'password_confirmation' => $password],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET;
    }
}
