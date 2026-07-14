<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Audit Log</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Today' => '1,247', 'This Week' => '8,934', 'Critical' => '3', 'Users Active' => '45'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Activity</h2>
            <div class="space-y-3">
                @foreach([
                    ['user' => 'Admin', 'action' => 'Updated user permissions', 'time' => '5m ago', 'level' => 'info'],
                    ['user' => 'System', 'action' => 'Failed login attempt detected', 'time' => '12m ago', 'level' => 'warning'],
                    ['user' => 'Admin', 'action' => 'Deleted backup files', 'time' => '1h ago', 'level' => 'critical'],
                ] as $log)
                <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <div class="w-2 h-2 rounded-full {{ $log['level'] === 'critical' ? 'bg-red-500' : ($log['level'] === 'warning' ? 'bg-yellow-500' : 'bg-blue-500') }}"></div>
                    <div class="flex-1">
                        <p class="text-sm text-zinc-900 dark:text-white"><span class="font-medium">{{ $log['user'] }}</span> {{ $log['action'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $log['time'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>