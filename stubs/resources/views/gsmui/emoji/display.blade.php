@props([
    'emoji' => '😀',
    'size' => 'md',
    'label' => null,
    'hoverable' => true,
    'copyable' => false,
])

@php
    $sizes = ['xs' => 'text-lg', 'sm' => 'text-xl', 'md' => 'text-2xl', 'lg' => 'text-3xl', 'xl' => 'text-4xl', '2xl' => 'text-5xl', '3xl' => 'text-6xl', '4xl' => 'text-7xl'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div 
    {{ $attributes->class(["inline-flex flex-col items-center gap-1 select-none"]) }}
    @if($copyable)
        x-data="{ copied: false, error: false }"
        @click="
            try {
                await navigator.clipboard.writeText('{{ $emoji }}');
                copied = true;
                error = false;
                setTimeout(() => copied = false, 2000);
            } catch(e) {
                error = true;
                setTimeout(() => error = false, 2000);
            }
        "
    @endif
>
    <div 
        class="flex items-center justify-center {{ $sizeClass }} {{ $hoverable ? 'cursor-pointer hover:scale-125 transition-transform duration-200' : '' }}"
        title="{{ $label ?? $emoji }}"
    >
        {{ $emoji }}
    </div>
    @if($label)
        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $label }}</span>
    @endif
    @if($copyable)
        <span 
            x-show="copied" 
            x-transition
            class="text-xs text-green-500 font-medium"
        >
            Copied!
        </span>
    @endif
</div>
