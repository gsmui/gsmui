@blaze(fold: true)

@props([
    //
])

@php
$classes = Gsmui::classes()
    ->add('px-2 pb-2 flex flex-col gap-2')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-kanban-column-footer>
    {{ $slot }}
</div>