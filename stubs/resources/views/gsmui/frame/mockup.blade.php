@props([
    'type' => 'browser',
    'title' => '',
    'url' => '',
    'shadow' => true,
    'rounded' => true,
])

@php
$shadowClass = $shadow ? 'shadow-2xl' : '';
$roundedClass = $rounded ? 'rounded-xl' : '';
@endphp

@if($type === 'browser')
<div {{ $attributes->class(['bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 overflow-hidden', $shadowClass, $roundedClass]) }}>
    {{-- Browser Header --}}
    <div class="bg-zinc-100 dark:bg-zinc-900 px-4 py-3 border-b border-zinc-200 dark:border-zinc-700">
        <div class="flex items-center gap-2">
            <div class="flex gap-1.5">
                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                <div class="w-3 h-3 rounded-full bg-green-400"></div>
            </div>
            @if($url)
            <div class="flex-1 mx-4">
                <div class="bg-white dark:bg-zinc-800 rounded-md px-3 py-1 text-xs text-zinc-500 border border-zinc-200 dark:border-zinc-700 truncate">
                    {{ $url }}
                </div>
            </div>
            @endif
        </div>
    </div>
    {{-- Browser Content --}}
    <div class="relative">
        {{ $slot }}
    </div>
</div>

@elseif($type === 'phone')
<div {{ $attributes->class(['inline-block bg-zinc-900 rounded-[2.5rem] p-3 shadow-2xl', $shadowClass]) }}>
    {{-- Phone Notch --}}
    <div class="relative bg-white dark:bg-zinc-800 rounded-[2rem] overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-24 h-6 bg-zinc-900 rounded-b-2xl z-10"></div>
        {{-- Phone Content --}}
        <div class="relative pt-6">
            {{ $slot }}
        </div>
        {{-- Home Indicator --}}
        <div class="pb-2 pt-1">
            <div class="w-1/3 h-1 bg-zinc-300 dark:bg-zinc-600 rounded-full mx-auto"></div>
        </div>
    </div>
</div>

@elseif($type === 'tablet')
<div {{ $attributes->class(['inline-block bg-zinc-800 rounded-2xl p-4 shadow-2xl', $shadowClass]) }}>
    <div class="bg-white dark:bg-zinc-800 rounded-xl overflow-hidden relative">
        {{-- Tablet Camera --}}
        <div class="absolute top-2 left-1/2 -translate-x-1/2 w-2 h-2 bg-zinc-700 rounded-full z-10"></div>
        {{-- Tablet Content --}}
        <div class="relative pt-4">
            {{ $slot }}
        </div>
    </div>
</div>

@elseif($type === 'laptop')
<div {{ $attributes->class(['relative', $shadowClass]) }}>
    {{-- Laptop Screen --}}
    <div class="bg-zinc-800 rounded-t-xl p-2 border border-zinc-700">
        <div class="bg-white dark:bg-zinc-900 rounded-lg overflow-hidden relative">
            {{-- Camera --}}
            <div class="absolute top-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-zinc-600 rounded-full z-10"></div>
            {{ $slot }}
        </div>
    </div>
    {{-- Laptop Base --}}
    <div class="bg-zinc-700 h-3 rounded-b-xl mx-8"></div>
    <div class="bg-zinc-600 h-1 rounded-b-lg mx-16"></div>
</div>
@endif
