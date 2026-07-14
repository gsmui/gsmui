@props([
    'title' => 'Sign In',
    'subtitle' => 'Enter your credentials to access your account.',
    'action' => '#',
    'method' => 'POST',
    'showSocial' => false,
    'showRemember' => true,
    'showForgotPassword' => true,
    'socialProviders' => ['google', 'github', 'apple'],
])

<div {{ $attributes->class('flex min-h-screen bg-white dark:bg-zinc-900') }}>
    <div class="flex w-full items-center justify-center p-6 lg:w-1/2">
        <div class="w-full max-w-md">
            <gsmui:auth.header name="Acme" />

            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>

            <form method="{{ $method }}" action="{{ $action }}" class="mt-8 space-y-4">
                <gsmui:field>
                    <gsmui:field:label>{{ __('Email') }}</gsmui:field:label>
                    <gsmui:input type="email" placeholder="{{ __('email@example.com') }}" wire:model="email" autocomplete="email" required />
                </gsmui:field>

                <gsmui:field>
                    <div class="flex items-center justify-between">
                        <gsmui:field:label>{{ __('Password') }}</gsmui:field:label>
                        @if ($showForgotPassword)
                            <a href="#" class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Forgot password?') }}</a>
                        @endif
                    </div>
                    <gsmui:input type="password" placeholder="{{ __('Enter your password') }}" wire:model="password" viewable autocomplete="current-password" required />
                </gsmui:field>

                @if ($showRemember)
                    <gsmui:checkbox wire:model="remember" label="{{ __('Remember me') }}" />
                @endif

                <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Sign in') }}</gsmui:button>
            </form>

            <p class="mt-8 text-sm text-zinc-500 dark:text-zinc-400">
                {{ __("Don't have an account?") }}
                <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Sign up') }}</a>
            </p>

            <gsmui:auth.footer />
        </div>
    </div>

    <div class="hidden lg:flex lg:w-1/2 bg-zinc-100 dark:bg-zinc-800 items-center justify-center p-12">
        <div class="text-center">
            <div class="mx-auto size-24 rounded-2xl bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                <svg class="size-12 text-zinc-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
            </div>
            <h3 class="mt-6 text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Welcome back') }}</h3>
            <p class="mt-2 max-w-sm text-sm text-zinc-500 dark:text-zinc-400">{{ __('Sign in to access your dashboard, manage your projects, and collaborate with your team.') }}</p>
        </div>
    </div>
</div>
