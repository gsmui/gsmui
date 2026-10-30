<?php

declare(strict_types=1);

namespace App\Infrastructure\Mail;

use App\Domains\Users\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send a welcome email.
     */
    public function sendWelcome(User $user): void
    {
        Mail::to($user->email)->send(new \App\Infrastructure\Mail\WelcomeEmail($user));
    }

    /**
     * Send an email verification.
     */
    public function sendEmailVerification(User $user): void
    {
        Mail::to($user->email)->send(new \App\Infrastructure\Mail\EmailVerificationEmail($user));
    }

    /**
     * Send a password reset email.
     */
    public function sendPasswordReset(User $user, string $token): void
    {
        Mail::to($user->email)->send(new \App\Infrastructure\Mail\PasswordResetEmail($user, $token));
    }

    /**
     * Send an invoice email.
     */
    public function sendInvoice(User $user, $invoice): void
    {
        Mail::to($user->email)->send(new \App\Infrastructure\Mail\InvoiceEmail($user, $invoice));
    }

    /**
     * Send a subscription confirmation.
     */
    public function sendSubscriptionConfirmation(User $user, $subscription): void
    {
        Mail::to($user->email)->send(new \App\Infrastructure\Mail\SubscriptionConfirmationEmail($user, $subscription));
    }

    /**
     * Send a notification email.
     */
    public function sendNotification(User $user, string $subject, string $body): void
    {
        Mail::to($user->email)->send(new \App\Infrastructure\Mail\NotificationEmail($user, $subject, $body));
    }
}
