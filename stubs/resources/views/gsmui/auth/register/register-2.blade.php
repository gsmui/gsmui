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

<div {{ $attributes->class('flex min-h-screen') }}>
    <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-emerald-600 to-teal-700">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-emerald-500/30 via-transparent to-transparent" aria-hidden="true"></div>
        <div class="relative flex flex-col justify-center p-12 text-white">
            <h2 class="text-3xl font-bold tracking-tight">{{ __('Join thousands of users.') }}</h2>
            <p class="mt-4 text-lg text-white/80 max-w-md">{{ __('Create your account and start building today.') }}</p>
            <div class="mt-8 space-y-4 max-w-md">
                @foreach (['Free tier available', 'No credit card required', 'Cancel anytime'] as $feature)
                    <div class="flex items-center gap-3">
                        <div class="flex size-8 items-center justify-center rounded-full bg-white/20">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        </div>
                        <span class="text-sm font-medium">{{ $feature }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="flex w-full items-center justify-center p-6 lg:w-1/2 bg-white dark:bg-zinc-900">
        <div class="w-full max-w-md">
            <gsmui:auth.header :$name :$logo />

            <gsmui:heading size="xl">{{ $title }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>

            @if ($showSocial)
                <gsmui:auth.social :$providers class="mt-6" />
                <gsmui:divider text="{{ __('or continue with') }}" class="mb-6" />
            @endif

            <form method="{{ $method }}" action="{{ $action }}" class="space-y-4">
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
        </div>

        <gsmui:auth.footer />
    </div>
</div>
