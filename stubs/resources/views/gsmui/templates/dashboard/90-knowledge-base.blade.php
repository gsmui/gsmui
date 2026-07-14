<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Knowledge Base</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Articles' => '342', 'Categories' => '18', 'Views' => '45K', 'Helpful' => '92%'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Popular Articles</h2>
                <div class="space-y-3">
                    @foreach([
                        ['title' => 'Getting Started Guide', 'views' => '12K', 'helpful' => '95%'],
                        ['title' => 'API Reference', 'views' => '8K', 'helpful' => '89%'],
                        ['title' => 'Troubleshooting', 'views' => '6K', 'helpful' => '91%'],
                    ] as $article)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $article['title'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $article['views'] }} views</p>
                        </div>
                        <span class="text-xs text-green-600">{{ $article['helpful'] }} helpful</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Categories</h2>
                <div class="space-y-2">
                    @foreach(['Getting Started' => 12, 'API' => 45, 'Tutorials' => 28, 'FAQ' => 34] as $cat => $count)
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