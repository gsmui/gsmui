@props([
    'color' => 'zinc',
    'dashed' => false,
    'label' => '',
])

@php
$colors = [
    'blue' => 'border-blue-400',
    'green' => 'border-green-400',
    'purple' => 'border-purple-400',
    'zinc' => 'border-zinc-300 dark:border-zinc-600',
];

$colorClass = $colors[$color] ?? 'border-zinc-300';
@endphp

<div {{ $attributes->class([
    'rounded-xl border',
    $colorClass,
    $dashed ? 'border-dashed' : 'border-dotted',
    'bg-zinc-50 dark:bg-zinc-900/50',
]) }}>
    @if($label)
    <div class="px-3 py-1 text-xs text-zinc-500 border-b {{ $colorClass }} {{ $dashed ? 'border-dashed' : 'border-dotted' }}">
        {{ $label }}
    </div>
    @endif
    {{ $slot }}
</div>
