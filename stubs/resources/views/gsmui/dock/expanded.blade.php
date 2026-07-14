@props([
    'items' => [],
    'position' => 'bottom',
    'showLabels' => true,
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    'left' => 'fixed left-4 top-1/2 -translate-y-1/2 flex-col',
    'right' => 'fixed right-4 top-1/2 -translate-y-1/2 flex-col',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center gap-1 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-100 dark:bg-zinc-700 text-zinc-900 dark:text-white' 
                          : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-700/50' }}">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                @if($showLabels && isset($item['label']))
                    <span class="text-sm font-medium whitespace-nowrap">{{ $item['label'] }}</span>
                @endif
            </a>
            
            @if(isset($item['badge']) && $item['badge'])
                <div class="absolute top-1 right-1 min-w-[16px] h-4 flex items-center justify-center px-1 bg-red-500 text-white text-[10px] font-bold rounded-full">
                    {{ $item['badge'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
