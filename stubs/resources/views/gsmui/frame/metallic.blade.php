@props([
    'finish' => 'silver',
    'bevel' => true,
])

@php
$finishes = [
    'silver' => 'bg-gradient-to-br from-zinc-200 via-zinc-300 to-zinc-200 border-zinc-400',
    'gold' => 'bg-gradient-to-br from-amber-200 via-amber-300 to-amber-200 border-amber-400',
    'copper' => 'bg-gradient-to-br from-orange-200 via-orange-300 to-orange-200 border-orange-400',
    'chrome' => 'bg-gradient-to-br from-zinc-100 via-white to-zinc-100 border-zinc-300',
];

$finishClass = $finishes[$finish] ?? 'bg-gradient-to-br from-zinc-200 via-zinc-300 to-zinc-200';
@endphp

<div {{ $attributes->class([
    'rounded-lg border-2',
    $finishClass,
    $bevel ? 'shadow-[inset_2px_2px_4px_rgba(255,255,255,0.5),inset_-2px_-2px_4px_rgba(0,0,0,0.1)]' : '',
]) }}>
    {{ $slot }}
</div>
