@props([
    'label' => 'Online',
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
        <span class="flex-shrink-0 relative">
            <span class="absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75 animate-ping"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
        </span>
    @endif
    <span class="font-medium text-green-700 dark:text-green-400 {{ $sizeSet['text'] }}">{{ $label }}</span>
</div>
