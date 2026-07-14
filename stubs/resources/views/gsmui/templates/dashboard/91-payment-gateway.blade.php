<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Payment Gateway</h1>
    </header>
    <main class="p-6">
        @php
        $badgeColors = [
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Volume' => '$245K', 'Transactions' => '3,420', 'Success Rate' => '99.2%', 'Avg Time' => '1.2s'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Transactions</h2>
            <div class="space-y-3">
                @foreach([
                    ['id' => 'TXN-001', 'amount' => '$124.50', 'status' => 'Success', 'color' => 'green', 'method' => 'Visa'],
                    ['id' => 'TXN-002', 'amount' => '$89.00', 'status' => 'Success', 'color' => 'green', 'method' => 'Mastercard'],
                    ['id' => 'TXN-003', 'amount' => '$234.00', 'status' => 'Failed', 'color' => 'red', 'method' => 'Amex'],
                ] as $txn)
                <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white font-mono">{{ $txn['id'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $txn['method'] }}</p>
                    </div>
                    <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $txn['amount'] }}</span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$txn['color']]['bg'] }} {{ $badgeColors[$txn['color']]['text'] }}">{{ $txn['status'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
