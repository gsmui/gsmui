@props([
    'label' => 'Away',
    'showDot' => true,
    'size' => 'md',
])

$sizes = [
    'sm' => ['dot' => 'w-1.5 h-1.5', 'text' => 'text-xs'],
    'md' => ['dot' => 'w-2 h-2', 'text' => 'text-sm'],
    'lg' => ['dot' => 'w-2.5 h-2.5', 'text' => 'text-base'],
];
$sizeSet = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-1.5']) }}>
    @if($showDot)
        <span class="flex-shrink-0 inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
    @endif
    <span class="font-medium text-yellow-700 dark:text-yellow-400 {{ $sizeSet['text'] }}">{{ $label }}</span>
</div>
