<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Booking System</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ New Reservation</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Today\'s Bookings', 'value' => '18'],
                ['label' => 'Available', 'value' => '12'],
                ['label' => 'Occupancy', 'value' => '85%'],
                ['label' => 'Revenue', 'value' => '$4,280'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Today's Reservations</h2>
                <div class="space-y-3">
                    @foreach([
                        ['guest' => 'John Smith', 'room' => 'Suite 101', 'checkin' => '2:00 PM', 'status' => 'Confirmed', 'color' => 'green'],
                        ['guest' => 'Maria Garcia', 'room' => 'Room 205', 'checkin' => '3:00 PM', 'status' => 'Checked In', 'color' => 'blue'],
                        ['guest' => 'Alex Johnson', 'room' => 'Suite 302', 'checkin' => '4:00 PM', 'status' => 'Pending', 'color' => 'yellow'],
                    ] as $booking)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-600 flex items-center justify-center text-zinc-600 dark:text-zinc-400 text-sm font-medium">
                            {{ substr($booking['guest'], 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $booking['guest'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $booking['room'] }} · {{ $booking['checkin'] }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$booking['color']]['bg'] }} {{ $badgeColors[$booking['color']]['text'] }}">{{ $booking['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Room Availability</h2>
                <div class="grid grid-cols-4 gap-2">
                    @foreach(range(101, 116) as $room)
                    <div class="aspect-square rounded-lg flex items-center justify-center text-sm font-medium {{ in_array($room, [103, 107, 112]) ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                        {{ $room }}
                    </div>
                    @endforeach
                </div>
                <div class="flex items-center gap-4 mt-4 text-xs text-zinc-500">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-green-100 dark:bg-green-900/30"></span> Available</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-red-100 dark:bg-red-900/30"></span> Booked</span>
                </div>
            </div>
        </div>
    </main>
</div>
