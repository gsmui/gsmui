@props([
    'name' => 'Pulse',
    'tagline' => 'Your health, in your pocket.',
    'description' => 'Track fitness, nutrition, sleep, and mindfulness — all in one beautiful app.',
    'features' => [
        ['icon' => '❤️', 'title' => 'Heart Rate Monitor', 'desc' => 'Real-time heart rate tracking with insights.'],
        ['icon' => '🏃', 'title' => 'Activity Tracking', 'desc' => 'Steps, calories, and workout logging.'],
        ['icon' => '😴', 'title' => 'Sleep Analysis', 'desc' => 'Deep insights into your sleep quality.'],
    ],
    'screenshots' => ['Dashboard', 'Activity', 'Sleep', 'Profile'],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <gsmui:button size="sm" variant="primary">{{ __('Download') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-20">
        <div class="mx-auto grid max-w-5xl items-center gap-12 sm:grid-cols-2">
            <div>
                <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
                <p class="mt-4 text-lg text-zinc-500">{{ $description }}</p>
                <div class="mt-8 flex gap-3">
                    <div class="h-12 w-36 rounded-lg bg-zinc-900 dark:bg-white flex items-center justify-center">
                        <span class="text-sm font-semibold text-white dark:text-zinc-900">App Store</span>
                    </div>
                    <div class="h-12 w-36 rounded-lg bg-zinc-900 dark:bg-white flex items-center justify-center">
                        <span class="text-sm font-semibold text-white dark:text-zinc-900">Google Play</span>
                    </div>
                </div>
            </div>
            <div class="mx-auto h-[480px] w-[240px] rounded-[2.5rem] bg-zinc-200 dark:bg-zinc-800 border-[6px] border-zinc-300 dark:border-zinc-700"></div>
        </div>
    </section>

    <main class="mx-auto max-w-5xl px-6 pb-20">
        <section class="mb-24">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Features') }}</h2>
            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="text-center">
                        <span class="text-4xl">{{ $feature['icon'] }}</span>
                        <h3 class="mt-4 font-semibold text-zinc-900 dark:text-white">{{ __($feature['title']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="mb-8 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Screenshots') }}</h2>
            <div class="flex gap-4 overflow-x-auto pb-4">
                @foreach ($screenshots as $screen)
                    <div class="flex-shrink-0 w-48">
                        <div class="h-80 rounded-2xl bg-zinc-100 dark:bg-zinc-800"></div>
                        <p class="mt-2 text-center text-sm text-zinc-500">{{ __($screen) }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-8 text-center text-sm text-zinc-400">
        &copy; {{ date('Y') }} {{ $name }}.
    </footer>
</div>
