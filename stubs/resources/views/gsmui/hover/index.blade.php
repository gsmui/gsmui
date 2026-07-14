@blaze(fold: true)

@props([
    'effect' => 'lift',
    'duration' => null,
    'scale' => null,
    'translateY' => null,
    'translateX' => null,
    'rotate' => null,
    'shadowSize' => null,
    'glowColor' => null,
    'borderColor' => null,
    'bgColor' => null,
    'textColor' => null,
    'opacity' => null,
    'radius' => null,
    'as' => null,
    'href' => null,
    'disabled' => false,
])

@php
$tag = $as ?: ($href ? 'a' : 'div');

$durationMap = match ($duration) {
    'fast' => 'duration-100',
    'slow' => 'duration-500',
    'very-slow' => 'duration-700',
    default => 'duration-200',
};

$easing = 'ease-out';

// === 2D Transforms & Motion ===
$effect2D = match ($effect) {
    'lift' => "-translate-y-1 scale-[1.02]",
    'lift-lg' => "-translate-y-2 scale-[1.04]",
    'press' => "translate-y-px scale-[0.98]",
    'press-lg' => "translate-y-0.5 scale-[0.96]",
    'scale' => "scale-105",
    'scale-lg' => "scale-110",
    'scale-down' => "scale-95",
    'grow' => "scale-x-110 scale-y-105",
    'shrink' => "scale-x-95 scale-y-95",
    'slide-up' => "-translate-y-1",
    'slide-down' => "translate-y-1",
    'slide-left' => "-translate-x-1",
    'slide-right' => "translate-x-1",
    'slide-up-lg' => "-translate-y-2",
    'slide-down-lg' => "translate-y-2",
    'slide-left-lg' => "-translate-x-2",
    'slide-right-lg' => "translate-x-2",
    'skew' => "skew-x-1 skew-y-1",
    'skew-lg' => "skew-x-3 skew-y-1",
    'skew-x' => "skew-x-2",
    'skew-y' => "skew-y-2",
    'rotate' => "rotate-1",
    'rotate-lg' => "rotate-3",
    'rotate-cw' => "rotate-2",
    'rotate-ccw' => "-rotate-2",
    'wobble' => "-translate-y-0.5 scale-[1.01]",
    'bounce' => "-translate-y-1 scale-105",
    'pulse' => "scale-105 animate-pulse",
    default => "-translate-y-1 scale-[1.02]",
};

// === Shadows ===
$shadowEffect = match ($effect) {
    'shadow' => "shadow-md",
    'shadow-lg' => "shadow-lg",
    'shadow-xl' => "shadow-xl",
    'shadow-2xl' => "shadow-2xl",
    'shadow-colored' => "shadow-lg shadow-blue-500/20 dark:shadow-blue-500/10",
    'shadow-deep' => "shadow-2xl shadow-zinc-900/20 dark:shadow-black/40",
    'glow' => "shadow-lg shadow-zinc-900/10 dark:shadow-white/10 ring-1 ring-black/5 dark:ring-white/10",
    'glow-blue' => "shadow-lg shadow-blue-500/30 dark:shadow-blue-500/20 ring-1 ring-blue-400/30",
    'glow-green' => "shadow-lg shadow-green-500/30 dark:shadow-green-500/20 ring-1 ring-green-400/30",
    'glow-red' => "shadow-lg shadow-red-500/30 dark:shadow-red-500/20 ring-1 ring-red-400/30",
    'glow-amber' => "shadow-lg shadow-amber-500/30 dark:shadow-amber-500/20 ring-1 ring-amber-400/30",
    'glow-violet' => "shadow-lg shadow-violet-500/30 dark:shadow-violet-500/20 ring-1 ring-violet-400/30",
    'glow-cyan' => "shadow-lg shadow-cyan-500/30 dark:shadow-cyan-500/20 ring-1 ring-cyan-400/30",
    'glow-rose' => "shadow-lg shadow-rose-500/30 dark:shadow-rose-500/20 ring-1 ring-rose-400/30",
    default => $effect === 'lift' || $effect === 'lift-lg' || $effect === 'bounce' ? "shadow-lg" : "",
};

// === Border & Ring ===
$borderEffect = match ($effect) {
    'border' => "ring-2 ring-zinc-400/50 dark:ring-zinc-500/50",
    'border-primary' => "ring-2 ring-blue-500/60",
    'border-accent' => "ring-2 ring-violet-500/60",
    'border-success' => "ring-2 ring-green-500/60",
    'border-danger' => "ring-2 ring-red-500/60",
    'border-warning' => "ring-2 ring-amber-500/60",
    'border-info' => "ring-2 ring-cyan-500/60",
    'outline' => "ring-2 ring-offset-2 ring-offset-white dark:ring-offset-zinc-900 ring-zinc-400/60",
    'outline-primary' => "ring-2 ring-offset-2 ring-offset-white dark:ring-offset-zinc-900 ring-blue-500/60",
    default => "",
};

// === Background & Color ===
$bgEffect = match ($effect) {
    'bg-darken' => "brightness-90",
    'bg-lighten' => "brightness-110",
    'bg-highlight' => "bg-zinc-100 dark:bg-zinc-800",
    'bg-primary' => "bg-blue-50 dark:bg-blue-900/30",
    'bg-success' => "bg-green-50 dark:bg-green-900/30",
    'bg-danger' => "bg-red-50 dark:bg-red-900/30",
    'bg-amber' => "bg-amber-50 dark:bg-amber-900/30",
    'bg-violet' => "bg-violet-50 dark:bg-violet-900/30",
    'bg-cyan' => "bg-cyan-50 dark:bg-cyan-900/30",
    'bg-rose' => "bg-rose-50 dark:bg-rose-900/30",
    'color-primary' => "text-blue-600 dark:text-blue-400",
    'color-success' => "text-green-600 dark:text-green-400",
    'color-danger' => "text-red-600 dark:text-red-400",
    'color-amber' => "text-amber-600 dark:text-amber-400",
    'color-violet' => "text-violet-600 dark:text-violet-400",
    'color-invert' => "text-zinc-900 dark:text-white",
    default => "",
};

// === Opacity ===
$opacityEffect = match ($effect) {
    'fade' => "opacity-70",
    'fade-lg' => "opacity-50",
    'reveal' => "opacity-100",
    default => "",
};

// === Filter Effects ===
$filterEffect = match ($effect) {
    'grayscale' => "grayscale-0",
    'grayscale-hover' => "grayscale",
    'saturate' => "saturate-150",
    'saturate-lg' => "saturate-200",
    'contrast' => "contrast-125",
    'contrast-lg' => "contrast-150",
    'brightness' => "brightness-110",
    'brightness-lg' => "brightness-125",
    'blur' => "blur-none",
    'blur-sm' => "blur-sm",
    'sepia' => "sepia-0",
    'sepia-hover' => "sepia",
    'invert' => "invert-0",
    'invert-hover' => "invert",
    'hue-rotate' => "hue-rotate-30",
    'hue-rotate-lg' => "hue-rotate-60",
    default => "",
};

// === Border Radius ===
$radiusClass = match ($radius) {
    'none' => 'rounded-none',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl',
    '3xl' => 'rounded-3xl',
    'full' => 'rounded-full',
    default => '',
};

// === Gradient overlay effects ===
$gradientEffect = match ($effect) {
    'gradient-overlay' => "bg-gradient-to-t from-black/30 to-transparent",
    'gradient-left' => "bg-gradient-to-r from-black/30 to-transparent",
    'gradient-right' => "bg-gradient-to-l from-black/30 to-transparent",
    'gradient-color' => "bg-gradient-to-t from-blue-600/20 to-transparent",
    default => "",
};

// Build the base classes
$classes = Gsmui::classes()
    ->add('relative inline-block')
    ->add($radiusClass)
    ->add($disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer')
    ;

// The hover group — target the hover-over-child pattern
$hoverClasses = Gsmui::classes()
    ->add('transition-all')
    ->add($durationMap)
    ->add($easing)
    ->add('group-hover:' . $effect2D)
    ;

// Additional hover effects that apply to the hovered element
if ($shadowEffect) {
    $classes = $classes->add('transition-shadow ' . $durationMap);
    $classes = $classes->add('group-hover:' . $shadowEffect);
}
if ($borderEffect) {
    $classes = $classes->add($borderEffect);
}
if ($gradientEffect) {
    $classes = $classes->add($gradientEffect);
}

// Effects that go on child elements (for overlay patterns)
$childEffect = '';
if ($bgEffect) {
    $childEffect = 'group-hover:' . $bgEffect;
}
if ($filterEffect) {
    $childEffect .= ' group-hover:' . $filterEffect;
}
if ($opacityEffect) {
    $childEffect .= ' group-hover:' . $opacityEffect;
}
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->class($classes) }}
    @if ($disabled) aria-disabled="true" @endif
    data-gsmui-hover
>
    <span class="inline-flex items-center {{ $hoverClasses }} {{ $childEffect }} {{ $radiusClass }}">
        {{ $slot }}
    </span>
</{{ $tag }}>
