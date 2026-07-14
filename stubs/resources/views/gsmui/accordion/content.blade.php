@blaze(fold: true)

@aware([ 'transition', 'expanded' ])

@props([
    'transition' => false,
    'expanded' => false,
])

@php
$classes = Gsmui::classes()
    ->add('pt-2 text-sm text-zinc-500 dark:text-zinc-300')
    ;
@endphp

<div
    x-show="open"
    @if ($transition) x-collapse @endif
    @if (! $expanded) x-cloak @endif
    data-gsmui-accordion-content
>
    <div {{ $attributes->class($classes) }}>
        {{ $slot }}
    </div>
</div>
