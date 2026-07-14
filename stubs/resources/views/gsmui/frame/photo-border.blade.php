@props([
    'style' => 'classic',
    'color' => 'white',
])

@php
$styles = [
    'classic' => 'bg-white dark:bg-zinc-800 p-3 shadow-lg',
    'matte' => 'bg-zinc-100 dark:bg-zinc-800 dark:bg-zinc-800 p-6 shadow-xl',
    'gallery' => 'bg-white dark:bg-zinc-800 p-2 border border-zinc-200 dark:border-zinc-700 shadow-md',
];

$styleClass = $styles[$style] ?? 'bg-white dark:bg-zinc-800 p-3 shadow-lg';
@endphp

<div {{ $attributes->class([
    $styleClass,
    'rounded',
]) }}>
    <div class="bg-zinc-100 dark:bg-zinc-800 dark:bg-zinc-800 overflow-hidden rounded">
        {{ $slot }}
    </div>
</div>
