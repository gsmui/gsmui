@blaze(fold: true)

@php
$classes = Gsmui::classes()
    ->add('block text-sm text-zinc-500 dark:text-zinc-400 mt-1.5')
    ;
@endphp

<p {{ $attributes->class($classes) }} data-gsmui-description>
    {{ $slot }}
</p>
