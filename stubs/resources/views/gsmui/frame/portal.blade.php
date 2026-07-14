@props([
    'title' => '',
    'controls' => true,
    'color' => 'blue',
])

@php
$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'red' => 'bg-red-500',
];

$colorClass = $colors[$color] ?? 'bg-blue-500';
@endphp

<div {{ $attributes->class([
    'rounded-xl overflow-hidden',
    'border border-zinc-200 dark:border-zinc-700 dark:border-zinc-700',
    'shadow-2xl',
]) }}>
    {{-- Title bar --}}
    <div class="bg-zinc-100 dark:bg-zinc-800 dark:bg-zinc-800 px-4 py-2 flex items-center justify-between border-b border-zinc-200 dark:border-zinc-700 dark:border-zinc-700">
        @if($controls)
        <div class="flex gap-1.5">
            <div class="w-3 h-3 rounded-full bg-red-400"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
            <div class="w-3 h-3 rounded-full bg-green-400"></div>
        </div>
        @endif
        
        @if($title)
        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">{{ $title }}</span>
        @endif
        
        <div class="w-12"></div>
    </div>
    
    {{-- Content --}}
    <div class="bg-white dark:bg-zinc-800 dark:bg-zinc-900">
        {{ $slot }}
    </div>
</div>
