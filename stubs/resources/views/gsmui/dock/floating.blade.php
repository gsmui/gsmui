@props([
    'items' => [],
    'position' => 'bottom',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => ['icon' => 'w-10 h-10'],
    'md' => ['icon' => 'w-12 h-12'],
    'lg' => ['icon' => 'w-14 h-14'],
];
$sizeSet = $sizes[$size] ?? $sizes['md'];

$positions = [
    'bottom' => 'fixed bottom-6 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-6 left-1/2 -translate-x-1/2',
    'left' => 'fixed left-6 top-1/2 -translate-y-1/2 flex-col',
    'right' => 'fixed right-6 top-1/2 -translate-y-1/2 flex-col',
];
$positionClass = $positions[$position] ?? $positions['bottom'];
@endphp

<div {{ $attributes->class([
    'flex items-center gap-1.5 z-50',
    $positionClass,
    'bg-white/10 dark:bg-zinc-800/30 backdrop-blur-2xl',
    'rounded-2xl p-2',
    'shadow-[0_8px_32px_rgba(0,0,0,0.12)]',
    'border border-white/20 dark:border-white/5',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group"
             @mouseenter="hovered = {{ $index }}"
             @mouseleave="hovered = null">
            
            <a href="{{ $item['url'] ?? '#' }}"
               class="relative flex items-center justify-center {{ $sizeSet['icon'] }} rounded-xl transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white/20 dark:bg-white/10 shadow-lg' 
                          : 'hover:bg-white/10 dark:hover:bg-white/5' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-8px' : '0px'}) scale(${hovered === {{ $index }} ? 1.15 : 1})`">
                
                @if(isset($item['image']))
                    <img src="{{ $item['image'] }}" alt="{{ $item['label'] ?? '' }}" class="w-[80%] h-[80%] rounded-lg object-cover" />
                @else
                    <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                @endif
                
                {{-- Hover glow --}}
                <div class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none
                            bg-gradient-to-t from-white/10 to-transparent"></div>
            </a>
            
            {{-- Floating label --}}
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 px-2 py-1 bg-zinc-900/90 dark:bg-zinc-700/90 text-white text-[11px] font-medium rounded-lg
                        opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none
                        translate-y-2 group-hover:translate-y-0 backdrop-blur-sm
                        whitespace-nowrap shadow-lg">
                {{ $item['label'] ?? '' }}
                <div class="absolute top-full left-1/2 -translate-x-1/2 w-2 h-2 bg-zinc-900/90 dark:bg-zinc-700/90 rotate-45 -mt-1"></div>
            </div>
            
            {{-- Badge --}}
            @if(isset($item['badge']) && $item['badge'])
                <div class="absolute -top-0.5 -right-0.5 min-w-[16px] h-[16px] flex items-center justify-center px-1 bg-red-500 text-white text-[9px] font-bold rounded-full shadow-md">
                    {{ $item['badge'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
