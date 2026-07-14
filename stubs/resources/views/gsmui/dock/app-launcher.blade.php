@props([
    'items' => [],
    'columns' => 4,
    'showLabels' => true,
])

<div {{ $attributes->class([
    'z-50 fixed bottom-4 left-1/2 -translate-x-1/2',
    'bg-white/90 dark:bg-zinc-800/90 backdrop-blur-2xl rounded-3xl p-6 shadow-2xl',
    'border border-zinc-200/50 dark:border-zinc-700/50',
]) }}>
    
    <div class="grid gap-4" style="grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));">
        @foreach($items as $index => $item)
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex flex-col items-center gap-2 p-2 rounded-2xl transition-all duration-200 hover:bg-zinc-100 dark:hover:bg-zinc-700/50 group">
                <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-gradient-to-br {{ $item['gradient'] ?? 'from-blue-400 to-blue-600' }} text-white shadow-lg group-hover:scale-110 transition-transform duration-200">
                    <span class="text-2xl">{!! $item['icon'] ?? '🏠' !!}</span>
                </div>
                @if($showLabels)
                    <span class="text-[11px] font-medium text-zinc-600 dark:text-zinc-400 group-hover:text-zinc-900 dark:group-hover:text-white text-center leading-tight">
                        {{ $item['label'] ?? '' }}
                    </span>
                @endif
                
                @if(isset($item['badge']) && $item['badge'])
                    <div class="absolute top-0 right-0 w-4 h-4 flex items-center justify-center bg-red-500 text-white text-[8px] font-bold rounded-full">
                        {{ $item['badge'] }}
                    </div>
                @endif
            </a>
        @endforeach
    </div>
</div>
