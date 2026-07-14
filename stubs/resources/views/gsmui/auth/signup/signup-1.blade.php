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

<div {{ $attributes->class(['flex min-h-screen items-center justify-center bg-white dark:bg-zinc-900 px-4 py-12']) }}>
    <div class="w-full max-w-md">
        <div class="border border-zinc-300 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 shadow-sm">
            <div class="px-8 pt-8 pb-2 text-center">
                <gsmui:auth.header :$name :$logo />

                <gsmui:heading size="xl">{{ $title }}</gsmui:heading>

                <gsmui:text variant="subtle">{{ $subtitle }}</gsmui:text>
            </div>

            <div class="px-8 pb-8 pt-4">
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
</div>
