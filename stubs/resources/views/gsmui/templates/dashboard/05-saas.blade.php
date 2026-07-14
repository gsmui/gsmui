<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">SaaS Dashboard</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">Upgrade Plan</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'MRR', 'value' => '$12,450'],
                ['label' => 'Customers', 'value' => '1,247'],
                ['label' => 'Churn', 'value' => '2.4%'],
                ['label' => 'NPS', 'value' => '+62'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Revenue Trend</h2>
                <div class="h-48 flex items-end gap-2">
                    @foreach([65, 72, 68, 85, 78, 92, 88, 95] as $i => $val)
                    <div class="flex-1 bg-gradient-to-t from-violet-500 to-pink-500 dark:from-violet-600 dark:to-pink-600 rounded-t" style="height: {{ $val }}%"></div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Usage by Plan</h2>
                <div class="space-y-3">
                    @foreach([
                        ['plan' => 'Free', 'percent' => 25],
                        ['plan' => 'Starter', 'percent' => 45],
                        ['plan' => 'Pro', 'percent' => 78],
                        ['plan' => 'Enterprise', 'percent' => 92],
                    ] as $usage)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $usage['plan'] }}</span>
                            <span class="text-zinc-500 dark:text-zinc-400">{{ $usage['percent'] }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-2 bg-gradient-to-r from-violet-500 to-pink-500 dark:from-violet-600 dark:to-pink-600 rounded-full" style="width: {{ $usage['percent'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
