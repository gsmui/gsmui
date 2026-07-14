@blaze(fold: true)

<x-gsmui:team style="list" {{ $attributes->merge(['style' => 'list']) }}>
    {{ $slot }}
</x-gsmui:team>
