@props([
    'shade' => 'oak',
    'inner' => true,
])

@php
$shades = [
    'oak' => 'bg-amber-800 border-amber-900',
    'pine' => 'bg-amber-600 border-amber-700',
    'walnut' => 'bg-amber-950 border-amber-950',
    'white' => 'bg-stone-200 border-stone-300',
];

$shadeClass = $shades[$shade] ?? 'bg-amber-800 border-amber-900';
@endphp

<div {{ $attributes->class([
    'p-3 rounded-lg border-4',
    $shadeClass,
    'shadow-xl',
]) }}>
    @if($inner)
    <div class="bg-white dark:bg-zinc-800 dark:bg-zinc-900 rounded overflow-hidden">
        {{ $slot }}
    </div>
    @else
    {{ $slot }}
    @endif
</div>
