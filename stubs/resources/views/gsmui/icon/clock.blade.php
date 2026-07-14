@props(['variant' => 'mini'])

@php
$classes = Gsmui::classes()
    ->add(match ($variant) {
        'outline', 'solid' => 'size-6',
        'mini' => 'size-5',
        'micro' => 'size-4',
    })
    ->add('shrink-0');
@endphp

<svg {{ $attributes->class($classes) }} viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
</svg>
