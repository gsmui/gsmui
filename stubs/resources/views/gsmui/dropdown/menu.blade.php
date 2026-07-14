@blaze(fold: true)

@props([
    'keepOpen' => false,
])

@php
$classes = Gsmui::classes()
    ->add('rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-600 bg-white dark:bg-zinc-700 p-1')
    ->add('min-w-48')
    ;
@endphp

<div
    {{ $attributes->class($classes) }}
    role="menu"
    @if ($keepOpen) x-on:click.stop @endif
    data-gsmui-menu
>
    {{ $slot }}
</div>
