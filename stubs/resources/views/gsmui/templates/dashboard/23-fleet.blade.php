<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Fleet Management</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Add Vehicle</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'zinc' => ['bg' => 'bg-zinc-100 dark:bg-zinc-900/30', 'text' => 'text-zinc-800 dark:text-zinc-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Vehicles', 'value' => '48', 'icon' => '🚛'],
                ['label' => 'Active', 'value' => '42', 'icon' => '✅'],
                ['label' => 'In Maintenance', 'value' => '4', 'icon' => '🔧'],
                ['label' => 'Fuel Efficiency', 'value' => '8.2mpg', 'icon' => '⛽'],
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
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Vehicle Status</h2>
                <div class="space-y-3">
                    @foreach([
                        ['plate' => 'ABC-1234', 'driver' => 'John D.', 'location' => 'Highway 101', 'status' => 'On Route', 'color' => 'green'],
                        ['plate' => 'XYZ-5678', 'driver' => 'Sarah M.', 'location' => 'Distribution Center', 'status' => 'Loading', 'color' => 'yellow'],
                        ['plate' => 'DEF-9012', 'driver' => 'Mike R.', 'location' => 'Depot', 'status' => 'Idle', 'color' => 'zinc'],
                    ] as $vehicle)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-10 h-10 rounded-lg bg-zinc-200 dark:bg-zinc-600 flex items-center justify-center text-lg">🚛</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $vehicle['plate'] }} - {{ $vehicle['driver'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $vehicle['location'] }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$vehicle['color']]['bg'] }} {{ $badgeColors[$vehicle['color']]['text'] }}">{{ $vehicle['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Maintenance Schedule</h2>
                <div class="space-y-3">
                    @foreach(['Oil change - Vehicle DEF-9012', 'Tire rotation - ABC-1234', 'Brake inspection - All fleet'] as $item)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
