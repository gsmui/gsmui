@blaze(fold: true)

@props([
    'placeholder' => null,
])

@php
$classes = Gsmui::classes()
    ->add('w-full block rounded-xl overflow-hidden shadow-xs')
    ->add('border border-zinc-200 dark:border-zinc-600')
    ;
@endphp

<ui-select clear="action" {{ $attributes->class($classes)->merge(['filter' => true]) }} data-gsmui-command>
    {{ $slot }}
</ui-select>
