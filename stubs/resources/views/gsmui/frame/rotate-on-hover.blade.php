@props([
    'degree' => 3,
    'duration' => '300',
])

<div {{ $attributes->class([
    'rounded-xl transition-transform duration-[' . $duration . 'ms]',
    'hover:rotate-0',
]) }} style="transform: rotate({{ $degree }}deg);">
    {{ $slot }}
</div>
