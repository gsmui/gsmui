@props([
    'items' => [],
    'side' => 'left',
    'width' => '280',
])

<div {{ $attributes->class([
    'fixed top-0 bottom-0 z-50 flex items-center',
    $side === 'left' ? 'left-0' : 'right-0',
]) }}
    x-data="{ open: false }">
    
    {{-- Toggle button --}}
    <button @click="open = !open"
            class="absolute {{ $side === 'left' ? 'right-0 translate-x-full' : 'left-0 -translate-x-full'}} top-1/2 -translate-y-1/2 w-8 h-16 bg-white dark:bg-zinc-800 rounded-r-lg lg:rounded-l-lg shadow-lg flex items-center justify-center border border-zinc-200 dark:border-zinc-700 z-50">
        <svg class="w-4 h-4 text-zinc-500 transition-transform duration-300" :class="open ? '{{ $side === "left" ? "rotate-180" : "-rotate-180" }}' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
    
    {{-- Drawer panel --}}
    <div class="h-full bg-white dark:bg-zinc-800 shadow-2xl border-r border-zinc-200 dark:border-zinc-700 transition-all duration-300 overflow-hidden"
         :style="`width: ${open ? '{{ $width }}px' : '0px'}`">
        
        <div class="flex flex-col gap-2 p-4 h-full" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            @foreach($items as $index => $item)
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                              : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                    <span class="text-sm font-medium">{{ $item['label'] ?? '' }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
