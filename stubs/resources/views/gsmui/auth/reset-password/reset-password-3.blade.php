@props([
    'title' => 'Reset your password',
    'subtitle' => 'Enter your new password below.',
    'action' => '#',
    'method' => 'POST',
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-white dark:bg-zinc-950 px-4 py-12') }}>
    <div class="w-full max-w-sm">
        <gsmui:auth.header :$name :$logo />

        <div class="space-y-1 mb-8">
            <gsmui:heading size="xl">{{ $title }}</gsmui:heading>
            @if ($subtitle)
                <gsmui:text variant="subtle">{{ $subtitle }}</gsmui:text>
            @endif
        </div>

        <form action="{{ $action }}" method="{{ $method }}" class="space-y-5">
            <div class="space-y-4">
                <gsmui:field>
                    <gsmui:field.label>{{ __('New password') }}</gsmui:field.label>
                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('Enter new password') }}" viewable />
                </gsmui:field>

                <gsmui:field>
                    <gsmui:field.label>{{ __('Confirm password') }}</gsmui:field.label>
                    <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm new password') }}" viewable />
                </gsmui:field>
            </div>

            <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Reset password') }}</gsmui:button>
        </form>

        <gsmui:auth.footer />
    </div>
</div>
