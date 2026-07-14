@props([
    'value' => 0,
    'max' => 100,
    'size' => 'md',
    'label' => null,
    'showValue' => true,
    'animated' => true,
])

@php
    $sizes = ['sm' => 80, 'md' => 120, 'lg' => 160, 'xl' => 200];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 10;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
    $gradientId = 'rainbow-' . md5($attributes->getClasses() ?? uniqid());
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sizePx }} {{ $sizePx }}">
            <defs>
                <linearGradient id="{{ $gradientId }}" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#ef4444" />
                    <stop offset="17%" stop-color="#f97316" />
                    <stop offset="33%" stop-color="#eab308" />
                    <stop offset="50%" stop-color="#22c55e" />
                    <stop offset="67%" stop-color="#3b82f6" />
                    <stop offset="83%" stop-color="#8b5cf6" />
                    <stop offset="100%" stop-color="#ec4899" />
                    @if($animated)
                        <animateTransform attributeName="gradientTransform" type="rotate" from="0 0.5 0.5" to="360 0.5 0.5" dur="3s" repeatCount="indefinite" />
                    @endif
                </linearGradient>
            </defs>
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 }}" r="{{ $radius }}" fill="none" stroke="url(#{{ $gradientId }})" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" :stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white" style="font-size: {{ $sizePx / 4 }}px;">{{ round($percentage) }}%</span></div>@endif
    </div>
</div>
