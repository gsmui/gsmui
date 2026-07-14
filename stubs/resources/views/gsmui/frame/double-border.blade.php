@props([
    'gap' => '1',
    'color' => 'zinc',
    'rounded' => true,
])

@php
$gaps = [
    '0.5' => 'gap-0.5',
    '1' => 'gap-1',
    '2' => 'gap-2',
    '3' => 'gap-3',
];

$colors = [
    'blue' => 'border-blue-500',
    'green' => 'border-green-500',
    'purple' => 'border-purple-500',
    'red' => 'border-red-500',
    'zinc' => 'border-zinc-300 dark:border-zinc-600',
];

$gapClass = $gaps[$gap] ?? 'gap-1';
$colorClass = $colors[$color] ?? 'border-zinc-300';
@endphp

<div class="flex {{ $gapClass }}">
    <div class="flex-1 border-2 {{ $colorClass }} {{ $rounded ? 'rounded-xl' : '' }} opacity-50"></div>
    <div {{ $attributes->class([
        'flex-1 border-2',
        $colorClass,
        $rounded ? 'rounded-xl' : '',
    ]) }}>
        {{ $slot }}
    </div>
</div>
