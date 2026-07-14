@props([
    'quote' => __('Simplicity is the ultimate sophistication.'),
    'name' => 'Ada Lovelace',
    'role' => __('Pioneer of Computing'),
])

<section {{ $attributes->class('py-24 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-2xl text-center">
        <blockquote class="text-4xl font-serif italic leading-snug text-zinc-800 dark:text-zinc-100 lg:text-5xl">
            "{{ $quote }}"
        </blockquote>
        <gsmui:divider class="mx-auto my-8 w-16" />
        <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $name }}</div>
        <div class="text-xs text-zinc-500">{{ $role }}</div>
    </div>
</section>
