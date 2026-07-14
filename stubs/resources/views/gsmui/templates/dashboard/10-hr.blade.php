<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">HR Dashboard</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Add Employee</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Employees', 'value' => '234'],
                ['label' => 'Open Positions', 'value' => '12'],
                ['label' => 'Turnover', 'value' => '4.2%'],
                ['label' => 'Satisfaction', 'value' => '87%'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Team Members</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Alex Johnson', 'role' => 'Engineering Lead', 'avatar' => 'AJ'],
                        ['name' => 'Sarah Chen', 'role' => 'Product Manager', 'avatar' => 'SC'],
                        ['name' => 'Mike Williams', 'role' => 'Designer', 'avatar' => 'MW'],
                    ] as $member)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 dark:from-blue-500 dark:to-purple-600 rounded-full flex items-center justify-center text-white font-medium text-sm">
                            {{ $member['avatar'] }}
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $member['name'] }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $member['role'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Department Distribution</h2>
                <div class="space-y-3">
                    @foreach([
                        ['dept' => 'Engineering', 'count' => 89, 'pct' => 38],
                        ['dept' => 'Product', 'count' => 45, 'pct' => 19],
                        ['dept' => 'Design', 'count' => 34, 'pct' => 15],
                        ['dept' => 'Marketing', 'count' => 66, 'pct' => 28],
                    ] as $dept)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $dept['dept'] }}</span>
                            <span class="text-zinc-500 dark:text-zinc-400">{{ $dept['count'] }} ({{ $dept['pct'] }}%)</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full bg-blue-500 dark:bg-blue-400 rounded-full" style="width: {{ $dept['pct'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
