<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Email Marketing</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ New Campaign</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Subscribers', 'value' => '24,589', 'change' => '+12%', 'up' => true],
                ['label' => 'Open Rate', 'value' => '32.4%', 'change' => '+2.1%', 'up' => true],
                ['label' => 'Click Rate', 'value' => '4.8%', 'change' => '-0.3%', 'up' => false],
                ['label' => 'Revenue', 'value' => '$12,450', 'change' => '+18%', 'up' => true],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs {{ $stat['up'] ? 'text-green-600' : 'text-red-600' }}">{{ $stat['change'] }} this month</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Recent Campaigns</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['name' => 'Summer Sale Announcement', 'sent' => '12,450', 'opens' => '34.2%', 'clicks' => '5.1%', 'status' => 'Sent'],
                    ['name' => 'Weekly Newsletter #47', 'sent' => '24,589', 'opens' => '28.9%', 'clicks' => '3.8%', 'status' => 'Sent'],
                    ['name' => 'Product Update - v2.0', 'sent' => '—', 'opens' => '—', 'clicks' => '—', 'status' => 'Scheduled'],
                ] as $campaign)
                <div class="p-4 flex items-center gap-4">
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $campaign['name'] }}</p>
                    </div>
                    <div class="hidden md:flex items-center gap-8 text-sm text-zinc-500">
                        <span>Sent: {{ $campaign['sent'] }}</span>
                        <span>Opens: {{ $campaign['opens'] }}</span>
                        <span>Clicks: {{ $campaign['clicks'] }}</span>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $campaign['status'] === 'Sent' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                        {{ $campaign['status'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
