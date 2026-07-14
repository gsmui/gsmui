@props([
    'items' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-6 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-6 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-6 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center gap-3 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-3xl p-3 shadow-2xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-16 h-16 rounded-2xl transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-8px' : '0'}) scale(${hovered === {{ $index }} ? 1.1 : 1})`">
                <span class="text-2xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            @if(isset($item['label']))
                <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-xs font-medium text-zinc-500 dark:text-zinc-400 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                    {{ $item['label'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
