<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-white">Log Viewer</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Errors' => '23', 'Warnings' => '89', 'Info' => '1,247', 'Debug' => '342'] as $label => $value)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <p class="text-sm text-zinc-400">{{ $label }}</p>
                <p class="text-2xl font-bold text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
            <div class="flex items-center gap-2 mb-4">
                <input type="text" placeholder="Filter logs..." class="flex-1 px-3 py-2 bg-zinc-700 border border-zinc-600 rounded-lg text-white text-sm placeholder-zinc-400">
                <button class="px-3 py-2 bg-zinc-700 border border-zinc-600 rounded-lg text-sm text-zinc-300">Filter</button>
            </div>
            <div class="font-mono text-sm space-y-1 max-h-96 overflow-auto">
                @foreach([
                    ['time' => '14:32:01', 'level' => 'ERROR', 'color' => 'text-red-400', 'msg' => 'Database connection failed'],
                    ['time' => '14:31:45', 'level' => 'WARN', 'color' => 'text-yellow-400', 'msg' => 'High memory usage detected'],
                    ['time' => '14:31:30', 'level' => 'INFO', 'color' => 'text-blue-400', 'msg' => 'Request processed successfully'],
                    ['time' => '14:31:15', 'level' => 'DEBUG', 'color' => 'text-zinc-400', 'msg' => 'Cache hit for key: user_123'],
                ] as $log)
                <div class="flex gap-3 p-2 hover:bg-zinc-700/50 rounded">
                    <span class="text-zinc-500">{{ $log['time'] }}</span>
                    <span class="{{ $log['color'] }} w-12">{{ $log['level'] }}</span>
                    <span class="text-zinc-300">{{ $log['msg'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>