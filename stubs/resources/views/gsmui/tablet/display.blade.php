@blaze(fold: true)

@props([
    'color' => null,
    'src' => null,
    'alt' => null,
    'aspect' => '4:3',
    'scrollable' => false,
    'orientation' => null,
])

@php
$isLandscape = $orientation === 'landscape';

$classes = Gsmui::classes()
    ->add('relative w-full')
    ->add(match ($aspect) {
        '4:3' => $isLandscape ? 'aspect-[4/3]' : 'aspect-[3/4]',
        '16:10' => $isLandscape ? 'aspect-[16/10]' : 'aspect-[10/16]',
        '3:2' => $isLandscape ? 'aspect-[3/2]' : 'aspect-[2/3]',
        'square' => 'aspect-square',
        'auto' => 'min-h-64',
        default => 'min-h-64',
    })
    ->add(match ($color) {
        'zinc' => 'bg-zinc-800',
        'slate' => 'bg-slate-800',
        'gray' => 'bg-gray-800',
        'neutral' => 'bg-neutral-800',
        'stone' => 'bg-stone-800',
        default => '',
    })
    ->add($scrollable ? 'overflow-y-auto' : 'overflow-hidden')
    ;

$contentClasses = Gsmui::classes()
    ->add('flex flex-col')
    ->add($src ? '' : 'p-4')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-tablet-display>
    @if ($src)
        <img class="w-full h-full object-cover" src="{{ $src }}" alt="{{ $alt ?? 'Tablet screen' }}" />
    @else
        <div class="{{ $contentClasses }}">
            {{ $slot }}
        </div>
    @endif
</div>
