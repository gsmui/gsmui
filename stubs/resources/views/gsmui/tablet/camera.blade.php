@blaze(fold: true)

@props([
    'variant' => 'dot',
    'position' => 'center',
])

@php
$classes = Gsmui::classes()
    ->add('relative z-10 mx-auto')
    ->add(match ($position) {
        'left' => 'ml-4',
        'right' => 'mr-4',
        default => '',
    })
    ->add(match ($variant) {
        'dot' => 'size-2.5 rounded-full bg-zinc-900 dark:bg-zinc-200 -mb-1',
        'bar' => 'w-12 h-1.5 rounded-full bg-zinc-900 dark:bg-zinc-200 -mb-1',
        'pill' => 'w-16 h-5 rounded-full bg-zinc-900 dark:bg-zinc-200 -mb-1.5',
        'none' => 'hidden',
        default => 'size-2.5 rounded-full bg-zinc-900 dark:bg-zinc-200 -mb-1',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-tablet-camera></div>
