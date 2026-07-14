<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Time Tracker</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Today' => '6h 45m', 'This Week' => '32h', 'Billable' => '28h', 'Utilization' => '87%'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Today's Entries</h2>
            <div class="space-y-3">
                @foreach([
                    ['task' => 'Code Review', 'project' => 'Web App', 'duration' => '2h 15m', 'billable' => true],
                    ['task' => 'API Development', 'project' => 'Mobile App', 'duration' => '3h 30m', 'billable' => true],
                    ['task' => 'Team Meeting', 'project' => 'Internal', 'duration' => '1h 00m', 'billable' => false],
                ] as $entry)
                <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $entry['task'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $entry['project'] }}</p>
                    </div>
                    <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $entry['duration'] }}</span>
                    <span class="w-2 h-2 rounded-full {{ $entry['billable'] ? 'bg-green-500' : 'bg-zinc-400' }}"></span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>