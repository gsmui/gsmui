<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">User Analytics</h1>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Daily Active Users', 'value' => '12,489', 'change' => '+8.2%'],
                ['label' => 'Weekly Active', 'value' => '45,230', 'change' => '+5.1%'],
                ['label' => 'Monthly Active', 'value' => '124,500', 'change' => '+12%'],
                ['label' => 'Session Duration', 'value' => '8m 32s', 'change' => '+1.2m'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs text-green-600">{{ $stat['change'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">User Activity</h2>
                <div class="flex items-end justify-between gap-2 h-40">
                    @foreach([65, 72, 58, 85, 78, 92, 68] as $day => $height)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-blue-500 rounded-t-md" style="height: {{ $height }}%"></div>
                        <span class="text-xs text-zinc-500">{{ ['M', 'T', 'W', 'T', 'F', 'S', 'S'][$day] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Pages</h2>
                <div class="space-y-3">
                    @foreach([
                        ['page' => '/dashboard', 'views' => '45,230', 'time' => '4m 12s'],
                        ['page' => '/profile', 'views' => '23,100', 'time' => '2m 45s'],
                        ['page' => '/settings', 'views' => '12,400', 'time' => '1m 30s'],
                    ] as $page)
                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $page['page'] }}</span>
                        <div class="text-right">
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $page['views'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $page['time'] }} avg</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
