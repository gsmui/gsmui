<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Customer Success</h1>
    </header>

    <main class="p-6">
        @php
        $statColors = [
            'green' => 'text-green-600',
            'blue' => 'text-blue-600',
            'yellow' => 'text-yellow-600',
            'purple' => 'text-purple-600',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Health Score', 'value' => '87%', 'color' => 'green'],
                ['label' => 'NPS Score', 'value' => '+62', 'color' => 'blue'],
                ['label' => 'Churn Risk', 'value' => '4.2%', 'color' => 'yellow'],
                ['label' => 'Renewals Due', 'value' => '12', 'color' => 'purple'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $statColors[$stat['color']] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">At-Risk Accounts</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Acme Corp', 'health' => 45, 'mrr' => '$4,200'],
                        ['name' => 'Global Tech', 'health' => 52, 'mrr' => '$8,900'],
                        ['name' => 'StartUp Inc', 'health' => 38, 'mrr' => '$2,100'],
                    ] as $account)
                    <div class="flex items-center gap-3 p-3 bg-red-50 dark:bg-red-900/10 rounded-lg border border-red-200 dark:border-red-900/30">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $account['name'] }}</p>
                            <p class="text-xs text-zinc-500">MRR: {{ $account['mrr'] }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-red-600">{{ $account['health'] }}%</p>
                            <p class="text-[10px] text-zinc-500">Health</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Upcoming Renewals</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Tech Solutions', 'date' => 'Jul 1', 'value' => '$24,000', 'status' => 'Confirmed'],
                        ['name' => 'Data Corp', 'date' => 'Jul 15', 'value' => '$12,000', 'status' => 'Pending'],
                        ['name' => 'Cloud Systems', 'date' => 'Aug 1', 'value' => '$36,000', 'status' => 'At Risk'],
                    ] as $renewal)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $renewal['name'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $renewal['date'] }} · {{ $renewal['value'] }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $renewal['status'] === 'Confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30' : ($renewal['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30' : 'bg-red-100 text-red-800 dark:bg-red-900/30') }}">{{ $renewal['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
