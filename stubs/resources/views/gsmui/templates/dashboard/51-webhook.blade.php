<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Webhook Manager</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Add Webhook</button>
        </div>
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
                ['label' => 'Active Webhooks', 'value' => '24'],
                ['label' => 'Deliveries (24h)', 'value' => '1,247'],
                ['label' => 'Success Rate', 'value' => '99.2%'],
                ['label' => 'Avg Response', 'value' => '145ms'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Recent Deliveries</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['event' => 'order.created', 'status' => '200 OK', 'color' => 'green', 'time' => '2m ago'],
                    ['event' => 'user.registered', 'status' => '200 OK', 'color' => 'green', 'time' => '5m ago'],
                    ['event' => 'payment.failed', 'status' => '500 Error', 'color' => 'red', 'time' => '12m ago'],
                ] as $webhook)
                <div class="p-4 flex items-center gap-4">
                    <code class="text-sm font-mono text-zinc-900 dark:text-white">{{ $webhook['event'] }}</code>
                    <span class="flex-1"></span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$webhook['color']]['bg'] }} {{ $badgeColors[$webhook['color']]['text'] }}">{{ $webhook['status'] }}</span>
                    <span class="text-xs text-zinc-500">{{ $webhook['time'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
