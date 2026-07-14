@props([
    'text' => __('Ready to streamline your workflow?'),
    'cta' => __('Get started'),
    'href' => '#',
])

<section {{ $attributes->class('py-12 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-4xl flex items-center gap-6">
        <div class="h-px flex-1 bg-zinc-200 dark:bg-white/10"></div>
        <div class="flex items-center gap-4 text-sm">
            <span class="text-zinc-500 dark:text-zinc-400">{{ $text }}</span>
            <a href="{{ $href }}" class="font-semibold text-zinc-900 dark:text-white underline underline-offset-4">{{ $cta }} &rarr;</a>
        </div>
        <div class="h-px flex-1 bg-zinc-200 dark:bg-white/10"></div>
    </div>
</section>
