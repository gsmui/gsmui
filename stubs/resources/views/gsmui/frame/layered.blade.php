@props([
    'layers' => 3,
    'offset' => '4',
    'color' => 'zinc',
])

@php
$layerColors = [
    'blue' => ['bg-blue-100 dark:bg-blue-900/30', 'bg-blue-200 dark:bg-blue-800/30', 'bg-blue-300 dark:bg-blue-700/30'],
    'green' => ['bg-green-100 dark:bg-green-900/30', 'bg-green-200 dark:bg-green-800/30', 'bg-green-300 dark:bg-green-700/30'],
    'purple' => ['bg-purple-100 dark:bg-purple-900/30', 'bg-purple-200 dark:bg-purple-800/30', 'bg-purple-300 dark:bg-purple-700/30'],
    'zinc' => ['bg-zinc-100 dark:bg-zinc-800 dark:bg-zinc-800', 'bg-zinc-200 dark:bg-zinc-700', 'bg-zinc-300 dark:bg-zinc-600'],
];

$colors = $layerColors[$color] ?? $layerColors['zinc'];
@endphp

<div class="relative" style="min-height: 100px;">
    @for($i = $layers; $i >= 1; $i--)
    <div class="absolute inset-0 {{ $colors[($i - 1) % 3] }} rounded-xl" 
         style="transform: translateY({{ ($i - 1) * $offset }}px) translateX({{ ($i - 1) * $offset }}px); z-index: {{ $i }};">
    </div>
    @endfor
    <div class="relative z-{{ $layers + 1 }}">
        {{ $slot }}
    </div>
</div>
