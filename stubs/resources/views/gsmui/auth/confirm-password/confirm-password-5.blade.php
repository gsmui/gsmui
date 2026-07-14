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
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white/5 via-transparent to-transparent" aria-hidden="true"></div>

    <div class="relative w-full max-w-sm">
        <div class="rounded-2xl border border-white/10 bg-zinc-900/80 p-6 backdrop-blur-sm shadow-xl">
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
                <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable />

                <div class="flex items-center gap-3">
                    @if ($showCancel)
                        <a href="#" class="flex-1 text-center text-sm py-2.5 rounded-lg border border-white/10 text-zinc-300 hover:bg-white/5 transition-colors">{{ __('Cancel') }}</a>
                    @endif
                    <gsmui:button variant="primary" type="submit" class="flex-1">{{ __('Confirm password') }}</gsmui:button>
                </div>
            </form>
        </div>

        <gsmui:auth.footer />
    </div>
</div>
