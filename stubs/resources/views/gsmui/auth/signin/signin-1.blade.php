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
    <div class="w-full max-w-md">
        <gsmui:card variant="outlined" size="lg" class="w-full">
            <div x-slot:header class="text-center py-6">
                <gsmui:auth.header name="Acme" />
                <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mt-1">{{ $subtitle }}</gsmui:text>
            </div>

            <div class="p-6">
                @if ($showSocial)
                    <gsmui:auth.social :providers="$socialProviders" class="mb-6" />
                    <gsmui:divider text="{{ __('or continue with email') }}" class="mb-6" />
                @endif

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
                </form>
            </div>

            <div x-slot:footer class="text-center py-4">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __("Don't have an account?") }}
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Sign up') }}</a>
                </p>
            </div>
        </gsmui:card>

        <gsmui:auth.footer />
    </div>
</div>
