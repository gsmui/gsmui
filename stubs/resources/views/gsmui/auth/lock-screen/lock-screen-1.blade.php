@props([
    'title' => 'Welcome back',
    'subtitle' => 'Enter your password to unlock.',
    'action' => '#',
    'method' => 'POST',
    'user' => 'John Doe',
    'avatar' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-50 via-white to-violet-50 dark:from-zinc-900 dark:via-zinc-900 dark:to-zinc-900 p-4') }}>
    <div class="w-full max-w-sm text-center">
        <div class="mx-auto mb-4">
            @if ($avatar)
                <img class="mx-auto size-20 rounded-full object-cover" src="{{ $avatar }}" alt="{{ $user }}" />
            @else
                <div class="mx-auto flex size-20 items-center justify-center rounded-full bg-zinc-200 dark:bg-zinc-700">
                    <svg class="size-10 text-zinc-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                </div>
            @endif
        </div>

        <gsmui:heading size="xl" level="1">{{ $user }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-1">{{ $subtitle }}</gsmui:text>

        <form method="{{ $method }}" action="{{ $action }}" class="mt-6 space-y-4">
            <gsmui:input type="password" placeholder="{{ __('Password') }}" wire:model="password" viewable autocomplete="current-password" required />

            <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Unlock') }}</gsmui:button>
        </form>

        <p class="mt-6 text-sm text-zinc-500 dark:text-zinc-400">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Sign in with a different account') }}</a>
        </p>
    </div>
</div>
