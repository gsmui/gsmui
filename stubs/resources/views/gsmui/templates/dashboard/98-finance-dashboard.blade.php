<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Finance Dashboard</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Revenue' => '$245K', 'Expenses' => '$124K', 'Profit' => '$121K', 'Margin' => '49%'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Revenue vs Expenses</h2>
                <div class="h-48 flex items-end gap-1">
                    @foreach([70, 75, 65, 80, 85, 90] as $i => $val)
                    <div class="flex-1 flex gap-0.5">
                        <div class="flex-1 bg-green-500 rounded-t" style="height: {{ $val }}%"></div>
                        <div class="flex-1 bg-red-400 rounded-t" style="height: {{ $val * 0.6 }}%"></div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Transactions</h2>
                <div class="space-y-3">
                    @foreach([
                        ['desc' => 'Client Payment', 'amount' => '+$12,400', 'type' => 'income'],
                        ['desc' => 'Server Hosting', 'amount' => '-$450', 'type' => 'expense'],
                    ] as $txn)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $txn['desc'] }}</p>
                        </div>
                        <span class="text-sm font-bold {{ $txn['type'] === 'income' ? 'text-green-600' : 'text-red-600' }}">{{ $txn['amount'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>