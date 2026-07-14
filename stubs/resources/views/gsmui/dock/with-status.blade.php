@props([
    'items' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

$statusColors = [
    'online' => 'bg-green-500',
    'away' => 'bg-yellow-500',
    'busy' => 'bg-red-500',
    'offline' => 'bg-zinc-400',
];

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
            
            {{-- Status indicator --}}
            @if(isset($item['status']))
                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white dark:border-zinc-800 {{ $statusColors[$item['status']] ?? 'bg-zinc-400' }}"></div>
            @endif
        </div>
    @endforeach
</div>
