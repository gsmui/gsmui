@props([
    'heading' => __('Find anything, instantly'),
    'subtitle' => __('Search across millions of articles, docs, and resources.'),
    'tags' => [__('Getting started'), __('API'), __('Tutorials'), __('Billing'), __('Integrations')],
])

<section {{ $attributes->class('py-24 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-2xl text-center">
        <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-5xl">{{ $heading }}</h1>
        <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        <div class="mt-8">
            <div class="relative">
                <x-gsmui:icon name="magnifying-glass" class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-zinc-400" />
                <input type="text" placeholder="{{ __('Search...') }}" class="w-full rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/5 py-4 pl-12 pr-4 text-zinc-900 dark:text-white shadow-lg placeholder:text-zinc-400 focus:outline-none" />
            </div>
        </div>
        <div class="mt-6 flex flex-wrap justify-center gap-2">
            @foreach ($tags as $tag)
                <span class="rounded-full bg-zinc-100 dark:bg-white/10 px-3 py-1 text-xs text-zinc-600 dark:text-zinc-300">{{ $tag }}</span>
            @endforeach
        </div>
    </div>
</section>
