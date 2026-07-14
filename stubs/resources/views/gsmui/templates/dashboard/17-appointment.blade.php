<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Appointment Scheduler</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ New Appointment</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $indicatorColors = [
            'blue' => 'bg-blue-500',
            'green' => 'bg-green-500',
            'purple' => 'bg-purple-500',
            'orange' => 'bg-orange-500',
            'red' => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
        ];
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                    <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                        <h2 class="font-semibold text-zinc-900 dark:text-white">Today's Schedule</h2>
                        <span class="text-sm text-zinc-500">June 15, 2026</span>
                    </div>
                    <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach([
                            ['time' => '09:00 AM', 'client' => 'John Smith', 'type' => 'Consultation', 'duration' => '30 min', 'color' => 'blue'],
                            ['time' => '10:30 AM', 'client' => 'Sarah Johnson', 'type' => 'Follow-up', 'duration' => '45 min', 'color' => 'green'],
                            ['time' => '02:00 PM', 'client' => 'Mike Davis', 'type' => 'New Patient', 'duration' => '60 min', 'color' => 'purple'],
                            ['time' => '04:00 PM', 'client' => 'Emily Brown', 'type' => 'Review', 'duration' => '30 min', 'color' => 'orange'],
                        ] as $apt)
                        <div class="p-4 flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                            <div class="text-sm font-medium text-zinc-500 w-20">{{ $apt['time'] }}</div>
                            <div class="w-1 h-12 {{ $indicatorColors[$apt['color']] }} rounded-full"></div>
                            <div class="flex-1">
                                <p class="font-medium text-zinc-900 dark:text-white">{{ $apt['client'] }}</p>
                                <p class="text-sm text-zinc-500">{{ $apt['type'] }} · {{ $apt['duration'] }}</p>
                            </div>
                            <button class="text-zinc-400 hover:text-zinc-600">⋮</button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Quick Stats</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Today's Appointments</span>
                            <span class="font-medium text-zinc-900 dark:text-white">8</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Completed</span>
                            <span class="font-medium text-green-600">3</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500">Upcoming</span>
                            <span class="font-medium text-blue-600">5</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">This Week</h3>
                    <div class="grid grid-cols-5 gap-1">
                        @foreach(['M', 'T', 'W', 'T', 'F'] as $day => $name)
                        <div class="text-center">
                            <p class="text-xs text-zinc-500 mb-1">{{ $name }}</p>
                            <div class="aspect-square rounded-lg {{ in_array($day, [1, 2, 4]) ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400' }} flex items-center justify-center text-sm font-medium">
                                {{ 8 + $day * 2 }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
