<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">CI/CD Pipeline</h1>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium">Run Pipeline</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $dotColors = [
            'green' => 'bg-green-500',
            'blue' => 'bg-blue-500',
            'red' => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
        ];
        $badgeColors = [
            'green' => ['bg' => 'bg-green-900/30', 'text' => 'text-green-400'],
            'blue' => ['bg' => 'bg-blue-900/30', 'text' => 'text-blue-400'],
            'red' => ['bg' => 'bg-red-900/30', 'text' => 'text-red-400'],
            'yellow' => ['bg' => 'bg-yellow-900/30', 'text' => 'text-yellow-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Builds', 'value' => '1,234', 'color' => 'text-blue-400'],
                ['label' => 'Success Rate', 'value' => '98.2%', 'color' => 'text-green-400'],
                ['label' => 'Avg Duration', 'value' => '4m 32s', 'color' => 'text-zinc-300'],
                ['label' => 'Failed (24h)', 'value' => '3', 'color' => 'text-red-400'],
            ] as $stat)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-zinc-800 rounded-xl border border-zinc-700">
            <div class="p-4 border-b border-zinc-700">
                <h2 class="font-semibold text-white">Recent Pipelines</h2>
            </div>
            <div class="divide-y divide-zinc-700">
                @foreach([
                    ['id' => '#4521', 'branch' => 'main', 'status' => 'Success', 'color' => 'green', 'time' => '2 min ago', 'duration' => '3m 45s'],
                    ['id' => '#4520', 'branch' => 'feat/auth', 'status' => 'Running', 'color' => 'blue', 'time' => '5 min ago', 'duration' => '1m 20s...'],
                    ['id' => '#4519', 'branch' => 'fix/login', 'status' => 'Failed', 'color' => 'red', 'time' => '12 min ago', 'duration' => '2m 10s'],
                ] as $pipeline)
                <div class="p-4 flex items-center gap-4 hover:bg-zinc-700/50">
                    <div class="w-3 h-3 rounded-full {{ $dotColors[$pipeline['color']] }}"></div>
                    <div class="flex-1">
                        <p class="font-medium text-white">{{ $pipeline['id'] }} <span class="text-zinc-400 font-normal">{{ $pipeline['branch'] }}</span></p>
                        <p class="text-sm text-zinc-500">{{ $pipeline['time'] }} · {{ $pipeline['duration'] }}</p>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $badgeColors[$pipeline['color']]['bg'] }} {{ $badgeColors[$pipeline['color']]['text'] }}">{{ $pipeline['status'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
