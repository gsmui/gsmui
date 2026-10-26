@blaze(fold: true)

@props([
    'variant' => null,
    'transition' => false,
])

@php
$classes = Gsmui::classes()
    ->add('block divide-y divide-zinc-800/10 dark:divide-white/10')
    ->add('border border-zinc-200 dark:border-white/10 rounded-xl')
    ;
@endphp

<ui-disclosure-group {{ $attributes->class($classes) }} data-gsmui-accordion data-gsmui-accordion-heading>
    {{ $slot }}
</ui-disclosure-group>
