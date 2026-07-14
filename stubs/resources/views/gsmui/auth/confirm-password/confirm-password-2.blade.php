@props([
    'title' => 'Confirm your password',
    'subtitle' => 'Please confirm your password to continue.',
    'action' => '#',
    'method' => 'POST',
    'showCancel' => true,
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen bg-white dark:bg-zinc-900') }}>
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 items-center justify-center p-12">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,_var(--tw-gradient-stops))] from-blue-400/20 via-transparent to-transparent" aria-hidden="true"></div>
        <div class="relative max-w-md text-center text-white">
            <svg class="mx-auto size-16" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            <h2 class="mt-6 text-2xl font-bold">{{ __('Secure confirmation') }}</h2>
            <p class="mt-3 text-blue-100 max-w-sm mx-auto">{{ __('Re-enter your password to verify your identity.') }}</p>
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

            <form action="{{ $action }}" method="{{ $method }}" class="space-y-4">
                <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable />

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
</div>
