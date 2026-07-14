@props([
    'title' => 'Forgot your password?',
    'subtitle' => 'Enter your email and we will send you a reset link.',
    'action' => '#',
    'method' => 'POST',
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen bg-white dark:bg-zinc-900') }}>
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 items-center justify-center p-12">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,_var(--tw-gradient-stops))] from-blue-400/20 via-transparent to-transparent" aria-hidden="true"></div>
        <div class="relative max-w-md text-center text-white">
            <h2 class="text-3xl font-bold mb-4">{{ __('No worries!') }}</h2>
            <p class="text-blue-100 text-lg">{{ __("We'll help you get back into your account in just a few steps.") }}</p>
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
                <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" />

                <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Send reset link') }}</gsmui:button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">{{ __('Back to sign in') }}</a>
            </p>

            <gsmui:auth.footer />
        </div>
    </div>
</div>
