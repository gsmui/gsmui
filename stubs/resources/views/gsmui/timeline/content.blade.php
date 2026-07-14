@props([
    //
])

@php
$classes = Gsmui::classes()
    ->add('[[data-gsmui-timeline-status=incomplete]_&]:opacity-75')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-timeline-content>
   {{ $slot }}
</div>