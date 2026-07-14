@props([
    'label' => 'Pending',
    'showIcon' => true,
    'size' => 'md',
])

$sizes = [
    'sm' => ['icon' => 'w-3.5 h-3.5', 'text' => 'text-xs'],
    'md' => ['icon' => 'w-4 h-4', 'text' => 'text-sm'],
    'lg' => ['icon' => 'w-5 h-5', 'text' => 'text-base'],
];
$sizeSet = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-1.5']) }}>
    @if($showIcon)
        <svg class="{{ $sizeSet['icon'] }} text-yellow-500 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
    <span class="font-medium text-yellow-700 dark:text-yellow-400 {{ $sizeSet['text'] }}">{{ $label }}</span>
</div>
