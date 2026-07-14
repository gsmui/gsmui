@props([
    'scale' => '105',
    'shadow' => true,
])

@php
$scales = [
    '102' => 'hover:scale-[1.02]',
    '105' => 'hover:scale-[1.05]',
    '110' => 'hover:scale-[1.10]',
];

$scaleClass = $scales[$scale] ?? 'hover:scale-[1.05]';
@endphp

<div {{ $attributes->class([
    'rounded-xl transition-transform duration-300',
    $scaleClass,
    $shadow ? 'hover:shadow-xl' : '',
]) }}>
    {{ $slot }}
</div>
