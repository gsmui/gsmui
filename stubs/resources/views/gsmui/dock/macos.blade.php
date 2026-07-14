@props([
    'items' => [],
    'size' => 'md',
    'showReflection' => true,
    'showSeparators' => true,
])

@php
$sizes = [
    'sm' => ['icon' => 'w-10 h-10', 'gap' => 'gap-2'],
    'md' => ['icon' => 'w-12 h-12', 'gap' => 'gap-2.5'],
    'lg' => ['icon' => 'w-14 h-14', 'gap' => 'gap-3'],
];
$sizeSet = $sizes[$size] ?? $sizes['md'];

$separators = collect($items)->filter(fn($item) => $item['type'] ?? '' === 'separator');
@endphp

<div {{ $attributes->class(['flex flex-col items-center z-50 fixed bottom-4 left-1/2 -translate-x-1/2']) }}
     x-data="{ hovered: null }">
    
    {{-- Dock body --}}
    <div class="flex items-end {{ $sizeSet['gap'] }} px-3 py-1.5
                bg-zinc-200/40 dark:bg-zinc-800/40 backdrop-blur-2xl
                rounded-[22px] shadow-2xl
                border border-white/30 dark:border-white/10">
        
        @foreach($items as $index => $item)
            @if(($item['type'] ?? '') === 'separator')
                <div class="w-px h-8 bg-zinc-400/30 dark:bg-zinc-500/30 mx-1"></div>
            @else
                <div class="relative group" 
                     @mouseenter="hovered = {{ $index }}"
                     @mouseleave="hovered = null">
                    <a href="{{ $item['url'] ?? '#' }}"
                       class="flex items-center justify-center {{ $sizeSet['icon'] }} rounded-[14px] transition-all duration-150 ease-out
                              {{ ($item['active'] ?? false) ? 'bg-zinc-300/50 dark:bg-zinc-600/50' : 'hover:bg-white/20 dark:hover:bg-white/10' }}"
                       :style="`transform: scale(${hovered === {{ $index }} ? 1.35 : (Math.abs(hovered - {{ $index }}) === 1 ? 1.15 : Math.abs(hovered - {{ $index }}) === 2 ? 1.05 : 1)})`">
                        
                        @if(isset($item['image']))
                            <img src="{{ $item['image'] }}" alt="{{ $item['label'] ?? '' }}" class="w-[85%] h-[85%] rounded-[10px] object-cover" />
                        @elseif(isset($item['icon']))
                            <span class="text-2xl">{!! $item['icon'] !!}</span>
                        @else
                            <div class="w-[85%] h-[85%] rounded-[10px] bg-gradient-to-br {{ $item['gradient'] ?? 'from-blue-400 to-blue-600' }}"></div>
                        @endif
                    </a>
                    
                    {{-- Running indicator --}}
                    @if($item['running'] ?? false)
                        <div class="absolute -bottom-1.5 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-zinc-500 dark:bg-zinc-400"></div>
                    @endif
                    
                    {{-- Tooltip --}}
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 px-2.5 py-1 bg-zinc-800/90 dark:bg-zinc-700/90 text-white text-xs rounded-md
                               opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap backdrop-blur-sm">
                        {{ $item['label'] ?? '' }}
                    </div>
                    
                    {{-- Badge --}}
                    @if(isset($item['badge']) && $item['badge'])
                        <div class="absolute -top-1 -right-1 min-w-[18px] h-[18px] flex items-center justify-center px-1 bg-red-500 text-white text-[10px] font-bold rounded-full shadow-lg">
                            {{ $item['badge'] }}
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
    
    {{-- Reflection --}}
    @if($showReflection)
        <div class="w-[80%] h-3 mt-0.5 bg-gradient-to-b from-zinc-200/20 dark:from-zinc-700/20 to-transparent rounded-b-xl blur-sm"></div>
    @endif
</div>
