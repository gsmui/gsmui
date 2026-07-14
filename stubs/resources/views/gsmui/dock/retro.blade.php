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
    'flex items-center gap-3 z-50',
    $positionClass,
    'bg-amber-100 dark:bg-amber-900/50 rounded-xl p-3 shadow-xl',
    'border-2 border-amber-800/30 dark:border-amber-700/30',
    'font-serif',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-lg transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-amber-800 text-amber-100' 
                          : 'text-amber-700 dark:text-amber-300 hover:bg-amber-200 dark:hover:bg-amber-800/50' }}">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            @if(isset($item['label']))
                <div class="absolute -bottom-5 left-1/2 -translate-x-1/2 text-[10px] text-amber-700 dark:text-amber-300 italic whitespace-nowrap">
                    {{ $item['label'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
