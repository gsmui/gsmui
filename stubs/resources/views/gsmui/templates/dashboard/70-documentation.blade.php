<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Documentation</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ New Article</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Articles', 'value' => '234'],
                ['label' => 'Categories', 'value' => '18'],
                ['label' => 'Views (30d)', 'value' => '45.2K'],
                ['label' => 'Helpful Rating', 'value' => '92%'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Popular Articles</h2>
                </div>
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach([
                        ['title' => 'Getting Started Guide', 'views' => '12.4K', 'category' => 'Basics'],
                        ['title' => 'API Reference', 'views' => '8.9K', 'category' => 'API'],
                        ['title' => 'Troubleshooting Common Issues', 'views' => '6.7K', 'category' => 'Support'],
                    ] as $article)
                    <div class="p-4 flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                        <div class="flex-1">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $article['title'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $article['views'] }} views</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400">{{ $article['category'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Categories</h2>
                <div class="space-y-2">
                    @foreach(['Getting Started' => 12, 'API Reference' => 45, 'Tutorials' => 28, 'FAQ' => 34, 'Changelog' => 89] as $cat => $count)
                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700/50 cursor-pointer">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $cat }}</span>
                        <span class="text-xs text-zinc-500">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
