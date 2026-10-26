@props([
    'direction' => 'vertical',
    'space' => '4',
    'divider' => false,
    'wrap' => false,
    'align' => 'stretch',
    'justify' => 'start',
    'class' => '',
])

<?php
$direction = is_array($direction) ? implode(' ', array_map(fn($d) => "flex-{$d}", $direction)) : "flex-col";
$directionClass = $direction === 'flex-col' ? 'flex-col' : ($direction === 'flex-row' ? 'flex-row' : $direction);

$spaceClass = is_array($space) ? implode(' ', array_map(fn($s) => "space-y-{$s}", $space)) : "space-y-{$space}";
$spaceClass = str_replace('space-y-', $directionClass === 'flex-col' ? 'space-y-' : 'space-x-', $spaceClass);

$alignClass = is_array($align) ? implode(' ', array_map(fn($a) => "items-{$a}", $align)) : "items-{$align}";
$justifyClass = is_array($justify) ? implode(' ', array_map(fn($j) => "justify-{$j}", $justify)) : "justify-{$justify}";
$wrapClass = $wrap ? 'flex-wrap' : 'flex-nowrap';
?>

<div 
    class="flex {{ $directionClass }} {{ $spaceClass }} {{ $alignClass }} {{ $justifyClass }} {{ $wrapClass }} {{ $class }}"
    role="list"
>
    @if($divider)
        @php
            $children = collect($slot->children ?? []);
            $dividerComponent = '<x-gsmui:divider class="' . ($directionClass === 'flex-col' ? 'my-0' : 'mx-0 h-4 w-px') . '" />';
        @endphp
        {{ $slot->renderWithDivider($dividerComponent) ?? $slot }}
    @else
        {{ $slot }}
    @endif
</div>