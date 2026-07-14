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
    'flex items-end gap-2 z-50',
    $positionClass,
    'bg-white/80 dark:bg-zinc-800/80 backdrop-blur-xl rounded-2xl p-2 shadow-2xl border border-zinc-200/50 dark:border-zinc-700/50',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-[400ms] ease-[cubic-bezier(0.34,1.56,0.64,1)]
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' 
                          : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-600' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-12px' : '0px'}) scale(${hovered === {{ $index }} ? 1.2 : (Math.abs(hovered - {{ $index }}) === 1 ? 1.05 : 1)})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            @if(isset($item['badge']) && $item['badge'])
                <div class="absolute -top-1 -right-1 min-w-[16px] h-4 flex items-center justify-center px-1 bg-red-500 text-white text-[9px] font-bold rounded-full animate-pulse">
                    {{ $item['badge'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
