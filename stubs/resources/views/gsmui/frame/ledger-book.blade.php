@props([
    'lines' => true,
    'color' => 'blue',
])

@php
$colors = [
    'blue' => 'bg-blue-50 dark:bg-blue-950/30 border-blue-200 dark:border-blue-800',
    'green' => 'bg-green-50 dark:bg-green-950/30 border-green-200 dark:border-green-800',
    'yellow' => 'bg-yellow-50 dark:bg-yellow-950/30 border-yellow-200 dark:border-yellow-800',
];

$colorClass = $colors[$color] ?? 'bg-blue-50 border-blue-200';
@endphp

<div {{ $attributes->class([
    $colorClass,
    'border rounded-lg shadow-lg p-4 relative',
]) }}>
    @if($lines)
    {{-- Ruled lines --}}
    <div class="absolute inset-0 pointer-events-none">
        @for($i = 1; $i <= 12; $i++)
        <div class="absolute left-4 right-4 h-px bg-current opacity-10" style="top: {{ $i * 32 }}px;"></div>
        @endfor
        <div class="absolute left-12 top-0 bottom-0 w-px bg-red-300 dark:bg-red-700"></div>
    </div>
    @endif
    
    <div class="relative z-10">
        {{ $slot }}
    </div>
</div>
