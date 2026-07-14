@blaze(fold: true)

@props([
    'effect' => 'tilt',
    'depth' => null,
    'perspective' => null,
    'as' => null,
    'href' => null,
    'disabled' => false,
    'duration' => null,
    'radius' => null,
])

@php
$tag = $as ?: ($href ? 'a' : 'div');

$durationMap = match ($duration) {
    'fast' => 'duration-200',
    'slow' => 'duration-700',
    'very-slow' => 'duration-1000',
    default => 'duration-400',
};

$radiusClass = match ($radius) {
    'none' => 'rounded-none',
    'sm' => 'rounded-sm',
    'md' => 'rounded-md',
    'lg' => 'rounded-lg',
    'xl' => 'rounded-xl',
    '2xl' => 'rounded-2xl',
    'full' => 'rounded-full',
    default => '',
};

$depthValue = match ($depth) {
    'sm' => '20px',
    'md' => '40px',
    'lg' => '60px',
    'xl' => '80px',
    default => '30px',
};

$perspectiveVal = match ($perspective) {
    'near' => '1000px',
    'far' => '2000px',
    default => '1500px',
};

// === 3D Effects: using data attributes for inline style transforms ===
$effectConfig = match ($effect) {
    'tilt' => ['rx' => '3deg', 'ry' => '3deg', 's' => '1', 'tz' => '0', 'ty' => '0', 'label' => 'Tilt'],
    'tilt-lg' => ['rx' => '6deg', 'ry' => '6deg', 's' => '1', 'tz' => '0', 'ty' => '0', 'label' => 'Tilt LG'],
    'float' => ['rx' => '0deg', 'ry' => '0deg', 's' => '1.05', 'tz' => '0', 'ty' => '-4', 'label' => 'Float'],
    'float-lg' => ['rx' => '0deg', 'ry' => '0deg', 's' => '1.1', 'tz' => '0', 'ty' => '-6', 'label' => 'Float LG'],
    'card' => ['rx' => '2deg', 'ry' => '0deg', 's' => '1.05', 'tz' => '0', 'ty' => '-2', 'label' => 'Card'],
    'card-lg' => ['rx' => '4deg', 'ry' => '0deg', 's' => '1.1', 'tz' => '0', 'ty' => '-4', 'label' => 'Card LG'],
    'flip' => ['rx' => '0deg', 'ry' => '12deg', 's' => '1', 'tz' => '0', 'ty' => '0', 'label' => 'Flip'],
    'flip-lg' => ['rx' => '0deg', 'ry' => '24deg', 's' => '1', 'tz' => '0', 'ty' => '0', 'label' => 'Flip LG'],
    'fold' => ['rx' => '12deg', 'ry' => '0deg', 's' => '0.95', 'tz' => '0', 'ty' => '0', 'label' => 'Fold'],
    'fold-lg' => ['rx' => '24deg', 'ry' => '0deg', 's' => '0.9', 'tz' => '0', 'ty' => '0', 'label' => 'Fold LG'],
    'pop' => ['rx' => '0deg', 'ry' => '0deg', 's' => '1.05', 'tz' => $depthValue, 'ty' => '0', 'label' => 'Pop'],
    'pop-lg' => ['rx' => '0deg', 'ry' => '0deg', 's' => '1.1', 'tz' => '60px', 'ty' => '0', 'label' => 'Pop LG'],
    'push' => ['rx' => '0deg', 'ry' => '0deg', 's' => '0.95', 'tz' => '-20px', 'ty' => '0', 'label' => 'Push'],
    'push-lg' => ['rx' => '0deg', 'ry' => '0deg', 's' => '0.9', 'tz' => '-40px', 'ty' => '0', 'label' => 'Push LG'],
    'rise' => ['rx' => '0deg', 'ry' => '0deg', 's' => '1', 'tz' => '0', 'ty' => '-4', 'label' => 'Rise'],
    'rise-lg' => ['rx' => '0deg', 'ry' => '0deg', 's' => '1', 'tz' => '0', 'ty' => '-6', 'label' => 'Rise LG'],
    'glide' => ['rx' => '0deg', 'ry' => '0deg', 's' => '1.05', 'tz' => '0', 'ty' => '-2', 'label' => 'Glide'],
    'glide-lg' => ['rx' => '0deg', 'ry' => '0deg', 's' => '1.1', 'tz' => '0', 'ty' => '-4', 'label' => 'Glide LG'],
    'swing' => ['rx' => '3deg', 'ry' => '6deg', 's' => '1', 'tz' => '0', 'ty' => '0', 'label' => 'Swing'],
    'swing-lg' => ['rx' => '6deg', 'ry' => '12deg', 's' => '1', 'tz' => '0', 'ty' => '0', 'label' => 'Swing LG'],
    'reveal-up' => ['rx' => '2deg', 'ry' => '0deg', 's' => '1', 'tz' => '0', 'ty' => '-2', 'label' => 'Reveal Up'],
    'reveal-down' => ['rx' => '2deg', 'ry' => '0deg', 's' => '1', 'tz' => '0', 'ty' => '2', 'label' => 'Reveal Down'],
    default => ['rx' => '0deg', 'ry' => '0deg', 's' => '1.05', 'tz' => '0', 'ty' => '-2', 'label' => 'Default'],
};

$cx = $effectConfig['rx'];
$cy = $effectConfig['ry'];
$s = $effectConfig['s'];
$tz = $effectConfig['tz'];
$ty = $effectConfig['ty'];

// Build the hover transform as an inline style applied via group-hover data attribute
$hoverTransform = "rotateX({$cx}) rotateY({$cy}) scale({$s}) translateY({$ty}px)" . ($tz !== '0' ? " translateZ({$tz})" : "");
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->class('group relative inline-block ' . $radiusClass . ($disabled ? ' opacity-50 cursor-not-allowed pointer-events-none' : ' cursor-pointer')) }}
    style="perspective: {{ $perspectiveVal }}"
    @if ($disabled) aria-disabled="true" @endif
    data-gsmui-hover-3d
>
    <span
        class="inline-flex items-center transition-all {{ $durationMap }} ease-out {{ $radiusClass }}"
        style="transform-style: preserve-3d; backface-visibility: hidden;"
        data-hover-transform="{{ $hoverTransform }}"
        onmouseover="this.style.transform=this.dataset.hoverTransform"
        onmouseout="this.style.transform=''"
    >
        {{ $slot }}
    </span>
</{{ $tag }}>
