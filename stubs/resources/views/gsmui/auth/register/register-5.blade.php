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

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-gradient-to-br from-zinc-50 via-white to-zinc-100 dark:from-zinc-950 dark:via-zinc-900 dark:to-zinc-950 p-4') }}>
    <div class="w-full max-w-md" x-data="{ step: 1 }">
        <gsmui:auth.header :$name :$logo />

        <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-xl p-8">
            <div class="mb-6 flex items-center justify-between">
                @foreach ([
                    ['label' => __('Account'), 'desc' => __('Email & password')],
                    ['label' => __('Profile'), 'desc' => __('Your details')],
                    ['label' => __('Done'), 'desc' => __('Confirmation')],
                ] as $i => $s)
                    <div class="flex items-center {{ $i > 0 ? 'flex-1' : '' }}">
                        @if ($i > 0)
                            <div class="h-px flex-1" :class="step > {{ $i }} ? 'bg-blue-600' : 'bg-zinc-200 dark:bg-zinc-700'"></div>
                        @endif
                        <div class="flex flex-col items-center {{ $i > 0 ? 'ms-3' : '' }}">
                            <div class="flex size-8 items-center justify-center rounded-full text-xs font-semibold" :class="step >= {{ $i + 1 }} ? 'bg-blue-600 text-white' : 'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400'">{{ $i + 1 }}</div>
                            <span class="mt-1 text-xs font-medium text-zinc-500 dark:text-zinc-400 hidden sm:block">{{ $s['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <form method="{{ $method }}" action="{{ $action }}">
                <div x-show="step === 1" class="space-y-4">
                    <gsmui:heading size="xl">{{ $title }}</gsmui:heading>
                    <gsmui:text variant="subtle">{{ $subtitle }}</gsmui:text>

                    @if ($showSocial)
                        <gsmui:auth.social :$providers class="mt-4" />
                        <gsmui:divider text="{{ __('or') }}" class="mb-4" />
                    @endif

                    <gsmui:input wire:model="email" type="email" placeholder="{{ __('Email address') }}" icon="envelope" />
                    <gsmui:input wire:model="password" type="password" placeholder="{{ __('Password') }}" icon="key" viewable />
                    <gsmui:input wire:model="password_confirmation" type="password" placeholder="{{ __('Confirm password') }}" icon="key" viewable />

                    <gsmui:button variant="primary" type="button" class="w-full" x-on:click="step = 2">{{ __('Continue') }}</gsmui:button>
                </div>

                <div x-show="step === 2" class="space-y-4" style="display: none;">
                    <gsmui:heading size="xl">{{ __('Your profile') }}</gsmui:heading>
                    <gsmui:text variant="subtle">{{ __('Tell us a bit about yourself.') }}</gsmui:text>

                    <div class="grid grid-cols-2 gap-4">
                        <gsmui:input wire:model="first_name" placeholder="{{ __('First name') }}" />
                        <gsmui:input wire:model="last_name" placeholder="{{ __('Last name') }}" />
                    </div>

                    @if ($showTerms)
                        <gsmui:checkbox wire:model="terms" label="{{ __('I agree to the Terms and Privacy Policy') }}" />
                    @endif

                    <div class="flex gap-3">
                        <gsmui:button variant="outline" type="button" class="flex-1" x-on:click="step = 1">{{ __('Back') }}</gsmui:button>
                        <gsmui:button variant="primary" type="submit" class="flex-1">{{ __('Create account') }}</gsmui:button>
                    </div>
                </div>

                <div x-show="step === 3" class="space-y-4 text-center" style="display: none;">
                    <div class="flex justify-center">
                        <div class="flex size-16 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                            <svg class="size-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        </div>
                    </div>
                    <gsmui:heading size="xl">{{ __('Account created!') }}</gsmui:heading>
                    <gsmui:text variant="subtle">{{ __('Your account has been created successfully.') }}</gsmui:text>
                    <gsmui:button variant="primary" type="button" class="w-full" x-on:click="window.location.href='{{ $action }}'">{{ __('Go to dashboard') }}</gsmui:button>
                </div>
            </form>
        </div>

        <gsmui:auth.footer />
    </div>
</div>
