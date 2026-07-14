<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Gamification Hub</h1>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Points', 'value' => '24,580', 'icon' => '⭐'],
                ['label' => 'Level', 'value' => '12', 'icon' => '🏆'],
                ['label' => 'Badges', 'value' => '34', 'icon' => '🎖️'],
                ['label' => 'Streak', 'value' => '7 days', 'icon' => '🔥'],
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
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Leaderboard</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Alex K.', 'points' => '28,450', 'rank' => 1],
                        ['name' => 'You', 'points' => '24,580', 'rank' => 2],
                        ['name' => 'Maria L.', 'points' => '22,100', 'rank' => 3],
                    ] as $user)
                    <div class="flex items-center gap-3 p-3 {{ $user['rank'] === 2 ? 'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800' : 'bg-zinc-50 dark:bg-zinc-700/50' }} rounded-lg">
                        <span class="w-8 h-8 rounded-full {{ $user['rank'] === 1 ? 'bg-yellow-100 text-yellow-700' : ($user['rank'] === 2 ? 'bg-blue-100 text-blue-700' : 'bg-zinc-100 text-zinc-600') }} flex items-center justify-center text-sm font-bold">
                            {{ $user['rank'] }}
                        </span>
                        <span class="flex-1 font-medium text-zinc-900 dark:text-white">{{ $user['name'] }}</span>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $user['points'] }} pts</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Achievements</h2>
                <div class="grid grid-cols-4 gap-3">
                    @foreach(['🏆', '⭐', '🎯', '🎖️', '💎', '🔥', '👑', '🏆'] as $badge)
                    <div class="aspect-square bg-zinc-50 dark:bg-zinc-700/50 rounded-lg flex items-center justify-center text-2xl hover:scale-110 transition-transform cursor-pointer">
                        {{ $badge }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
