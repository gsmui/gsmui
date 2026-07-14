@props([
    'amount' => 'full',
])

@php
$amounts = [
    'light' => 'hover:grayscale-[30%]',
    'medium' => 'hover:grayscale-[50%]',
    'full' => 'hover:grayscale',
];

$amountClass = $amounts[$amount] ?? 'hover:grayscale';
@endphp

<div {{ $attributes->class([
    'rounded-xl transition-all duration-300',
    $amountClass,
]) }}>
    {{ $slot }}
</div>
