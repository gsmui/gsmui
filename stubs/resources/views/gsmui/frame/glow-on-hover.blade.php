@props([
    'color' => 'blue',
    'intensity' => 'md',
])

@php
$glows = [
    'blue' => 'hover:shadow-[0_0_20px_rgba(59,130,246,0.5)]',
    'green' => 'hover:shadow-[0_0_20px_rgba(34,197,94,0.5)]',
    'purple' => 'hover:shadow-[0_0_20px_rgba(168,85,247,0.5)]',
    'pink' => 'hover:shadow-[0_0_20px_rgba(236,72,153,0.5)]',
    'cyan' => 'hover:shadow-[0_0_20px_rgba(6,182,212,0.5)]',
];

$glowClass = $glows[$color] ?? 'hover:shadow-[0_0_20px_rgba(59,130,246,0.5)]';
@endphp

<div {{ $attributes->class([
    'rounded-xl transition-shadow duration-300',
    $glowClass,
]) }}>
    {{ $slot }}
</div>
