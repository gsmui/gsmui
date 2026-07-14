@props([
    'value' => 0,
    'max' => 100,
    'color' => 'blue',
    'label' => null,
    'showValue' => true,
    'xs' => 32, 'sm' => 48, 'md' => 80, 'lg' => 120, 'xl' => 160,
])

@php
    $colors = ['blue' => '#3b82f6', 'green' => '#22c55e', 'red' => '#ef4444', 'purple' => '#a855f7', 'orange' => '#f97316'];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(["inline-flex flex-col items-center gap-2 select-none"]) }}
    x-data="{ windowWidth: window.innerWidth }"
    x-init="window.addEventListener('resize', () => windowWidth = window.innerWidth)"
>
    @if($label)<span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>@endif
    
    {{-- xs --}}
    <div class="relative hidden max-[479px]:block" style="width: {{ $xs }}px; height: {{ $xs }}px;" x-data="{ v: {{ $value }}, m: {{ $max }}, p: {{ $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0 }} }">
        @php $r = ($xs - $xs/8) / 2; $c = 2 * pi() * $r; @endphp
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $xs }} {{ $xs }}">
            <circle cx="{{ $xs/2 }}" cy="{{ $xs/2 }}" r="{{ $r }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $xs/8 }}" />
            <circle cx="{{ $xs/2 }}" cy="{{ $xs/2 }}" r="{{ $r }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $xs/8 }}" stroke-linecap="round" :stroke-dasharray="{{ $c }}" :stroke-dashoffset="{{ $c }} - (p / 100 * {{ $c }})" class="transition-all duration-500" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white text-xs" x-text="p + '%'"></span></div>@endif
    </div>

    {{-- sm --}}
    <div class="relative hidden min-[480px]:block min-[640px]:hidden" style="width: {{ $sm }}px; height: {{ $sm }}px;">
        @php $r = ($sm - $sm/8) / 2; $c = 2 * pi() * $r; $p = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0; @endphp
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $sm }} {{ $sm }}">
            <circle cx="{{ $sm/2 }}" cy="{{ $sm/2 }}" r="{{ $r }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $sm/8 }}" />
            <circle cx="{{ $sm/2 }}" cy="{{ $sm/2 }}" r="{{ $r }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $sm/8 }}" stroke-linecap="round" stroke-dasharray="{{ $c }}" :stroke-dashoffset="{{ $c }} - ({{ $p }} / 100 * {{ $c }})" class="transition-all duration-500" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white text-sm">{{ round($p) }}%</span></div>@endif
    </div>

    {{-- md+ --}}
    <div class="relative hidden min-[640px]:block" style="width: {{ $md }}px; height: {{ $md }}px;">
        @php $r = ($md - $md/8) / 2; $c = 2 * pi() * $r; $p = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0; @endphp
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $md }} {{ $md }}">
            <circle cx="{{ $md/2 }}" cy="{{ $md/2 }}" r="{{ $r }}" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-700" stroke-width="{{ $md/8 }}" />
            <circle cx="{{ $md/2 }}" cy="{{ $md/2 }}" r="{{ $r }}" fill="none" stroke="{{ $trackColor }}" stroke-width="{{ $md/8 }}" stroke-linecap="round" stroke-dasharray="{{ $c }}" :stroke-dashoffset="{{ $c }} - ({{ $p }} / 100 * {{ $c }})" class="transition-all duration-500" />
        </svg>
        @if($showValue)<div class="absolute inset-0 flex items-center justify-center"><span class="font-bold text-zinc-900 dark:text-white">{{ round($p) }}%</span></div>@endif
    </div>
</div>
