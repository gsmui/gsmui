<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-white">DevOps Dashboard</h1>
    </header>

    <main class="p-6">
        @php
        $dotColors = [
            'green' => 'bg-green-500',
            'yellow' => 'bg-yellow-500',
            'red' => 'bg-red-500',
        ];
        $statusColorMap = [
            'green' => 'text-green-400',
            'yellow' => 'text-yellow-400',
            'red' => 'text-red-400',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Uptime', 'value' => '99.98%', 'color' => 'text-green-400'],
                ['label' => 'Deployments (7d)', 'value' => '24', 'color' => 'text-blue-400'],
                ['label' => 'Avg Deploy Time', 'value' => '3m 12s', 'color' => 'text-zinc-300'],
                ['label' => 'Incidents', 'value' => '1', 'color' => 'text-yellow-400'],
            ] as $stat)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Infrastructure</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach([
                        ['name' => 'API Gateway', 'status' => 'Healthy', 'color' => 'green'],
                        ['name' => 'Database', 'status' => 'Healthy', 'color' => 'green'],
                        ['name' => 'Cache Layer', 'status' => 'Degraded', 'color' => 'yellow'],
                        ['name' => 'CDN', 'status' => 'Healthy', 'color' => 'green'],
                    ] as $service)
                    <div class="p-3 bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full {{ $dotColors[$service['color']] }}"></span>
                            <span class="text-sm font-medium text-white">{{ $service['name'] }}</span>
                        </div>
                        <span class="text-xs text-zinc-400">{{ $service['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Recent Deployments</h2>
                <div class="space-y-3">
                    @foreach([
                        ['version' => 'v2.4.1', 'author' => 'Alex', 'status' => 'Success', 'color' => 'green', 'time' => '2h ago'],
                        ['version' => 'v2.4.0', 'author' => 'Sarah', 'status' => 'Success', 'color' => 'green', 'time' => '1d ago'],
                        ['version' => 'v2.3.9', 'author' => 'Mike', 'status' => 'Rolled Back', 'color' => 'red', 'time' => '2d ago'],
                    ] as $deploy)
                    <div class="flex items-center gap-3 p-3 bg-zinc-700/50 rounded-lg">
                        <div class="w-3 h-3 rounded-full {{ $dotColors[$deploy['color']] }}"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white font-mono">{{ $deploy['version'] }}</p>
                            <p class="text-xs text-zinc-400">{{ $deploy['author'] }} · {{ $deploy['time'] }}</p>
                        </div>
                        <span class="text-xs {{ $statusColorMap[$deploy['color']] }}">{{ $deploy['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
