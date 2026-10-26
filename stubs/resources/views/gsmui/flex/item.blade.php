@props([
    'grow' => '0',
    'shrink' => '1',
    'basis' => 'auto',
    'class' => '',
])

<?php
$growClass = "grow-{$grow}";
$shrinkClass = "shrink-{$shrink}";
$basisClass = $basis === 'auto' ? 'basis-auto' : ($basis === 'full' ? 'basis-full' : "basis-{$basis}");
?>

<div 
    class="flex {{ $growClass }} {{ $shrinkClass }} {{ $basisClass }} {{ $class }}"
    role="listitem"
>
    {{ $slot }}
</div>