@blaze(fold: true)

@php
$classes = Gsmui::classes()
    ->add('p-[.3125rem]')
    ->add('overflow-y-auto')
    ->add('bg-white dark:bg-zinc-700')
    ;
@endphp

<ui-options {{ $attributes->class($classes) }} data-gsmui-command-items>
    {{ $slot }}

    <gsmui:command.empty>{!! __('No results found') !!}</gsmui:command.empty>
</ui-options>
