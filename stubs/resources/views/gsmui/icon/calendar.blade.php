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
    <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75a.75.75 0 01.75-.75zm-2.5 6.5h13.5v6.75c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25V8.5z" clip-rule="evenodd" />
</svg>
