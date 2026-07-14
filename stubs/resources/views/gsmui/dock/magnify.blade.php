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
    'flex items-end gap-1 z-50',
    $positionClass,
    'bg-zinc-900/80 dark:bg-zinc-100/80 backdrop-blur-xl rounded-2xl p-2.5 shadow-2xl',
]) }}
    x-data="{ hovered: -1 }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = -1">
            <a href="{{ $item['url'] ?? '#' }}"
               class="block rounded-2xl transition-all duration-200 ease-out overflow-hidden
                      {{ ($item['active'] ?? false) ? 'bg-zinc-700 dark:bg-zinc-300' : '' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-12px' : '0'}) scale(${hovered === {{ $index }} ? 1.35 : (Math.abs(hovered - {{ $index }}) === 1 ? 1.18 : Math.abs(hovered - {{ $index }}) === 2 ? 1.06 : 1)})`">
                
                <div class="w-11 h-11 flex items-center justify-center {{ ($item['active'] ?? false) ? '' : 'hover:bg-white/10' }}">
                    @if(isset($item['image']))
                        <img src="{{ $item['image'] }}" alt="{{ $item['label'] ?? '' }}" class="w-[85%] h-[85%] rounded-xl object-cover" />
                    @else
                        <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                    @endif
                </div>
            </a>
            
            @if(isset($item['badge']) && $item['badge'])
                <div class="absolute -top-1 -right-1 min-w-[16px] h-4 flex items-center justify-center px-1 bg-red-500 text-white text-[9px] font-bold rounded-full">
                    {{ $item['badge'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
