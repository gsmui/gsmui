@blaze(fold: true)

<x-gsmui:team style="cover" {{ $attributes->merge(['style' => 'cover']) }}>
    {{ $slot }}
</x-gsmui:team>
