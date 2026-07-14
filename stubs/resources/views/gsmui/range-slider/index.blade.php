@blaze(fold: true)

@props([
    'sliders' => [
        ['id' => 'vertical', 'name' => 'Vertical Slider', 'category' => 'Orientation', 'type' => 'Vertical', 'desc' => 'Vertical range slider with bottom-to-top value increase.'],
        ['id' => 'curve', 'name' => 'Curve Slider', 'category' => 'Shape', 'type' => 'Arc', 'desc' => 'Curved/arc range slider with animated track.'],
        ['id' => 'dual', 'name' => 'Dual Handle', 'category' => 'Range', 'type' => 'Multi', 'desc' => 'Dual-handle range slider for min/max selection.'],
        ['id' => 'gradient', 'name' => 'Gradient Track', 'category' => 'Style', 'type' => 'Gradient', 'desc' => 'Range slider with gradient colored track.'],
        ['id' => 'step', 'name' => 'Step Slider', 'category' => 'Interaction', 'type' => 'Discrete', 'desc' => 'Step-based slider with discrete values.'],
        ['id' => 'tooltip', 'name' => 'Tooltip Slider', 'category' => 'Feedback', 'type' => 'Overlay', 'desc' => 'Slider with floating tooltip on drag.'],
        ['id' => 'markers', 'name' => 'Markers Slider', 'category' => 'Display', 'type' => 'Labeled', 'desc' => 'Slider with labeled markers at intervals.'],
        ['id' => 'solid', 'name' => 'Solid Track', 'category' => 'Style', 'type' => 'Filled', 'desc' => 'Solid filled track range slider.'],
        ['id' => 'outline', 'name' => 'Outline Slider', 'category' => 'Style', 'type' => 'Border', 'desc' => 'Outline/border style range slider.'],
        ['id' => 'pill', 'name' => 'Pill Slider', 'category' => 'Shape', 'type' => 'Rounded', 'desc' => 'Pill-shaped rounded range slider.'],
        ['id' => 'custom-thumb', 'name' => 'Custom Thumb', 'category' => 'Thumb', 'type' => 'Icon', 'desc' => 'Slider with custom icon/text thumb.'],
        ['id' => 'labeled', 'name' => 'Labeled Slider', 'category' => 'Display', 'type' => 'Labels', 'desc' => 'Slider with min/max labels.'],
        ['id' => 'color', 'name' => 'Color Picker', 'category' => 'Specialized', 'type' => 'HSL', 'desc' => 'Color picker with hue/saturation/lightness.'],
        ['id' => 'temperature', 'name' => 'Temperature', 'category' => 'Specialized', 'type' => 'Gauge', 'desc' => 'Temperature gauge with color gradient.'],
        ['id' => 'volume', 'name' => 'Volume Control', 'category' => 'Specialized', 'type' => 'Audio', 'desc' => 'Volume control with mute toggle.'],
        ['id' => 'brightness', 'name' => 'Brightness', 'category' => 'Specialized', 'type' => 'Display', 'desc' => 'Brightness control with sun icons.'],
        ['id' => 'circular', 'name' => 'Circular Slider', 'category' => 'Shape', 'type' => 'Round', 'desc' => 'Circular/radial range slider.'],
        ['id' => 'stacked', 'name' => 'Stacked Sliders', 'category' => 'Multi', 'type' => 'Stacked', 'desc' => 'Multiple stacked range sliders.'],
        ['id' => 'multi-stop', 'name' => 'Multi-Stop', 'category' => 'Gradient', 'type' => 'Stops', 'desc' => 'Gradient slider with multiple color stops.'],
        ['id' => 'connected', 'name' => 'Connected Sliders', 'category' => 'Multi', 'type' => 'Linked', 'desc' => 'Linked sliders with preview.'],
    ],
])

@php
    $categories = $sliders->groupBy('category');
    $types = $sliders->groupBy('type');
@endphp

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    {{-- Header --}}
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div>
                <h1 class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro Range Slider</h1>
                <p class="text-sm text-zinc-500">{{ count($sliders) }} slider variants across {{ count($categories) }} categories</p>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-xs font-medium text-blue-700 dark:text-blue-300">{{ count($sliders) }} Variants</span>
                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">{{ count($categories) }} Categories</span>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-12 space-y-16">
        {{-- By Category --}}
        @foreach($categories as $category => $items)
            <section>
                <div class="mb-6 flex items-center gap-3">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-sm font-bold text-blue-600 dark:text-blue-400">{{ Str::limit($category, 1) }}</span>
                    <div>
                        <h2 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $category }}</h2>
                        <p class="text-sm text-zinc-500">{{ count($items) }} variants</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($items as $slider)
                        <div class="group" id="slider-{{ $slider['id'] }}">
                            <div class="mb-3">
                                <span class="inline-block rounded-full bg-zinc-200 dark:bg-zinc-700 px-2.5 py-0.5 text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $slider['type'] }}</span>
                                <h3 class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $slider['name'] }}</h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $slider['desc'] }}</p>
                            </div>
                            <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-sm p-6">
                                <p class="text-xs text-zinc-400 mb-4">Usage: <code class="bg-zinc-100 dark:bg-zinc-700 px-1 rounded">&lt;x-gsmui::range-slider.{{ $slider['id'] }} /&gt;</code></p>
                                <div class="h-32 flex items-center justify-center bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                                    <span class="text-zinc-400 text-sm">{{ $slider['name'] }} Preview</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        {{-- Footer --}}
        <footer class="border-t border-zinc-200 dark:border-white/10 pt-12 pb-8 text-center">
            <p class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro — {{ count($sliders) }} Range Slider Components</p>
            <p class="mt-2 text-sm text-zinc-500">Vertical · Curve · Dual · Gradient · Step · Tooltip · Circular · And more</p>
            <p class="mt-1 text-xs text-zinc-400">Use <code class="rounded bg-zinc-200 dark:bg-zinc-700 px-1.5 py-0.5 text-xs font-mono">&lt;x-gsmui::range-slider.{variant} /&gt;</code></p>
        </footer>
    </main>
</div>
