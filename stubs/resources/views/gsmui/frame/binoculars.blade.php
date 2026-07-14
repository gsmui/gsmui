@props([
    'color' => 'zinc',
    'connected' => true,
])

@php
$colors = [
    'zinc' => 'bg-zinc-800 border-zinc-700',
    'green' => 'bg-green-800 border-green-700',
    'blue' => 'bg-blue-800 border-blue-700',
];

$colorClass = $colors[$color] ?? 'bg-zinc-800';
@endphp

<div class="inline-flex gap-1 {{ $colorClass }} p-2 rounded-full border-2 shadow-xl">
    {{-- Left lens --}}
    <div class="w-20 h-20 rounded-full bg-white dark:bg-zinc-800/10 border-4 border-zinc-600 overflow-hidden flex items-center justify-center">
        <div class="w-full h-full">
            {{ $slot }}
        </div>
    </div>
    
    @if($connected)
    {{-- Bridge --}}
    <div class="w-4 h-20 flex items-center">
        <div class="w-full h-2 bg-zinc-600 rounded"></div>
    </div>
    @endif
    
    {{-- Right lens --}}
    <div class="w-20 h-20 rounded-full bg-white dark:bg-zinc-800/10 border-4 border-zinc-600 overflow-hidden flex items-center justify-center">
        <div class="w-full h-full">
            {{ $slot }}
        </div>
    </div>
</div>
