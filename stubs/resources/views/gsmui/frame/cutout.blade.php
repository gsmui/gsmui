@props([
    'size' => 'md',
    'corners' => 'all',
])

@php
$sizes = [
    'sm' => '12px',
    'md' => '20px',
    'lg' => '32px',
];

$sizeValue = $sizes[$size] ?? '20px';
@endphp

<div {{ $attributes->class(['relative']) }}>
    {{-- Corner Cutouts --}}
    @if(in_array($corners, ['all', 'top-left']))
    <div class="absolute -top-px -left-px w-0 h-0 border-t-[{{ $sizeValue }}] border-l-[{{ $sizeValue }}] border-t-white dark:border-t-zinc-900 border-l-transparent"></div>
    @endif
    @if(in_array($corners, ['all', 'top-right']))
    <div class="absolute -top-px -right-px w-0 h-0 border-t-[{{ $sizeValue }}] border-r-[{{ $sizeValue }}] border-t-white dark:border-t-zinc-900 border-r-transparent"></div>
    @endif
    @if(in_array($corners, ['all', 'bottom-left']))
    <div class="absolute -bottom-px -left-px w-0 h-0 border-b-[{{ $sizeValue }}] border-l-[{{ $sizeValue }}] border-b-white dark:border-b-zinc-900 border-l-transparent"></div>
    @endif
    @if(in_array($corners, ['all', 'bottom-right']))
    <div class="absolute -bottom-px -right-px w-0 h-0 border-b-[{{ $sizeValue }}] border-r-[{{ $sizeValue }}] border-b-white dark:border-b-zinc-900 border-r-transparent"></div>
    @endif
    
    <div class="rounded-xl overflow-hidden">
        {{ $slot }}
    </div>
</div>
