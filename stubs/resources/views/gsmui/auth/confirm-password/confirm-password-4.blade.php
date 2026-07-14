@props([
    'title' => 'Confirm your password',
    'subtitle' => 'Please confirm your password to continue.',
    'action' => '#',
    'method' => 'POST',
    'showCancel' => true,
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-zinc-950 px-4 py-12') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-zinc-800/50 via-zinc-950 to-zinc-950" aria-hidden="true"></div>

    <div class="relative w-full max-w-md">
        <gsmui:auth.header :$name :$logo />

        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6 sm:p-8 shadow-2xl">
            <div class="text-center">
                <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-blue-500/10">
                    <svg class="size-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                </div>
                <gsmui:heading size="xl" level="1" class="mt-4 text-white">{{ $title }}</gsmui:heading>
                @if ($subtitle)
                    <gsmui:text class="mt-2 text-zinc-400">{{ $subtitle }}</gsmui:text>
                @endif
            </div>

            <form action="{{ $action }}" method="{{ $method }}" class="mt-6 space-y-4">
                <gsmui:field>
                    <gsmui:field.label class="text-zinc-300">{{ __('Password') }}</gsmui:field.label>
                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('Enter your password') }}" viewable />
                </gsmui:field>

                <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Confirm password') }}</gsmui:button>

                @if ($showCancel)
                    <div class="text-center">
                        <a href="#" class="text-sm text-zinc-400 hover:text-zinc-200 underline underline-offset-2">{{ __('Cancel') }}</a>
                    </div>
                @endif
            </form>
        </div>

        <gsmui:auth.footer />
    </div>
</div>
