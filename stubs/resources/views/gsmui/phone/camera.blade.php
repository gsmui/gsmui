@blaze(fold: true)

@props([
    'variant' => 'dynamic-island',
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
        'dot' => 'size-3 rounded-full bg-zinc-900 dark:bg-zinc-200 -mb-1',
        'bar' => 'w-16 h-1.5 rounded-full bg-zinc-900 dark:bg-zinc-200 -mb-1',
        'notch' => 'w-24 h-6 rounded-b-2xl bg-zinc-900 dark:bg-zinc-200 -mb-0',
        'dynamic-island' => 'flex items-center justify-center gap-1.5 w-20 h-[22px] rounded-full bg-zinc-900 dark:bg-zinc-200 -mb-1.5',
        default => 'flex items-center justify-center gap-1.5 w-20 h-[22px] rounded-full bg-zinc-900 dark:bg-zinc-200 -mb-1.5',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-phone-camera>
    @if ($variant === 'dynamic-island')
        <span class="size-1.5 rounded-full bg-zinc-700 dark:bg-zinc-400"></span>
        <span class="size-1.5 rounded-full bg-zinc-700 dark:bg-zinc-400"></span>
    @endif
</div>
