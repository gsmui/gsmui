@blaze(fold: true, unsafe: ['time'])

@props([
    'time' => null,
    'battery' => 85,
    'wifi' => true,
    'inverse' => true,
    'size' => null,
    'orientation' => null,
])

@php
$displayTime = $time ?: '9:41';
$isLandscape = $orientation === 'landscape';

$classes = Gsmui::classes()
    ->add('flex items-center justify-between w-full select-none')
    ->add(match ($size) {
        'sm' => 'h-5 text-[10px] px-2',
        'lg' => $isLandscape ? 'h-8 text-sm px-5' : 'h-8 text-sm px-5',
        'xl' => $isLandscape ? 'h-9 text-base px-6' : 'h-9 text-base px-6',
        default => $isLandscape ? 'h-7 text-xs px-4' : 'h-7 text-xs px-4',
    })
    ;

$textClasses = match ($inverse) {
    false => 'text-white dark:text-zinc-300',
    default => 'text-black dark:text-white',
};

$batteryPct = min(100, max(0, (int) $battery));

$batteryColor = match (true) {
    $batteryPct <= 10 => 'bg-red-400',
    $batteryPct <= 20 => 'bg-amber-400',
    default => $inverse ? 'bg-black dark:bg-white' : 'bg-white dark:bg-zinc-300',
};

$batteryHeight = match ($size) {
    'sm' => 'h-2.5',
    'lg' => 'h-3.5',
    'xl' => 'h-4',
    default => 'h-3',
};

$batteryBorder = match ($size) {
    'sm' => 'px-[1.5px] py-[1.5px]',
    'lg' => 'px-[2px] py-[2px]',
    'xl' => 'px-[2.5px] py-[2.5px]',
    default => 'px-[2px] py-[2px]',
};
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-tablet-status>
    {{-- Left: time --}}
    <span class="font-semibold {{ $textClasses }}">
        {{ $displayTime }}
    </span>

    {{-- Center spacer --}}
    <div class="flex-1"></div>

    {{-- Right: indicators --}}
    <div class="flex items-center gap-2 {{ $textClasses }}">
        @if ($wifi)
            <span class="leading-none" aria-label="WiFi">📶</span>
        @endif

        @if ($battery !== false)
            <span class="inline-flex items-center gap-0.5" aria-label="Battery {{ $battery }}%">
                <span class="relative inline-flex items-center border rounded-sm {{ $batteryBorder }} {{ $inverse ? 'border-black/40 dark:border-white/40' : 'border-white/50 dark:border-zinc-400/50' }}">
                    <span class="block {{ $batteryHeight }} {{ $batteryColor }}" style="width: {{ $batteryPct }}%"></span>
                </span>
                <span class="{{ $batteryHeight == 'h-2.5' ? 'text-[7px]' : ($batteryHeight == 'h-3.5' ? 'text-[9px]' : ($batteryHeight == 'h-4' ? 'text-[10px]' : 'text-[8px]')) }} {{ $inverse ? 'text-black/40 dark:text-white/40' : 'text-white/50 dark:text-zinc-400/50' }}">▐</span>
            </span>
        @endif
    </div>
</div>
