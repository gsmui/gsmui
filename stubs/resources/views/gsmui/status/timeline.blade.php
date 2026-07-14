@props([
    'label' => 'Timeline',
    'items' => [],
    'size' => 'md',
])

@php
$statusColors = [
    'completed' => 'bg-green-500',
    'current' => 'bg-blue-500',
    'pending' => 'bg-zinc-300 dark:bg-zinc-600',
    'error' => 'bg-red-500',
];
@endphp

<div {{ $attributes->class(['space-y-3']) }}>
    @foreach($items as $index => $item)
        <div class="flex items-start gap-3">
            <div class="flex flex-col items-center">
                <span class="w-3 h-3 rounded-full {{ $statusColors[$item['status'] ?? 'pending'] }}"></span>
                @if(!$loop->last)
                    <div class="w-0.5 h-6 bg-zinc-200 dark:bg-zinc-700 mt-1"></div>
                @endif
            </div>
            <div class="pb-3">
                <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $item['label'] ?? '' }}</span>
                @if(isset($item['description']))
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $item['description'] }}</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
