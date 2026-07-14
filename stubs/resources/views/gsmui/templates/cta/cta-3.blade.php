@props([
    'heading' => __('Accelerate your workflow today'),
    'cta' => __('Start free trial'),
])

<section {{ $attributes->class('bg-zinc-900 dark:bg-white py-6 px-6') }}>
    <div class="mx-auto max-w-7xl flex flex-col items-center justify-between gap-4 sm:flex-row">
        <h2 class="text-xl font-bold text-white dark:text-zinc-900 lg:text-2xl">{{ $heading }}</h2>
        <gsmui:button :variant="'outline'" class="border-white/20 text-white hover:bg-white/10 dark:border-zinc-900/20 dark:text-zinc-900 dark:hover:bg-zinc-900/10">{{ $cta }}</gsmui:button>
    </div>
</section>
