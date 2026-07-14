@blaze(fold: true)

@props([])

@php
$classes = Gsmui::classes()
    ->add('px-4 py-3 text-sm text-zinc-900 dark:text-zinc-100')
    ->add('border-t border-zinc-200 dark:border-white/10')
    ->add('hover:bg-zinc-50 dark:hover:bg-zinc-900/50')
    ;
@endphp

<td {{ $attributes->class($classes) }}>
    {{ $slot }}
</td>
