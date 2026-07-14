@props([
    'title' => 'Forgot your password?',
    'subtitle' => 'Enter your email and we will send you a reset link.',
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
                <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" />

                <gsmui:button variant="primary" type="submit" class="w-full !bg-violet-600 hover:!bg-violet-500 active:!bg-violet-700">{{ __('Send reset link') }}</gsmui:button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-400">
                <a href="#" class="font-medium text-violet-400 hover:text-violet-300">{{ __('Back to sign in') }}</a>
            </p>
        </div>

        <gsmui:auth.footer />
    </div>
</div>
