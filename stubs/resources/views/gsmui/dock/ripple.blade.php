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
    'flex items-center gap-2 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ ripples: [] }">
    
    @foreach($items as $index => $item)
        <div class="relative overflow-hidden"
             x-data="{ show: false }"
             @click="show = true; setTimeout(() => show = false, 600)">
            <a href="{{ $item['url'] ?? '#' }}"
               class="relative flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200 z-10
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Ripple effect --}}
            <div x-show="show" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-0" x-transition:enter-end="opacity-100 scale-150"
                 class="absolute inset-0 rounded-xl bg-zinc-300/30 dark:bg-zinc-500/30 pointer-events-none"></div>
        </div>
    @endforeach
</div>
