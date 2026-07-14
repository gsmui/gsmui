<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Inventory Dashboard</h1>
            <div class="flex items-center gap-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">+ Add Product</button>
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Products</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">1,234</p>
                <p class="text-xs text-green-600">+12% this month</p>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Low Stock Items</p>
                <p class="text-2xl font-bold text-orange-600">47</p>
                <p class="text-xs text-orange-600">Requires attention</p>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Out of Stock</p>
                <p class="text-2xl font-bold text-red-600">12</p>
                <p class="text-xs text-red-600">Needs reorder</p>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Value</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">$847,293</p>
                <p class="text-xs text-green-600">+5% this month</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Stock Levels</h2>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        @foreach(['Widget Pro' => 85, 'Gadget X' => 23, 'Device Plus' => 100, 'Tool Master' => 45] as $item => $level)
                        <div class="flex items-center gap-3">
                            <span class="flex-1 text-sm text-zinc-700 dark:text-zinc-300">{{ $item }}</span>
                            <div class="w-32 h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                                <div class="h-full rounded-full {{ $level > 60 ? 'bg-green-500' : ($level > 30 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $level }}%"></div>
                            </div>
                            <span class="text-sm text-zinc-500 w-10 text-right">{{ $level }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Recent Activity</h2>
                </div>
                <div class="p-4 space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 mt-2 rounded-full bg-blue-500"></div>
                        <div>
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">Widget Pro restocked</p>
                            <p class="text-xs text-zinc-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 mt-2 rounded-full bg-orange-500"></div>
                        <div>
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">Gadget X low stock alert</p>
                            <p class="text-xs text-zinc-500">4 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 mt-2 rounded-full bg-green-500"></div>
                        <div>
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">Shipment received</p>
                            <p class="text-xs text-zinc-500">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
