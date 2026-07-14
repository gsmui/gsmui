<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Design Hub</h1>
            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium">+ New Project</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Projects', 'value' => '24', 'icon' => '🎨'],
                ['label' => 'Components', 'value' => '156', 'icon' => '🧩'],
                ['label' => 'Team Members', 'value' => '8', 'icon' => '👥'],
                ['label' => 'Comments', 'value' => '89', 'icon' => '💬'],
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
            <div class="lg:col-span-2">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Projects</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['name' => 'Brand Refresh', 'cover' => 'bg-gradient-to-br from-purple-500 to-pink-500', 'updated' => '2h ago'],
                        ['name' => 'App Redesign', 'cover' => 'bg-gradient-to-br from-blue-500 to-cyan-500', 'updated' => '1d ago'],
                        ['name' => 'Icon Set', 'cover' => 'bg-gradient-to-br from-green-500 to-emerald-500', 'updated' => '3d ago'],
                        ['name' => 'Marketing Site', 'cover' => 'bg-gradient-to-br from-amber-500 to-orange-500', 'updated' => '1w ago'],
                    ] as $project)
                    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
                        <div class="h-32 {{ $project['cover'] }}"></div>
                        <div class="p-3">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $project['name'] }}</p>
                            <p class="text-xs text-zinc-500">Updated {{ $project['updated'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Team Activity</h2>
                <div class="space-y-3">
                    @foreach([
                        ['user' => 'Alex', 'action' => 'commented on Brand Refresh', 'time' => '5m ago'],
                        ['user' => 'Sarah', 'action' => 'uploaded 3 assets', 'time' => '1h ago'],
                        ['user' => 'Mike', 'action' => 'approved App Redesign', 'time' => '2h ago'],
                    ] as $activity)
                    <div class="flex items-start gap-2">
                        <div class="w-6 h-6 rounded-full bg-purple-100 dark:bg-purple-900/30 flex-shrink-0"></div>
                        <div>
                            <p class="text-sm text-zinc-700 dark:text-zinc-300"><span class="font-medium">{{ $activity['user'] }}</span> {{ $activity['action'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
