<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Data Pipeline</h1>
            <span class="flex items-center gap-2 text-sm text-green-400">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> All pipelines healthy
            </span>
        </div>
    </header>

    <main class="p-6">
        @php
        $dotColors = [
            'green' => 'bg-green-500',
            'red' => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
        ];
        $statusColorMap = [
            'green' => 'text-green-400',
            'red' => 'text-red-400',
            'yellow' => 'text-yellow-400',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Active Pipelines', 'value' => '18', 'color' => 'text-blue-400'],
                ['label' => 'Records (24h)', 'value' => '2.4M', 'color' => 'text-green-400'],
                ['label' => 'Avg Latency', 'value' => '1.2s', 'color' => 'text-zinc-300'],
                ['label' => 'Failed Jobs', 'value' => '3', 'color' => 'text-red-400'],
            ] as $stat)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Pipeline Status</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'user-events', 'status' => 'Running', 'color' => 'green', 'records' => '1.2M', 'time' => '45s'],
                        ['name' => 'order-processing', 'status' => 'Running', 'color' => 'green', 'records' => '234K', 'time' => '1.2m'],
                        ['name' => 'analytics-aggregate', 'status' => 'Failed', 'color' => 'red', 'records' => '—', 'time' => '—'],
                    ] as $pipeline)
                    <div class="flex items-center gap-3 p-3 bg-zinc-700/50 rounded-lg">
                        <span class="w-2 h-2 rounded-full {{ $dotColors[$pipeline['color']] }}"></span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white font-mono">{{ $pipeline['name'] }}</p>
                            <p class="text-xs text-zinc-400">{{ $pipeline['records'] }} records · {{ $pipeline['time'] }}</p>
                        </div>
                        <span class="text-xs {{ $statusColorMap[$pipeline['color']] }}">{{ $pipeline['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Data Sources</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'PostgreSQL', 'type' => 'Database', 'status' => 'Connected', 'color' => 'green'],
                        ['name' => 'Kafka', 'type' => 'Streaming', 'status' => 'Connected', 'color' => 'green'],
                        ['name' => 'S3 Bucket', 'type' => 'Storage', 'status' => 'Connected', 'color' => 'green'],
                    ] as $source)
                    <div class="flex items-center gap-3 p-3 bg-zinc-700/50 rounded-lg">
                        <div class="w-8 h-8 rounded bg-zinc-600 flex items-center justify-center text-lg">🗄️</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">{{ $source['name'] }}</p>
                            <p class="text-xs text-zinc-400">{{ $source['type'] }}</p>
                        </div>
                        <span class="text-xs {{ $statusColorMap[$source['color']] }}">{{ $source['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
