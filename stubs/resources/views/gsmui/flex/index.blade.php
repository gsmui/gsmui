@props([
    'direction' => 'row',
    'gap' => '4',
    'align' => 'stretch',
    'justify' => 'start',
    'wrap' => 'nowrap',
    'grow' => null,
    'shrink' => null,
    'basis' => null,
    'class' => '',
])

<?php
$directionClass = is_array($direction) ? implode(' ', array_map(fn($d) => "flex-{$d}", $direction)) : "flex-{$direction}";
$gapClass = is_array($gap) ? implode(' ', array_map(fn($g) => "gap-{$g}", $gap)) : "gap-{$gap}";
$alignClass = is_array($align) ? implode(' ', array_map(fn($a) => "items-{$a}", $align)) : "items-{$align}";
$justifyClass = is_array($justify) ? implode(' ', array_map(fn($j) => "justify-{$j}", $justify)) : "justify-{$justify}";
$wrapClass = "flex-wrap-{$wrap}";
$growClass = $grow ? (is_array($grow) ? implode(' ', array_map(fn($g) => "flex-grow-{$g}", $grow)) : "flex-grow-{$grow}") : '';
$shrinkClass = $shrink ? (is_array($shrink) ? implode(' ', array_map(fn($s) => "flex-shrink-{$s}", $shrink)) : "flex-shrink-{$shrink}") : '';
$basisClass = $basis ? (is_array($basis) ? implode(' ', array_map(fn($b) => "flex-basis-{$b}", $basis)) : "flex-basis-{$basis}") : '';
?>

<div 
    class="flex {{ $directionClass }} {{ $gapClass }} {{ $alignClass }} {{ $justifyClass }} {{ $wrapClass }} {{ $growClass }} {{ $shrinkClass }} {{ $basisClass }} {{ $class }}"
    role="group"
>
    {{ $slot }}
</div>