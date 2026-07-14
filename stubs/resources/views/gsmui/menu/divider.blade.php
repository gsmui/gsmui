@blaze(fold: true)

@props([])

@php
$classes = Gsmui::classes()
    ->add('my-1 border-t border-zinc-200 dark:border-white/10')
    ;
@endphp

<div {{ $attributes->class($classes) }} role="separator" aria-orientation="horizontal"></div>
