@blaze(fold: true)

@props([
    'value' => 0,
    'max' => 5,
    'size' => null,
    'color' => 'amber',
    'readonly' => false,
    'allowHalf' => false,
])

@php
$filledStars = (int) $value;
$halfStar = $allowHalf && ($value - $filledStars >= 0.5);
$emptyStars = $max - $filledStars - ($halfStar ? 1 : 0);

$sizeClasses = match ($size) {
    'sm' => 'size-4',
    'lg' => 'size-6',
    default => 'size-5',
};

$colorClasses = match ($color) {
    'red' => 'text-red-500',
    'orange' => 'text-orange-500',
    'amber' => 'text-amber-500',
    'yellow' => 'text-yellow-500',
    'green' => 'text-green-500',
    'blue' => 'text-blue-500',
    'indigo' => 'text-indigo-500',
    'purple' => 'text-purple-500',
    'pink' => 'text-pink-500',
    default => 'text-amber-500',
};

$starSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="' . $sizeClasses . '"><path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.651l-4.752-.381-1.831-4.401z" clip-rule="evenodd" /></svg>';
$starEmptySvg = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke-width="1.5" stroke="currentColor" class="' . $sizeClasses . '"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>';
@endphp

<div {{ $attributes->class('inline-flex items-center gap-0.5') }} data-gsmui-rating role="img" aria-label="{{ __('Rating') }}: {{ $value }} out of {{ $max }}">
    @for ($i = 0; $i < $filledStars; $i++)
        <span class="{{ $colorClasses }}">{{ $starSvg }}</span>
    @endfor

    @if ($halfStar)
        <span class="relative {{ $colorClasses }}">
            <span class="absolute inset-0 overflow-hidden" style="width: 50%">
                {{ $starSvg }}
            </span>
            <span class="text-zinc-300 dark:text-zinc-600">
                {{ $starSvg }}
            </span>
        </span>
        @php $emptyStars--; @endphp
    @endif

    @for ($i = 0; $i < $emptyStars; $i++)
        <span class="text-zinc-300 dark:text-zinc-600">{{ $starEmptySvg }}</span>
    @endfor
</div>
