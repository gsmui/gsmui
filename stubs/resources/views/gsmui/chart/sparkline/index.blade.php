@props([
    'data' => [],
    'width' => 120,
    'height' => 30,
    'lineColor' => '#3b82f6',
    'fillColor' => '#3b82f6',
    'fillOpacity' => 0.1,
    'strokeWidth' => 1.5,
    'showArea' => true,
    'showDots' => false,
    'showLastDot' => true,
    'smooth' => true,
    'min' => null,
    'max' => null,
    'class' => '',
])

<?php
$id = 'sparkline-' . uniqid();
?>

<div 
    class="gsmui-chart-sparkline inline-flex {{ $class }}"
    x-data="gsmuiSparkline({
        data: @js($data),
        width: @js($width),
        height: @js($height),
        lineColor: '{{ $lineColor }}',
        fillColor: '{{ $fillColor }}',
        fillOpacity: @js($fillOpacity),
        strokeWidth: @js($strokeWidth),
        showArea: @js($showArea),
        showDots: @js($showDots),
        showLastDot: @js($showLastDot),
        smooth: @js($smooth),
        min: @js($min),
        max: @js($max),
    })"
    id="{{ $id }}"
    role="img"
    :aria-label="'Sparkline chart with ' + data.length + ' data points'"
>
    <svg 
        :width="width" 
        :height="height" 
        viewBox="0 0 120 30"
        class="overflow-visible"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <!-- Area fill -->
        <template x-if="showArea && data.length > 1">
            <path 
                :d="areaPath"
                :fill="fillColor"
                :opacity="fillOpacity"
            />
        </template>
        
        <!-- Line -->
        <path 
            :d="linePath"
            :stroke="lineColor"
            :stroke-width="strokeWidth"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="transition-all duration-300"
        />
        
        <!-- Gradient definition -->
        <defs>
            <linearGradient :id="'sparkline-grad-' + '{{ $id }}'" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" :stop-color="fillColor" :stop-opacity="fillOpacity"></stop>
                <stop offset="100%" :stop-color="fillColor" stop-opacity="0"></stop>
            </linearGradient>
        </defs>
        
        <!-- Dots -->
        <template x-if="showDots">
            <template x-for="(point, i) in points" :key="i">
                <circle 
                    :cx="point.x" 
                    :cy="point.y" 
                    r="1.5"
                    :fill="lineColor"
                    class="transition-opacity"
                />
            </template>
        </template>
        
        <!-- Last dot highlight -->
        <template x-if="showLastDot && points.length > 0">
            <circle 
                :cx="points[points.length - 1].x" 
                :cy="points[points.length - 1].y" 
                r="2.5"
                :fill="lineColor"
                class="drop-shadow-sm"
            />
        </template>
    </svg>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiSparkline', (config) => ({
        data: config.data,
        width: config.width,
        height: config.height,
        lineColor: config.lineColor,
        fillColor: config.fillColor,
        fillOpacity: config.fillOpacity,
        strokeWidth: config.strokeWidth,
        showArea: config.showArea,
        showDots: config.showDots,
        showLastDot: config.showLastDot,
        smooth: config.smooth,
        min: config.min,
        max: config.max,
        
        get chartMin() {
            if (this.min != null) return this.min;
            return Math.min(...this.data);
        },
        
        get chartMax() {
            if (this.max != null) return this.max;
            return Math.max(...this.data);
        },
        
        get range() {
            return this.chartMax - this.chartMin || 1;
        },
        
        get points() {
            const w = 120;
            const h = 30;
            const len = this.data.length;
            if (len === 0) return [];
            
            return this.data.map((val, i) => {
                const x = (i / (len - 1)) * w;
                const y = h - ((val - this.chartMin) / this.range) * h;
                return { x, y };
            });
        },
        
        get linePath() {
            const pts = this.points;
            if (pts.length === 0) return '';
            if (pts.length === 1) return `M ${pts[0].x} ${pts[0].y}`;
            
            if (!this.smooth) {
                return pts.map((p, i) => `${i === 0 ? 'M' : 'L'} ${p.x} ${p.y}`).join(' ');
            }
            
            let d = `M ${pts[0].x} ${pts[0].y}`;
            for (let i = 0; i < pts.length - 1; i++) {
                const p0 = pts[i];
                const p1 = pts[i + 1];
                const cx1 = p0.x + (p1.x - p0.x) / 2;
                const cy1 = p0.y;
                const cx2 = p0.x + (p1.x - p0.x) / 2;
                const cy2 = p1.y;
                d += ` C ${cx1} ${cy1}, ${cx2} ${cy2}, ${p1.x} ${p1.y}`;
            }
            return d;
        },
        
        get areaPath() {
            const pts = this.points;
            if (pts.length === 0) return '';
            const line = this.linePath;
            if (!line) return '';
            return line + ` L ${pts[pts.length - 1].x} 30 L ${pts[0].x} 30 Z`;
        },
    }));
});
</script>

<style>
.gsmui-chart-sparkline {
    @apply inline-flex align-middle;
}

.gsmui-chart-sparkline svg {
    @apply overflow-visible;
}
</style>
