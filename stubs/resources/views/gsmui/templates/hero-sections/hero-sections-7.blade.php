@props([
    'date' => __('March 15-17, 2025'),
    'location' => __('San Francisco, CA'),
    'heading' => __('DevConf 2025'),
    'subtitle' => __('Three days of workshops, talks, and networking with 5,000+ developers.'),
    'cta' => __('Register now'),
])

<section {{ $attributes->class('py-24 px-6 bg-white dark:bg-zinc-900') }} x-data="{ days: '00', hours: '00', minutes: '00', seconds: '00' }">
    <div class="mx-auto max-w-3xl text-center">
        <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-zinc-100 dark:bg-white/10 px-4 py-2 text-sm text-zinc-600 dark:text-zinc-300">
            <x-gsmui:icon name="calendar" class="h-4 w-4" />
            {{ $date }} &middot; {{ $location }}
        </div>
        <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-6xl">{{ $heading }}</h1>
        <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        <div class="mt-10 flex items-center justify-center gap-4">
            @foreach (['days', 'hours', 'minutes', 'seconds'] as $unit)
                <div class="text-center">
                    <div class="text-3xl font-bold tabular-nums text-zinc-900 dark:text-white" x-text="{{ $unit }}">00</div>
                    <div class="text-xs text-zinc-500">{{ ucfirst($unit) }}</div>
                </div>
            @endforeach
        </div>
        <gsmui:button class="mt-10" size="lg">{{ $cta }}</gsmui:button>
    </div>
</section>
