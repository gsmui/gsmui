@blaze(fold: true)

@props([
    'value' => 0,
    'digits' => 2,
    'label' => null,
    'size' => null,
    'color' => null,
    'variant' => null,
    'ariaLabel' => null,
])

@php
$classes = Gsmui::classes()
    ->add('flex flex-col items-center')
    ->add(match ($variant) {
        'solid' => 'p-3 rounded-xl bg-zinc-100 dark:bg-zinc-800',
        'bordered' => 'p-3 rounded-xl border border-zinc-200 dark:border-zinc-700',
        'glass' => 'p-3 rounded-xl bg-white/50 dark:bg-white/5 backdrop-blur-sm border border-white/20',
        'neo' => 'p-3 rounded-xl bg-zinc-100 dark:bg-zinc-800 shadow-[3px_3px_6px_#d9d9d9,-3px_-3px_6px_#ffffff] dark:shadow-[3px_3px_6px_#1e1e1e,-3px_-3px_6px_#3a3a3a]',
        default => 'p-2',
    })
    ;

$labelClasses = Gsmui::classes()
    ->add('text-xs font-medium uppercase tracking-wider mt-1')
    ->add(match ($variant) { 'solid', 'bordered', 'neo' => 'text-zinc-500 dark:text-zinc-400', default => 'text-zinc-400 dark:text-zinc-500' })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-countdown-block>
    <gsmui:countdown :$value :$digits :$size :$color :ariaLabel="$ariaLabel" />

    @if ($label)
        <span class="{{ $labelClasses }}">{{ $label }}</span>
    @endif
</div>
