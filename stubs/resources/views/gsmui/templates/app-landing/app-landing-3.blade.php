@props([
    'name' => 'Mindful',
    'tagline' => 'Meditation made simple.',
    'steps' => [
        ['number' => '1', 'title' => 'Choose Your Session', 'desc' => 'Browse guided meditations for sleep, focus, anxiety, and more.'],
        ['number' => '2', 'title' => 'Follow Along', 'desc' => 'Expert-led sessions with calming visuals and sounds.'],
        ['number' => '3', 'title' => 'Track Progress', 'desc' => 'See your streak, minutes meditated, and mood trends.'],
        ['number' => '4', 'title' => 'Build a Habit', 'desc' => 'Daily reminders and personalized session recommendations.'],
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
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500 {{ __('Find your calm with guided sessions, sleep stories, and mindfulness tools.') }}">{{ __('Find your calm with guided sessions, sleep stories, and mindfulness tools.') }}</p>
    </section>

    <main class="mx-auto max-w-5xl px-6 pb-20">
        <section class="space-y-24">
            @foreach ($steps as $step)
                <div class="grid items-center gap-12 sm:grid-cols-2 {{ $loop->iteration % 2 === 0 ? '' : '' }}">
                    <div class="{{ $loop->even ? 'sm:order-2' : '' }}">
                        <span class="text-6xl font-bold text-zinc-200 dark:text-white/10">{{ $step['number'] }}</span>
                        <h2 class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">{{ __($step['title']) }}</h2>
                        <p class="mt-3 text-zinc-500">{{ $step['desc'] }}</p>
                    </div>
                    <div class="{{ $loop->even ? 'sm:order-1' : '' }}">
                        <div class="mx-auto h-[400px] w-[200px] rounded-[2rem] bg-zinc-100 dark:bg-zinc-800 border-4 border-zinc-200 dark:border-zinc-700"></div>
                    </div>
                </div>
            @endforeach
        </section>
    </main>

    <section class="bg-zinc-50 dark:bg-zinc-900 px-6 py-16 text-center">
        <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Start your journey') }}</h2>
        <div class="mt-6 flex justify-center gap-4">
            <div class="h-12 w-36 rounded-lg bg-zinc-900 dark:bg-white flex items-center justify-center">
                <span class="text-sm font-semibold text-white dark:text-zinc-900">App Store</span>
            </div>
            <div class="h-12 w-36 rounded-lg bg-zinc-900 dark:bg-white flex items-center justify-center">
                <span class="text-sm font-semibold text-white dark:text-zinc-900">Google Play</span>
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-8 text-center text-sm text-zinc-400">
        &copy; {{ date('Y') }} {{ $name }}.
    </footer>
</div>
