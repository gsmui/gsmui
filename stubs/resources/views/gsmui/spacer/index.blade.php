@props([
    'space' => '4',
    'class' => '',
])

<?php
$spaceClass = is_array($space) ? implode(' ', array_map(fn($s) => "h-{$s}", $space)) : "h-{$space}";
?>

<div 
    class="{{ $spaceClass }} {{ $class }}"
    aria-hidden="true"
></div>