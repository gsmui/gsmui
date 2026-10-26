@props([
    'queues' => [],
    'failed' => [],
    'stats' => [],
    'class' => '',
])

<?php
$id = 'jobs-' . uniqid();
$queues = $queues ?: [
    ['name' => 'default', 'pending' => 23, 'processing' => 2, 'failed' => 1, 'processed' => 15420],
    ['name' => 'emails', 'pending' => 5, 'processing' => 1, 'failed' => 0, 'processed' => 8931],
    ['name' => 'notifications', 'pending' => 12, 'processing' => 0, 'failed' => 2, 'processed' => 4520],
    ['name' => 'exports', 'pending' => 3, 'processing' => 1, 'failed' => 0, 'processed' => 1204],
];
$failed = $failed ?: [
    ['id' => 1, 'job' => 'App\\Jobs\\SendEmail', 'queue' => 'emails', 'failed_at' => '2024-01-15 10:30:00', 'exception' => 'Connection timeout'],
    ['id' => 2, 'job' => 'App\\Jobs\\ProcessPayment', 'queue' => 'default', 'failed_at' => '2024-01-14 08:15:00', 'exception' => 'Invalid amount'],
];
?>

<div 
    class="gsmui-jobs {{ $class }}"
    x-data="gsmuiJobs({
        queues: @js($queues),
        failed: @js($failed),
        stats: @js($stats),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Job Queue</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Monitor queues, jobs, and failed jobs.</p>
            </div>
            <div class="flex items-center gap-2">
                <button @click="refreshStats" class="px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Refresh</button>
                <button @click="retryAllFailed" class="px-3 py-1.5 bg-primary text-white rounded-lg text-sm hover:bg-primary/90 transition-colors">Retry All Failed</button>
            </div>
        </div>

        <!-- Queue Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <template x-for="queue in queues" :key="queue.name">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-medium text-zinc-900 dark:text-white capitalize" x-text="queue.name"></h3>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-primary/10 text-primary" x-text="queue.pending + ' pending'"></span>
                    </div>
                    <div class="space-y-1 text-sm text-zinc-500 dark:text-zinc-400">
                        <div class="flex justify-between"><span>Processing</span><span class="font-medium text-zinc-900 dark:text-white" x-text="queue.processing"></span></div>
                        <div class="flex justify-between"><span>Failed</span><span class="font-medium" :class="queue.failed > 0 ? 'text-red-500' : 'text-zinc-900 dark:text-white'" x-text="queue.failed"></span></div>
                        <div class="flex justify-between"><span>Processed</span><span class="font-medium text-zinc-900 dark:text-white" x-text="queue.processed.toLocaleString()"></span></div>
                    </div>
                    <div class="mt-3 h-1.5 bg-zinc-100 dark:bg-zinc-700 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full transition-all" :style="{ width: (queue.processing / (queue.pending + queue.processing || 1)) * 100 + '%' }"></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Failed Jobs -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Failed Jobs</h3>
                <span class="text-sm text-red-500" x-show="failed.length > 0" x-text="failed.length + ' failed'"></span>
            </div>
            <template x-if="failed.length === 0">
                <div class="p-8 text-center text-zinc-500 dark:text-zinc-400">
                    <svg class="w-12 h-12 mx-auto mb-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>No failed jobs</p>
                </div>
            </template>
            <template x-if="failed.length > 0">
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="job in failed" :key="job.id">
                        <div class="p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <code class="text-sm font-mono text-zinc-900 dark:text-white" x-text="job.job"></code>
                                    <div class="flex items-center gap-3 mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                        <span class="px-1.5 py-0.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded" x-text="job.queue"></span>
                                        <span x-text="job.failed_at"></span>
                                    </div>
                                    <div class="mt-1 text-xs text-red-500 font-mono truncate" x-text="job.exception"></div>
                                </div>
                                <div class="flex items-center gap-1 flex-shrink-0 ml-2">
                                    <button @click="retryJob(job)" class="p-1 text-zinc-400 hover:text-primary transition-colors" title="Retry">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
                                    <button @click="forgetJob(job)" class="p-1 text-zinc-400 hover:text-red-500 transition-colors" title="Forget">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiJobs', (config) => ({
        queues: config.queues,
        failed: config.failed,
        stats: config.stats,

        refreshStats() {
            this.$dispatch('jobs:refresh');
        },

        retryJob(job) {
            this.failed = this.failed.filter(j => j.id !== job.id);
            const queue = this.queues.find(q => q.name === job.queue);
            if (queue) { queue.pending++; queue.failed--; }
        },

        forgetJob(job) {
            this.failed = this.failed.filter(j => j.id !== job.id);
            const queue = this.queues.find(q => q.name === job.queue);
            if (queue) queue.failed--;
        },

        retryAllFailed() {
            this.failed.forEach(job => {
                const queue = this.queues.find(q => q.name === job.queue);
                if (queue) { queue.pending++; queue.failed--; }
            });
            this.failed = [];
        },
    }));
});
</script>
