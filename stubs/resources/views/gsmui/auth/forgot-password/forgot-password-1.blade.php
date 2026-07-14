@props([
    'title' => 'Forgot your password?',
    'subtitle' => 'Enter your email and we will send you a reset link.',
    'action' => '#',
    'method' => 'POST',
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-gradient-to-br from-zinc-50 via-white to-zinc-100 dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950 px-4 py-12') }}>
    <div class="w-full max-w-md">
        <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-xl shadow-zinc-200/50 dark:shadow-zinc-900/50 p-8">
            <gsmui:auth.header :$name :$logo />

            <div class="space-y-1 mb-6">
                <gsmui:heading size="xl">{{ $title }}</gsmui:heading>
                @if ($subtitle)
                    <gsmui:text variant="subtle">{{ $subtitle }}</gsmui:text>
                @endif
            </div>

            <form action="{{ $action }}" method="{{ $method }}" class="space-y-5">
                <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" />

                <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Send reset link') }}</gsmui:button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">{{ __('Back to sign in') }}</a>
            </p>
        </div>

        <gsmui:auth.footer />
    </div>
</div>
