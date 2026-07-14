<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Supply Chain</h1>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Suppliers', 'value' => '156', 'icon' => '🏭'],
                ['label' => 'Active Orders', 'value' => '89', 'icon' => '📦'],
                ['label' => 'Inventory Value', 'value' => '$2.4M', 'icon' => '💰'],
                ['label' => 'On-Time Rate', 'value' => '94%', 'icon' => '✅'],
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
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Order Status</h2>
                <div class="space-y-3">
                    @foreach([
                        ['order' => 'PO-2024-089', 'supplier' => 'Acme Corp', 'status' => 'In Transit', 'color' => 'blue', 'eta' => '3 days'],
                        ['order' => 'PO-2024-088', 'supplier' => 'Global Tech', 'status' => 'Delivered', 'color' => 'green', 'eta' => '—'],
                        ['order' => 'PO-2024-087', 'supplier' => 'Parts Plus', 'status' => 'Processing', 'color' => 'yellow', 'eta' => '5 days'],
                    ] as $order)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $order['order'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $order['supplier'] }}</p>
                        </div>
                        <span class="text-xs text-zinc-500">ETA: {{ $order['eta'] }}</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$order['color']]['bg'] }} {{ $badgeColors[$order['color']]['text'] }}">{{ $order['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Warehouse Stock</h2>
                <div class="space-y-3">
                    @foreach(['Warehouse A' => 78, 'Warehouse B' => 92, 'Warehouse C' => 45, 'Warehouse D' => 88] as $wh => $pct)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $wh }}</span>
                            <span class="text-zinc-500">{{ $pct }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full {{ $pct > 80 ? 'bg-green-500' : ($pct > 50 ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
