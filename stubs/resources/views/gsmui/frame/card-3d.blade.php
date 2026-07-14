@props([
    'perspective' => '1000',
    'rotateX' => 0,
    'rotateY' => 0,
    'hover' => true,
    'shadow' => true,
])

<div class="perspective-{{ $perspective }}">
    <div {{ $attributes->class([
        'transition-transform duration-300',
        $hover ? 'hover:rotate-x-0 hover:rotate-y-0' : '',
        $shadow ? 'shadow-xl hover:shadow-2xl' : '',
    ]) }} style="transform: rotateX({{ $rotateX }}deg) rotateY({{ $rotateY }}deg);">
        {{ $slot }}
    </div>
</div>
