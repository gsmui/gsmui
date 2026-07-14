@props([
    'items' => [],
    'position' => 'bottom',
])

<div {{ $attributes->class([
    'flex items-center justify-around gap-1 z-50',
    'fixed bottom-0 left-0 right-0',
    'bg-white dark:bg-zinc-800',
    'px-2 pb-safe pt-2',
    'border-t border-zinc-200 dark:border-zinc-700',
    'sm:hidden',
]) }}>
    
    @foreach($items as $index => $item)
        <a href="{{ $item['url'] ?? '#' }}"
           class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-xl transition-all duration-200
                  {{ ($item['active'] ?? false) 
                      ? 'text-blue-500' 
                      : 'text-zinc-400 dark:text-zinc-500' }}">
            <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            <span class="text-[10px] font-medium">{{ $item['label'] ?? '' }}</span>
            
            @if($item['active'] ?? false)
                <div class="w-4 h-0.5 bg-blue-500 rounded-full mt-0.5"></div>
            @endif
        </a>
    @endforeach
</div>
