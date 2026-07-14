@blaze(fold: true, unsafe: ['time'])

@props([
    'variant' => 'default',
    'time' => null,
    'battery' => 75,
    'signal' => true,
    'wifi' => true,
    'cellular' => true,
    'alignment' => null,
    'size' => null,
    'inverse' => true,
    'showCameraGap' => false,
])

@php
// Default time — 9:41 is the classic Apple keynote time
$displayTime = $time ?: '9:41';

$classes = Gsmui::classes()
    ->add('flex items-center justify-between w-full select-none')
    ->add(match ($alignment) {
        'left' => 'flex-row',
        'center' => 'flex-row',
        default => 'flex-row',
    })
    ->add(match ($size) {
        'xs' => 'h-4 text-[8px] px-1',
        'sm' => 'h-5 text-[9px] px-2',
        'lg' => 'h-7 text-xs px-4',
        default => 'h-6 text-[10px] px-3',
    })
    ;

$textClasses = match ($inverse) {
    false => 'text-white dark:text-zinc-200',
    default => 'text-black dark:text-white',
};

$iconSize = match ($size) {
    'xs' => 'text-[8px]',
    'sm' => 'text-[9px]',
    'lg' => 'text-xs',
    default => 'text-[10px]',
};

$leftWidth = match ($alignment) {
    'center' => 'w-16',
    default => 'w-12',
};

$rightWidth = match ($alignment) {
    'center' => 'w-16',
    default => 'w-16',
};

$cameraGapWidth = match ($size) {
    'xs' => 'w-10',
    'sm' => 'w-12',
    'lg' => 'w-20',
    default => 'w-16',
};

$batteryPct = min(100, max(0, (int) $battery));

$batteryColor = match (true) {
    $batteryPct <= 10 => 'bg-red-400',
    $batteryPct <= 20 => 'bg-amber-400',
    default => $inverse ? 'bg-black dark:bg-white' : 'bg-white dark:bg-zinc-200',
};
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-phone-status>
    {{-- Left side: time --}}
    <span class="font-semibold {{ $leftWidth }} text-left {{ $textClasses }} {{ $iconSize }}">
        {{ $displayTime }}
    </span>

    {{-- Center: camera notch gap or empty --}}
    @if ($alignment === 'center')
        <div class="flex items-center justify-center {{ $cameraGapWidth }}">
            @if ($showCameraGap)
                <span class="h-[6px] w-[6px] rounded-full bg-black/10 dark:bg-white/10"></span>
            @endif
        </div>
    @elseif ($alignment === 'left')
        <div class="flex-1"></div>
    @else
        <div class="flex-1"></div>
    @endif

    {{-- Right side: indicators --}}
    <div class="flex items-center gap-1 {{ $rightWidth }} justify-end {{ $textClasses }} {{ $iconSize }}">
        @if ($cellular)
            <span class="leading-none" aria-label="Cellular signal">
                @php
                $bars = match (true) { $signal === true || (is_numeric($signal) && $signal > 2) => '▂▄▆█', default => '▁▃▅▇' };
                @endphp
                {{ $bars }}
            </span>
        @endif

        @if ($wifi)
            <span class="leading-none" aria-label="WiFi">📶</span>
        @endif

        @if ($battery !== false)
            <span class="inline-flex items-center gap-0.5" aria-label="Battery {{ $battery }}%">
                <span class="relative inline-flex items-center border rounded-sm px-[1px] py-[1px] {{ $inverse ? 'border-black/40 dark:border-white/40' : 'border-white/50 dark:border-zinc-400/50' }}">
                    <span class="block h-2 {{ $batteryColor }} rounded-[0.5px]" style="width: {{ $batteryPct }}%"></span>
                </span>
                <span class="text-[6px] {{ $inverse ? 'text-black/40 dark:text-white/40' : 'text-white/50 dark:text-zinc-400/50' }}">█</span>
            </span>
        @endif
    </div>
</div>
