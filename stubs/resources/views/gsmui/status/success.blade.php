@props([
    'label' => 'Success',
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
        <div class="{{ $sizeSet['icon'] }} rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
            <svg class="w-3 h-3 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
    @endif
    <span class="font-medium text-green-700 dark:text-green-400 {{ $sizeSet['text'] }}">{{ $label }}</span>
</div>
