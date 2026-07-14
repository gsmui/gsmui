@props([
    'size' => 'md',
    'color' => 'blue',
    'anglePosition' => 'all',
])

@php
$sizes = [
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
    'xl' => 'p-12',
];

$colors = [
    'blue' => 'border-blue-500',
    'green' => 'border-green-500',
    'purple' => 'border-purple-500',
    'red' => 'border-red-500',
    'zinc' => 'border-zinc-500',
];

$sizeClass = $sizes[$size] ?? 'p-6';
$colorClass = $colors[$color] ?? 'border-blue-500';
@endphp

<div {{ $attributes->class(['relative', $sizeClass]) }}>
    {{-- Top Left Angle --}}
    @if(in_array($anglePosition, ['all', 'top-left', 'top']))
    <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 {{ $colorClass }}"></div>
    @endif
    
    {{-- Top Right Angle --}}
    @if(in_array($anglePosition, ['all', 'top-right', 'top']))
    <div class="absolute top-0 right-0 w-8 h-8 border-t-2 border-r-2 {{ $colorClass }}"></div>
    @endif
    
    {{-- Bottom Left Angle --}}
    @if(in_array($anglePosition, ['all', 'bottom-left', 'bottom']))
    <div class="absolute bottom-0 left-0 w-8 h-8 border-b-2 border-l-2 {{ $colorClass }}"></div>
    @endif
    
    {{-- Bottom Right Angle --}}
    @if(in_array($anglePosition, ['all', 'bottom-right', 'bottom']))
    <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 {{ $colorClass }}"></div>
    @endif
    
    {{ $slot }}
</div>
