@props([
    'opacity' => '80',
    'duration' => '300',
])

@php
$opacities = [
    '50' => 'hover:opacity-50',
    '60' => 'hover:opacity-60',
    '70' => 'hover:opacity-70',
    '80' => 'hover:opacity-80',
    '90' => 'hover:opacity-90',
];

$opacityClass = $opacities[$opacity] ?? 'hover:opacity-80';
@endphp

<div {{ $attributes->class([
    'rounded-xl transition-opacity duration-[' . $duration . 'ms]',
    $opacityClass,
]) }}>
    {{ $slot }}
</div>
