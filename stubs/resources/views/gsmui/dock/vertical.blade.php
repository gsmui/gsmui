@props([
    'items' => [],
    'position' => 'left',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => ['icon' => 'w-8 h-8', 'text' => 'text-sm'],
    'md' => ['icon' => 'w-10 h-10', 'text' => 'text-base'],
    'lg' => ['icon' => 'w-12 h-12', 'text' => 'text-lg'],
];
$sizeSet = $sizes[$size] ?? $sizes['md'];

$positionClass = match($position) {
    'left' => 'fixed left-4 top-1/2 -translate-y-1/2',
    'right' => 'fixed right-4 top-1/2 -translate-y-1/2',
    default => 'fixed left-4 top-1/2 -translate-y-1/2',
};
@endphp

<div {{ $attributes->class([
    'flex flex-col items-center gap-2 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center {{ $sizeSet['icon'] }} rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-100 dark:bg-zinc-700 text-zinc-900 dark:text-white' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700/50' }}"
               :style="`transform: translateX(${hovered === {{ $index }} ? '4px' : '0'}) scale(${hovered === {{ $index }} ? 1.1 : 1})`">
                <span class="{{ $sizeSet['text'] }}">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Tooltip --}}
            <div class="absolute left-full ml-3 top-1/2 -translate-y-1/2 px-2.5 py-1 bg-zinc-900 dark:bg-zinc-700 text-white text-xs rounded-lg
                        opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                {{ $item['label'] ?? '' }}
                <div class="absolute right-full top-1/2 -translate-y-1/2 w-0 h-0 border-t-4 border-b-4 border-r-4 border-transparent border-r-zinc-900 dark:border-r-zinc-700"></div>
            </div>
        </div>
    @endforeach
</div>
