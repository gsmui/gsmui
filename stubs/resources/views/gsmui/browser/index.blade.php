@blaze(fold: true)

@props([
    'variant' => 'default',
    'color' => null,
    'size' => null,
])

@php
$classes = Gsmui::classes()
    ->add('relative inline-flex flex-col w-full overflow-hidden rounded-xl')
    ->add(match ($size) {
        'sm' => 'max-w-lg',
        'lg' => 'max-w-5xl',
        'xl' => 'max-w-7xl',
        default => 'max-w-3xl',
    })
    ->add(match ($variant) {
        'flat' => 'shadow-lg border border-zinc-300 dark:border-zinc-700',
        'minimal' => 'shadow-md border border-zinc-200 dark:border-zinc-700',
        default => 'shadow-xl border border-zinc-300 dark:border-zinc-600',
    })
    ->add(match ($color) {
        'zinc' => 'bg-zinc-100 dark:bg-zinc-800',
        'slate' => 'bg-slate-100 dark:bg-slate-800',
        'gray' => 'bg-gray-100 dark:bg-gray-800',
        'neutral' => 'bg-neutral-100 dark:bg-neutral-800',
        'stone' => 'bg-stone-100 dark:bg-stone-800',
        default => 'bg-white dark:bg-zinc-900',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-browser>
    {{ $slot }}
</div>
