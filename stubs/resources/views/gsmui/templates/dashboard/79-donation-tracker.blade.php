<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Donation Tracker</h1>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium">+ New Campaign</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Raised', 'value' => '$124,500', 'icon' => '💰'],
                ['label' => 'Donors', 'value' => '1,247', 'icon' => '👥'],
                ['label' => 'Campaigns', 'value' => '8', 'icon' => '🎯'],
                ['label' => 'Avg Donation', 'value' => '$99.80', 'icon' => '📊'],
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Active Campaigns</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Clean Water Initiative', 'goal' => 50000, 'raised' => 34500],
                        ['name' => 'Education Fund', 'goal' => 25000, 'raised' => 18200],
                        ['name' => 'Medical Relief', 'goal' => 75000, 'raised' => 62100],
                    ] as $campaign)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $campaign['name'] }}</span>
                            <span class="text-sm text-zinc-500">${{ number_format($campaign['raised']) }} / ${{ number_format($campaign['goal']) }}</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-600 rounded-full">
                            <div class="h-full bg-green-500 rounded-full" style="width: {{ ($campaign['raised'] / $campaign['goal']) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Donations</h2>
                <div class="space-y-3">
                    @foreach([
                        ['donor' => 'Anonymous', 'amount' => '$500', 'campaign' => 'Clean Water', 'time' => '2h ago'],
                        ['donor' => 'John Smith', 'amount' => '$250', 'campaign' => 'Education Fund', 'time' => '4h ago'],
                        ['donor' => 'Sarah Johnson', 'amount' => '$1,000', 'campaign' => 'Medical Relief', 'time' => '1d ago'],
                    ] as $donation)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 text-sm font-bold">
                            {{ substr($donation['donor'], 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $donation['donor'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $donation['campaign'] }} · {{ $donation['time'] }}</p>
                        </div>
                        <span class="text-sm font-bold text-green-600">{{ $donation['amount'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>