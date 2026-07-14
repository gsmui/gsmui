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

<div {{ $attributes->class(['flex min-h-screen items-center justify-center bg-pink-50/50 dark:bg-zinc-900 px-4 py-12']) }}>
    <div class="w-full max-w-md">
        <div class="rounded-2xl border border-pink-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-sm p-8">
            <div class="text-center mb-6">
                <gsmui:auth.header :$name :$logo />

                <h1 class="mt-4 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Join us today!') }}</h1>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __("It's quick and easy") }}</p>
            </div>

            @if($showSocial)
                <gsmui:auth.social :$providers />

                <gsmui:divider text="{{ __('or continue with') }}" class="mb-6" />
            @endif

            <form action="{{ $action }}" method="{{ $method }}">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <gsmui:input wire:model="first_name" placeholder="{{ __('First name') }}" class="rounded-xl" />
                        <gsmui:input wire:model="last_name" placeholder="{{ __('Last name') }}" class="rounded-xl" />
                    </div>

                    <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" class="rounded-xl" />

                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable class="rounded-xl" />

                    <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" icon="key" viewable class="rounded-xl" />

                    @if($showTerms)
                        <gsmui:checkbox wire:model="terms" label="{{ __('I agree to the Terms of Service and Privacy Policy') }}" />
                    @endif

                    <gsmui:button variant="primary" type="submit" class="w-full !bg-pink-600 hover:!bg-pink-500">{{ __('Sign Up') }}</gsmui:button>
                </div>
            </form>

            <gsmui:auth.footer />
        </div>
    </div>
</div>
