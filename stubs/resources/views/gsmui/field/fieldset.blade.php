@blaze(fold: true)

@php
$classes = Gsmui::classes()
    ->add('block')
    ;
@endphp

<fieldset {{ $attributes->class($classes) }} data-gsmui-fieldset>
    {{ $slot }}
</fieldset>
