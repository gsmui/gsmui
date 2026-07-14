@blaze(fold: true)

@props([
    'name' => null,
    'src' => null,
    'initials' => null,
    'alt' => null,
    'size' => null,
    'color' => null,
    'colorSeed' => null,
    'circle' => false,
    'icon' => null,
    'iconVariant' => 'solid',
    'as' => null,
    'href' => null,
    'tooltip' => null,
    'tooltipPosition' => 'top',
    'badge' => null,
    'badgeColor' => 'green',
    'badgePosition' => null,
    'badgeCircle' => false,
    'badgeVariant' => null,
])

@php
$isButton = $as === 'button';
$isLink = $href && !$isButton;
$tag = $isButton ? 'button' : ($isLink ? 'a' : 'div');

$sizeMap = [
    'xs' => ['size' => 'size-6', 'text' => 'text-[10px]'],
    'sm' => ['size' => 'size-8', 'text' => 'text-xs'],
    'lg' => ['size' => 'size-12', 'text' => 'text-base'],
    'xl' => ['size' => 'size-16', 'text' => 'text-xl'],
    default => ['size' => 'size-10', 'text' => 'text-sm'],
];
$sizeClasses = $sizeMap[$size] ?? $sizeMap['default'];

// Auto-generate initials from name
$initialsText = $initials;
if (!$initialsText && $name) {
    $parts = explode(' ', $name);
    if (count($parts) >= 2) {
        $initialsText = strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
    } else {
        $initialsText = strtoupper(substr($name, 0, 2));
    }
}

// Color mapping for auto/seed
$autoColors = ['red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'];
if ($color === 'auto') {
    $seed = $colorSeed ?: ($name ?: 'default');
    $hash = crc32($seed);
    $color = $autoColors[abs($hash) % count($autoColors)];
}

$bgColor = match ($color) {
    'red' => 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200',
    'orange' => 'bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-200',
    'amber' => 'bg-amber-100 text-amber-700 dark:bg-amber-800 dark:text-amber-200',
    'yellow' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-200',
    'lime' => 'bg-lime-100 text-lime-700 dark:bg-lime-800 dark:text-lime-200',
    'green' => 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200',
    'emerald' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-800 dark:text-emerald-200',
    'teal' => 'bg-teal-100 text-teal-700 dark:bg-teal-800 dark:text-teal-200',
    'cyan' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-800 dark:text-cyan-200',
    'sky' => 'bg-sky-100 text-sky-700 dark:bg-sky-800 dark:text-sky-200',
    'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200',
    'indigo' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-800 dark:text-indigo-200',
    'violet' => 'bg-violet-100 text-violet-700 dark:bg-violet-800 dark:text-violet-200',
    'purple' => 'bg-purple-100 text-purple-700 dark:bg-purple-800 dark:text-purple-200',
    'fuchsia' => 'bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-800 dark:text-fuchsia-200',
    'pink' => 'bg-pink-100 text-pink-700 dark:bg-pink-800 dark:text-pink-200',
    'rose' => 'bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-200',
    default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200',
};

$classes = Gsmui::classes()
    ->add('relative inline-flex items-center justify-center shrink-0 overflow-hidden font-medium')
    ->add($circle ? 'rounded-full' : 'rounded-lg')
    ->add($sizeClasses['size'])
    ->add($src ? '' : $bgColor)
    ->add($src ? '' : $sizeClasses['text'])
    ->add($isButton ? 'hover:opacity-80 active:opacity-70 cursor-pointer' : '')
    ;

$badgePositionClasses = match ($badgePosition) {
    'top right' => 'top-0 right-0',
    'top left' => 'top-0 left-0',
    'bottom right' => 'bottom-0 right-0',
    'bottom left' => 'bottom-0 left-0',
    default => 'bottom-0 right-0',
};
@endphp

@if ($tooltip)
    <gsmui:tooltip :content="$tooltip" :position="$tooltipPosition" class="contents">
        <{{ $tag }}
            @if ($isButton) type="button"
            @elseif ($isLink) href="{{ $href }}"
            @endif
            {{ $attributes->class($classes) }}
            data-gsmui-avatar
        >
            @if ($src)
                <img class="size-full object-cover {{ $circle ? 'rounded-full' : 'rounded-lg' }}" src="{{ $src }}" alt="{{ $alt ?? $name ?? '' }}" />
            @elseif ($icon)
                <gsmui:icon :$icon :variant="$iconVariant" class="size-1/2" />
            @elseif ($initialsText)
                <span>{{ $initialsText }}</span>
            @else
                <gsmui:icon name="user" variant="solid" class="size-1/2 opacity-60" />
            @endif

            @if ($badge !== null && $badge !== false)
                <span class="absolute {{ $badgePositionClasses }} {{ is_numeric($badge) ? 'flex items-center justify-center size-4 text-[10px] font-bold rounded-full' : ($badgeCircle ? 'rounded-full' : 'rounded') }} text-white ring-2 ring-white dark:ring-zinc-900" style="background-color: {{ match($badgeColor) { 'red' => '#ef4444', 'orange' => '#f97316', 'amber' => '#f59e0b', 'yellow' => '#eab308', 'lime' => '#84cc16', 'green' => '#22c55e', 'emerald' => '#10b981', 'teal' => '#14b8a6', 'cyan' => '#06b6d4', 'sky' => '#0ea5e9', 'blue' => '#3b82f6', 'indigo' => '#6366f1', 'violet' => '#8b5cf6', 'purple' => '#a855f7', 'fuchsia' => '#d946ef', 'pink' => '#ec4899', 'rose' => '#f43f5e', default => '#6b7280' } };">
                    {{ $badge === true ? '' : $badge }}
                </span>
            @endif
        </{{ $tag }}>
    </gsmui:tooltip>
@else
    <{{ $tag }}
        @if ($isButton) type="button"
        @elseif ($isLink) href="{{ $href }}"
        @endif
        {{ $attributes->class($classes) }}
        data-gsmui-avatar
    >
        @if ($src)
            <img class="size-full object-cover {{ $circle ? 'rounded-full' : 'rounded-lg' }}" src="{{ $src }}" alt="{{ $alt ?? $name ?? '' }}" />
        @elseif ($icon)
            <gsmui:icon :$icon :variant="$iconVariant" class="size-1/2" />
        @elseif ($initialsText)
            <span>{{ $initialsText }}</span>
        @else
            <gsmui:icon name="user" variant="solid" class="size-1/2 opacity-60" />
        @endif

        @if ($badge !== null && $badge !== false)
            <span class="absolute {{ $badgePositionClasses }} {{ is_numeric($badge) ? 'flex items-center justify-center size-4 text-[10px] font-bold rounded-full' : ($badgeCircle ? 'rounded-full' : 'rounded') }} text-white ring-2 ring-white dark:ring-zinc-900" style="background-color: {{ match($badgeColor) { 'red' => '#ef4444', 'orange' => '#f97316', 'amber' => '#f59e0b', 'yellow' => '#eab308', 'lime' => '#84cc16', 'green' => '#22c55e', 'emerald' => '#10b981', 'teal' => '#14b8a6', 'cyan' => '#06b6d4', 'sky' => '#0ea5e9', 'blue' => '#3b82f6', 'indigo' => '#6366f1', 'violet' => '#8b5cf6', 'purple' => '#a855f7', 'fuchsia' => '#d946ef', 'pink' => '#ec4899', 'rose' => '#f43f5e', default => '#6b7280' } };">
                {{ $badge === true ? '' : $badge }}
            </span>
        @endif
    </{{ $tag }}>
@endif
