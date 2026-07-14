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
    <path fill-rule="evenodd" d="M10.53 3.47a.75.75 0 00-1.06 0L6.22 6.72a.75.75 0 001.06 1.06L10 5.06l2.72 2.72a.75.75 0 101.06-1.06l-3.25-3.25zm-4.31 9.81l3.25 3.25a.75.75 0 001.06 0l3.25-3.25a.75.75 0 10-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 10-1.06 1.06z" clip-rule="evenodd" />
</svg>
