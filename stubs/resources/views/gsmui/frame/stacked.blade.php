@props([
    'cards' => 3,
    'spacing' => '2',
])

@php
$cardColors = [
    'bg-zinc-200 dark:bg-zinc-700',
    'bg-zinc-300 dark:bg-zinc-600',
    'bg-zinc-400 dark:bg-zinc-500',
];
@endphp

<div class="relative" style="min-height: 200px;">
    @for($i = $cards; $i >= 1; $i--)
    <div class="absolute {{ $i === $cards ? 'z-30' : ($i === $cards - 1 ? 'z-20' : 'z-10') }}" 
         style="top: {{ ($i - 1) * 8 }}px; left: {{ ($i - 1) * 8 }}px; right: -{{ ($i - 1) * 8 }}px;">
        @if($i === 1)
        <div class="{{ $attributes->class(['rounded-xl shadow-lg']) }}">
            {{ $slot }}
        </div>
        @else
        <div class="rounded-xl {{ $cardColors[($i - 2) % 3] }} h-full"></div>
        @endif
    </div>
    @endfor
</div>
