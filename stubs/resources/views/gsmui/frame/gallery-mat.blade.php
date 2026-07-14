@props([
    'matColor' => 'white',
    'borderWidth' => '4',
])

@php
$matColors = [
    'white' => 'bg-white dark:bg-zinc-800 dark:bg-zinc-100 dark:bg-zinc-800',
    'black' => 'bg-black dark:bg-zinc-900',
    'cream' => 'bg-cream dark:bg-amber-50',
    'grey' => 'bg-zinc-300 dark:bg-zinc-600',
];

$matColorClass = $matColors[$matColor] ?? 'bg-white dark:bg-zinc-800';
@endphp

<div {{ $attributes->class([
    $matColorClass,
    'p-4 rounded shadow-xl border border-zinc-200 dark:border-zinc-700 dark:border-zinc-700',
]) }}>
    <div class="bg-zinc-100 dark:bg-zinc-800 dark:bg-zinc-800 overflow-hidden rounded shadow-inner">
        {{ $slot }}
    </div>
</div>
