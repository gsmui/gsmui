@props([
    'items' => [],
    'position' => 'bottom-right',
    'size' => 'sm',
])

@php
$sizes = [
    'xs' => ['icon' => 'w-6 h-6', 'text' => 'text-xs'],
    'sm' => ['icon' => 'w-8 h-8', 'text' => 'text-sm'],
    'md' => ['icon' => 'w-10 h-10', 'text' => 'text-base'],
];
$sizeSet = $sizes[$size] ?? $sizes['sm'];

$positionClass = match($position) {
    'bottom-right' => 'fixed bottom-4 right-4',
    'bottom-left' => 'fixed bottom-4 left-4',
    'top-right' => 'fixed top-4 right-4',
    'top-left' => 'fixed top-4 left-4',
    default => 'fixed bottom-4 right-4',
};
@endphp

<div {{ $attributes->class([
    'flex flex-col items-center gap-1 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-xl p-1.5 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center {{ $sizeSet['icon'] }} rounded-lg transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="{{ $sizeSet['text'] }}">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
