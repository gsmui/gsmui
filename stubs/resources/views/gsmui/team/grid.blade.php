@blaze(fold: true)

<x-gsmui:team style="grid" {{ $attributes->merge(['style' => 'grid']) }}>
    {{ $slot }}
</x-gsmui:team>
