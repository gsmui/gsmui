<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">SEO Dashboard</h1>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Organic Traffic', 'value' => '45.2K', 'change' => '+12%'],
                ['label' => 'Keywords Ranked', 'value' => '892', 'change' => '+45'],
                ['label' => 'Domain Authority', 'value' => '67', 'change' => '+2'],
                ['label' => 'Backlinks', 'value' => '12.4K', 'change' => '+234'],
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
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Keywords</h2>
                <div class="space-y-3">
                    @foreach([
                        ['keyword' => 'livewire components', 'position' => 3, 'volume' => '2.4K'],
                        ['keyword' => 'tailwind css tutorial', 'position' => 7, 'volume' => '8.9K'],
                        ['keyword' => 'laravel framework', 'position' => 12, 'volume' => '12K'],
                    ] as $keyword)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 text-sm font-bold">#{{ $keyword['position'] }}</span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $keyword['keyword'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $keyword['volume'] }} monthly searches</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Pages</h2>
                <div class="space-y-3">
                    @foreach([
                        ['page' => '/blog/livewire-guide', 'traffic' => '12.4K', 'position' => '3'],
                        ['page' => '/docs/getting-started', 'traffic' => '8.9K', 'position' => '5'],
                        ['page' => '/blog/tailwind-tips', 'traffic' => '6.7K', 'position' => '8'],
                    ] as $page)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white font-mono">{{ $page['page'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $page['traffic'] }} visits · Position {{ $page['position'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
