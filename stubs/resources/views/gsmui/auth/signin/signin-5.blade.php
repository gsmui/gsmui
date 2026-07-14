@props([
    'title' => 'Welcome Back',
    'subtitle' => 'Sign in to continue to your account.',
    'action' => '#',
    'method' => 'POST',
    'showSocial' => false,
    'showRemember' => true,
    'showForgotPassword' => true,
    'socialProviders' => ['google', 'github', 'apple'],
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-amber-50 dark:bg-zinc-950 p-4') }}>
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <div class="mx-auto size-16 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                <svg class="size-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
            </div>
        </div>

        <gsmui:card variant="default" size="lg" class="w-full">
            <div class="p-6 sm:p-8">
                <div class="text-center">
                    <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
                    <gsmui:text variant="subtle" class="mt-1">{{ $subtitle }}</gsmui:text>
                </div>

                <form method="{{ $method }}" action="{{ $action }}" class="mt-6 space-y-4">
                    <gsmui:field>
                        <gsmui:field:label>{{ __('Email') }}</gsmui:field:label>
                        <gsmui:input type="email" placeholder="{{ __('email@example.com') }}" wire:model="email" autocomplete="email" required />
                    </gsmui:field>

                    <gsmui:field>
                        <div class="flex items-center justify-between">
                            <gsmui:field:label>{{ __('Password') }}</gsmui:field:label>
                            @if ($showForgotPassword)
                                <a href="#" class="text-xs font-medium text-amber-600 dark:text-amber-400 hover:underline">{{ __('Forgot password?') }}</a>
                            @endif
                        </div>
                        <gsmui:input type="password" placeholder="{{ __('Enter your password') }}" wire:model="password" viewable autocomplete="current-password" required />
                    </gsmui:field>

                    @if ($showRemember)
                        <gsmui:checkbox wire:model="remember" label="{{ __('Remember me') }}" />
                    @endif

                    <gsmui:button variant="primary" type="submit" class="w-full bg-amber-600 hover:bg-amber-500 active:bg-amber-700">{{ __('Sign in') }}</gsmui:button>
                </form>

                <p class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __("Don't have an account?") }}
                    <a href="#" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">{{ __('Sign up') }}</a>
                </p>
            </div>
        </gsmui:card>

        <gsmui:auth.footer />
    </div>
</div>
