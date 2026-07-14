@props([
    'color' => 'blue',
    'intensity' => 'md',
])

@php
$intensities = [
    'sm' => '0 0 10px',
    'md' => '0 0 20px',
    'lg' => '0 0 30px',
];

$colors = [
    'blue' => 'rgba(59, 130, 246, 0.5)',
    'green' => 'rgba(34, 197, 94, 0.5)',
    'purple' => 'rgba(168, 85, 247, 0.5)',
    'pink' => 'rgba(236, 72, 153, 0.5)',
    'cyan' => 'rgba(6, 182, 212, 0.5)',
];

$intensityValue = $intensities[$intensity] ?? '0 0 20px';
$colorValue = $colors[$color] ?? 'rgba(59, 130, 246, 0.5)';
@endphp

<div {{ $attributes->class(['rounded-xl border border-zinc-200 dark:border-zinc-700 dark:border-zinc-700']) }}
     style="box-shadow: {{ $intensityValue }} {{ $colorValue }};">
    {{ $slot }}
</div>
