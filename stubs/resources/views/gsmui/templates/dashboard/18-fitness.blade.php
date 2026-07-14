<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Fitness Tracker</h1>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-orange-500 to-red-500 dark:from-orange-600 dark:to-red-600 rounded-xl p-4 text-white shadow-lg">
                <p class="text-sm opacity-80">Calories Burned</p>
                <p class="text-3xl font-bold">2,450</p>
                <p class="text-xs opacity-80 mt-1">Goal: 3,000</p>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-cyan-500 dark:from-blue-600 dark:to-cyan-600 rounded-xl p-4 text-white shadow-lg">
                <p class="text-sm opacity-80">Steps</p>
                <p class="text-3xl font-bold">12,847</p>
                <p class="text-xs opacity-80 mt-1">Goal: 15,000</p>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-emerald-500 dark:from-green-600 dark:to-emerald-600 rounded-xl p-4 text-white shadow-lg">
                <p class="text-sm opacity-80">Active Minutes</p>
                <p class="text-3xl font-bold">87</p>
                <p class="text-xs opacity-80 mt-1">Goal: 90</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-pink-500 dark:from-purple-600 dark:to-pink-600 rounded-xl p-4 text-white shadow-lg">
                <p class="text-sm opacity-80">Heart Rate</p>
                <p class="text-3xl font-bold">72 <span class="text-lg">bpm</span></p>
                <p class="text-xs opacity-80 mt-1">Resting</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 shadow-sm">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Weekly Activity</h2>
                <div class="flex items-end justify-between gap-2 h-40">
                    @foreach([65, 45, 80, 55, 90, 70, 30] as $day => $height)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full bg-blue-500 dark:bg-blue-400 rounded-t-md" style="height: {{ $height }}%"></div>
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ ['M', 'T', 'W', 'T', 'F', 'S', 'S'][$day] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4 shadow-sm">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Today's Workouts</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Morning Run', 'duration' => '35 min', 'calories' => 420, 'icon' => '🏃'],
                        ['name' => 'Strength Training', 'duration' => '45 min', 'calories' => 380, 'icon' => '🏋️'],
                        ['name' => 'Yoga Session', 'duration' => '30 min', 'calories' => 150, 'icon' => '🧘'],
                    ] as $workout)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <span class="text-2xl">{{ $workout['icon'] }}</span>
                        <div class="flex-1">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $workout['name'] }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $workout['duration'] }}</p>
                        </div>
                        <span class="text-sm font-medium text-orange-600 dark:text-orange-400">{{ $workout['calories'] }} cal</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
