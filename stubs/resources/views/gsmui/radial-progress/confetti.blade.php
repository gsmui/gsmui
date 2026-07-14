@props([
    'value' => 100,
    'max' => 100,
    'size' => 'md',
    'showValue' => true,
    'celebrate' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 10;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}
    x-data="{ show: false }" x-init="if ({{ $percentage }} >= 100) { setTimeout(() => show = true, 500); }"
>
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="#22c55e" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;">{{ round($percentage) }}%</span></div>@endif
        {{-- Confetti --}}
        <template x-if="show && {{ $celebrate ? 'true' : 'false' }}">
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                @foreach(range(1, 20) as $i)
                    <div class="absolute w-2 h-2 rounded-full" style="left: {{ rand(10, 90) }}%; top: {{ rand(10, 90) }}%; background: {{ ['#ef4444','#f97316','#eab308','#22c55e','#3b82f6','#8b5cf6','#ec4899'][array_rand(['#ef4444','#f97316','#eab308','#22c55e','#3b82f6','#8b5cf6','#ec4899'])] }}; animation: confetti-{{ $i }} {{ rand(1, 3) }}s ease-out forwards;"></div>
                @endforeach
            </div>
        </template>
    </div>
</div>

<style>
@for($i = 1; $i <= 20; $i++)
    @keyframes confetti-{{ $i }} {
        0% { transform: translate(0, 0) rotate(0deg); opacity: 1; }
        100% { transform: translate({{ rand(-50, 50) }}px, {{ rand(-80, -20) }}px) rotate({{ rand(180, 720) }}deg); opacity: 0; }
    }
@endfor
</style>
