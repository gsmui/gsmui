@props([
    'checks' => [],
    'services' => [],
    'class' => '',
])

<?php
$id = 'health-dashboard-' . uniqid();
$checks = $checks ?: [
    ['name' => 'Database Connection', 'status' => 'pass', 'message' => 'Connected', 'duration' => '2ms'],
    ['name' => 'Cache Store (Redis)', 'status' => 'pass', 'message' => 'Connected', 'duration' => '1ms'],
    ['name' => 'Queue Connection', 'status' => 'pass', 'message' => 'Responding', 'duration' => '15ms'],
    ['name' => 'File System Writable', 'status' => 'pass', 'message' => 'Writable', 'duration' => '0ms'],
    ['name' => 'SSL Certificate', 'status' => 'warn', 'message' => 'Expires in 30 days', 'duration' => '-'],
    ['name' => 'Disk Space', 'status' => 'pass', 'message' => '45% used (72.4 GB free)', 'duration' => '-'],
    ['name' => 'Memory Usage', 'status' => 'pass', 'message' => '62% used', 'duration' => '-'],
    ['name' => 'CPU Load', 'status' => 'fail', 'message' => 'Load average: 4.5 (critical)', 'duration' => '-'],
    ['name' => 'Uptime', 'status' => 'pass', 'message' => '14 days, 6 hours', 'duration' => '-'],
    ['name' => 'Last Backup', 'status' => 'warn', 'message' => '2 days ago', 'duration' => '-'],
];
$services = $services ?: [
    ['name' => 'Web Server', 'status' => 'up', 'uptime' => '99.98%', 'response' => '45ms'],
    ['name' => 'Database', 'status' => 'up', 'uptime' => '99.95%', 'response' => '2ms'],
    ['name' => 'Redis', 'status' => 'up', 'uptime' => '100%', 'response' => '1ms'],
    ['name' => 'Mail', 'status' => 'degraded', 'uptime' => '95.2%', 'response' => '1.2s'],
];
?>

<div 
    class="gsmui-health-dashboard {{ $class }}"
    x-data="gsmuiHealthDashboard({
        checks: @js($checks),
        services: @js($services),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">System Health</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Monitor system status and performance.</p></div>
            <button @click="runAllChecks" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90 flex items-center gap-1.5">
                <svg class="w-4 h-4" :class="{ 'animate-spin': checking }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span x-text="checking ? 'Running...' : 'Run All Checks'"></span>
            </button>
        </div>

        <!-- Overall Status -->
        <div class="p-6 rounded-xl border transition-colors"
            :class="overallStatus === 'pass' ? 'border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20' : overallStatus === 'warn' ? 'border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20' : 'border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20'">
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-full flex items-center justify-center"
                    :class="overallStatus === 'pass' ? 'bg-emerald-100 dark:bg-emerald-900/30' : overallStatus === 'warn' ? 'bg-amber-100 dark:bg-amber-900/30' : 'bg-red-100 dark:bg-red-900/30'">
                    <svg class="w-7 h-7" :class="overallStatus === 'pass' ? 'text-emerald-600' : overallStatus === 'warn' ? 'text-amber-600' : 'text-red-600'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-lg font-semibold" :class="overallStatus === 'pass' ? 'text-emerald-800 dark:text-emerald-300' : overallStatus === 'warn' ? 'text-amber-800 dark:text-amber-300' : 'text-red-800 dark:text-red-300'">
                        <span x-text="overallStatus === 'pass' ? 'All Systems Operational' : overallStatus === 'warn' ? 'Degraded Performance' : 'System Issues Detected'"></span>
                    </div>
                    <p class="text-sm mt-0.5" :class="overallStatus === 'pass' ? 'text-emerald-600 dark:text-emerald-400' : overallStatus === 'warn' ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400'">
                        <span x-text="checks.filter(c => c.status === 'pass').length + ' passed'"></span>,
                        <span x-text="checks.filter(c => c.status === 'warn').length + ' warnings'"></span>,
                        <span x-text="checks.filter(c => c.status === 'fail').length + ' failures'"></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <template x-for="svc in services" :key="svc.name">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2.5 h-2.5 rounded-full" :class="{'bg-emerald-500': svc.status === 'up', 'bg-amber-500': svc.status === 'degraded', 'bg-red-500': svc.status === 'down'}"></div>
                        <span class="text-sm font-medium text-zinc-900 dark:text-white" x-text="svc.name"></span>
                    </div>
                    <div class="text-xs text-zinc-500 space-y-0.5">
                        <div class="flex justify-between"><span>Uptime</span><span class="font-medium" x-text="svc.uptime"></span></div>
                        <div class="flex justify-between"><span>Response</span><span class="font-medium" x-text="svc.response"></span></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Checks -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700"><h3 class="font-semibold text-zinc-900 dark:text-white">System Checks</h3></div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                <template x-for="check in checks" :key="check.name">
                    <div class="flex items-center justify-between px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" :class="{'text-emerald-500': check.status === 'pass', 'text-amber-500': check.status === 'warn', 'text-red-500': check.status === 'fail'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <template x-if="check.status === 'pass'"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></template>
                                <template x-if="check.status === 'warn'"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></template>
                                <template x-if="check.status === 'fail'"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></template>
                            </svg>
                            <div><div class="text-sm font-medium text-zinc-900 dark:text-white" x-text="check.name"></div><div class="text-xs text-zinc-500" x-text="check.message"></div></div>
                        </div>
                        <span class="text-xs text-zinc-400 tabular-nums" x-text="check.duration"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiHealthDashboard', (config) => ({
        checks: config.checks, services: config.services, checking: false,

        get overallStatus() {
            if (this.checks.some(c => c.status === 'fail')) return 'fail';
            if (this.checks.some(c => c.status === 'warn')) return 'warn';
            return 'pass';
        },

        runAllChecks() {
            this.checking = true;
            setTimeout(() => {
                this.checks = this.checks.map(c => ({
                    ...c,
                    status: Math.random() > 0.15 ? 'pass' : Math.random() > 0.5 ? 'warn' : 'fail',
                    duration: Math.floor(Math.random() * 50) + 'ms',
                }));
                this.checking = false;
            }, 2000);
        },
    }));
});
</script>
