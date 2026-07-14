<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Analytics Dashboard</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Visitors' => '24.5K', 'Page Views' => '89.2K', 'Bounce Rate' => '32%', 'Avg Session' => '4m 23s'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Traffic Sources</h2>
                <div class="space-y-3">
                    @foreach(['Organic' => 45, 'Direct' => 28, 'Referral' => 18, 'Social' => 9] as $source => $pct)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $source }}</span>
                            <span class="text-zinc-500">{{ $pct }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Pages</h2>
                <div class="space-y-3">
                    @foreach(['/home' => '12.4K', '/products' => '8.9K', '/about' => '5.6K'] as $page => $views)
                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $page }}</span>
                        <span class="text-sm text-zinc-500">{{ $views }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>