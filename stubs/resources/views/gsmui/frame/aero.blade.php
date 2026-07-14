@props([
    'blur' => 'lg',
    'opacity' => '70',
])

@php
$blurs = [
    'sm' => 'backdrop-blur-sm',
    'md' => 'backdrop-blur-md',
    'lg' => 'backdrop-blur-lg',
    'xl' => 'backdrop-blur-xl',
];

$blurClass = $blurs[$blur] ?? 'backdrop-blur-lg';
@endphp

<div {{ $attributes->class([
    'rounded-xl',
    'bg-white/40 dark:bg-zinc-800/40',
    $blurClass,
    'border border-white/30 dark:border-zinc-700/30',
    'shadow-[0_8px_32px_rgba(0,0,0,0.1)]',
    'overflow-hidden',
]) }}>
    {{-- Reflection effect --}}
    <div class="absolute inset-0 bg-gradient-to-b from-white/20 to-transparent pointer-events-none"></div>
    <div class="relative z-10">
        {{ $slot }}
    </div>
</div>
