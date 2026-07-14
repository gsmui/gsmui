@props([
    'type' => 'admission',
    'color' => 'blue',
])

@php
$colors = [
    'blue' => 'bg-gradient-to-r from-blue-500 to-blue-600',
    'red' => 'bg-gradient-to-r from-red-500 to-red-600',
    'green' => 'bg-gradient-to-r from-green-500 to-green-600',
    'purple' => 'bg-gradient-to-r from-purple-500 to-purple-600',
];

$colorClass = $colors[$color] ?? 'bg-gradient-to-r from-blue-500 to-blue-600';
@endphp

<div class="relative flex">
    {{-- Left section --}}
    <div class="flex-1 {{ $colorClass }} text-white p-4 rounded-l-lg">
        {{ $slot }}
    </div>
    
    {{-- Perforation --}}
    <div class="relative w-4 bg-zinc-100 dark:bg-zinc-800">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 rounded-full bg-white dark:bg-zinc-900"></div>
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-4 h-4 rounded-full bg-white dark:bg-zinc-900"></div>
        <div class="absolute inset-y-4 border-l-2 border-dashed border-zinc-300 dark:border-zinc-600"></div>
    </div>
    
    {{-- Right section (stub) --}}
    <div class="w-24 {{ $colorClass }} text-white p-4 rounded-r-lg flex items-center justify-center opacity-80">
        <p class="text-xs font-bold text-center uppercase">{{ $type }}</p>
    </div>
</div>
