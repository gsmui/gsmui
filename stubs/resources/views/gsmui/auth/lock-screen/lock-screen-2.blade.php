@props([
    'title' => 'Welcome back',
    'subtitle' => 'Enter your password to unlock.',
    'action' => '#',
    'method' => 'POST',
    'user' => 'John Doe',
    'avatar' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-zinc-950 p-4') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-zinc-800/30 via-zinc-950 to-zinc-950" aria-hidden="true"></div>

    <div class="relative w-full max-w-sm text-center">
        <div class="mx-auto mb-4">
            @if ($avatar)
                <img class="mx-auto size-24 rounded-full object-cover ring-4 ring-zinc-800" src="{{ $avatar }}" alt="{{ $user }}" />
            @else
                <div class="mx-auto flex size-24 items-center justify-center rounded-full bg-zinc-800 ring-4 ring-zinc-700">
                    <svg class="size-12 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                </div>
            @endif
        </div>

        <gsmui:heading size="xl" level="1" class="text-white">{{ $user }}</gsmui:heading>
        <gsmui:text class="mt-1 text-zinc-400">{{ $subtitle }}</gsmui:text>

        <form method="{{ $method }}" action="{{ $action }}" class="mt-6 space-y-4">
            <gsmui:input type="password" placeholder="{{ __('Password') }}" wire:model="password" viewable autocomplete="current-password" required />

            <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Unlock') }}</gsmui:button>
        </form>

        <p class="mt-6 text-sm text-zinc-500">
            <a href="#" class="font-medium text-blue-400 hover:underline">{{ __('Switch account') }}</a>
        </p>
    </div>
</div>
