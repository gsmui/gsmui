@props([
    'emojis' => [],
    'size' => 'md',
    'columns' => 8,
    'label' => null,
])

@php
    $sizes = ['xs' => 'text-lg', 'sm' => 'text-xl', 'md' => 'text-2xl', 'lg' => 'text-3xl', 'xl' => 'text-4xl'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class(["select-none"]) }}>
    @if($label)
        <div class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">{{ $label }}</div>
    @endif
    <div class="grid grid-cols-{{ $columns }} gap-1">
        @foreach($emojis as $emoji)
            <button 
                class="flex items-center justify-center w-10 h-10 {{ $sizeClass }} rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                @click="$dispatch('emoji-select', '{{ $emoji }}')"
                title="{{ $emoji }}"
            >
                {{ $emoji }}
            </button>
        @endforeach
    </div>
</div>
