@props([
    'texture' => 'leather',
    'inner' => true,
])

@php
$textures = [
    'leather' => 'bg-gradient-to-br from-amber-800 via-amber-900 to-amber-800 border-amber-950',
    'fabric' => 'bg-gradient-to-br from-zinc-400 via-zinc-500 to-zinc-400 border-zinc-600',
    'paper' => 'bg-gradient-to-br from-amber-50 via-amber-100 to-amber-50 border-amber-200',
];

$textureClass = $textures[$texture] ?? 'bg-gradient-to-br from-amber-800 via-amber-900 to-amber-800';
@endphp

<div {{ $attributes->class([
    'p-4 rounded-lg border-2',
    $textureClass,
    'shadow-[inset_0_2px_4px_rgba(255,255,255,0.2),0_4px_8px_rgba(0,0,0,0.3)]',
]) }}>
    @if($inner)
    <div class="bg-white dark:bg-zinc-900 rounded shadow-inner overflow-hidden">
        {{ $slot }}
    </div>
    @else
    {{ $slot }}
    @endif
</div>
