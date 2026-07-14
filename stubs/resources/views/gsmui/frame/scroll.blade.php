@props([
    'rolled' => true,
    'color' => 'amber',
])

@php
$colors = [
    'amber' => 'bg-gradient-to-b from-amber-100 via-amber-50 to-amber-100 border-amber-300',
    'cream' => 'bg-gradient-to-b from-orange-50 via-orange-25 to-orange-50 border-orange-200',
];

$colorClass = $colors[$color] ?? 'bg-gradient-to-b from-amber-100 via-amber-50 to-amber-100';
@endphp

<div class="relative">
    @if($rolled)
    {{-- Top roll --}}
    <div class="h-6 bg-gradient-to-b from-amber-700 via-amber-600 to-amber-700 rounded-t-lg shadow-md"></div>
    @endif
    
    <div {{ $attributes->class([
        $colorClass,
        'border-x-2 p-6 shadow-lg',
        $rolled ? 'rounded-none' : 'rounded-lg',
    ]) }}>
        {{ $slot }}
    </div>
    
    @if($rolled)
    {{-- Bottom roll --}}
    <div class="h-6 bg-gradient-to-b from-amber-700 via-amber-600 to-amber-700 rounded-b-lg shadow-md"></div>
    @endif
</div>
