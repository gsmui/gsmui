@props([
    'title' => 'Two-factor authentication',
    'subtitle' => 'Enter the verification code from your authenticator app.',
    'action' => '#',
    'method' => 'POST',
    'showRecovery' => true,
    'name' => null,
    'logo' => null,
])

<div {{ $attributes->class('flex min-h-screen items-center justify-center bg-white dark:bg-zinc-900 p-4') }}>
    <div class="w-full max-w-sm">
        <gsmui:auth.header :$name :$logo />

        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>

        <form method="{{ $method }}" action="{{ $action }}" class="mt-8 space-y-6">
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

        <gsmui:auth.footer />
    </div>
</div>
