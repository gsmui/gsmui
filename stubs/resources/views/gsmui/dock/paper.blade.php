@props([
    'items' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center gap-2 z-50',
    $positionClass,
    'bg-amber-50 dark:bg-amber-950 rounded-xl p-3 shadow-xl',
    'border border-amber-200 dark:border-amber-800',
    'font-serif',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-11 h-11 rounded-lg transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-amber-800 text-amber-100' 
                          : 'text-amber-700 dark:text-amber-300 hover:bg-amber-100 dark:hover:bg-amber-900/50' }}"
               :style="`transform: rotate(${hovered === {{ $index }} ? '-3deg' : '0deg'})`">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
