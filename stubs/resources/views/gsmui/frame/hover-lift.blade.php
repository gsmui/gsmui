@props([
    'lift' => 'md',
    'shadow' => true,
])

@php
$lifts = [
    'sm' => 'hover:-translate-y-1',
    'md' => 'hover:-translate-y-2',
    'lg' => 'hover:-translate-y-4',
];

$liftClass = $lifts[$lift] ?? 'hover:-translate-y-2';
@endphp

<div {{ $attributes->class([
    'rounded-xl transition-all duration-300',
    $liftClass,
    $shadow ? 'hover:shadow-xl' : '',
]) }}>
    {{ $slot }}
</div>
