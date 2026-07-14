<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Inventory Management</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Total Items' => '12,450', 'Low Stock' => '23', 'Out of Stock' => '8', 'Value' => '$892K'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Stock Alerts</h2>
            <div class="space-y-3">
                @foreach([
                    ['item' => 'Widget A', 'sku' => 'WA-001', 'stock' => 5, 'status' => 'Critical'],
                    ['item' => 'Gadget B', 'sku' => 'GB-002', 'stock' => 12, 'status' => 'Low'],
                    ['item' => 'Tool C', 'sku' => 'TC-003', 'stock' => 45, 'status' => 'OK'],
                ] as $alert)
                <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <div class="w-2 h-2 rounded-full {{ $alert['status'] === 'Critical' ? 'bg-red-500' : ($alert['status'] === 'Low' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $alert['item'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $alert['sku'] }}</p>
                    </div>
                    <span class="text-sm font-medium {{ $alert['stock'] < 10 ? 'text-red-600' : 'text-zinc-600' }}">{{ $alert['stock'] }} units</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>