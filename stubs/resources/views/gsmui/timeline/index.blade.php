@props([
    'horizontal' => false,
    'align' => 'center',
    'size' => null,
])

@php
$classes = Gsmui::classes()
    ;

if ($horizontal) {
    $attributes = $attributes->merge([
        'data-gsmui-timeline-horizontal' => $horizontal,
    ]);
}

if ($align) {
    $attributes = $attributes->merge([
        'data-gsmui-timeline-align' => $align,
    ]);
}

if ($size) {
    $attributes = $attributes->merge([
        'data-gsmui-timeline-size' => $size,
    ]);
}
@endphp

<ol {{ $attributes->class($classes) }} data-gsmui-timeline>
    {{ $slot }}
</ol>