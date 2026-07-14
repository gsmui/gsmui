@extends('gsmui::layouts.demo')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Restaurant Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Today\'s Revenue', 'value' => '$4,523', 'icon' => '💵'],
                ['label' => 'Orders', 'value' => '87', 'icon' => '📝'],
                ['label' => 'Avg Order', 'value' => '$52', 'icon' => '📊'],
                ['label' => 'Reviews', 'value' => '4.8⭐', 'icon' => '⭐'],
            ] as $stat)
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-5 border border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $stat['icon'] }}</span>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                            <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Active Orders</h3>
                <div class="space-y-3">
                    @foreach([
                        ['table' => 'Table 5', 'items' => '2x Burger, 1x Fries', 'status' => 'Preparing', 'time' => '12 min'],
                        ['table' => 'Table 12', 'items' => '1x Pizza, 2x Salad', 'status' => 'Ready', 'time' => '5 min'],
                        ['table' => 'Takeaway', 'items' => '3x Sushi Roll', 'status' => 'Pending', 'time' => '2 min'],
                    ] as $order)
                        <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">{{ $order['table'] }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $order['items'] }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs px-2 py-0.5 rounded-full {{ $order['status'] === 'Ready' ? 'bg-green-100 text-green-700' : ($order['status'] === 'Preparing' ? 'bg-yellow-100 text-yellow-700' : 'bg-zinc-100 text-zinc-700') }}">{{ $order['status'] }}</span>
                                <p class="text-xs text-zinc-500 mt-1">{{ $order['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Popular Items</h3>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Classic Burger', 'orders' => 45, 'revenue' => '$895'],
                        ['name' => 'Margherita Pizza', 'orders' => 38, 'revenue' => '$760'],
                        ['name' => 'Caesar Salad', 'orders' => 32, 'revenue' => '$480'],
                    ] as $item)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">{{ $item['name'] }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $item['orders'] }} orders</p>
                            </div>
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ $item['revenue'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
