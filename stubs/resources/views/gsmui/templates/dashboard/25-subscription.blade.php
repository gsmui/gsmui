<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Subscription Analytics</h1>
            <div class="flex items-center gap-2">
                <select class="px-3 py-1.5 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                    <option>Last 30 days</option>
                    <option>Last 90 days</option>
                    <option>This year</option>
                </select>
            </div>
        </div>
    </header>

    <main class="p-6">
        @php
        $indicatorColors = [
            'green' => 'bg-green-500',
            'purple' => 'bg-purple-500',
            'blue' => 'bg-blue-500',
            'yellow' => 'bg-yellow-500',
            'red' => 'bg-red-500',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'MRR', 'value' => '$48,290', 'change' => '+5.2%', 'up' => true],
                ['label' => 'Active Subs', 'value' => '3,847', 'change' => '+124', 'up' => true],
                ['label' => 'Churn Rate', 'value' => '2.4%', 'change' => '-0.3%', 'up' => true],
                ['label' => 'LTV', 'value' => '$489', 'change' => '+$23', 'up' => true],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs {{ $stat['up'] ? 'text-green-600' : 'text-red-600' }}">{{ $stat['change'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Plan Distribution</h2>
                <div class="space-y-4">
                    @foreach([
                        ['plan' => 'Free', 'count' => 2340, 'pct' => 61, 'color' => 'zinc'],
                        ['plan' => 'Starter', 'count' => 980, 'pct' => 25, 'color' => 'blue'],
                        ['plan' => 'Pro', 'count' => 420, 'pct' => 11, 'color' => 'purple'],
                        ['plan' => 'Enterprise', 'count' => 107, 'pct' => 3, 'color' => 'yellow'],
                    ] as $plan)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $plan['plan'] }}</span>
                            <span class="text-zinc-500">{{ $plan['count'] }} ({{ $plan['pct'] }}%)</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full {{ $indicatorColors[$plan['color']] }} rounded-full" style="width: {{ $plan['pct'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Activity</h2>
                <div class="space-y-3">
                    @php
                    $activityColorMap = [
                        'green' => 'bg-green-500',
                        'purple' => 'bg-purple-500',
                        'red' => 'bg-red-500',
                    ];
                    @endphp
                    @foreach([
                        ['action' => 'New subscription', 'plan' => 'Pro', 'time' => '2 min ago', 'color' => 'green'],
                        ['action' => 'Plan upgrade', 'plan' => 'Enterprise', 'time' => '15 min ago', 'color' => 'purple'],
                        ['action' => 'Cancellation', 'plan' => 'Starter', 'time' => '1 hour ago', 'color' => 'red'],
                    ] as $activity)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-2 h-2 rounded-full {{ $activityColorMap[$activity['color']] }}"></div>
                        <div class="flex-1">
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $activity['action'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $activity['plan'] }} · {{ $activity['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
