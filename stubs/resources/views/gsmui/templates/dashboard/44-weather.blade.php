<div class="min-h-screen bg-gradient-to-br from-blue-500 to-blue-700 dark:from-blue-900 dark:to-blue-950">
    <header class="px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Weather Dashboard</h1>
            <span class="text-white/80 text-sm">New York, NY</span>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Temperature', 'value' => '72°F', 'icon' => '🌡️'],
                ['label' => 'Humidity', 'value' => '65%', 'icon' => '💧'],
                ['label' => 'Wind', 'value' => '12 mph', 'icon' => '🌬️'],
                ['label' => 'UV Index', 'value' => '6', 'icon' => '☀️'],
            ] as $stat)
            <div class="bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/30 dark:border-white/20">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $stat['icon'] }}</span>
                    <div>
                        <p class="text-sm text-white/80">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-white">{{ $stat['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-xl border border-white/30 dark:border-white/20 p-4">
                <h2 class="font-semibold text-white mb-4">5-Day Forecast</h2>
                <div class="grid grid-cols-5 gap-2">
                    @foreach([
                        ['day' => 'Mon', 'icon' => '☀️', 'high' => '75', 'low' => '58'],
                        ['day' => 'Tue', 'icon' => '⛅', 'high' => '72', 'low' => '55'],
                        ['day' => 'Wed', 'icon' => '🌧️', 'high' => '65', 'low' => '52'],
                        ['day' => 'Thu', 'icon' => '⛈️', 'high' => '62', 'low' => '50'],
                        ['day' => 'Fri', 'icon' => '☀️', 'high' => '70', 'low' => '54'],
                    ] as $forecast)
                    <div class="text-center p-2">
                        <p class="text-xs text-white/80">{{ $forecast['day'] }}</p>
                        <span class="text-2xl">{{ $forecast['icon'] }}</span>
                        <p class="text-sm text-white">{{ $forecast['high'] }}°</p>
                        <p class="text-xs text-white/60">{{ $forecast['low'] }}°</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-xl border border-white/30 dark:border-white/20 p-4">
                <h2 class="font-semibold text-white mb-4">Hourly Temperature</h2>
                <div class="flex items-end justify-between gap-1 h-32">
                    @foreach([72, 74, 76, 78, 77, 75, 73, 70, 68, 66, 65, 64] as $hour => $temp)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <span class="text-[10px] text-white/80">{{ $temp }}°</span>
                        <div class="w-full bg-white/40 dark:bg-white/30 rounded-t" style="height: {{ ($temp - 55) * 5 }}%"></div>
                        <span class="text-[8px] text-white/60">{{ $hour + 12 }}:00</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
