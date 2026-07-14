@props([
    'offset' => 'md',
    'hover' => true,
])

@php
$offsets = [
    'sm' => 'translate-y-1 hover:translate-y-0',
    'md' => 'translate-y-2 hover:translate-y-0',
    'lg' => 'translate-y-4 hover:translate-y-0',
];

$offsetClass = $offsets[$offset] ?? 'translate-y-2 hover:translate-y-0';
@endphp

<div {{ $attributes->class([
    'rounded-xl shadow-lg transition-all duration-300',
    $hover ? $offsetClass : '',
]) }}>
    {{ $slot }}
</div>
