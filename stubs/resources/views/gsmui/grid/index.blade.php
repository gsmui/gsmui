@props([
    'cols' => '1',
    'gap' => '4',
    'colsStart' => null,
    'colsEnd' => null,
    'rows' => null,
    'flow' => 'row',
    'templateAreas' => null,
    'class' => '',
])

<?php
$colsClass = is_array($cols) ? implode(' ', array_map(fn($c) => "grid-cols-{$c}", $cols)) : "grid-cols-{$cols}";
$gapClass = is_array($gap) ? implode(' ', array_map(fn($g) => "gap-{$g}", $gap)) : "gap-{$gap}";
$flowClass = "grid-flow-{$flow}";
$startClass = $colsStart ? "col-start-{$colsStart}" : '';
$endClass = $colsEnd ? "col-end-{$colsEnd}" : '';
$rowsClass = $rows ? (is_array($rows) ? implode(' ', array_map(fn($r) => "grid-rows-{$r}", $rows)) : "grid-rows-{$rows}") : '';
$areasClass = $templateAreas ? "grid-template-areas-[{$templateAreas}]" : '';
?>

<div 
    class="grid {{ $colsClass }} {{ $gapClass }} {{ $flowClass }} {{ $startClass }} {{ $endClass }} {{ $rowsClass }} {{ $areasClass }} {{ $class }}"
    role="list"
>
    {{ $slot }}
</div>