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

<div {{ $attributes->class('flex min-h-screen bg-white dark:bg-zinc-900') }}>
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 items-center justify-center p-12">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,_var(--tw-gradient-stops))] from-blue-400/20 via-transparent to-transparent" aria-hidden="true"></div>
        <div class="relative max-w-md text-center text-white">
            <h2 class="text-3xl font-bold mb-4">{{ __('Build something amazing.') }}</h2>
            <p class="text-blue-100 text-lg">{{ __('Access your dashboard and manage your projects with ease.') }}</p>
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

            <gsmui:auth.footer />
        </div>
    </div>
</div>
