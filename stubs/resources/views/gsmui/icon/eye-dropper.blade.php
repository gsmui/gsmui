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
    <path fill-rule="evenodd" d="M12.1 3.667a3.502 3.502 0 116.782 1.738 3.487 3.487 0 01-.907 1.57l-6.694 6.69a1 1 0 01-.447.26L8.9 13.9l-2.7 2.7h-4v-4l2.7-2.7.982-.934a1 1 0 01.261-.447l6.694-6.69a3.5 3.5 0 011.463-1.162zM13.5 4.5a2 2 0 00-2 2h2v-2z" clip-rule="evenodd" />
</svg>
