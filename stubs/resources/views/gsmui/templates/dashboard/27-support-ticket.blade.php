<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Customer Support</h1>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Open Tickets', 'value' => '34', 'icon' => '🎫'],
                ['label' => 'Avg Response', 'value' => '2.4h', 'icon' => '⏱️'],
                ['label' => 'Satisfaction', 'value' => '94%', 'icon' => '⭐'],
                ['label' => 'Resolved Today', 'value' => '28', 'icon' => '✅'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $stat['icon'] }}</span>
                    <div>
                        <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Active Tickets</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['subject' => 'Cannot access account', 'customer' => 'Alex K.', 'priority' => 'High', 'color' => 'red', 'time' => '10m ago'],
                    ['subject' => 'Billing question', 'customer' => 'Maria L.', 'priority' => 'Medium', 'color' => 'yellow', 'time' => '25m ago'],
                    ['subject' => 'Feature request', 'customer' => 'James P.', 'priority' => 'Low', 'color' => 'blue', 'time' => '1h ago'],
                ] as $ticket)
                <div class="p-4 flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                    <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400 font-medium text-sm">
                        {{ substr($ticket['customer'], 0, 2) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $ticket['subject'] }}</p>
                        <p class="text-sm text-zinc-500">{{ $ticket['customer'] }} · {{ $ticket['time'] }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColors[$ticket['color']]['bg'] }} {{ $badgeColors[$ticket['color']]['text'] }}">{{ $ticket['priority'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
