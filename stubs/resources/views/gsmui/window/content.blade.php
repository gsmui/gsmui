@blaze(fold: true)

@props([
    'src' => null,
    'alt' => null,
    'minHeight' => null,
    'height' => null,
    'scrollable' => false,
    'centered' => false,
    'padded' => true,
])

@php
$classes = Gsmui::classes()
    ->add('relative w-full')
    ->add($scrollable ? 'overflow-y-auto' : 'overflow-hidden')
    ->add($height ? $height : ($minHeight ? $minHeight : 'min-h-48'))
    ->add($centered ? 'flex items-center justify-center' : '')
    ->add($padded ? 'p-6' : '')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-window-content>
    @if ($src)
        <img class="w-full h-full object-cover block" src="{{ $src }}" alt="{{ $alt ?? 'Window content' }}" />
    @else
        {{ $slot }}
    @endif
</div>
