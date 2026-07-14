@props([
    'items' => [],
    'position' => 'bottom',
    'showLabels' => true,
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-end justify-center gap-3 z-50',
    $positionClass,
    'bg-zinc-900 dark:bg-zinc-100 rounded-2xl p-3 shadow-2xl',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="flex flex-col items-center gap-1.5 group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-700 dark:bg-zinc-300 text-white dark:text-zinc-900' 
                          : 'text-zinc-400 dark:text-zinc-600 hover:bg-zinc-800 dark:hover:bg-zinc-200' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-8px' : '0'}) scale(${hovered === {{ $index }} ? 1.1 : 1})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            @if($showLabels)
                <span class="text-[10px] font-medium text-zinc-400 dark:text-zinc-500 group-hover:text-white dark:group-hover:text-zinc-900 transition-colors whitespace-nowrap">
                    {{ $item['label'] ?? '' }}
                </span>
            @endif
        </div>
    @endforeach
</div>
