<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Helpdesk</h1>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Open Tickets', 'value' => '47', 'icon' => '🎫'],
                ['label' => 'Avg Resolution', 'value' => '4.2h', 'icon' => '⏱️'],
                ['label' => 'CSAT Score', 'value' => '4.6/5', 'icon' => '⭐'],
                ['label' => 'First Response', 'value' => '12m', 'icon' => '💬'],
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Recent Tickets</h2>
                </div>
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach([
                        ['subject' => 'Cannot reset password', 'customer' => 'John D.', 'priority' => 'High', 'color' => 'red', 'time' => '5m ago'],
                        ['subject' => 'Billing discrepancy', 'customer' => 'Maria L.', 'priority' => 'Medium', 'color' => 'yellow', 'time' => '15m ago'],
                        ['subject' => 'Feature request - dark mode', 'customer' => 'Alex K.', 'priority' => 'Low', 'color' => 'blue', 'time' => '1h ago'],
                    ] as $ticket)
                    <div class="p-4 flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                        <div class="flex-1">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $ticket['subject'] }}</p>
                            <p class="text-sm text-zinc-500">{{ $ticket['customer'] }} · {{ $ticket['time'] }}</p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $badgeColors[$ticket['color']]['bg'] }} {{ $badgeColors[$ticket['color']]['text'] }}">{{ $ticket['priority'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Agent Performance</h2>
                <div class="space-y-3">
                    @foreach([
                        ['agent' => 'Alex C.', 'tickets' => 24, 'rating' => '4.8'],
                        ['agent' => 'Sarah M.', 'tickets' => 21, 'rating' => '4.9'],
                        ['agent' => 'Mike R.', 'tickets' => 18, 'rating' => '4.7'],
                    ] as $agent)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 text-xs font-bold">
                            {{ substr($agent['agent'], 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $agent['agent'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $agent['tickets'] }} tickets</p>
                        </div>
                        <span class="text-sm text-yellow-600">⭐ {{ $agent['rating'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
