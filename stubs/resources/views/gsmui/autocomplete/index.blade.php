@blaze(fold: true)

@props([
    'filter' => true,
    'disabled' => false,
])

<?php $containerAttributes = Gsmui::attributesAfter('container:', $attributes); ?>
<ui-select autocomplete clear="esc" data-gsmui-autocomplete {{ $containerAttributes->merge(['filter' => $filter, 'disabled' => $disabled]) }}>
    <gsmui:input :attributes="$attributes->except('filter')" />

    <gsmui:autocomplete.items>
        {{ $slot }}
    </gsmui:autocomplete.items>
</ui-select>
