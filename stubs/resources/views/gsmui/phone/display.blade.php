@blaze(fold: true)

@props([
    'color' => null,
    'src' => null,
    'alt' => null,
    'aspect' => 'auto',
    'scrollable' => false,
])

@php
$classes = Gsmui::classes()
    ->add('relative w-full')
    ->add(match ($aspect) {
        'square' => 'aspect-square',
        'video' => 'aspect-[9/16]',
        'ultrawide' => 'aspect-[19.5/9]',
        'auto' => 'min-h-48',
        default => 'min-h-48',
    })
    ->add(match ($color) {
        'zinc' => 'bg-zinc-800',
        'slate' => 'bg-slate-800',
        'gray' => 'bg-gray-800',
        'neutral' => 'bg-neutral-800',
        'stone' => 'bg-stone-800',
        default => '', // inherit from parent
    })
    ->add($scrollable ? 'overflow-y-auto' : 'overflow-hidden')
    ;

$contentClasses = Gsmui::classes()
    ->add('flex flex-col')
    ->add($src ? '' : 'p-4')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-phone-display>
    @if ($src)
        <img class="w-full h-full object-cover" src="{{ $src }}" alt="{{ $alt ?? 'Phone screen' }}" />
    @else
        <div class="{{ $contentClasses }}">
            {{ $slot }}
        </div>
    @endif
</div>
