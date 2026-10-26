@blaze(fold: true)

@props([])

@php
$classes = Gsmui::classes()
    ->add('flex flex-col gap-0.5')
    ;
@endphp

<nav {{ $attributes->class($classes) }} data-gsmui-navlist>
    {{ $slot }}
</nav>
