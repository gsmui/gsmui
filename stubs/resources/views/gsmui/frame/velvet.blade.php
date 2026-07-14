@props([
    'color' => 'red',
    'inner' => true,
])

@php
$colors = [
    'red' => 'bg-gradient-to-br from-red-800 via-red-900 to-red-800 border-red-700',
    'blue' => 'bg-gradient-to-br from-blue-800 via-blue-900 to-blue-800 border-blue-700',
    'green' => 'bg-gradient-to-br from-green-800 via-green-900 to-green-800 border-green-700',
    'purple' => 'bg-gradient-to-br from-purple-800 via-purple-900 to-purple-800 border-purple-700',
];

$colorClass = $colors[$color] ?? 'bg-gradient-to-br from-red-800 via-red-900 to-red-800';
@endphp

<div {{ $attributes->class([
    'p-4 rounded-xl border-4',
    $colorClass,
    'shadow-2xl',
    'shadow-black/50',
]) }}>
    @if($inner)
    <div class="bg-white dark:bg-zinc-800 dark:bg-zinc-900 rounded-lg overflow-hidden">
        {{ $slot }}
    </div>
    @else
    {{ $slot }}
    @endif
</div>
