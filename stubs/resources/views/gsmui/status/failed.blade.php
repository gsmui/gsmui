@props([
    'label' => 'Failed',
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
        <div class="{{ $sizeSet['icon'] }} rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
            <svg class="w-3 h-3 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
    @endif
    <span class="font-medium text-red-700 dark:text-red-400 {{ $sizeSet['text'] }}">{{ $label }}</span>
</div>
