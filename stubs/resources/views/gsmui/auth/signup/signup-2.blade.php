@props([
    'title' => 'Sign Up',
    'subtitle' => 'Create your account to get started.',
    'action' => '#',
    'method' => 'POST',
    'showSocial' => true,
    'showTerms' => true,
    'providers' => ['google', 'github', 'apple'],
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class(['flex min-h-screen bg-white dark:bg-zinc-900']) }}>
    <div class="hidden lg:flex w-2/5 bg-zinc-100 dark:bg-zinc-800 flex-col justify-center px-12">
        <gsmui:auth.header :$name :$logo />

        <h2 class="mt-8 text-2xl font-semibold text-zinc-900 dark:text-white">{{ __('Why join us?') }}</h2>

        <ul class="mt-6 space-y-6">
            <li class="flex items-start gap-3">
                <x-heroicon-o-check-circle class="h-6 w-6 shrink-0 text-green-500" />
                <span class="text-zinc-700 dark:text-zinc-300">{{ __('Free forever') }}</span>
            </li>
            <li class="flex items-start gap-3">
                <x-heroicon-o-check-circle class="h-6 w-6 shrink-0 text-green-500" />
                <span class="text-zinc-700 dark:text-zinc-300">{{ __('No credit card required') }}</span>
            </li>
            <li class="flex items-start gap-3">
                <x-heroicon-o-check-circle class="h-6 w-6 shrink-0 text-green-500" />
                <span class="text-zinc-700 dark:text-zinc-300">{{ __('Cancel anytime') }}</span>
            </li>
            <li class="flex items-start gap-3">
                <x-heroicon-o-check-circle class="h-6 w-6 shrink-0 text-green-500" />
                <span class="text-zinc-700 dark:text-zinc-300">{{ __('24/7 customer support') }}</span>
            </li>
            <li class="flex items-start gap-3">
                <x-heroicon-o-check-circle class="h-6 w-6 shrink-0 text-green-500" />
                <span class="text-zinc-700 dark:text-zinc-300">{{ __('All features included') }}</span>
            </li>
        </ul>
    </div>

    <div class="w-full lg:w-3/5 flex items-center justify-center px-8 py-12">
        <div class="w-full max-w-md">
            <div class="lg:hidden mb-8">
                <gsmui:auth.header :$name :$logo />
            </div>

            <gsmui:heading size="xl">{{ $title }}</gsmui:heading>

            <gsmui:text variant="subtle">{{ $subtitle }}</gsmui:text>

            @if($showSocial)
                <gsmui:auth.social :$providers />

                <gsmui:divider text="{{ __('or continue with') }}" class="mb-6" />
            @endif

            <form action="{{ $action }}" method="{{ $method }}">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <gsmui:input wire:model="first_name" placeholder="{{ __('First name') }}" />
                        <gsmui:input wire:model="last_name" placeholder="{{ __('Last name') }}" />
                    </div>

                    <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" />

                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable />

                    <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" icon="key" viewable />

                    @if($showTerms)
                        <gsmui:checkbox wire:model="terms" label="{{ __('I agree to the Terms of Service and Privacy Policy') }}" />
                    @endif

                    <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Sign Up') }}</gsmui:button>
                </div>
            </form>

            <gsmui:auth.footer />
        </div>
    </div>
</div>
