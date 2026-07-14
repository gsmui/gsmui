@props([
    'color' => 'white',
    'inner' => true,
])

@php
$colors = [
    'white' => 'bg-gradient-to-br from-stone-100 via-stone-200 to-stone-100 border-stone-300',
    'black' => 'bg-gradient-to-br from-stone-800 via-stone-900 to-stone-800 border-stone-700',
    'green' => 'bg-gradient-to-br from-emerald-100 via-emerald-200 to-emerald-100 border-emerald-300',
];

$colorClass = $colors[$color] ?? 'bg-gradient-to-br from-stone-100 via-stone-200 to-stone-100';
@endphp

<div {{ $attributes->class([
    'p-4 rounded-xl border-2',
    $colorClass,
    'shadow-lg',
]) }}>
    @if($inner)
    <div class="bg-white dark:bg-zinc-800 dark:bg-zinc-900 rounded-lg overflow-hidden">
        {{ $slot }}
    </div>
    @else
    {{ $slot }}
    @endif
</div>
