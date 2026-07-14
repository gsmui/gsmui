@props([
    'value' => null,
    'max' => 100,
    'size' => 'md',
    'loading' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 10;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}
    x-data="{ loading: {{ $loading ? 'true' : 'false' }} }"
>
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            @if($loading)
                <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" class="animate-pulse" />
            @else
                <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
                <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="#3b82f6" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $circumference }} - ({{ $value ?? 0 }} / {{ $max }} * {{ $circumference }})" class="transition-all duration-500" />
            @endif
        </svg>
        @if(!$loading && $value !== null)
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;">{{ round(($value / $max) * 100) }}%</span>
            </div>
        @endif
    </div>
    <button @click="loading = !loading" class="text-xs text-blue-500 hover:underline">Toggle Loading</button>
</div>
