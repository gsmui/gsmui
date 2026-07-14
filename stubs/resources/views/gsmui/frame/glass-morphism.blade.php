@props([
    'blur' => 'xl',
    'opacity' => '60',
    'border' => true,
])

@php
$blurs = [
    'sm' => 'backdrop-blur-sm',
    'md' => 'backdrop-blur-md',
    'lg' => 'backdrop-blur-lg',
    'xl' => 'backdrop-blur-xl',
    '2xl' => 'backdrop-blur-2xl',
];

$blurClass = $blurs[$blur] ?? 'backdrop-blur-xl';
@endphp

<div {{ $attributes->class([
    'rounded-2xl',
    'bg-white dark:bg-zinc-800/30 dark:bg-zinc-800/30',
    $blurClass,
    $border ? 'border border-white/30 dark:border-zinc-700/30' : '',
    'shadow-2xl',
]) }}>
    {{ $slot }}
</div>
