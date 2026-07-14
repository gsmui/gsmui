<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Inventory Analytics</h1>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total SKUs', 'value' => '4,521'],
                ['label' => 'In Stock', 'value' => '4,102'],
                ['label' => 'Low Stock', 'value' => '342'],
                ['label' => 'Out of Stock', 'value' => '77'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Sellers</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Widget Pro', 'sold' => 234, 'stock' => 156],
                        ['name' => 'Gadget X', 'sold' => 189, 'stock' => 23],
                        ['name' => 'Device Plus', 'sold' => 156, 'stock' => 89],
                    ] as $product)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $product['name'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $product['sold'] }} sold this month</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $product['stock'] > 50 ? 'bg-green-100 text-green-800 dark:bg-green-900/30' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30' }}">{{ $product['stock'] }} in stock</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Category Breakdown</h2>
                <div class="space-y-4">
                    @foreach(['Electronics' => 42, 'Clothing' => 28, 'Home' => 18, 'Sports' => 12] as $category => $pct)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $category }}</span>
                            <span class="text-zinc-500">{{ $pct }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
