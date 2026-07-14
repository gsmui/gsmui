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
]) }}>
    
    @foreach($items as $index => $item)
        <div class="relative group">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Progress ring --}}
            @if(isset($item['progress']))
                @php $progress = min(100, max(0, $item['progress'])); @endphp
                <div class="absolute inset-0 rounded-xl overflow-hidden pointer-events-none">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="20" fill="none" stroke-width="3" class="stroke-zinc-200 dark:stroke-zinc-600"/>
                        <circle cx="24" cy="24" r="20" fill="none" stroke-width="3" stroke-linecap="round"
                                class="stroke-blue-500" style="stroke-dasharray: 125.66; stroke-dashoffset: {{ 125.66 - (125.66 * $progress / 100) }};"/>
                    </svg>
                </div>
            @endif
        </div>
    @endforeach
</div>
