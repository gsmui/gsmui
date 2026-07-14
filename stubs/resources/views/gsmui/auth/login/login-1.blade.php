@props([
    'title' => 'Welcome back',
    'subtitle' => 'Sign in to your account to continue.',
    'action' => '#',
    'method' => 'POST',
    'showSocial' => true,
    'showRemember' => true,
    'showForgotPassword' => true,
    'providers' => ['google', 'github', 'apple'],
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-gradient-to-br from-zinc-50 via-white to-zinc-100 dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950 px-4 py-12') }}>
    <div class="w-full max-w-md">
        <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-xl shadow-zinc-200/50 dark:shadow-zinc-900/50 p-8">
            <gsmui:auth.header :$name :$logo />

            <div class="space-y-1 mb-6">
                <gsmui:heading size="xl">{{ $title }}</gsmui:heading>
                @if ($subtitle)
                    <gsmui:text variant="subtle">{{ $subtitle }}</gsmui:text>
                @endif
            </div>

            <form action="{{ $action }}" method="{{ $method }}" class="space-y-5">
                <div class="space-y-4">
                    <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" />
                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable />
                </div>

                <div class="flex items-center justify-between">
                    @if ($showRemember)
                        <gsmui:checkbox wire:model="remember" label="{{ __('Remember me') }}" />
                    @endif

                    @if ($showForgotPassword)
                        <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">{{ __('Forgot password?') }}</a>
                    @endif
                </div>

                <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Sign in') }}</gsmui:button>
            </form>

            @if ($showSocial)
                <div class="mt-6">
                    <gsmui:divider text="{{ __('or continue with') }}" class="mb-6" />
                    <gsmui:auth.social :$providers />
                </div>
            @endif
        </div>

        <gsmui:auth.footer />
    </div>
</div>
