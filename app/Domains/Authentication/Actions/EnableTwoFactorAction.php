<?php

declare(strict_types=1);

namespace App\Domains\Authentication\Actions;

use App\Domains\Users\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class EnableTwoFactorAction
{
    public function execute(User $user): array
    {
        $google2fa = new Google2FA();

        $secret = $google2fa->generateSecretKey();

        $user->update([
            'two_factor_secret' => Crypt::encryptString($secret),
            'two_factor_enabled' => false,
        ]);

        return [
            'secret' => $secret,
            'recovery_codes' => $this->generateRecoveryCodes(),
        ];
    }

    public function confirm(User $user, string $code): bool
    {
        $secret = Crypt::decryptString($user->two_factor_secret);

        $valid = (new Google2FA())->verifyKey($secret, $code);

        if ($valid) {
            $user->update(['two_factor_enabled' => true]);
        }

        return $valid;
    }

    public function disable(User $user): void
    {
        $user->update([
            'two_factor_secret' => null,
            'two_factor_enabled' => false,
            'two_factor_recovery_codes' => null,
        ]);
    }

    protected function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(Str::random(4) . '-' . Str::random(4));
        }
        return $codes;
    }
}
