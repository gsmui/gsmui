@props([
    'items' => [],
    'position' => 'bottom',
    'showLabels' => false,
])

$positions = [
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    'left' => 'fixed left-4 top-1/2 -translate-y-1/2 flex-col',
    'right' => 'fixed right-4 top-1/2 -translate-y-1/2 flex-col',
];
$positionClass = $positions[$position] ?? $positions['bottom'];

<div {{ $attributes->class([
    'flex items-center gap-3 z-50',
    $positionClass,
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group"
             @mouseenter="hovered = {{ $index }}"
             @mouseleave="hovered = null">
            
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'text-zinc-900 dark:text-white' 
                          : 'text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-300' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.15 : 1})`">
                
                @if(isset($item['icon']))
                    <span class="text-lg">{!! $item['icon'] !!}</span>
                @else
                    <span class="text-sm font-medium">{{ strtoupper(substr($item['label'] ?? '?', 0, 1)) }}</span>
                @endif
            </a>
            
            {{-- Underline indicator --}}
            @if($item['active'] ?? false)
                <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-4 h-0.5 rounded-full bg-zinc-900 dark:bg-white"></div>
            @endif
            
            {{-- Label --}}
            @if($showLabels && isset($item['label']))
                <div class="absolute -bottom-5 left-1/2 -translate-x-1/2 text-[10px] text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                    {{ $item['label'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
