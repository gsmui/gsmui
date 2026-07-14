@blaze(fold: true)

<x-gsmui:team style="minimal" {{ $attributes->merge(['style' => 'minimal']) }}>
    {{ $slot }}
</x-gsmui:team>
