<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Video Analytics</h1>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Views', 'value' => '1.2M', 'change' => '+12%'],
                ['label' => 'Watch Time', 'value' => '48K hrs', 'change' => '+8%'],
                ['label' => 'Subscribers', 'value' => '45.2K', 'change' => '+1.2K'],
                ['label' => 'Revenue', 'value' => '$8,420', 'change' => '+15%'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs text-green-600">{{ $stat['change'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Videos</h2>
                <div class="space-y-3">
                    @foreach([
                        ['title' => 'Laravel 11 Tutorial', 'views' => '234K', 'thumb' => '🎬'],
                        ['title' => 'Livewire Crash Course', 'views' => '189K', 'thumb' => '🎬'],
                        ['title' => 'Tailwind Tips & Tricks', 'views' => '156K', 'thumb' => '🎬'],
                    ] as $video)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-2xl">{{ $video['thumb'] }}</span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $video['title'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $video['views'] }} views</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Audience Demographics</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">Age Groups</p>
                        <div class="flex items-end gap-2 h-24">
                            @foreach(['18-24' => 35, '25-34' => 45, '35-44' => 28, '45+' => 15] as $age => $pct)
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-full bg-blue-500 rounded-t-md" style="height: {{ $pct }}%"></div>
                                <span class="text-[10px] text-zinc-500">{{ $age }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
