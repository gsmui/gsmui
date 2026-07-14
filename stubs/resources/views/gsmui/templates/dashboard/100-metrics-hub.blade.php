<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Metrics Hub</h1>
            <div class="flex items-center gap-2">
                <select class="px-3 py-1.5 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>This year</option>
                </select>
            </div>
        </div>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Revenue', 'value' => '$245K', 'change' => '+12.5%', 'up' => true],
                ['label' => 'Users', 'value' => '12.4K', 'change' => '+8.2%', 'up' => true],
                ['label' => 'Conversion', 'value' => '3.2%', 'change' => '+0.4%', 'up' => true],
                ['label' => 'Churn', 'value' => '1.8%', 'change' => '-0.2%', 'up' => true],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs {{ $stat['up'] ? 'text-green-600' : 'text-red-600' }}">{{ $stat['change'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Performance Overview</h2>
                <div class="h-48 flex items-end gap-2">
                    @foreach([65, 72, 68, 85, 78, 92, 88, 95, 82, 90, 87, 94] as $i => $val)
                    <div class="flex-1 bg-gradient-to-t from-blue-500 to-blue-400 rounded-t" style="height: {{ $val }}%"></div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Quick Stats</h2>
                <div class="space-y-3">
                    @foreach(['Uptime' => '99.9%', 'Response' => '145ms', 'Errors' => '0.1%'] as $label => $value)
                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $label }}</span>
                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>