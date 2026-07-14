<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Affiliate Program</h1>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium">Get Referral Link</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Earnings', 'value' => '$12,450', 'icon' => '💰'],
                ['label' => 'Active Referrals', 'value' => '234', 'icon' => '👥'],
                ['label' => 'Click-through', 'value' => '8.2%', 'icon' => '📊'],
                ['label' => 'Conversion', 'value' => '3.4%', 'icon' => '🎯'],
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
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Referrals</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'john@email.com', 'status' => 'Converted', 'color' => 'green', 'amount' => '$45'],
                        ['name' => 'sarah@email.com', 'status' => 'Pending', 'color' => 'yellow', 'amount' => '—'],
                        ['name' => 'mike@email.com', 'status' => 'Converted', 'color' => 'green', 'amount' => '$32'],
                    ] as $referral)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-600 flex items-center justify-center text-xs font-medium text-zinc-600">
                            {{ strtoupper(substr($referral['name'], 0, 2)) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-zinc-900 dark:text-white">{{ $referral['name'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $referral['status'] }}</p>
                        </div>
                        <span class="text-sm font-medium text-green-600">{{ $referral['amount'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Commission Tiers</h2>
                <div class="space-y-3">
                    @foreach([
                        ['tier' => 'Starter', 'commission' => '10%', 'requirement' => '0-50 referrals'],
                        ['tier' => 'Pro', 'commission' => '15%', 'requirement' => '51-200 referrals'],
                        ['tier' => 'Elite', 'commission' => '20%', 'requirement' => '200+ referrals'],
                    ] as $tier)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $tier['tier'] }}</span>
                            <span class="text-lg font-bold text-green-600">{{ $tier['commission'] }}</span>
                        </div>
                        <p class="text-xs text-zinc-500 mt-1">{{ $tier['requirement'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
