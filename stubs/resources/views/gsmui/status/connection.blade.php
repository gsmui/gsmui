@props([
    'connected' => true,
    'label' => null,
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'h-1.5 w-1.5',
    'md' => 'h-2 w-2',
    'lg' => 'h-2.5 w-2.5',
];

$textSizes = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];

$dotClass = $sizes[$size] ?? 'h-2 w-2';
$textClass = $textSizes[$size] ?? 'text-sm';
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <span @class([
        'rounded-full',
        $dotClass,
        $connected ? 'bg-green-500' : 'bg-red-500',
    ])></span>
    @if($label || !$label)
        <span class="{{ $textClass }} font-medium {{ $connected ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
            {{ $label ?? ($connected ? 'Connected' : 'Disconnected') }}
        </span>
    @endif
</div>
