@props([
    'heading' => __('Start building today'),
    'subtitle' => __('Get up and running in minutes with our quickstart guide. No credit card required.'),
    'cta' => __('Get started free'),
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="space-y-6">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white lg:text-4xl">{{ $heading }}</h2>
                <p class="text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
                <gsmui:button size="lg">{{ $cta }}</gsmui:button>
            </div>
            <div class="aspect-video rounded-2xl bg-zinc-100 dark:bg-white/5 border border-zinc-200 dark:border-white/10"></div>
        </div>
    </div>
</section>
