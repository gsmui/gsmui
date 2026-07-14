@props([
    'title' => 'Two-factor authentication',
    'subtitle' => 'Enter the verification code from your authenticator app.',
    'action' => '#',
    'method' => 'POST',
    'showRecovery' => true,
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-50 via-white to-violet-50 dark:from-zinc-900 dark:via-zinc-900 dark:to-zinc-900 p-4') }}>
    <div class="w-full max-w-md">
        <gsmui:auth.header :$name :$logo />

        <gsmui:card variant="default" size="lg" class="w-full">
            <div class="p-6 sm:p-8">
                <div class="text-center">
                    <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="size-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                    </div>
                    <gsmui:heading size="xl" level="1" class="mt-4">{{ $title }}</gsmui:heading>
                    <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>
                </div>

                <form method="{{ $method }}" action="{{ $action }}" class="mt-6 space-y-6">
                    <div class="flex justify-center gap-2" x-data>
                        <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-semibold rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" x-on:input="$el.value.length === 1 && $el.nextElementSibling?.focus()" x-on:keydown.backspace="$el.value.length === 0 && $el.previousElementSibling?.focus()" inputmode="numeric" autocomplete="one-time-code" />
                        <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-semibold rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" x-on:input="$el.value.length === 1 && $el.nextElementSibling?.focus()" x-on:keydown.backspace="$el.value.length === 0 && $el.previousElementSibling?.focus()" inputmode="numeric" />
                        <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-semibold rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" x-on:input="$el.value.length === 1 && $el.nextElementSibling?.focus()" x-on:keydown.backspace="$el.value.length === 0 && $el.previousElementSibling?.focus()" inputmode="numeric" />
                        <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-semibold rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" x-on:input="$el.value.length === 1 && $el.nextElementSibling?.focus()" x-on:keydown.backspace="$el.value.length === 0 && $el.previousElementSibling?.focus()" inputmode="numeric" />
                        <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-semibold rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" x-on:input="$el.value.length === 1 && $el.nextElementSibling?.focus()" x-on:keydown.backspace="$el.value.length === 0 && $el.previousElementSibling?.focus()" inputmode="numeric" />
                        <input type="text" maxlength="1" class="w-12 h-14 text-center text-xl font-semibold rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none" x-on:input="$el.value.length === 1 && $el.nextElementSibling?.focus()" x-on:keydown.backspace="$el.value.length === 0 && $el.previousElementSibling?.focus()" inputmode="numeric" />
                    </div>

                    <gsmui:button variant="primary" type="submit" class="w-full">{{ __('Verify') }}</gsmui:button>
                </form>

                @if ($showRecovery)
                    <p class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Use a recovery code') }}</a>
                    </p>
                @endif
            </div>
        </gsmui:card>

        <gsmui:auth.footer />
    </div>
</div>
