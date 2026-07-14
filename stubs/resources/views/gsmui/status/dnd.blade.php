@props([
    'label' => 'Do Not Disturb',
    'showIcon' => true,
    'size' => 'md',
])

$sizes = [
    'sm' => 'text-xs gap-1',
    'md' => 'text-sm gap-1.5',
    'lg' => 'text-base gap-2',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class(['inline-flex items-center', $sizeClass]) }}>
    @if($showIcon)
        <span class="flex-shrink-0 w-4 h-4 rounded-full bg-red-500 flex items-center justify-center">
            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
            </svg>
        </span>
    @endif
    <span class="font-medium text-red-700 dark:text-red-400">{{ $label }}</span>
</div>
