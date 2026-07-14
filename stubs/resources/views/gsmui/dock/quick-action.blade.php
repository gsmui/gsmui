@props([
    'items' => [],
    'position' => 'bottom',
    'primaryColor' => 'blue',
])

@php
$primaryColors = [
    'blue' => 'bg-blue-500 hover:bg-blue-600 text-white',
    'green' => 'bg-green-500 hover:bg-green-600 text-white',
    'purple' => 'bg-purple-500 hover:bg-purple-600 text-white',
];
$primaryClass = $primaryColors[$primaryColor] ?? $primaryColors['blue'];

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};
@endphp

<div {{ $attributes->class([
    'flex items-center gap-2 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['primary'] ?? false) 
                          ? $primaryClass . ' shadow-lg'
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.1 : 1})`">
                <span class="text-xl">{!! $item['icon'] ?? '➕' !!}</span>
            </a>
        </div>
    @endforeach
</div>
