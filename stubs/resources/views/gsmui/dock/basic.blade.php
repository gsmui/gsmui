@props([
    'items' => [],
    'position' => 'bottom',
    'size' => 'md',
    'magnify' => true,
])

@php
$sizes = [
    'sm' => ['icon' => 'w-10 h-10', 'gap' => 'gap-1', 'padding' => 'px-2 py-1'],
    'md' => ['icon' => 'w-12 h-12', 'gap' => 'gap-1.5', 'padding' => 'px-3 py-2'],
    'lg' => ['icon' => 'w-14 h-14', 'gap' => 'gap-2', 'padding' => 'px-4 py-2'],
];
$sizeSet = $sizes[$size] ?? $sizes['md'];

$positions = [
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    'left' => 'fixed left-4 top-1/2 -translate-y-1/2 flex-col',
    'right' => 'fixed right-4 top-1/2 -translate-y-1/2 flex-col',
];
$positionClass = $positions[$position] ?? $positions['bottom'];
@endphp

<div {{ $attributes->class([
    'flex items-end z-50',
    $positionClass,
    $sizeSet['gap'],
    'bg-white/80 dark:bg-zinc-800/80 backdrop-blur-xl',
    'rounded-2xl shadow-2xl',
    'border border-zinc-200/50 dark:border-zinc-700/50',
    $sizeSet['padding'],
]) }}
    x-data="{ hovered: null }"
    @if($position === 'bottom' || $position === 'top') style="transform-origin: bottom center;" @endif
>
    @foreach($items as $index => $item)
        <div class="relative group" 
             @mouseenter="hovered = {{ $index }}"
             @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center {{ $sizeSet['icon'] }} rounded-xl transition-all duration-200 ease-out
                      {{ isset($item['active']) && $item['active'] ? 'bg-zinc-200 dark:bg-zinc-700' : 'hover:bg-zinc-100 dark:hover:bg-zinc-700/50' }}"
               @if($magnify) 
                   :style="`transform: scale(${hovered === {{ $index }} ? 1.3 : (Math.abs(hovered - {{ $index }}) === 1 ? 1.15 : 1)})`"
               @endif
               title="{{ $item['label'] ?? '' }}">
                @if(isset($item['icon']))
                    <span class="text-xl">{!! $item['icon'] !!}</span>
                @elseif(isset($item['image']))
                    <img src="{{ $item['image'] }}" alt="{{ $item['label'] ?? '' }}" class="w-full h-full rounded-lg object-cover" />
                @else
                    <span class="text-lg">{{ $item['label'][0] ?? '?' }}</span>
                @endif
            </a>
            
            {{-- Tooltip --}}
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-zinc-900 dark:bg-zinc-700 text-white text-xs rounded-lg
                         opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">
                {{ $item['label'] ?? '' }}
            </div>
            
            {{-- Active indicator --}}
            @if(isset($item['active']) && $item['active'])
                <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-zinc-500 dark:bg-zinc-400"></div>
            @endif
            
            {{-- Badge --}}
            @if(isset($item['badge']) && $item['badge'])
                <div class="absolute -top-1 -right-1 min-w-[18px] h-[18px] flex items-center justify-center px-1 bg-red-500 text-white text-[10px] font-bold rounded-full">
                    {{ $item['badge'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
