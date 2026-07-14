@blaze(fold: true)

@props([
    'height' => '1rem',
    'width' => '100%',
    'rounded' => 'md',
    'circle' => false,
])

@php
$classes = Gsmui::classes()
    ->add('animate-pulse')
    ->add('bg-zinc-200 dark:bg-zinc-700')
    ->add(match ($rounded) {
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'full' => 'rounded-full',
        default => 'rounded-md',
    })
    ->add($circle ? 'rounded-full' : '')
    ;
@endphp

<div
    {{ $attributes->class($classes) }}
    data-gsmui-skeleton
    style="height: {{ $height }}; width: {{ $width }};"
    aria-hidden="true"
></div>
