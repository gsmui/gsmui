@props([
    'items' => [],
    'columns' => 6,
])

<div {{ $attributes->class(['fixed inset-0 z-50 flex items-center justify-center']) }}
     x-data="{ open: false }">
    
    {{-- Trigger button --}}
    <button @click="open = !open"
            class="fixed bottom-6 left-1/2 -translate-x-1/2 w-14 h-14 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 z-50">
        <svg class="w-6 h-6 transition-transform duration-300" :class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    
    {{-- Overlay --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-zinc-900/80 backdrop-blur-sm" @click="open = false">
    </div>
    
    {{-- Modal content --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
         class="relative bg-white dark:bg-zinc-800 rounded-3xl p-8 shadow-2xl max-w-lg w-full mx-4"
         @click.stop>
        
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6 text-center">Quick Actions</h3>
        
        <div class="grid gap-4" style="grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));">
            @foreach($items as $index => $item)
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex flex-col items-center gap-2 p-3 rounded-2xl transition-all duration-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 group">
                    <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br {{ $item['gradient'] ?? 'from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-600' }} 
                         text-xl group-hover:scale-110 transition-transform duration-200">
                        {!! $item['icon'] ?? '🏠' !!}
                    </div>
                    <span class="text-xs font-medium text-zinc-600 dark:text-zinc-400 text-center">{{ $item['label'] ?? '' }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
