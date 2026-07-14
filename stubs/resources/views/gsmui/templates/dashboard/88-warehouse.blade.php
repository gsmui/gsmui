<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Warehouse Management</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Capacity' => '78%', 'Orders Today' => '234', 'Picked' => '189', 'Pending' => '45'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Zones</h2>
                <div class="grid grid-cols-3 gap-3">
                    @foreach(['A' => 85, 'B' => 62, 'C' => 94, 'D' => 45, 'E' => 78, 'F' => 56] as $zone => $fill)
                    <div class="text-center p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">Zone {{ $zone }}</p>
                        <p class="text-lg font-bold {{ $fill > 90 ? 'text-red-600' : ($fill > 70 ? 'text-yellow-600' : 'text-green-600') }}">{{ $fill }}%</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Active Pickers</h2>
                <div class="space-y-3">
                    @foreach(['Picker 1 - Zone A' => '12 orders', 'Picker 2 - Zone B' => '8 orders'] as $picker => $orders)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $picker }}</p>
                            <p class="text-xs text-zinc-500">{{ $orders }} picked</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>