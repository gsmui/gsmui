<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-white">Sports Analytics</h1>
    </header>

    <main class="p-6">
        @php
        $resultColorMap = [
            'green' => ['bg' => 'bg-green-900/50', 'text' => 'text-green-400'],
            'red' => ['bg' => 'bg-red-900/50', 'text' => 'text-red-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Wins', 'value' => '28', 'color' => 'text-green-400'],
                ['label' => 'Losses', 'value' => '12', 'color' => 'text-red-400'],
                ['label' => 'Win Rate', 'value' => '70%', 'color' => 'text-blue-400'],
                ['label' => 'Points Scored', 'value' => '2,847', 'color' => 'text-amber-400'],
            ] as $stat)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Recent Games</h2>
                <div class="space-y-3">
                    @foreach([
                        ['opponent' => 'Eagles', 'score' => '105 - 98', 'result' => 'W', 'color' => 'green'],
                        ['opponent' => 'Hawks', 'score' => '88 - 92', 'result' => 'L', 'color' => 'red'],
                        ['opponent' => 'Lions', 'score' => '112 - 101', 'result' => 'W', 'color' => 'green'],
                    ] as $game)
                    <div class="flex items-center gap-3 p-3 bg-zinc-700/50 rounded-lg">
                        <div class="w-8 h-8 rounded-full {{ $resultColorMap[$game['color']]['bg'] }} flex items-center justify-center {{ $resultColorMap[$game['color']]['text'] }} font-bold text-sm">{{ $game['result'] }}</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">vs {{ $game['opponent'] }}</p>
                            <p class="text-xs text-zinc-400">{{ $game['score'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Top Players</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Alex Johnson', 'stat' => '24.5 PPG', 'avatar' => '🏀'],
                        ['name' => 'Mike Williams', 'stat' => '11.2 RPG', 'avatar' => '🏀'],
                        ['name' => 'Chris Davis', 'stat' => '8.7 APG', 'avatar' => '🏀'],
                    ] as $player)
                    <div class="flex items-center gap-3 p-3 bg-zinc-700/50 rounded-lg">
                        <span class="text-2xl">{{ $player['avatar'] }}</span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">{{ $player['name'] }}</p>
                            <p class="text-xs text-zinc-400">{{ $player['stat'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
