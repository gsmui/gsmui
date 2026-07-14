@blaze(fold: true)

@props([
    'src' => null,
    'alt' => null,
    'minHeight' => null,
    'scrollable' => false,
    'noBorder' => false,
])

@php
$classes = Gsmui::classes()
    ->add('relative w-full')
    ->add($noBorder ? '' : 'border-t border-zinc-200 dark:border-zinc-700')
    ->add($scrollable ? 'overflow-y-auto' : 'overflow-hidden')
    ->add($minHeight ? $minHeight : 'min-h-48')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-browser-content>
    @if ($src)
        <img class="w-full h-full object-cover block" src="{{ $src }}" alt="{{ $alt ?? 'Browser content' }}" />
    @else
        {{ $slot }}
    @endif
</div>
