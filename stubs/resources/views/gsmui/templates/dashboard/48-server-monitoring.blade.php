<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Server Monitoring</h1>
            <span class="flex items-center gap-2 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span> All Systems Operational
            </span>
        </div>
    </header>

    <main class="p-6">
        @php
        $dotColors = [
            'green' => 'bg-green-500',
            'yellow' => 'bg-yellow-500',
            'blue' => 'bg-blue-500',
        ];
        $eventColorMap = [
            'success' => 'bg-green-500',
            'warning' => 'bg-yellow-500',
            'info' => 'bg-blue-500',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'CPU Usage', 'value' => '42%', 'color' => 'green'],
                ['label' => 'Memory', 'value' => '68%', 'color' => 'yellow'],
                ['label' => 'Disk', 'value' => '54%', 'color' => 'blue'],
                ['label' => 'Network', 'value' => '2.4 GB/s', 'color' => 'purple'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Server Status</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'web-01', 'status' => 'Online', 'color' => 'green', 'uptime' => '99.9%'],
                        ['name' => 'web-02', 'status' => 'Online', 'color' => 'green', 'uptime' => '99.8%'],
                        ['name' => 'db-01', 'status' => 'Online', 'color' => 'green', 'uptime' => '100%'],
                        ['name' => 'cache-01', 'status' => 'Warning', 'color' => 'yellow', 'uptime' => '98.5%'],
                    ] as $server)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="w-2 h-2 rounded-full {{ $dotColors[$server['color']] }}"></span>
                        <span class="flex-1 font-medium text-zinc-900 dark:text-white font-mono text-sm">{{ $server['name'] }}</span>
                        <span class="text-sm text-zinc-500">{{ $server['uptime'] }} uptime</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Events</h2>
                <div class="space-y-3">
                    @foreach([
                        ['event' => 'Deployment completed', 'time' => '5 min ago', 'type' => 'success'],
                        ['event' => 'High memory usage alert', 'time' => '23 min ago', 'type' => 'warning'],
                        ['event' => 'SSL certificate renewed', 'time' => '2 hours ago', 'type' => 'info'],
                    ] as $event)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-2 h-2 rounded-full {{ $eventColorMap[$event['type']] }}"></div>
                        <div class="flex-1">
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $event['event'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $event['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
