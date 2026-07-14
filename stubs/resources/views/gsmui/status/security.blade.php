@props([
    'level' => 'medium',
    'size' => 'md',
])

@php
$levels = [
    'low' => [
        'label' => 'Low Security',
        'color' => 'bg-red-500',
        'textColor' => 'text-red-700 dark:text-red-400',
        'bars' => 1,
    ],
    'medium' => [
        'label' => 'Medium Security',
        'color' => 'bg-yellow-500',
        'textColor' => 'text-yellow-700 dark:text-yellow-400',
        'bars' => 2,
    ],
    'high' => [
        'label' => 'High Security',
        'color' => 'bg-green-500',
        'textColor' => 'text-green-700 dark:text-green-400',
        'bars' => 3,
    ],
    'maximum' => [
        'label' => 'Maximum Security',
        'color' => 'bg-blue-500',
        'textColor' => 'text-blue-700 dark:text-blue-400',
        'bars' => 4,
    ],
];

$sizes = [
    'sm' => 'h-2 w-1.5 gap-0.5 text-[10px]',
    'md' => 'h-3 w-2 gap-0.5 text-xs',
    'lg' => 'h-4 w-2.5 gap-1 text-sm',
];

$levelData = $levels[$level] ?? $levels['medium'];
$sizeClass = $sizes[$size] ?? 'h-3 w-2 gap-0.5 text-xs';
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-1.5', $levelData['textColor']]) }}>
    <div class="flex items-end gap-px">
        @for($i = 1; $i <= 4; $i++)
            <div @class([
                'rounded-sm',
                $i <= $levelData['bars'] ? $levelData['color'] : 'bg-zinc-200 dark:bg-zinc-700',
            ]) style="width: {{ $size }}; height: {{ 40 + ($i * 15) }}%"></div>
        @endfor
    </div>
    <span class="font-medium">{{ $levelData['label'] }}</span>
</div>
