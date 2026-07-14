<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">E-commerce Dashboard</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Add Product</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $changeColorMap = [
            'green' => 'text-green-600',
            'red' => 'text-red-600',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Revenue', 'value' => '$45,230', 'change' => '+12%', 'up' => true],
                ['label' => 'Orders', 'value' => '1,247', 'change' => '+8%', 'up' => true],
                ['label' => 'Customers', 'value' => '3,892', 'change' => '+5%', 'up' => true],
                ['label' => 'Returns', 'value' => '23', 'change' => '-12%', 'up' => false],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <span class="text-sm {{ $stat['up'] ? 'text-green-600' : 'text-red-600' }}">{{ $stat['change'] }}</span>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Products</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Widget Pro', 'sold' => 234, 'revenue' => '$12,400'],
                        ['name' => 'Gadget X', 'sold' => 189, 'revenue' => '$8,900'],
                        ['name' => 'Device Plus', 'sold' => 156, 'revenue' => '$6,700'],
                    ] as $product)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $product['name'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $product['sold'] }} sold</p>
                        </div>
                        <span class="text-sm font-bold text-green-600">{{ $product['revenue'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Orders</h2>
                <div class="space-y-3">
                    @foreach([
                        ['id' => '#8921', 'customer' => 'John D.', 'amount' => '$124.50', 'status' => 'Shipped'],
                        ['id' => '#8920', 'customer' => 'Sarah M.', 'amount' => '$89.00', 'status' => 'Processing'],
                        ['id' => '#8919', 'customer' => 'Mike R.', 'amount' => '$234.00', 'status' => 'Delivered'],
                    ] as $order)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white font-mono">{{ $order['id'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $order['customer'] }}</p>
                        </div>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $order['amount'] }}</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $order['status'] === 'Delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($order['status'] === 'Shipped' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400') }}">{{ $order['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
