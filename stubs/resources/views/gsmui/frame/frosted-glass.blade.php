@props([
    'opacity' => '80',
    'blur' => 'xl',
])

@php
$opacities = [
    '60' => 'bg-white/60 dark:bg-zinc-800/60',
    '70' => 'bg-white/70 dark:bg-zinc-800/70',
    '80' => 'bg-white/80 dark:bg-zinc-800/80',
    '90' => 'bg-white/90 dark:bg-zinc-800/90',
];

$blurs = [
    'sm' => 'backdrop-blur-sm',
    'md' => 'backdrop-blur-md',
    'lg' => 'backdrop-blur-lg',
    'xl' => 'backdrop-blur-xl',
];

$opacityClass = $opacities[$opacity] ?? 'bg-white/80 dark:bg-zinc-800/80';
$blurClass = $blurs[$blur] ?? 'backdrop-blur-xl';
@endphp

<div {{ $attributes->class([
    'rounded-xl',
    $opacityClass,
    $blurClass,
    'border border-white/20 dark:border-zinc-700/50',
    'shadow-xl',
]) }}>
    {{ $slot }}
</div>
