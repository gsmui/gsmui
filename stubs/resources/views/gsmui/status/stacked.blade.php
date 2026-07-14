@props([
    'items' => [],
    'size' => 'md',
])

@php
$statusColors = [
    'online' => 'bg-green-500',
    'offline' => 'bg-zinc-400',
    'away' => 'bg-yellow-500',
    'busy' => 'bg-red-500',
];
@endphp

<div {{ $attributes->class(['inline-flex items-center']) }}>
    @foreach(array_slice($items, 0, 3) as $index => $item)
        <div class="{{ $index > 0 ? '-ml-2' : '' }} relative">
            @if(isset($item['avatar']))
                <img src="{{ $item['avatar'] }}" alt="" class="w-8 h-8 rounded-full border-2 border-white dark:border-zinc-800 object-cover">
            @else
                <div class="w-8 h-8 rounded-full border-2 border-white dark:border-zinc-800 bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-600 dark:text-zinc-400">
                    {{ strtoupper(substr($item['name'] ?? '?', 0, 1)) }}
                </div>
            @endif
            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white dark:border-zinc-800 {{ $statusColors[$item['status'] ?? 'online'] }}"></span>
        </div>
    @endforeach
    
    @if(count($items) > 3)
        <div class="-ml-2 w-8 h-8 rounded-full border-2 border-white dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center text-xs font-medium text-zinc-600 dark:text-zinc-400">
            +{{ count($items) - 3 }}
        </div>
    @endif
</div>
