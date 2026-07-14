@props([
    'label' => 'Status',
    'status' => 'active',
    'actions' => [],
    'size' => 'md',
])

@php
$statuses = [
    'active' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400', 'dot' => 'bg-green-500'],
    'inactive' => ['bg' => 'bg-zinc-100 dark:bg-zinc-800', 'text' => 'text-zinc-600 dark:text-zinc-400', 'dot' => 'bg-zinc-400'],
    'pending' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400', 'dot' => 'bg-yellow-500'],
];
$statusSet = $statuses[$status] ?? $statuses['active'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-3 px-3 py-2 rounded-lg', $statusSet['bg']]) }}>
    <span class="w-2 h-2 rounded-full {{ $statusSet['dot'] }}"></span>
    <span class="font-medium {{ $statusSet['text'] }} text-sm">{{ $label }}</span>
    
    @if(count($actions) > 0)
        <div class="flex items-center gap-1 ml-2 pl-2 border-l border-current/20">
            @foreach($actions as $action)
                <button class="px-2 py-0.5 text-xs font-medium rounded hover:bg-black/5 dark:hover:bg-white/10 transition-colors {{ $statusSet['text'] }}">
                    {{ $action['label'] ?? '' }}
                </button>
            @endforeach
        </div>
    @endif
</div>
