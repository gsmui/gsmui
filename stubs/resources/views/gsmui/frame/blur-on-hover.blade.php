@props([
    'blur' => 'sm',
    'amount' => '1',
])

@php
$blurs = [
    '0' => 'hover:blur-none',
    'sm' => 'hover:blur-[1px]',
    'md' => 'hover:blur-[2px]',
    'lg' => 'hover:blur-[4px]',
];

$blurClass = $blurs[$blur] ?? 'hover:blur-[1px]';
@endphp

<div {{ $attributes->class([
    'rounded-xl transition-all duration-300',
    $blurClass,
]) }}>
    {{ $slot }}
</div>
