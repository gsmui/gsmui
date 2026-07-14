<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Social Scheduler</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Schedule Post</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $statColors = [
            'blue' => 'text-blue-600',
            'green' => 'text-green-600',
            'purple' => 'text-purple-600',
            'amber' => 'text-amber-600',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Posts Scheduled', 'value' => '24', 'color' => 'blue'],
                ['label' => 'Published Today', 'value' => '8', 'color' => 'green'],
                ['label' => 'Engagement Rate', 'value' => '4.2%', 'color' => 'purple'],
                ['label' => 'Reach Today', 'value' => '12.4K', 'color' => 'amber'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $statColors[$stat['color']] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Upcoming Posts</h2>
                <div class="space-y-3">
                    @foreach([
                        ['content' => 'Check out our new feature! 🚀', 'platform' => 'Twitter', 'time' => 'Today, 3:00 PM', 'icon' => '🐦'],
                        ['content' => 'Behind the scenes at our office', 'platform' => 'Instagram', 'time' => 'Today, 6:00 PM', 'icon' => '📸'],
                        ['content' => 'New blog post: Tips for 2026', 'platform' => 'LinkedIn', 'time' => 'Tomorrow, 9:00 AM', 'icon' => '💼'],
                    ] as $post)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-2xl">{{ $post['icon'] }}</span>
                        <div class="flex-1">
                            <p class="text-sm text-zinc-900 dark:text-white">{{ $post['content'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $post['platform'] }} · {{ $post['time'] }}</p>
                        </div>
                        <button class="text-zinc-400 hover:text-zinc-600">⋮</button>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Platform Performance</h2>
                <div class="space-y-4">
                    @foreach([
                        ['platform' => 'Twitter', 'followers' => '12.4K', 'engagement' => '3.8%', 'icon' => '🐦'],
                        ['platform' => 'Instagram', 'followers' => '8.9K', 'engagement' => '5.2%', 'icon' => '📸'],
                        ['platform' => 'LinkedIn', 'followers' => '4.2K', 'engagement' => '2.1%', 'icon' => '💼'],
                    ] as $platform)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xl">{{ $platform['icon'] }}</span>
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $platform['platform'] }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-zinc-500">{{ $platform['followers'] }} followers</span>
                            <span class="text-green-600">{{ $platform['engagement'] }} engagement</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
