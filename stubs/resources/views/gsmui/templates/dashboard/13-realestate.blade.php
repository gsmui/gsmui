<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Real Estate Dashboard</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Add Listing</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Properties', 'value' => '156'],
                ['label' => 'Sold', 'value' => '42'],
                ['label' => 'Revenue', 'value' => '$2.4M'],
                ['label' => 'Avg Days', 'value' => '28'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Featured Properties</h2>
                <div class="space-y-3">
                    @foreach([
                        ['address' => '123 Oak Street', 'price' => '$425,000', 'beds' => 3, 'baths' => 2],
                        ['address' => '456 Maple Avenue', 'price' => '$375,000', 'beds' => 2, 'baths' => 2],
                        ['address' => '789 Pine Road', 'price' => '$550,000', 'beds' => 4, 'baths' => 3],
                    ] as $property)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-500 dark:from-blue-500 dark:to-purple-600 rounded-lg flex items-center justify-center text-white text-xl">
                            🏠
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $property['address'] }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $property['beds'] }} bed · {{ $property['baths'] }} bath</p>
                        </div>
                        <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $property['price'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Activity</h2>
                <div class="space-y-3">
                    @foreach([
                        ['action' => 'New listing added', 'time' => '2 hours ago', 'type' => 'success'],
                        ['action' => 'Property sold', 'time' => '5 hours ago', 'type' => 'info'],
                        ['action' => 'Price reduction', 'time' => '1 day ago', 'type' => 'warning'],
                    ] as $activity)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-2 h-2 rounded-full {{ $activity['type'] === 'success' ? 'bg-green-500' : ($activity['type'] === 'info' ? 'bg-blue-500' : 'bg-yellow-500') }}"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $activity['action'] }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
