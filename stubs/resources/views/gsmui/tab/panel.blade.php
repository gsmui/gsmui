@blaze(fold: true)

@props([
    'selected' => false,
    'name' => null,
])

@php
$classes = Gsmui::classes()
    ->add('[&:not([data-selected])]:hidden [:where(&)]:pt-8')
;

if ($name) {
    $attributes = $attributes->merge([
        'name' => $name,
        'wire:key' => $name,
    ]);
}
@endphp

<div {{ $attributes->class($classes)->merge(['data-selected' => $selected]) }} data-gsmui-tab-panel>
    {{ $slot }}
</div>
