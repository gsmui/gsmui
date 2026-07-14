<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Video Conference</h1>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium">+ New Meeting</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Today\'s Meetings', 'value' => '6'],
                ['label' => 'Duration', 'value' => '4.5 hrs'],
                ['label' => 'Participants', 'value' => '24'],
                ['label' => 'Recordings', 'value' => '12'],
            ] as $stat)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Upcoming Meetings</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Team Standup', 'time' => '10:00 AM', 'duration' => '30 min', 'participants' => 8],
                        ['name' => 'Client Call', 'time' => '2:00 PM', 'duration' => '1 hr', 'participants' => 4],
                        ['name' => 'Design Review', 'time' => '4:00 PM', 'duration' => '45 min', 'participants' => 6],
                    ] as $meeting)
                    <div class="flex items-center gap-3 p-3 bg-zinc-700/50 rounded-lg">
                        <div class="w-12 h-12 rounded-lg bg-blue-900/50 flex items-center justify-center text-xl">📹</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">{{ $meeting['name'] }}</p>
                            <p class="text-xs text-zinc-400">{{ $meeting['time'] }} · {{ $meeting['duration'] }}</p>
                        </div>
                        <span class="text-xs text-zinc-500">{{ $meeting['participants'] }} people</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Active Rooms</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach([
                        ['name' => 'Design Sprint', 'users' => 4, 'active' => true],
                        ['name' => 'Dev Pair', 'users' => 2, 'active' => true],
                        ['name' => 'Support', 'users' => 0, 'active' => false],
                        ['name' => 'Sales', 'users' => 0, 'active' => false],
                    ] as $room)
                    <div class="p-3 bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full {{ $room['active'] ? 'bg-green-500' : 'bg-zinc-500' }}"></span>
                            <span class="text-sm font-medium text-white">{{ $room['name'] }}</span>
                        </div>
                        <p class="text-xs text-zinc-400">{{ $room['users'] }} participants</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
