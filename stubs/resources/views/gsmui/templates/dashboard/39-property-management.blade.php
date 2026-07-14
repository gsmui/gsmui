<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Property Management</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Add Property</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $priorityColorMap = [
            'red' => 'text-red-600',
            'yellow' => 'text-yellow-600',
            'blue' => 'text-blue-600',
        ];
        $dotColors = [
            'red' => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
            'blue' => 'bg-blue-500',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Properties', 'value' => '24', 'icon' => '🏢'],
                ['label' => 'Occupancy Rate', 'value' => '94%', 'icon' => '📊'],
                ['label' => 'Monthly Revenue', 'value' => '$48,200', 'icon' => '💰'],
                ['label' => 'Pending Maint.', 'value' => '7', 'icon' => '🔧'],
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
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Properties</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Sunset Apartments', 'units' => '12', 'occupancy' => '100%', 'status' => 'Full'],
                        ['name' => 'Oak Street Complex', 'units' => '8', 'occupancy' => '87%', 'status' => '1 Vacant'],
                        ['name' => 'Downtown Lofts', 'units' => '16', 'occupancy' => '94%', 'status' => '1 Vacant'],
                    ] as $property)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-lg">🏢</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $property['name'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $property['units'] }} units · {{ $property['occupancy'] }} occupied</p>
                        </div>
                        <span class="text-xs text-zinc-600 dark:text-zinc-400">{{ $property['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Maintenance</h2>
                <div class="space-y-3">
                    @foreach([
                        ['issue' => 'Plumbing repair - Unit 4B', 'priority' => 'High', 'color' => 'red', 'date' => '2 days ago'],
                        ['issue' => 'AC maintenance - Building A', 'priority' => 'Medium', 'color' => 'yellow', 'date' => '5 days ago'],
                        ['issue' => 'Roof inspection - Oak St.', 'priority' => 'Low', 'color' => 'blue', 'date' => '1 week ago'],
                    ] as $maintenance)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-2 h-2 rounded-full {{ $dotColors[$maintenance['color']] }}"></div>
                        <div class="flex-1">
                            <p class="text-sm text-zinc-900 dark:text-white">{{ $maintenance['issue'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $maintenance['date'] }}</p>
                        </div>
                        <span class="text-xs font-medium {{ $priorityColorMap[$maintenance['color']] }}">{{ $maintenance['priority'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
