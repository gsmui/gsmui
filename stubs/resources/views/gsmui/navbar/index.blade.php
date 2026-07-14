@blaze(fold: true)

@props([
    'variant' => null,
])

@php
$classes = Gsmui::classes()
    ->add('flex items-center gap-1')
    ->add(match ($variant) {
        'outline' => 'rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 p-1 shadow-xs',
        default => '',
    })
    ;
@endphp

<nav {{ $attributes->class($classes) }} data-gsmui-navbar>
    {{ $slot }}
</nav>
