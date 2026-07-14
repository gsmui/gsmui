<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Shipping Dashboard</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Create Shipment</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Pending Shipments', 'value' => '47', 'icon' => '📦', 'color' => 'yellow'],
                ['label' => 'In Transit', 'value' => '123', 'icon' => '🚚', 'color' => 'blue'],
                ['label' => 'Delivered Today', 'value' => '89', 'icon' => '✅', 'color' => 'green'],
                ['label' => 'Returns', 'value' => '12', 'icon' => '↩️', 'color' => 'red'],
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

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Active Shipments</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-700/50">
                        <tr>
                            <th class="text-left text-xs font-medium text-zinc-500 uppercase tracking-wider px-4 py-3">Tracking ID</th>
                            <th class="text-left text-xs font-medium text-zinc-500 uppercase tracking-wider px-4 py-3">Destination</th>
                            <th class="text-left text-xs font-medium text-zinc-500 uppercase tracking-wider px-4 py-3">Status</th>
                            <th class="text-left text-xs font-medium text-zinc-500 uppercase tracking-wider px-4 py-3">ETA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach([
                            ['id' => 'SHP-29384', 'dest' => 'New York, NY', 'status' => 'In Transit', 'eta' => '2 hours', 'color' => 'blue'],
                            ['id' => 'SHP-29385', 'dest' => 'Los Angeles, CA', 'status' => 'Out for Delivery', 'eta' => '30 min', 'color' => 'green'],
                            ['id' => 'SHP-29386', 'dest' => 'Chicago, IL', 'status' => 'Processing', 'eta' => '3 days', 'color' => 'yellow'],
                        ] as $shipment)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/30">
                            <td class="px-4 py-3 text-sm font-mono text-zinc-900 dark:text-white">{{ $shipment['id'] }}</td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $shipment['dest'] }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColors[$shipment['color']]['bg'] }} {{ $badgeColors[$shipment['color']]['text'] }}">{{ $shipment['status'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">{{ $shipment['eta'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
