@props([
    'metrics' => [],
    'period' => '7d',
    'class' => '',
])

<?php
$id = 'analytics-' . uniqid();
$metrics = $metrics ?: [
    ['label' => 'Visitors', 'value' => '12,847', 'change' => '+12.5%', 'trend' => 'up', 'chart' => [30, 45, 38, 52, 48, 60, 55]],
    ['label' => 'Page Views', 'value' => '48,290', 'change' => '+8.3%', 'trend' => 'up', 'chart' => [120, 145, 132, 158, 142, 165, 150]],
    ['label' => 'Bounce Rate', 'value' => '34.2%', 'change' => '-2.1%', 'trend' => 'down', 'chart' => [38, 36, 35, 34, 33, 34, 34]],
    ['label' => 'Avg. Session', 'value' => '4m 32s', 'change' => '+5.2%', 'trend' => 'up', 'chart' => [3.5, 4.0, 3.8, 4.2, 4.5, 4.3, 4.5]],
];
?>

<div 
    class="gsmui-analytics {{ $class }}"
    x-data="gsmuiAnalytics({
        metrics: @js($metrics),
        period: '{{ $period }}',
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Analytics</h2>
            <select x-model="period" class="px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                <option value="24h">Last 24 Hours</option>
                <option value="7d">Last 7 Days</option>
                <option value="30d">Last 30 Days</option>
                <option value="90d">Last 90 Days</option>
            </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <template x-for="metric in metrics" :key="metric.label">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400" x-text="metric.label"></span>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                            :class="metric.trend === 'up' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700' : 'bg-red-100 dark:bg-red-900/30 text-red-700'"
                            x-text="metric.change">
                        </span>
                    </div>
                    <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="metric.value"></div>
                    <div class="mt-2 h-8 flex items-end gap-0.5">
                        <template x-for="(v, i) in metric.chart" :key="i">
                            <div class="flex-1 rounded-t transition-all duration-300" :style="{ height: (v / Math.max(...metric.chart) * 100) + '%', backgroundColor: metric.trend === 'up' ? 'rgb(34 197 94 / 0.3)' : 'rgb(239 68 68 / 0.3)' }"></div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Traffic Sources</h3>
                <div class="space-y-3">
                    <template x-for="source in trafficSources" :key="source.name">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-zinc-600 dark:text-zinc-400" x-text="source.name"></span>
                                <span class="font-medium text-zinc-900 dark:text-white" x-text="source.percentage + '%'"></span>
                            </div>
                            <div class="h-2 bg-zinc-100 dark:bg-zinc-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all" :style="{ width: source.percentage + '%', backgroundColor: source.color }"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Pages</h3>
                <div class="space-y-2">
                    <template x-for="(page, i) in topPages" :key="i">
                        <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-700 last:border-0">
                            <div class="flex items-center gap-3 text-sm">
                                <span class="text-xs font-medium text-zinc-400 w-5" x-text="i + 1"></span>
                                <span class="text-zinc-900 dark:text-white truncate max-w-[250px]" x-text="page.path"></span>
                            </div>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400 tabular-nums" x-text="page.views.toLocaleString()"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiAnalytics', (config) => ({
        metrics: config.metrics,
        period: config.period,
        trafficSources: [
            { name: 'Organic Search', percentage: 45, color: '#3b82f6' },
            { name: 'Direct', percentage: 25, color: '#22c55e' },
            { name: 'Social Media', percentage: 15, color: '#f59e0b' },
            { name: 'Referral', percentage: 10, color: '#8b5cf6' },
            { name: 'Email', percentage: 5, color: '#ec4899' },
        ],
        topPages: [
            { path: '/', views: 12450 },
            { path: '/pricing', views: 8320 },
            { path: '/features', views: 6540 },
            { path: '/docs/getting-started', views: 4320 },
            { path: '/blog', views: 3210 },
        ],
    }));
});
</script>
