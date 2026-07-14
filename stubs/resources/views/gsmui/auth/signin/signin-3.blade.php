@props([
    'title' => 'Sign In',
    'subtitle' => 'Enter your credentials below.',
    'action' => '#',
    'method' => 'POST',
    'showSocial' => false,
    'showRemember' => true,
    'showForgotPassword' => true,
    'socialProviders' => ['google', 'github', 'apple'],
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-white dark:bg-zinc-900 p-4') }}>
    <div class="w-full max-w-xs">
        <gsmui:auth.header name="Acme" />

        <gsmui:heading size="lg" level="1">{{ $title }}</gsmui:heading>
        <gsmui:text variant="subtle" size="sm" class="mt-1">{{ $subtitle }}</gsmui:text>

        <form method="{{ $method }}" action="{{ $action }}" class="mt-8 space-y-5">
            <div>
                <input type="email" placeholder="{{ __('Email address') }}" wire:model="email" autocomplete="email" required class="w-full border-0 border-b border-zinc-200 dark:border-zinc-700 bg-transparent pb-2 text-sm focus:border-blue-600 focus:outline-none focus:ring-0 dark:text-white dark:focus:border-blue-400 placeholder-zinc-400" />
            </div>

            <div>
                <input type="password" placeholder="{{ __('Password') }}" wire:model="password" autocomplete="current-password" required class="w-full border-0 border-b border-zinc-200 dark:border-zinc-700 bg-transparent pb-2 text-sm focus:border-blue-600 focus:outline-none focus:ring-0 dark:text-white dark:focus:border-blue-400 placeholder-zinc-400" />
            </div>

            <div class="flex items-center justify-between">
                @if ($showRemember)
                    <gsmui:checkbox wire:model="remember" label="{{ __('Remember me') }}" />
                @endif
                @if ($showForgotPassword)
                    <a href="#" class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Forgot?') }}</a>
                @endif
            </div>

            <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Sign in') }}</gsmui:button>
        </form>

        <p class="mt-8 text-center text-xs text-zinc-500 dark:text-zinc-400">
            {{ __("Don't have an account?") }}
            <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Sign up') }}</a>
        </p>

        <gsmui:auth.footer />
    </div>
</div>
