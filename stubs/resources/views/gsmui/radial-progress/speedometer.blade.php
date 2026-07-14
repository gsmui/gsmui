@props([
    'value' => 50,
    'min' => 0,
    'max' => 100,
    'size' => 'md',
    'label' => null,
    'showValue' => true,
    'zones' => [
        ['from' => 0, 'to' => 33, 'color' => '#22c55e'],
        ['from' => 33, 'to' => 66, 'color' => '#f59e0b'],
        ['from' => 66, 'to' => 100, 'color' => '#ef4444'],
    ],
])

@php
    $sizes = ['sm' => 120, 'md' => 160, 'lg' => 200, 'xl' => 240];
    $sizePx = $sizes[$size] ?? $sizes['md'];
    $strokeWidth = 20;
    $radius = ($sizePx - $strokeWidth) / 2;
    $circumference = pi() * $radius;
    $percentage = $max > $min ? min(100, max(0, (($value - $min) / ($max - $min)) * 100)) : 0;
    $offset = $circumference - ($percentage / 100) * $circumference;
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    <div class="relative" style="width: {{ $sizePx }}px; height: {{ $sizePx / 2 + 30 }}px;">
        <svg class="w-full h-full" viewBox="0 0 {{ $sizePx }} {{ $sizePx / 2 + 30 }}">
            {{-- Background arcs for zones --}}
            @foreach($zones as $zone)
                @php
                    $zoneRadius = $radius;
                    $zoneStart = ($zone['from'] / 100) * pi();
                    $zoneEnd = ($zone['to'] / 100) * pi();
                @endphp
            @endforeach
            <path d="M {{ $strokeWidth / 2 }} {{ $sizePx / 2 + 10 }} A {{ $radius }} {{ $radius }} 0 0 1 {{ $sizePx - $strokeWidth / 2 }} {{ $sizePx / 2 + 10 }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" />
            <path d="M {{ $strokeWidth / 2 }} {{ $sizePx / 2 + 10 }} A {{ $radius }} {{ $radius }} 0 0 1 {{ $sizePx - $strokeWidth / 2 }} {{ $sizePx / 2 + 10 }}" fill="none" stroke="#3b82f6" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-dasharray="{{ $circumference }}" :stroke-dashoffset="{{ $offset }}" class="transition-all duration-500" />
            {{-- Needle --}}
            @php
                $needleAngle = -90 + ($percentage / 100) * 180;
                $needleLength = $radius * 0.7;
            @endphp
            <line x1="{{ $sizePx / 2 }}" y1="{{ $sizePx / 2 + 10 }}" x2="{{ $sizePx / 2 }}" y2="{{ $sizePx / 2 + 10 - $needleLength }}" stroke="#1f2937" stroke-width="3" stroke-linecap="round" :transform="`rotate({{ $needleAngle }} {{ $sizePx / 2 }} {{ $sizePx / 2 + 10 }})`" class="transition-all duration-500" />
            <circle cx="{{ $sizePx / 2 }}" cy="{{ $sizePx / 2 + 10 }}" r="6" fill="#1f2937" />
        </svg>
        @if($showValue)<div class="absolute inset-x-0 bottom-0 flex justify-center"><span class="text-2xl font-bold text-zinc-900 dark:text-white">{{ round($value) }}</span></div>@endif
    </div>
</div>
