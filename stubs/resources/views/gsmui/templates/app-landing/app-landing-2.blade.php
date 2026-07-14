@props([
    'name' => 'SnapVault',
    'tagline' => 'Capture. Organize. Relive.',
    'stats' => ['5M+ Downloads', '4.8★ Rating', '150+ Countries'],
    'features' => [
        ['title' => 'Smart Albums', 'desc' => 'AI-powered photo organization.'],
        ['title' => 'Cloud Backup', 'desc' => 'Never lose a memory again.'],
        ['title' => 'Shared Libraries', 'desc' => 'Collaborate with family and friends.'],
    ],
    'testimonials' => [
        ['quote' => 'Best photo app I\'ve ever used.', 'author' => 'App Store Review'],
        ['quote' => 'Finally, an app that organizes my photos for me.', 'author' => 'Google Play Review'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <gsmui:button size="sm" variant="primary">{{ __('Download') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-24 text-center">
        <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500">{{ __('The smartest photo gallery app. Download for free on iOS and Android.') }}</p>
        <div class="mt-8 flex justify-center gap-4">
            <div class="h-14 w-44 rounded-xl bg-zinc-900 dark:bg-white flex items-center justify-center">
                <span class="text-sm font-semibold text-white dark:text-zinc-900">Download on App Store</span>
            </div>
            <div class="h-14 w-44 rounded-xl bg-zinc-900 dark:bg-white flex items-center justify-center">
                <span class="text-sm font-semibold text-white dark:text-zinc-900">Get it on Google Play</span>
            </div>
        </div>
        <div class="mt-10 flex justify-center gap-8">
            @foreach ($stats as $stat)
                <span class="text-sm font-semibold text-zinc-500">{{ __($stat) }}</span>
            @endforeach
        </div>
    </section>

    <main class="mx-auto max-w-5xl px-6 pb-20">
        <section class="mb-24">
            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8 text-center">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __($feature['title']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('What Users Say') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ($testimonials as $testimonial)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-6">
                        <p class="text-zinc-600 dark:text-zinc-400 italic">"{{ $testimonial['quote'] }}"</p>
                        <p class="mt-3 text-sm font-semibold text-zinc-900 dark:text-white">{{ $testimonial['author'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-8 text-center text-sm text-zinc-400">
        &copy; {{ date('Y') }} {{ $name }}.
    </footer>
</div>
