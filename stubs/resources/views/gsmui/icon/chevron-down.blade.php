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
    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
</svg>
