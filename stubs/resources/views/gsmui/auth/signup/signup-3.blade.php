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
    <div class="w-full max-w-2xl">
        <div class="text-center mb-10">
            <gsmui:auth.header :$name :$logo />

            <h1 class="mt-4 font-serif text-4xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $title }}</h1>

            <p class="mt-2 font-serif text-lg text-zinc-500 dark:text-zinc-400 italic">{{ $subtitle }}</p>
        </div>

        @if($showSocial)
            <gsmui:auth.social :$providers />

            <gsmui:divider text="{{ __('or continue with') }}" class="mb-8" />
        @endif

        <form action="{{ $action }}" method="{{ $method }}">
            <div class="space-y-10">
                <section>
                    <h2 class="font-serif text-xl font-semibold text-zinc-900 dark:text-white mb-1">{{ __('Account') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">{{ __('Set up your login credentials.') }}</p>

                    <div class="space-y-4">
                        <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" />

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable />
                            <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" icon="key" viewable />
                        </div>
                    </div>
                </section>

                <gsmui:divider />

                <section>
                    <h2 class="font-serif text-xl font-semibold text-zinc-900 dark:text-white mb-1">{{ __('Personal Information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">{{ __('Tell us a bit about yourself.') }}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <gsmui:input wire:model="first_name" placeholder="{{ __('First name') }}" />
                        <gsmui:input wire:model="last_name" placeholder="{{ __('Last name') }}" />
                    </div>
                </section>

                <gsmui:divider />

                @if($showTerms)
                    <section>
                        <h2 class="font-serif text-xl font-semibold text-zinc-900 dark:text-white mb-1">{{ __('Legal') }}</h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">{{ __('Review and accept our policies.') }}</p>

                        <gsmui:checkbox wire:model="terms" label="{{ __('I agree to the Terms of Service and Privacy Policy') }}" />
                    </section>

                    <gsmui:divider />
                @endif

                <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Sign Up') }}</gsmui:button>
            </div>
        </form>

        <gsmui:auth.footer />
    </div>
</div>
