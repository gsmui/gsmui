@props([
    'degree' => 3,
    'hover' => true,
    'hoverDegree' => 0,
])

<div {{ $attributes->class([
    'rounded-xl transition-transform duration-300',
    $hover ? 'hover:rotate-0' : '',
]) }} style="transform: rotate({{ $degree }}deg);">
    {{ $slot }}
</div>
