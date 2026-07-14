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

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-zinc-50 dark:bg-zinc-950 p-4') }}>
    <div class="w-full max-w-2xl">
        <gsmui:auth.header name="Acme" />

        <gsmui:card variant="outlined" size="lg" class="w-full">
            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div>
                        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
                        <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>

                        <div class="mt-6 space-y-3">
                            @foreach (['Secure login', 'Remember your session', '2FA support'] as $feature)
                                <div class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                                    <svg class="size-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    {{ $feature }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <form method="{{ $method }}" action="{{ $action }}" class="space-y-4">
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

                        <p class="text-center text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __("Don't have an account?") }}
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Sign up') }}</a>
                        </p>
                    </form>
                </div>
            </div>
        </gsmui:card>

        <gsmui:auth.footer />
    </div>
</div>
