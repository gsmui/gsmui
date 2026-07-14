@blaze(fold: true)

@props([
    'showRadius' => true,
    'showShadow' => true,
    'showFont' => true,
    'showSpacing' => false,
    'compact' => false,
    'id' => null,
])

@php
$settingsId = $id ?: 'settings-' . str()->random(6);

$radiusOptions = [
    ['value' => '0', 'label' => 'None', 'preview' => '0px'],
    ['value' => '.25rem', 'label' => 'XS', 'preview' => '4px'],
    ['value' => '.375rem', 'label' => 'SM', 'preview' => '6px'],
    ['value' => '.5rem', 'label' => 'Base', 'preview' => '8px'],
    ['value' => '.75rem', 'label' => 'LG', 'preview' => '12px'],
    ['value' => '1rem', 'label' => 'XL', 'preview' => '16px'],
    ['value' => '1.5rem', 'label' => '2XL', 'preview' => '24px'],
    ['value' => '9999px', 'label' => 'Full', 'preview' => 'Pill'],
];

$shadowOptions = [
    ['value' => 'none', 'label' => 'None'],
    ['value' => '0 1px 2px 0 rgb(0 0 0 / 0.05)', 'label' => 'SM'],
    ['value' => '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)', 'label' => 'Base'],
    ['value' => '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)', 'label' => 'MD'],
    ['value' => '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)', 'label' => 'LG'],
    ['value' => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)', 'label' => 'XL'],
];

$fontOptions = [
    ['value' => 'ui-sans-serif, system-ui, -apple-system, sans-serif', 'label' => 'System UI', 'preview' => 'Aa'],
    ['value' => '"Inter", ui-sans-serif, system-ui, sans-serif', 'label' => 'Inter', 'preview' => 'Aa'],
    ['value' => '"Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif', 'label' => 'Jakarta', 'preview' => 'Aa'],
    ['value' => '"DM Sans", ui-sans-serif, system-ui, sans-serif', 'label' => 'DM Sans', 'preview' => 'Aa'],
    ['value' => 'ui-serif, Georgia, serif', 'label' => 'Serif', 'preview' => 'Aa'],
    ['value' => 'ui-monospace, SFMono-Regular, monospace', 'label' => 'Mono', 'preview' => 'Aa'],
];
@endphp

<div
    x-data="{
        radius: '{{ $showRadius ? '.75rem' : '' }}',
        shadow: '{{ $showShadow ? '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)' : '' }}',
        font: '{{ $showFont ? 'ui-sans-serif, system-ui, -apple-system, sans-serif' : '' }}',

        apply() {
            const root = document.documentElement;
            if (this.radius) {
                root.style.setProperty('--color-radius', this.radius);
                root.style.setProperty('--color-radius-sm', this.radius === '0' ? '0' : 'calc(' + this.radius + ' * 0.75)');
                root.style.setProperty('--color-radius-lg', this.radius === '9999px' ? '9999px' : 'calc(' + this.radius + ' * 1.25)');
            }
            if (this.shadow) {
                root.style.setProperty('--color-shadow', this.shadow);
            }
            if (this.font) {
                root.style.setProperty('--color-font-sans', this.font);
            }
            this.$dispatch('settings-changed', { radius: this.radius, shadow: this.shadow, font: this.font });
        }
    }"
    @input="apply()"
    class="space-y-4"
    data-gsmui-customization-settings
>
    {{-- Border Radius --}}
    @if ($showRadius)
        <div>
            <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-2">Border Radius</label>
            <div class="grid grid-cols-4 gap-1.5">
                @foreach ($radiusOptions as $opt)
                    <button
                        type="button"
                        @click="radius = '{{ $opt['value'] }}'; apply()"
                        :class="radius === '{{ $opt['value'] }}' ? 'ring-2 ring-(--color-accent, #3b82f6) bg-(--color-accent, #3b82f6)/10 border-(--color-accent, #3b82f6)' : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="flex flex-col items-center gap-1 px-2 py-2 text-xs rounded-lg border bg-white dark:bg-zinc-900 transition-all duration-100"
                    >
                        <span class="size-6 border-2 border-current rounded" style="border-radius: {{ $opt['value'] }}"></span>
                        <span class="font-medium text-zinc-900 dark:text-white">{{ $opt['label'] }}</span>
                        <span class="text-[10px] text-zinc-400 dark:text-zinc-500">{{ $opt['preview'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Shadow --}}
    @if ($showShadow)
        <div>
            <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-2">Shadow Intensity</label>
            <div class="flex gap-1.5">
                @foreach ($shadowOptions as $opt)
                    <button
                        type="button"
                        @click="shadow = '{{ $opt['value'] }}'; apply()"
                        :class="shadow === '{{ $opt['value'] }}' ? 'ring-2 ring-(--color-accent, #3b82f6) bg-(--color-accent, #3b82f6)/10 border-(--color-accent, #3b82f6)' : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="flex-1 px-2 py-2 text-xs font-medium rounded-lg border bg-white dark:bg-zinc-900 transition-all duration-100 text-center"
                    >
                        <div class="flex justify-center mb-1">
                            <div class="size-5 rounded bg-zinc-200 dark:bg-zinc-700" :style="'box-shadow: ' + ('{{ $opt['value'] }}' === 'none' ? 'none' : '{{ $opt['value'] }}' + ' rgba(0,0,0,0.15)')"></div>
                        </div>
                        <span class="text-zinc-900 dark:text-white">{{ $opt['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Font --}}
    @if ($showFont)
        <div>
            <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-2">Font Family</label>
            <div class="grid grid-cols-3 gap-1.5">
                @foreach ($fontOptions as $opt)
                    <button
                        type="button"
                        @click="font = '{{ $opt['value'] }}'; apply()"
                        :class="font === '{{ $opt['value'] }}' ? 'ring-2 ring-(--color-accent, #3b82f6) bg-(--color-accent, #3b82f6)/10 border-(--color-accent, #3b82f6)' : 'border-zinc-200 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-zinc-800'"
                        class="px-2 py-2 text-xs rounded-lg border bg-white dark:bg-zinc-900 transition-all duration-100"
                        :style="'font-family: ' + ('{{ $opt['value'] }}')"
                    >
                        <div class="text-base font-bold text-zinc-900 dark:text-white leading-tight" :style="'font-family: ' + ('{{ $opt['value'] }}')">{{ $opt['preview'] ?? 'Aa' }}</div>
                        <div class="text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $opt['label'] }}</div>
                    </button>
                @endforeach
            </div>
        </div>
    @endif
</div>
