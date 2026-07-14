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
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Tooltip with shortcut --}}
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 px-2.5 py-2 bg-zinc-900 dark:bg-zinc-700 text-white text-xs rounded-lg
                        opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap shadow-lg min-w-[100px]">
                <div class="font-medium">{{ $item['label'] ?? '' }}</div>
                @if(isset($item['shortcut']))
                    <div class="mt-1 flex items-center gap-1">
                        @foreach(explode('+', $item['shortcut']) as $key)
                            <kbd class="px-1.5 py-0.5 bg-zinc-700 dark:bg-zinc-600 rounded text-[10px] font-mono">{{ $key }}</kbd>
                            @if(!$loop->last)
                                <span class="text-zinc-400">+</span>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
