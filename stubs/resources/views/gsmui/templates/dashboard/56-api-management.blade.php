<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">API Management</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Create API Key</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'API Calls (24h)', 'value' => '2.4M'],
                ['label' => 'Active Keys', 'value' => '89'],
                ['label' => 'Avg Latency', 'value' => '145ms'],
                ['label' => 'Error Rate', 'value' => '0.3%'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">API Endpoints</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-700/50">
                        <tr>
                            <th class="text-left text-xs font-medium text-zinc-500 uppercase tracking-wider px-4 py-3">Endpoint</th>
                            <th class="text-left text-xs font-medium text-zinc-500 uppercase tracking-wider px-4 py-3">Method</th>
                            <th class="text-left text-xs font-medium text-zinc-500 uppercase tracking-wider px-4 py-3">Calls</th>
                            <th class="text-left text-xs font-medium text-zinc-500 uppercase tracking-wider px-4 py-3">Avg Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach([
                            ['path' => '/api/users', 'method' => 'GET', 'calls' => '456K', 'time' => '120ms'],
                            ['path' => '/api/orders', 'method' => 'POST', 'calls' => '234K', 'time' => '180ms'],
                            ['path' => '/api/products', 'method' => 'GET', 'calls' => '892K', 'time' => '95ms'],
                        ] as $endpoint)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/30">
                            <td class="px-4 py-3 text-sm font-mono text-zinc-900 dark:text-white">{{ $endpoint['path'] }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded {{ $endpoint['method'] === 'GET' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' }}">{{ $endpoint['method'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $endpoint['calls'] }}</td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $endpoint['time'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
