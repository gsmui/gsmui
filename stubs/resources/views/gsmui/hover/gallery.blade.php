@blaze(fold: true, unsafe: ['caption'])

@props([
    'effect' => 'zoom',
    'src' => null,
    'alt' => null,
    'caption' => null,
    'overlayColor' => null,
    'tintColor' => null,
    'radius' => null,
    'aspect' => null,
    'duration' => null,
])

@php
$durationMap = match ($duration) {
    'fast' => 'duration-200',
    'slow' => 'duration-500',
    'very-slow' => 'duration-700',
    default => 'duration-300',
};

$radiusClass = match ($radius) {
    'none' => 'rounded-none',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl',
    'full' => 'rounded-full',
    default => 'rounded-lg',
};

$aspectClass = match ($aspect) {
    'square' => 'aspect-square',
    'video' => 'aspect-video',
    'portrait' => 'aspect-[3/4]',
    'ultrawide' => 'aspect-[21/9]',
    default => '',
};

$hasCaption = $caption || $slot?->caption ?? false;
$showDescription = ($slot?->description ?? false) !== false;

// Safe tint color fallback
$safeTint = $tintColor ?: 'blue';

// === Image transform effects ===
$imageTransform = match ($effect) {
    'zoom' => 'group-hover:scale-110',
    'zoom-lg' => 'group-hover:scale-125',
    'zoom-out' => 'scale-110 group-hover:scale-100',
    'pan-up' => 'group-hover:-translate-y-2 group-hover:scale-105',
    'pan-down' => 'group-hover:translate-y-2 group-hover:scale-105',
    'pan-left' => 'group-hover:-translate-x-2 group-hover:scale-105',
    'pan-right' => 'group-hover:translate-x-2 group-hover:scale-105',
    'pan-diagonal' => 'group-hover:translate-x-1 group-hover:-translate-y-1 group-hover:scale-110',
    'rotate-zoom' => 'group-hover:scale-110 group-hover:rotate-2',
    'rotate-zoom-ccw' => 'group-hover:scale-110 group-hover:-rotate-2',
    'tilt-zoom' => 'group-hover:scale-105 group-hover:-translate-y-1 group-hover:rotate-1',
    'blur' => 'group-hover:blur-none',
    'blur-in' => 'blur-sm group-hover:blur-none group-hover:scale-105',
    'grayscale' => 'group-hover:grayscale-0',
    'grayscale-in' => 'grayscale group-hover:grayscale-0 group-hover:scale-105',
    'saturate' => 'group-hover:saturate-150',
    'sepia' => 'group-hover:sepia-0',
    'sepia-in' => 'sepia group-hover:sepia-0',
    'brighten' => 'group-hover:brightness-110',
    'darken' => 'group-hover:brightness-75',
    'contrast' => 'group-hover:contrast-125',
    'vintage' => 'sepia group-hover:sepia-0 group-hover:saturate-110 group-hover:contrast-110',
    default => 'group-hover:scale-110',
};

// === Overlay effects ===
$overlayEffect = match ($effect) {
    'overlay' => 'bg-black/0 group-hover:bg-black/30',
    'overlay-dark' => 'bg-black/0 group-hover:bg-black/50',
    'overlay-light' => 'bg-white/0 group-hover:bg-white/20',
    'overlay-gradient' => "bg-gradient-to-t from-black/0 via-black/0 to-black/0 group-hover:from-black/60 group-hover:via-black/20 group-hover:to-transparent",
    'overlay-left' => "bg-gradient-to-r from-black/0 to-transparent group-hover:from-black/50 group-hover:to-transparent",
    'overlay-right' => "bg-gradient-to-l from-black/0 to-transparent group-hover:from-black/50 group-hover:to-transparent",
    'overlay-top' => "bg-gradient-to-b from-black/0 to-transparent group-hover:from-black/50 group-hover:to-transparent",
    'tint' => "bg-{$safeTint}-500/0 group-hover:bg-{$safeTint}-500/30",
    'tint-blue' => "bg-blue-600/0 group-hover:bg-blue-600/30",
    'tint-green' => "bg-green-600/0 group-hover:bg-green-600/30",
    'tint-red' => "bg-red-600/0 group-hover:bg-red-600/30",
    'tint-amber' => "bg-amber-600/0 group-hover:bg-amber-600/30",
    'tint-violet' => "bg-violet-600/0 group-hover:bg-violet-600/30",
    'tint-rose' => "bg-rose-600/0 group-hover:bg-rose-600/30",
    'tint-cyan' => "bg-cyan-600/0 group-hover:bg-cyan-600/30",
    'blur-overlay' => "backdrop-blur-none group-hover:backdrop-blur-sm bg-white/0 group-hover:bg-white/10",
    'spotlight' => "bg-black/0 group-hover:bg-black/10",
    'reveal-caption' => '',
    'polaroid' => '',
    'stack' => '',
    default => '',
};

// === Caption effects ===
$captionEffect = match ($effect) {
    'caption-fade', 'overlay', 'overlay-dark', 'overlay-light', 'tint', 'tint-blue', 'tint-green', 'tint-red', 'tint-amber', 'tint-violet', 'tint-rose', 'tint-cyan', 'spotlight' => 'opacity-0 group-hover:opacity-100',
    'caption-slide-up' => 'translate-y-2 group-hover:translate-y-0 opacity-0 group-hover:opacity-100',
    'caption-slide-down' => '-translate-y-2 group-hover:translate-y-0 opacity-0 group-hover:opacity-100',
    'caption-slide-left' => 'translate-x-2 group-hover:translate-x-0 opacity-0 group-hover:opacity-100',
    'caption-slide-right' => '-translate-x-2 group-hover:translate-x-0 opacity-0 group-hover:opacity-100',
    'caption-zoom' => 'scale-90 group-hover:scale-100 opacity-0 group-hover:opacity-100',
    'caption-reveal' => 'opacity-0 group-hover:opacity-100',
    default => $hasCaption ? 'opacity-0 group-hover:opacity-100' : '',
};

// === Special gallery wrapper effects (applied to the root element) ===
$wrapperClass = match ($effect) {
    'polaroid' => 'p-3 pb-8 bg-white dark:bg-zinc-800 shadow-lg rotate-1 group-hover:rotate-0 group-hover:-translate-y-1 group-hover:shadow-xl transition-all duration-300',
    'polaroid-reverse' => 'p-3 pb-8 bg-white dark:bg-zinc-800 shadow-lg -rotate-1 group-hover:rotate-0 group-hover:-translate-y-1 group-hover:shadow-xl transition-all duration-300',
    'stack' => 'shadow-lg group-hover:-translate-y-2 group-hover:shadow-2xl transition-all duration-300',
    'frame' => 'border-4 border-white dark:border-zinc-700 shadow-lg group-hover:shadow-xl transition-all duration-300',
    default => '',
};
@endphp

<div
    {{ $attributes->class('group relative inline-flex overflow-hidden ' . $radiusClass . ' ' . $aspectClass . ' ' . $wrapperClass) }}
    data-gsmui-hover-gallery
>
    {{-- Image --}}
    @if ($src)
        <img
            class="w-full h-full object-cover transition-all {{ $durationMap }} ease-out {{ $imageTransform }} {{ $radiusClass }}"
            src="{{ $src }}"
            alt="{{ $alt ?? '' }}"
        />
    @else
        <div class="w-full h-full transition-all {{ $durationMap }} ease-out {{ $imageTransform }} {{ $radiusClass }} {{ $aspectClass }}">
            {{ $slot }}
        </div>
    @endif

    {{-- Overlay --}}
    @if ($overlayEffect)
        <div class="absolute inset-0 transition-all {{ $durationMap }} ease-out {{ $overlayEffect }} {{ $radiusClass }}"></div>
    @endif

    {{-- Spotlight mask (applied inline since it's not a standard class) --}}
    @if ($effect === 'spotlight')
        <style>
            [data-gsmui-hover-gallery]:has(.spotlight-mask) .spotlight-mask {
                -webkit-mask-image: radial-gradient(circle at 50% 50%, transparent 60%, black 80%);
                mask-image: radial-gradient(circle at 50% 50%, transparent 60%, black 80%);
            }
            [data-gsmui-hover-gallery]:has(.spotlight-mask):hover .spotlight-mask {
                -webkit-mask-image: radial-gradient(circle at 50% 50%, transparent 40%, black 70%);
                mask-image: radial-gradient(circle at 50% 50%, transparent 40%, black 70%);
            }
        </style>
    @endif

    {{-- Caption --}}
    @if ($hasCaption && $captionEffect)
        <div class="absolute inset-x-0 bottom-0 p-4 transition-all {{ $durationMap }} ease-out {{ $captionEffect }}">
            <div class="text-white text-sm font-medium drop-shadow-lg">
                {{ $caption ?? $slot->caption ?? '' }}
            </div>
        </div>
    @endif

    {{-- Description overlay --}}
    @if ($showDescription)
        <div class="absolute inset-0 flex items-center justify-center p-6 transition-all {{ $durationMap }} ease-out {{ $captionEffect }}">
            <div class="text-white text-center text-sm drop-shadow-lg">
                {{ $slot->description }}
            </div>
        </div>
    @endif
</div>
