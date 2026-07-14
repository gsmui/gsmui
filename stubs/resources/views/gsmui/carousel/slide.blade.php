@blaze(fold: true)

@props([
    //
])

@php
$classes = Gsmui::classes()
    ->add('shrink-0 snap-start')
    ->add('[snap="mandatory"_&]:snap-always')
    ;
@endphp

<ui-carousel-slide {{ $attributes->class($classes) }} data-gsmui-carousel-slide>
    {{ $slot }}
</ui-carousel-slide>
