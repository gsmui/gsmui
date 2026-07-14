@props([
    'label' => 'Information',
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
        <div class="{{ $sizeSet['icon'] }} rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
            <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
        </div>
    @endif
    <span class="font-medium text-blue-700 dark:text-blue-400 {{ $sizeSet['text'] }}">{{ $label }}</span>
</div>
