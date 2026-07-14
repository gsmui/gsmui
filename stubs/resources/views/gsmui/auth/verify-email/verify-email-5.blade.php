@props([
    'title' => 'Verify your email',
    'subtitle' => 'We sent a verification link to your email address. Please check your inbox.',
    'action' => '#',
    'method' => 'POST',
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
                        <svg class="size-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2.25 2.25L15 9.75" /></svg>
                    </div>
                    <gsmui:heading size="xl" level="1" class="mt-4">{{ $title }}</gsmui:heading>
                    <gsmui:text variant="subtle" class="mt-2">{{ $subtitle }}</gsmui:text>
                </div>

                <form method="{{ $method }}" action="{{ $action }}" class="mt-6 space-y-4" x-data="{ countdown: 59, timer: null }" x-init="timer = setInterval(() => { countdown--; if (countdown <= 0) { clearInterval(timer); timer = null; } }, 1000)">
                    <template x-if="timer !== null">
                        <p class="text-center text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Resend in') }} <span class="font-medium tabular-nums" x-text="countdown + 's'"></span>
                        </p>
                    </template>
                    <template x-if="timer === null">
                        <gsmui:button variant="outline" type="submit" class="w-full">{{ __('Resend verification email') }}</gsmui:button>
                    </template>
                </form>

                <p class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('Back to sign in') }}</a>
                </p>
            </div>
        </gsmui:card>

        <gsmui:auth.footer />
    </div>
</div>
