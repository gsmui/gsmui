@props([
    'data' => [],
    'nameKey' => 'name',
    'valueKey' => 'value',
    'childrenKey' => 'children',
    'colorKey' => null,
    'padding' => 2,
    'showLabels' => true,
    'showValues' => true,
    'minHeight' => 20,
    'minWidth' => 30,
    'colors' => ['#3b82f6', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16', '#f97316', '#6366f1'],
    'class' => '',
])

<?php
$id = 'treemap-' . uniqid();
?>

<div 
    class="gsmui-chart-treemap {{ $class }}"
    x-data="gsmuiTreemap({
        data: @js($data),
        nameKey: '{{ $nameKey }}',
        valueKey: '{{ $valueKey }}',
        childrenKey: '{{ $childrenKey }}',
        colorKey: '{{ $colorKey }}',
        padding: @js($padding),
        showLabels: @js($showLabels),
        showValues: @js($showValues),
        minHeight: @js($minHeight),
        minWidth: @js($minWidth),
        colors: @js($colors),
    })"
    id="{{ $id }}"
    role="figure"
    aria-label="Treemap chart"
>
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 overflow-auto">
        <div 
            class="treemap-container relative w-full"
            :style="{ aspectRatio: '16/10', minHeight: '300px' }"
            x-ref="container"
        >
            <template x-if="rectangles.length === 0">
                <div class="absolute inset-0 flex items-center justify-center text-zinc-400 dark:text-zinc-600">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                        <p class="text-sm">No data available</p>
                    </div>
                </div>
            </template>
            
            <template x-for="(rect, index) in rectangles" :key="index">
                <div 
                    class="treemap-rect absolute overflow-hidden transition-all duration-150"
                    :style="{
                        left: rect.x + 'px',
                        top: rect.y + 'px',
                        width: rect.width + 'px',
                        height: rect.height + 'px',
                        backgroundColor: rect.color + '20',
                        borderLeft: '3px solid ' + rect.color,
                        borderRadius: '6px',
                        fontSize: Math.min(rect.width, rect.height) * 0.12 + 'px'
                    }"
                    @mouseenter="showDetail($event, rect)"
                    @mouseleave="hideDetail"
                    role="button"
                    :aria-label="rect.name + ': ' + rect.value"
                >
                    <template x-if="showLabels && rect.width > 40 && rect.height > 25">
                        <div class="p-1.5 h-full flex flex-col justify-between" :style="{ opacity: rect.depth > 2 ? 0.7 : 1 }">
                            <div>
                                <div class="font-semibold leading-tight truncate text-zinc-900 dark:text-white" :style="{ fontSize: 'inherit' }" x-text="rect.name"></div>
                                <template x-if="showValues && rect.height > 35">
                                    <div class="text-zinc-500 dark:text-zinc-400 truncate" :style="{ fontSize: '0.85em' }" x-text="formatValue(rect.value)"></div>
                                </template>
                            </div>
                            <template x-if="rect.percentage && rect.height > 40">
                                <div class="text-xs font-medium text-zinc-600 dark:text-zinc-400" x-text="rect.percentage + '%'"></div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
        
        <!-- Tooltip -->
        <template x-if="activeDetail">
            <div class="fixed z-50 px-4 py-3 bg-zinc-900 dark:bg-zinc-700 text-white text-sm rounded-xl shadow-xl pointer-events-none min-w-[150px]" 
                 :style="{ left: detailX + 'px', top: (detailY - 60) + 'px' }">
                <div class="font-semibold mb-1" x-text="detailData.name"></div>
                <div class="text-xs text-zinc-300 space-y-0.5">
                    <div><span class="text-zinc-400">Value:</span> <span x-text="formatValue(detailData.value)"></span></div>
                    <template x-if="detailData.percentage">
                        <div><span class="text-zinc-400">Share:</span> <span x-text="detailData.percentage + '%'"></span></div>
                    </template>
                    <template x-if="detailData.childrenCount">
                        <div><span class="text-zinc-400">Items:</span> <span x-text="detailData.childrenCount"></span></div>
                    </template>
                </div>
            </div>
        </template>
        
        <!-- Legend for top-level items -->
        <template x-if="topLevelItems.length > 1">
            <div class="flex flex-wrap gap-3 mt-4 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                <template x-for="(item, i) in topLevelItems" :key="i">
                    <div class="flex items-center gap-1.5 text-xs text-zinc-600 dark:text-zinc-400">
                        <div class="w-3 h-3 rounded" :style="{ backgroundColor: item.color + '40', borderLeft: '3px solid ' + item.color }"></div>
                        <span x-text="item.name"></span>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiTreemap', (config) => ({
        data: config.data,
        nameKey: config.nameKey,
        valueKey: config.valueKey,
        childrenKey: config.childrenKey,
        colorKey: config.colorKey,
        padding: config.padding,
        showLabels: config.showLabels,
        showValues: config.showValues,
        minHeight: config.minHeight,
        minWidth: config.minWidth,
        colors: config.colors,
        
        rectangles: [],
        topLevelItems: [],
        
        activeDetail: false,
        detailX: 0,
        detailY: 0,
        detailData: {},
        
        init() {
            this.$nextTick(() => this.computeLayout());
        },
        
        computeLayout() {
            const container = this.$refs.container;
            if (!container) return;
            const width = container.offsetWidth;
            const height = Math.max(300, width * 0.625);
            
            const total = this.sumValues(this.data);
            this.rectangles = [];
            this.topLevelItems = [];
            
            if (this.data[this.childrenKey]) {
                const children = this.data[this.childrenKey];
                const childTotal = children.reduce((s, c) => s + this.getValue(c), 0);
                let colorIndex = 0;
                
                children.forEach(child => {
                    const childValue = this.getValue(child);
                    const ratio = childValue / childTotal;
                    const color = this.colors[colorIndex % this.colors.length];
                    colorIndex++;
                    
                    const item = {
                        name: this.getName(child),
                        value: childValue,
                        color: color,
                        percentage: Math.round(ratio * 100),
                        depth: 0,
                    };
                    this.topLevelItems.push(item);
                });
                
                this.squarify(this.data[this.childrenKey], 0, 0, width, height, 0);
            } else {
                const color = this.colors[0];
                this.rectangles.push({
                    x: 0, y: 0, width, height,
                    name: this.getName(this.data),
                    value: this.getValue(this.data),
                    color: color,
                    percentage: 100,
                    depth: 0,
                });
                this.topLevelItems.push({
                    name: this.getName(this.data),
                    value: this.getValue(this.data),
                    color: color,
                    percentage: 100,
                });
            }
        },
        
        sumValues(node) {
            if (!node) return 0;
            if (node[this.childrenKey]) {
                return node[this.childrenKey].reduce((s, c) => s + this.sumValues(c), 0);
            }
            return this.getValue(node);
        },
        
        getValue(node) {
            return node[this.valueKey] || 0;
        },
        
        getName(node) {
            return node[this.nameKey] || '(unnamed)';
        },
        
        getColor(node, depth) {
            if (this.colorKey && node[this.colorKey]) return node[this.colorKey];
            return this.colors[depth % this.colors.length];
        },
        
        squarify(items, x, y, width, height, depth) {
            if (items.length === 0) return;
            
            const total = items.reduce((s, item) => s + this.getValue(item), 0);
            const isVertical = width >= height;
            const mainSize = isVertical ? width : height;
            
            let row = [];
            let rowSum = 0;
            let bestAspect = Infinity;
            
            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                const value = this.getValue(item);
                const newSum = rowSum + value;
                const newRow = [...row, item];
                
                const rowAspect = this.calcRowAspect(newRow, newSum, mainSize, isVertical);
                
                if (rowAspect < bestAspect && (depth > 0 || items.length > 1)) {
                    row = newRow;
                    rowSum = newSum;
                    bestAspect = rowAspect;
                } else {
                    this.layoutRow(row, rowSum, x, y, width, height, isVertical, depth);
                    
                    const used = isVertical ? (rowSum / total) * width : (rowSum / total) * height;
                    if (isVertical) {
                        x += used;
                        width -= used;
                    } else {
                        y += used;
                        height -= used;
                    }
                    
                    row = [item];
                    rowSum = value;
                    bestAspect = Infinity;
                }
            }
            
            if (row.length > 0) {
                this.layoutRow(row, rowSum, x, y, width, height, isVertical, depth);
            }
        },
        
        calcRowAspect(row, sum, mainSize, isVertical) {
            if (sum === 0) return Infinity;
            const first = Math.abs(this.getValue(row[0]) / sum) * mainSize;
            if (first === 0) return Infinity;
            const rest = mainSize / row.length;
            const aspect = Math.max(first / rest, rest / first);
            return aspect;
        },
        
        layoutRow(row, sum, x, y, width, height, isVertical, depth) {
            const container = this.$refs.container;
            if (!container) return;
            const cw = container.offsetWidth;
            const ch = Math.max(300, cw * 0.625);
            
            const totalWidth = isVertical ? width : sum / this.sumValues(this.data[this.childrenKey]) * (isVertical ? cw : ch);
            const mainSize = isVertical ? width : height;
            const rowSize = Math.min(mainSize, (sum / this.totalSum) * (isVertical ? cw : ch) || mainSize);
            
            let offset = 0;
            const color = this.colors[(depth + 1) % this.colors.length];
            
            row.forEach(item => {
                const value = this.getValue(item);
                const ratio = value / sum;
                const itemSize = ratio * rowSize;
                
                let rx = x, ry = y, rw = 0, rh = 0;
                if (isVertical) {
                    rw = width * (sum / this.totalSum);
                    rh = itemSize * (height / rowSize);
                    ry = y + offset;
                } else {
                    rw = itemSize * (width / rowSize);
                    rh = height * (sum / this.totalSum);
                    rx = x + offset;
                }
                
                // Apply padding
                const pad = this.padding;
                const finalX = rx + pad;
                const finalY = ry + pad;
                const finalW = Math.max(0, rw - 2 * pad);
                const finalH = Math.max(0, rh - 2 * pad);
                
                if (finalW >= this.minWidth && finalH >= this.minHeight) {
                    this.rectangles.push({
                        x: finalX, y: finalY, width: finalW, height: finalH,
                        name: this.getName(item),
                        value: value,
                        color: color,
                        percentage: Math.round((value / this.totalSum) * 100),
                        depth: depth + 1,
                        childrenCount: item[this.childrenKey]?.length || 0,
                    });
                }
                
                offset += itemSize;
            });
        },
        
        get totalSum() {
            if (this.data[this.childrenKey]) {
                return this.data[this.childrenKey].reduce((s, c) => s + this.getValue(c), 0);
            }
            return this.getValue(this.data);
        },
        
        formatValue(value) {
            if (value >= 1e9) return (value / 1e9).toFixed(1) + 'B';
            if (value >= 1e6) return (value / 1e6).toFixed(1) + 'M';
            if (value >= 1e3) return (value / 1e3).toFixed(1) + 'K';
            return value?.toLocaleString() || '0';
        },
        
        showDetail(event, rect) {
            this.activeDetail = true;
            this.detailX = event.clientX;
            this.detailY = event.clientY;
            this.detailData = rect;
        },
        
        hideDetail() {
            this.activeDetail = false;
        },
    }));
});
</script>

<style>
.gsmui-chart-treemap {
    @apply font-sans;
}

.gsmui-chart-treemap .treemap-rect {
    @apply transition-shadow duration-150;
}

.gsmui-chart-treemap .treemap-rect:hover {
    @apply shadow-lg;
    z-index: 10;
}
</style>
