@blaze(fold: true)

@props([
    //
])

@php
$classes = Gsmui::classes()
    ->add('rounded-lg w-80 max-w-80')
    ->add('[:where(&)]:bg-zinc-100 dark:[:where(&)]:bg-zinc-800')
    ;
@endphp

<div data-gsmui-kanban-column>
    <div {{ $attributes->class($classes) }}>
        {{ $slot }}
    </div>
</div>