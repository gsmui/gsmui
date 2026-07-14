@props([
    'label' => 'Invisible',
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
        <span class="flex-shrink-0 w-4 h-4 rounded-full border-2 border-zinc-400 dark:border-zinc-500 flex items-center justify-center">
            <span class="w-1.5 h-1.5 rounded-full bg-zinc-400 dark:bg-zinc-500"></span>
        </span>
    @endif
    <span class="font-medium text-zinc-500 dark:text-zinc-400">{{ $label }}</span>
</div>
