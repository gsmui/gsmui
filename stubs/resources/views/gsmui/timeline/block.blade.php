@php
$classes = Gsmui::classes()
    ->add('');
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-timeline-block>
   {{ $slot }}
</div>