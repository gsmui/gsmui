<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Error Monitoring</h1>
            <span class="flex items-center gap-2 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span> Healthy
            </span>
        </div>
    </header>

    <main class="p-6">
        @php
        $dotColors = [
            'error' => 'bg-red-500',
            'warning' => 'bg-yellow-500',
            'info' => 'bg-blue-500',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Errors (24h)', 'value' => '23', 'change' => '-12%', 'up' => true],
                ['label' => 'Affected Users', 'value' => '89', 'change' => '-5%', 'up' => true],
                ['label' => 'Error Rate', 'value' => '0.12%', 'change' => '-0.03%', 'up' => true],
                ['label' => 'MTTR', 'value' => '4.2h', 'change' => '-1h', 'up' => true],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs {{ $stat['up'] ? 'text-green-600' : 'text-red-600' }}">{{ $stat['change'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Recent Errors</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['error' => 'TypeError: Cannot read property', 'file' => 'utils.js:42', 'count' => 23, 'first' => '2h ago', 'severity' => 'error'],
                    ['error' => 'Network request failed', 'file' => 'api.js:108', 'count' => 12, 'first' => '4h ago', 'severity' => 'warning'],
                    ['error' => 'Deprecated API usage', 'file' => 'legacy.js:23', 'count' => 89, 'first' => '1d ago', 'severity' => 'info'],
                ] as $err)
                <div class="p-4 flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                    <div class="w-3 h-3 rounded-full {{ $dotColors[$err['severity']] }}"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $err['error'] }}</p>
                        <p class="text-xs text-zinc-500 font-mono">{{ $err['file'] }} · First seen {{ $err['first'] }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400">{{ $err['count'] }} occurrences</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
