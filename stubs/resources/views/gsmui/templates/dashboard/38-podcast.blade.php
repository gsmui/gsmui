<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Podcast Dashboard</h1>
            <button class="px-4 py-2 bg-orange-600 text-white rounded-lg text-sm font-medium">+ New Episode</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Downloads', 'value' => '124K', 'icon' => '📥'],
                ['label' => 'Subscribers', 'value' => '8,940', 'icon' => '👥'],
                ['label' => 'Avg Listen Time', 'value' => '42 min', 'icon' => '⏱️'],
                ['label' => 'Rating', 'value' => '4.8 ⭐', 'icon' => '📊'],
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
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Episodes</h2>
                <div class="space-y-3">
                    @foreach([
                        ['title' => 'The Future of AI', 'downloads' => '12.4K', 'date' => 'Jun 14', 'duration' => '58 min'],
                        ['title' => 'Remote Work Tips', 'downloads' => '8.9K', 'date' => 'Jun 7', 'duration' => '45 min'],
                        ['title' => 'Startup Stories', 'downloads' => '10.2K', 'date' => 'May 31', 'duration' => '62 min'],
                    ] as $episode)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-2xl">🎙️</span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $episode['title'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $episode['date'] }} · {{ $episode['duration'] }}</p>
                        </div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $episode['downloads'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Platforms</h2>
                <div class="space-y-3">
                    @foreach([
                        ['platform' => 'Apple Podcasts', 'pct' => 42, 'color' => 'bg-purple-500'],
                        ['platform' => 'Spotify', 'pct' => 35, 'color' => 'bg-green-500'],
                        ['platform' => 'Google Podcasts', 'pct' => 15, 'color' => 'bg-blue-500'],
                        ['platform' => 'Others', 'pct' => 8, 'color' => 'bg-zinc-400'],
                    ] as $platform)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $platform['platform'] }}</span>
                            <span class="text-zinc-500">{{ $platform['pct'] }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full {{ $platform['color'] }} rounded-full" style="width: {{ $platform['pct'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
