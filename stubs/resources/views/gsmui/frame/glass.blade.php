@props([
    'blur' => 'md',
    'opacity' => '70',
    'border' => true,
])

@php
$blurs = [
    'sm' => 'backdrop-blur-sm',
    'md' => 'backdrop-blur-md',
    'lg' => 'backdrop-blur-lg',
    'xl' => 'backdrop-blur-xl',
];

$blurClass = $blurs[$blur] ?? 'backdrop-blur-md';
@endphp

<div {{ $attributes->class([
    'bg-white/70 dark:bg-zinc-800/70',
    $blurClass,
    $border ? 'border border-white/20 dark:border-zinc-700/50' : '',
    'rounded-xl shadow-xl',
]) }}>
    {{ $slot }}
</div>
