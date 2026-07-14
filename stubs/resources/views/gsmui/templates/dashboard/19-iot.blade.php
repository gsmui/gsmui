<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Smart Home</h1>
            <div class="flex items-center gap-2 text-sm text-zinc-400">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                All Systems Online
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['name' => 'Living Room', 'temp' => '72°F', 'icon' => '💡', 'active' => true],
                ['name' => 'Bedroom', 'temp' => '68°F', 'icon' => '🛏️', 'active' => false],
                ['name' => 'Kitchen', 'temp' => '70°F', 'icon' => '🍳', 'active' => true],
                ['name' => 'Garage', 'temp' => '65°F', 'icon' => '🚗', 'active' => false],
            ] as $room)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700 {{ $room['active'] ? 'ring-2 ring-blue-500' : '' }}">
                <span class="text-2xl">{{ $room['icon'] }}</span>
                <h3 class="text-white font-medium mt-2">{{ $room['name'] }}</h3>
                <p class="text-zinc-400 text-sm">{{ $room['temp'] }}</p>
                <div class="mt-3 flex items-center gap-2">
                    <div class="w-10 h-5 rounded-full {{ $room['active'] ? 'bg-blue-500' : 'bg-zinc-600' }} relative cursor-pointer">
                        <div class="absolute top-0.5 {{ $room['active'] ? 'left-5' : 'left-0.5' }} w-4 h-4 bg-white rounded-full transition-all"></div>
                    </div>
                    <span class="text-xs text-zinc-500">{{ $room['active'] ? 'On' : 'Off' }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="text-white font-semibold mb-4">Energy Usage</h2>
                <div class="text-center py-8">
                    <svg viewBox="0 0 100 100" class="w-32 h-32 mx-auto">
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#3f3f46" stroke-width="8"/>
                        <circle cx="50" cy="50" r="40" fill="none" stroke="#22c55e" stroke-width="8" stroke-dasharray="251" stroke-dashoffset="63" transform="rotate(-90 50 50)"/>
                    </svg>
                    <p class="text-3xl font-bold text-white mt-4">75%</p>
                    <p class="text-zinc-400 text-sm">Efficient Usage</p>
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="text-white font-semibold mb-4">Devices</h2>
                <div class="space-y-3">
                    @foreach(['Smart Lights' => true, 'Security Camera' => true, 'Thermostat' => true, 'Door Lock' => false] as $device => $active)
                    <div class="flex items-center justify-between">
                        <span class="text-zinc-300 text-sm">{{ $device }}</span>
                        <span class="w-2 h-2 rounded-full {{ $active ? 'bg-green-500' : 'bg-zinc-500' }}"></span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="text-white font-semibold mb-4">Schedule</h2>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="text-zinc-500 text-sm w-16">06:00</span>
                        <span class="text-zinc-300 text-sm">Lights on (Bedroom)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-zinc-500 text-sm w-16">07:30</span>
                        <span class="text-zinc-300 text-sm">Coffee maker start</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-zinc-500 text-sm w-16">22:00</span>
                        <span class="text-zinc-300 text-sm">All lights off</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
