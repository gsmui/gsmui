@props([
    'items' => [],
    'position' => 'bottom',
    'columns' => 4,
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-3 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}>
    
    <div class="grid gap-2" style="grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr));">
        @foreach($items as $index => $item)
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-11 h-11 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        @endforeach
    </div>
</div>
