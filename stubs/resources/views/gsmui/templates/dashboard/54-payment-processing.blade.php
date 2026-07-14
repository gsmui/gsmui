<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Payment Processing</h1>
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
            @foreach([
                ['label' => 'Today\'s Revenue', 'value' => '$24,580', 'change' => '+12%'],
                ['label' => 'Transactions', 'value' => '1,247', 'change' => '+8%'],
                ['label' => 'Avg Order', 'value' => '$19.70', 'change' => '+3%'],
                ['label' => 'Failed', 'value' => '12', 'change' => '-5%'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs {{ str_starts_with($stat['change'], '+') ? 'text-green-600' : 'text-red-600' }}">{{ $stat['change'] }} vs yesterday</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Transactions</h2>
                <div class="space-y-3">
                    @foreach([
                        ['id' => 'TXN-8921', 'amount' => '$49.99', 'status' => 'Completed', 'color' => 'green', 'method' => '💳 Visa'],
                        ['id' => 'TXN-8920', 'amount' => '$124.50', 'status' => 'Completed', 'color' => 'green', 'method' => '💳 MC'],
                        ['id' => 'TXN-8919', 'amount' => '$29.99', 'status' => 'Failed', 'color' => 'red', 'method' => '💳 Amex'],
                    ] as $txn)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-lg">{{ explode(' ', $txn['method'])[0] }}</span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white font-mono">{{ $txn['id'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $txn['method'] }}</p>
                        </div>
                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $txn['amount'] }}</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$txn['color']]['bg'] }} {{ $badgeColors[$txn['color']]['text'] }}">{{ $txn['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Payment Methods</h2>
                <div class="space-y-4">
                    @foreach([
                        ['method' => 'Visa', 'pct' => 42, 'icon' => '💳'],
                        ['method' => 'Mastercard', 'pct' => 28, 'icon' => '💳'],
                        ['method' => 'PayPal', 'pct' => 18, 'icon' => '🅿️'],
                        ['method' => 'Apple Pay', 'pct' => 12, 'icon' => '🍎'],
                    ] as $method)
                    <div class="flex items-center gap-3">
                        <span class="text-xl">{{ $method['icon'] }}</span>
                        <div class="flex-1">
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-zinc-700 dark:text-zinc-300">{{ $method['method'] }}</span>
                                <span class="text-zinc-500">{{ $method['pct'] }}%</span>
                            </div>
                            <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $method['pct'] }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
