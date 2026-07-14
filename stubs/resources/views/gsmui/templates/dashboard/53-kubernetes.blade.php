<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Kubernetes Cluster</h1>
            <span class="px-3 py-1 bg-green-900/50 text-green-400 text-xs font-medium rounded-full">Healthy</span>
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
                ['label' => 'Nodes', 'value' => '12', 'color' => 'text-blue-400'],
                ['label' => 'Pods', 'value' => '89', 'color' => 'text-green-400'],
                ['label' => 'Services', 'value' => '24', 'color' => 'text-purple-400'],
                ['label' => 'Namespaces', 'value' => '8', 'color' => 'text-amber-400'],
            ] as $stat)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Pod Status</h2>
                <div class="space-y-2">
                    @foreach([
                        ['name' => 'api-gateway-7x8k9', 'status' => 'Running', 'color' => 'green', 'restarts' => 0],
                        ['name' => 'web-app-4m2n5', 'status' => 'Running', 'color' => 'green', 'restarts' => 1],
                        ['name' => 'worker-9p3q7', 'status' => 'CrashLoop', 'color' => 'red', 'restarts' => 5],
                        ['name' => 'scheduler-2r5t8', 'status' => 'Running', 'color' => 'green', 'restarts' => 0],
                    ] as $pod)
                    <div class="flex items-center gap-3 p-2 bg-zinc-700/50 rounded-lg font-mono text-sm">
                        <span class="w-2 h-2 rounded-full {{ $dotColors[$pod['color']] }}"></span>
                        <span class="flex-1 text-zinc-300">{{ $pod['name'] }}</span>
                        <span class="{{ $statusColorMap[$pod['color']] }}">{{ $pod['status'] }}</span>
                        <span class="text-zinc-500">restarts: {{ $pod['restarts'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Resource Usage</h2>
                <div class="space-y-4">
                    @foreach(['CPU' => 62, 'Memory' => 78, 'Storage' => 45] as $resource => $usage)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-400">{{ $resource }}</span>
                            <span class="text-white">{{ $usage }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-700 rounded-full">
                            <div class="h-full {{ $usage > 80 ? 'bg-red-500' : ($usage > 60 ? 'bg-yellow-500' : 'bg-green-500') }} rounded-full" style="width: {{ $usage }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
