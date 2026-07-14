@props([
    'title' => 'Welcome back',
    'subtitle' => 'Enter your password.',
    'action' => '#',
    'method' => 'POST',
    'user' => 'John Doe',
    'avatar' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-white dark:bg-zinc-900 p-4') }}>
    <div class="w-full max-w-xs text-center">
        @if ($avatar)
            <img class="mx-auto size-16 rounded-full object-cover" src="{{ $avatar }}" alt="{{ $user }}" />
        @else
            <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-800">
                <svg class="size-8 text-zinc-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
            </div>
        @endif

        <p class="mt-4 text-sm font-medium text-zinc-900 dark:text-white">{{ $user }}</p>

        <form method="{{ $method }}" action="{{ $action }}" class="mt-4 space-y-3">
            <gsmui:input type="password" placeholder="{{ __('Password') }}" wire:model="password" viewable autocomplete="current-password" required />

            <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Unlock') }}</gsmui:button>
        </form>

        <a href="#" class="mt-4 inline-block text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200">{{ __('Not you?') }}</a>
    </div>
</div>
