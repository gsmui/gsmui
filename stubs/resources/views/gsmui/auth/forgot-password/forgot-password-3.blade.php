@props([
    'title' => 'Forgot your password?',
    'subtitle' => 'Enter your email and we will send you a reset link.',
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
                    <gsmui:field.label>{{ __('Email') }}</gsmui:field.label>
                    <gsmui:input wire:model="email" type="email" placeholder="{{ __('you@example.com') }}" />
                </gsmui:field>
            </div>

            <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Send reset link') }}</gsmui:button>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
            <a href="#" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 underline underline-offset-2">{{ __('Back to sign in') }}</a>
        </p>

        <gsmui:auth.footer />
    </div>
</div>
