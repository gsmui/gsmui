@props([
    'title' => 'Confirm your password',
    'subtitle' => 'Please confirm your password to continue.',
    'action' => '#',
    'method' => 'POST',
    'showCancel' => true,
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-gradient-to-br from-zinc-50 via-white to-zinc-100 dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950 px-4 py-12') }}>
    <div class="w-full max-w-md">
        <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-xl shadow-zinc-200/50 dark:shadow-zinc-900/50 p-8">
            <gsmui:auth.header :$name :$logo />

            <div class="text-center">
                <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                    <svg class="size-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                </div>
                <gsmui:heading size="xl" level="1" class="mt-4">{{ $title }}</gsmui:heading>
                @if ($subtitle)
                    <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>
                @endif
            </div>

            <form action="{{ $action }}" method="{{ $method }}" class="mt-6 space-y-4">
                <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable />

                <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Confirm password') }}</gsmui:button>

                @if ($showCancel)
                    <div class="text-center">
                        <a href="#" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 underline underline-offset-2">{{ __('Cancel') }}</a>
                    </div>
                @endif
            </form>
        </div>

        <gsmui:auth.footer />
    </div>
</div>
