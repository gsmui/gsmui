@props([
    'label' => 'Processing',
    'status' => 'loading',
    'size' => 'md',
])

@php
$statuses = [
    'loading' => ['color' => 'text-blue-600 dark:text-blue-400', 'bg' => 'bg-blue-100 dark:bg-blue-900/30'],
    'success' => ['color' => 'text-green-600 dark:text-green-400', 'bg' => 'bg-green-100 dark:bg-green-900/30'],
    'error' => ['color' => 'text-red-600 dark:text-red-400', 'bg' => 'bg-red-100 dark:bg-red-900/30'],
];
$statusSet = $statuses[$status] ?? $statuses['loading'];

$sizes = [
    'sm' => 'h-5 w-5',
    'md' => 'h-6 w-6',
    'lg' => 'h-8 w-8',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    @if($status === 'loading')
        <svg class="animate-spin {{ $sizeClass }} {{ $statusSet['color'] }}" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($status === 'success')
        <div class="{{ $sizeClass }} rounded-full {{ $statusSet['bg'] }} flex items-center justify-center">
            <svg class="w-4 h-4 {{ $statusSet['color'] }}" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
        </div>
    @elseif($status === 'error')
        <div class="{{ $sizeClass }} rounded-full {{ $statusSet['bg'] }} flex items-center justify-center">
            <svg class="w-4 h-4 {{ $statusSet['color'] }}" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
    @endif
    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
</div>
