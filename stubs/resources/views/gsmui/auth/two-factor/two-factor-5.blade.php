@props([
    'title' => 'Two-factor authentication',
    'subtitle' => 'Enter the verification code from your authenticator app.',
    'action' => '#',
    'method' => 'POST',
    'showRecovery' => true,
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-50 via-white to-violet-50 dark:from-zinc-900 dark:via-zinc-900 dark:to-zinc-900 p-4') }}>
    <div class="w-full max-w-md">
        <gsmui:auth.header :$name :$logo />

        <gsmui:card variant="default" size="lg" class="w-full">
            <div class="p-6 sm:p-8">
                <div class="text-center">
                    <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="size-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                    </div>
                    <gsmui:heading size="xl" level="1" class="mt-4">{{ $title }}</gsmui:heading>
                    <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>
                </div>

                <div class="mt-6 flex flex-col items-center">
                    <div class="flex items-center justify-center w-48 h-48 rounded-xl border-2 border-dashed border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                        <div class="text-center">
                            <svg class="mx-auto size-10 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z" /></svg>
                            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Scan QR code') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <gsmui:text variant="subtle" class="text-center text-sm">{{ __('Or enter code manually:') }}</gsmui:text>

                    <form method="{{ $method }}" action="{{ $action }}" class="mt-4 space-y-4">
                        <gsmui:field>
                            <gsmui:input type="text" placeholder="{{ __('Enter code') }}" autocomplete="one-time-code" required />
                        </gsmui:field>

                        <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Verify') }}</gsmui:button>
                    </form>
                </div>

                @if ($showRecovery)
                    <p class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Use a recovery code') }}</a>
                    </p>
                @endif
            </div>
        </gsmui:card>

        <gsmui:auth.footer />
    </div>
</div>
