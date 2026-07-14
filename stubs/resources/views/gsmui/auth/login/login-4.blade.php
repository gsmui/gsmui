@props([
    'title' => 'Welcome back',
    'subtitle' => 'Sign in to your account to continue.',
    'action' => '#',
    'method' => 'POST',
    'showSocial' => false,
    'showRemember' => true,
    'showForgotPassword' => true,
    'providers' => ['google', 'github', 'apple'],
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-white dark:bg-zinc-950 px-4 py-12') }}>
    <div class="w-full max-w-sm">
        <gsmui:auth.header :$name :$logo />

        <div class="space-y-1 mb-8">
            <gsmui:heading size="xl">{{ $title }}</gsmui:heading>
            @if ($subtitle)
                <gsmui:text variant="subtle">{{ $subtitle }}</gsmui:text>
            @endif
        </div>

        <form action="{{ $action }}" method="{{ $method }}" class="space-y-5">
            <div class="space-y-4">
                <gsmui:field>
                    <gsmui:field.label>{{ __('Email') }}</gsmui:field.label>
                    <gsmui:input wire:model="email" type="email" placeholder="{{ __('you@example.com') }}" />
                </gsmui:field>

                <gsmui:field>
                    <gsmui:field.label>{{ __('Password') }}</gsmui:field.label>
                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('Enter your password') }}" viewable />
                </gsmui:field>
            </div>

            <div class="flex items-center justify-between">
                @if ($showRemember)
                    <gsmui:checkbox wire:model="remember" label="{{ __('Remember me') }}" />
                @endif

                @if ($showForgotPassword)
                    <a href="#" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 underline underline-offset-2">{{ __('Forgot password?') }}</a>
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
