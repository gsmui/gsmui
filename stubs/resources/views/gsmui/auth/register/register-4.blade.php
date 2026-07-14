@props([
    'title' => 'Create account',
    'subtitle' => 'Get started with your free account.',
    'action' => '#',
    'method' => 'POST',
    'showSocial' => true,
    'showTerms' => true,
    'providers' => ['google', 'github', 'apple'],
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-white dark:bg-zinc-900 p-4') }}>
    <div class="w-full max-w-lg">
        <gsmui:auth.header :$name :$logo />

        <gsmui:heading size="xl" class="text-center">{{ $title }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-2 text-center">{{ $subtitle }}</gsmui:text>

        @if ($showSocial)
            <gsmui:auth.social :$providers class="mt-6" />
            <gsmui:divider text="{{ __('or continue with') }}" class="mb-6" />
        @endif

        <form method="{{ $method }}" action="{{ $action }}" class="space-y-3">
            <div class="grid grid-cols-2 gap-4">
                <gsmui:input wire:model="first_name" placeholder="{{ __('First name') }}" />
                <gsmui:input wire:model="last_name" placeholder="{{ __('Last name') }}" />
            </div>

            <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" />
            <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable />
            <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" icon="key" viewable />

            @if ($showTerms)
                <gsmui:checkbox wire:model="terms" label="{{ __('I agree to the Terms and Privacy Policy') }}" />
            @endif

            <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Create account') }}</gsmui:button>
        </form>

        <gsmui:auth.footer />
    </div>
</div>
