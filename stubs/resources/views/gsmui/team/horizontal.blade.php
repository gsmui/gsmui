@blaze(fold: true)

<x-gsmui:team style="horizontal" {{ $attributes->merge(['style' => 'horizontal']) }}>
    {{ $slot }}
</x-gsmui:team>
