@props([
    'title' => 'Reset your password',
    'subtitle' => 'Enter your new password below.',
    'action' => '#',
    'method' => 'POST',
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen bg-white dark:bg-zinc-900') }}>
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 items-center justify-center p-12">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,_var(--tw-gradient-stops))] from-blue-400/20 via-transparent to-transparent" aria-hidden="true"></div>
        <div class="relative max-w-md text-center text-white">
            <h2 class="text-3xl font-bold mb-4">{{ __('Secure reset') }}</h2>
            <p class="text-blue-100 text-lg">{{ __('Your new password will be encrypted and stored securely.') }}</p>
        </div>
    </div>

    <div class="flex w-full lg:w-1/2 items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <gsmui:auth.header :$name :$logo />

            <div class="space-y-1 mb-6">
                <gsmui:heading size="xl">{{ $title }}</gsmui:heading>
                @if ($subtitle)
                    <gsmui:text variant="subtle">{{ $subtitle }}</gsmui:text>
                @endif
            </div>

            <form action="{{ $action }}" method="{{ $method }}" class="space-y-5">
                <div class="space-y-4">
                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('New password') }}" icon="key" viewable />
                    <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" icon="key" viewable />
                </div>

                <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Reset password') }}</gsmui:button>
            </form>

            <gsmui:auth.footer />
        </div>
    </div>
</div>
