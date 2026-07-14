@props([
    'items' => [],
    'position' => 'bottom',
    'blur' => 'heavy',
])

@php
$blurLevels = [
    'light' => 'backdrop-blur-md',
    'medium' => 'backdrop-blur-xl',
    'heavy' => 'backdrop-blur-2xl',
];
$blurClass = $blurLevels[$blur] ?? $blurLevels['heavy'];

$positions = [
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    'left' => 'fixed left-4 top-1/2 -translate-y-1/2 flex-col',
    'right' => 'fixed right-4 top-1/2 -translate-y-1/2 flex-col',
];
$positionClass = $positions[$position] ?? $positions['bottom'];
@endphp

<div {{ $attributes->class([
    'flex items-center gap-1 z-50',
    $positionClass,
    $blurClass,
    'bg-white/20 dark:bg-white/5',
    'rounded-2xl p-2',
    'shadow-[0_8px_32px_0_rgba(31,38,135,0.37)]',
    'border border-white/30 dark:border-white/10',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group"
             @mouseenter="hovered = {{ $index }}"
             @mouseleave="hovered = null">
            
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300 ease-out
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white/30 dark:bg-white/15 shadow-inner' 
                          : 'hover:bg-white/20 dark:hover:bg-white/10' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.2 : 1})`">
                
                @if(isset($item['image']))
                    <img src="{{ $item['image'] }}" alt="{{ $item['label'] ?? '' }}" class="w-8 h-8 rounded-lg object-cover" />
                @else
                    <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                @endif
            </a>
            
            {{-- Tooltip --}}
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 px-2.5 py-1 
                        bg-white/20 dark:bg-white/10 backdrop-blur-xl
                        text-zinc-900 dark:text-white text-xs font-medium rounded-lg
                        border border-white/30 dark:border-white/10
                        opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none
                        translate-y-1 group-hover:translate-y-0 whitespace-nowrap">
                {{ $item['label'] ?? '' }}
            </div>
        </div>
    @endforeach
</div>
