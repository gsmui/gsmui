<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Influencer Hub</h1>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Followers', 'value' => '2.4M', 'platform' => 'Instagram'],
                ['label' => 'Engagement Rate', 'value' => '4.8%', 'platform' => 'All Platforms'],
                ['label' => 'Active Campaigns', 'value' => '12', 'platform' => 'Current'],
                ['label' => 'Revenue', 'value' => '$45,200', 'platform' => 'This Month'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs text-zinc-400">{{ $stat['platform'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Platform Breakdown</h2>
                <div class="grid grid-cols-3 gap-4">
                    @foreach([
                        ['platform' => 'Instagram', 'icon' => '📸', 'followers' => '1.2M', 'engagement' => '5.2%'],
                        ['platform' => 'TikTok', 'icon' => '🎵', 'followers' => '890K', 'engagement' => '6.1%'],
                        ['platform' => 'YouTube', 'icon' => '🎬', 'followers' => '340K', 'engagement' => '3.8%'],
                    ] as $platform)
                    <div class="text-center p-4 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-3xl">{{ $platform['icon'] }}</span>
                        <p class="font-medium text-zinc-900 dark:text-white mt-2">{{ $platform['platform'] }}</p>
                        <p class="text-lg font-bold text-blue-600">{{ $platform['followers'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $platform['engagement'] }} engagement</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Posts</h2>
                <div class="space-y-3">
                    @foreach(['Summer vibes 🌴' => '45K likes', 'Behind the scenes' => '38K likes', 'New product review' => '32K likes'] as $post => $likes)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $post }}</p>
                        <p class="text-xs text-zinc-500">{{ $likes }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
