@props([
    'items' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-1 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-1 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-1 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center gap-0.5 z-50',
    $positionClass,
    'bg-zinc-900 dark:bg-zinc-100 rounded-lg p-0.5 shadow-lg',
]) }}>
    
    @foreach($items as $index => $item)
        <a href="{{ $item['url'] ?? '#' }}"
           class="flex items-center justify-center w-6 h-6 rounded transition-all duration-150
                  {{ ($item['active'] ?? false) 
                      ? 'bg-white/20 dark:bg-zinc-900/20 text-white dark:text-zinc-900' 
                      : 'text-zinc-400 dark:text-zinc-600 hover:bg-white/10' }}">
            <span class="text-[10px]">{!! $item['icon'] ?? '🏠' !!}</span>
        </a>
    @endforeach
</div>
