@props([
    'title' => 'Reset your password',
    'subtitle' => 'Enter your new password below.',
    'action' => '#',
    'method' => 'POST',
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-zinc-950 px-4 py-12') }}>
    <div class="absolute inset-0 bg-[url(\'data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2032%2032%22%20width%3D%2232%22%20height%3D%2232%22%20fill%3D%22none%22%20stroke%3D%22rgb(255%20255%20255%20%2F%200.03)%22%3E%3Cpath%20d%3D%22M0%20.5H31.5V32%22%2F%3E%3C%2Fsvg%3E\')] opacity-50" aria-hidden="true"></div>

    <div class="relative w-full max-w-md">
        <div class="rounded-2xl border border-white/10 bg-zinc-900/80 p-8 backdrop-blur-sm">
            <gsmui:auth.header :$name :$logo />

            <div class="space-y-1 mb-6">
                <gsmui:heading size="xl" class="!text-white">{{ $title }}</gsmui:heading>
                @if ($subtitle)
                    <gsmui:text variant="subtle" class="!text-zinc-400">{{ $subtitle }}</gsmui:text>
                @endif
            </div>

            <form action="{{ $action }}" method="{{ $method }}" class="space-y-5">
                <div class="space-y-4">
                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('New password') }}" icon="key" viewable />
                    <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" icon="key" viewable />
                </div>

                <gsmui:button variant="primary" type="submit" class="w-full !bg-blue-600 hover:!bg-blue-500 active:!bg-blue-700">{{ __('Reset password') }}</gsmui:button>
            </form>
        </div>

        <gsmui:auth.footer />
    </div>
</div>
