@props([
    'data' => [],
    'xLabels' => [],
    'yLabels' => [],
    'minColor' => '#f0f9ff',
    'maxColor' => '#0369a1',
    'showValues' => true,
    'colorScale' => 'blues',
    'cellSize' => 40,
    'gap' => 4,
    'rounded' => true,
    'tooltip' => true,
    'class' => '',
])

<?php
$id = 'heatmap-' . uniqid();

$colorScales = [
    'blues' => ['#f0f9ff', '#e0f2fe', '#bae6fd', '#7dd3fc', '#38bdf8', '#0ea5e9', '#0284c7', '#0369a1'],
    'greens' => ['#f0fdf4', '#dcfce7', '#bbf7d0', '#86efac', '#4ade80', '#22c55e', '#16a34a', '#15803d'],
    'reds' => ['#fef2f2', '#fee2e2', '#fecaca', '#fca5a5', '#f87171', '#ef4444', '#dc2626', '#b91c1c'],
    'purples' => ['#faf5ff', '#f3e8ff', '#e9d5ff', '#d8b4fe', '#c084fc', '#a855f7', '#9333ea', '#7e22ce'],
    'oranges' => ['#fff7ed', '#ffedd5', '#fed7aa', '#fdba74', '#fb923c', '#f97316', '#ea580c', '#c2410c'],
    'viridis' => ['#440154', '#3b528b', '#21918c', '#5ec962', '#fde725'],
    'spectral' => ['#d53e4f', '#fc8d59', '#fee08b', '#e6f598', '#99d594', '#3288bd'],
];
$scale = $colorScales[$colorScale] ?? $colorScales['blues'];
?>

<div 
    class="gsmui-chart-heatmap {{ $class }}"
    x-data="gsmuiHeatmap({
        data: @js($data),
        xLabels: @js($xLabels),
        yLabels: @js($yLabels),
        showValues: @js($showValues),
        minColor: '{{ $minColor }}',
        maxColor: '{{ $maxColor }}',
        cellSize: @js($cellSize),
        gap: @js($gap),
        rounded: @js($rounded),
        tooltip: @js($tooltip),
        scale: @js($scale),
    })"
    id="{{ $id }}"
    role="grid"
    aria-label="Heatmap chart"
>
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 overflow-auto">
        <div class="inline-flex">
            <!-- Y Labels -->
            <div class="flex flex-col justify-center" :style="{ marginRight: gap + 'px' }">
                <div :style="{ height: cellSize + 'px' }"></div>
                <template x-for="label in yLabels" :key="label">
                    <div class="flex items-center justify-end pr-2 text-xs text-zinc-600 dark:text-zinc-400 font-medium" 
                         :style="{ height: cellSize + 'px', marginBottom: gap + 'px' }"
                         x-text="label">
                    </div>
                </template>
            </div>
            
            <!-- Grid -->
            <div>
                <!-- X Labels -->
                <div class="flex" :style="{ marginBottom: gap + 'px' }">
                    <template x-for="label in xLabels" :key="label">
                        <div class="text-xs text-zinc-600 dark:text-zinc-400 font-medium text-center truncate"
                             :style="{ width: cellSize + 'px', marginRight: gap + 'px' }"
                             x-text="label">
                        </div>
                    </template>
                </div>
                
                <!-- Cells -->
                <template x-for="(row, yIndex) in data" :key="yIndex">
                    <div class="flex" :style="{ marginBottom: gap + 'px' }">
                        <template x-for="(value, xIndex) in row" :key="xIndex">
                            <div 
                                class="relative cursor-pointer transition-transform duration-100 hover:scale-110 hover:z-10"
                                :style="{ 
                                    width: cellSize + 'px', 
                                    height: cellSize + 'px',
                                    marginRight: gap + 'px',
                                    backgroundColor: getColor(value),
                                    borderRadius: rounded ? '6px' : '0'
                                }"
                                @mouseenter="showTooltip($event, value, xIndex, yIndex)"
                                @mouseleave="hideTooltip"
                                role="gridcell"
                                :aria-label="yLabels[yIndex] + ' ' + xLabels[xIndex] + ': ' + value"
                            >
                                <template x-if="showValues">
                                    <div class="absolute inset-0 flex items-center justify-center text-xs font-medium mix-blend-difference text-white" x-text="formatValue(value)"></div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Tooltip -->
        <template x-if="activeTooltip && tooltip">
            <div 
                class="fixed z-50 px-3 py-2 bg-zinc-900 dark:bg-zinc-700 text-white text-xs rounded-lg shadow-lg pointer-events-none"
                :style="{ left: tooltipX + 'px', top: (tooltipY - 40) + 'px' }"
            >
                <span x-text="tooltipContent"></span>
            </div>
        </template>
        
        <!-- Legend -->
        <div class="flex items-center gap-2 mt-4 pt-3 border-t border-zinc-200 dark:border-zinc-700">
            <span class="text-xs text-zinc-500 dark:text-zinc-400">Min</span>
            <div class="flex rounded overflow-hidden">
                <template x-for="(color, i) in scale" :key="i">
                    <div class="w-5 h-4" :style="{ backgroundColor: color }"></div>
                </template>
            </div>
            <span class="text-xs text-zinc-500 dark:text-zinc-400">Max</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiHeatmap', (config) => ({
        data: config.data,
        xLabels: config.xLabels,
        yLabels: config.yLabels,
        showValues: config.showValues,
        minColor: config.minColor,
        maxColor: config.maxColor,
        cellSize: config.cellSize,
        gap: config.gap,
        rounded: config.rounded,
        tooltip: config.tooltip,
        scale: config.scale,
        
        activeTooltip: false,
        tooltipX: 0,
        tooltipY: 0,
        tooltipContent: '',
        
        get minValue() {
            let min = Infinity;
            this.data.forEach(row => row.forEach(v => { if (v < min) min = v; }));
            return min === Infinity ? 0 : min;
        },
        
        get maxValue() {
            let max = -Infinity;
            this.data.forEach(row => row.forEach(v => { if (v > max) max = v; }));
            return max === -Infinity ? 1 : max;
        },
        
        getColor(value) {
            if (value == null) return 'transparent';
            const ratio = (value - this.minValue) / (this.maxValue - this.minValue);
            const index = Math.min(this.scale.length - 1, Math.max(0, Math.floor(ratio * (this.scale.length - 1))));
            return this.scale[index] || this.scale[0];
        },
        
        formatValue(value) {
            if (value == null) return '';
            if (Number.isInteger(value)) return value;
            return value.toFixed(1);
        },
        
        showTooltip(event, value, xIndex, yIndex) {
            if (!this.tooltip) return;
            this.activeTooltip = true;
            this.tooltipX = event.clientX;
            this.tooltipY = event.clientY;
            this.tooltipContent = `${this.yLabels[yIndex]} / ${this.xLabels[xIndex]}: ${value}`;
        },
        
        hideTooltip() {
            this.activeTooltip = false;
        },
    }));
});
</script>

<style>
.gsmui-chart-heatmap {
    @apply font-sans;
}

.gsmui-chart-heatmap [x-cloak] {
    display: none !important;
}
</style>
