@blaze(fold: true)

@php
$classes = Gsmui::classes()
    ->add('block text-sm font-semibold text-zinc-900 dark:text-white mb-3')
    ;
@endphp

<legend {{ $attributes->class($classes) }} data-gsmui-legend>
    {{ $slot }}
</legend>
