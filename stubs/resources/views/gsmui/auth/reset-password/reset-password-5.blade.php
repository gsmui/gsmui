@props([
    'title' => 'Reset your password',
    'subtitle' => 'Enter your new password below.',
    'action' => '#',
    'method' => 'POST',
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-950 via-purple-900 to-slate-900 px-4 py-12') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white/5 via-transparent to-transparent" aria-hidden="true"></div>
    <div class="absolute top-20 left-10 size-72 rounded-full bg-violet-500/10 blur-3xl" aria-hidden="true"></div>
    <div class="absolute bottom-20 right-10 size-96 rounded-full bg-indigo-500/10 blur-3xl" aria-hidden="true"></div>

    <div class="relative w-full max-w-md">
        <div class="rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-xl">
            <gsmui:auth.header :$name :$logo />

            <div class="space-y-1 mb-6">
                <gsmui:heading size="xl" class="!text-white">{{ $title }}</gsmui:heading>
                @if ($subtitle)
                    <gsmui:text variant="subtle" class="!text-zinc-400">{{ $subtitle }}</gsmui:text>
                @endif
            </div>

            <form action="{{ $action }}" method="{{ $method }}" class="space-y-5">
                <div class="space-y-4">
                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('New password') }}" icon="key" viewable />
                    <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" icon="key" viewable />
                </div>

                <gsmui:button variant="primary" type="submit" class="w-full !bg-violet-600 hover:!bg-violet-500 active:!bg-violet-700">{{ __('Reset password') }}</gsmui:button>
            </form>
        </div>

        <gsmui:auth.footer />
    </div>
</div>
