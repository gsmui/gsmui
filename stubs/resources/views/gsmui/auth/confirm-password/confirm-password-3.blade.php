@props([
    'title' => 'Confirm your password',
    'subtitle' => 'Please confirm your password to continue.',
    'action' => '#',
    'method' => 'POST',
    'showCancel' => true,
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-white dark:bg-zinc-900 px-4 py-12') }}>
    <div class="w-full max-w-sm">
        <gsmui:auth.header :$name :$logo />

        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        @if ($subtitle)
            <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>
        @endif

        <form action="{{ $action }}" method="{{ $method }}" class="mt-8 space-y-4">
            <gsmui:field>
                <gsmui:field.label>{{ __('Password') }}</gsmui:field.label>
                <gsmui:input wire:model="password" type="password" placeholder="{{ __('Enter your password') }}" viewable />
            </gsmui:field>

            <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Confirm password') }}</gsmui:button>

            @if ($showCancel)
                <div class="text-center">
                    <a href="#" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 underline underline-offset-2">{{ __('Cancel') }}</a>
                </div>
            @endif
        </form>

        <gsmui:auth.footer />
    </div>
</div>
