<div class="min-h-screen bg-zinc-950">
    <header class="bg-zinc-900 border-b border-zinc-800 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Crypto Trading</h1>
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1 text-sm text-green-400"><span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> Live</span>
                <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium">Trade</button>
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'BTC', 'value' => '$67,432', 'change' => '+2.4%', 'up' => true],
                ['label' => 'ETH', 'value' => '$3,892', 'change' => '+1.8%', 'up' => true],
                ['label' => 'SOL', 'value' => '$142', 'change' => '-0.5%', 'up' => false],
                ['label' => 'Portfolio', 'value' => '$24,580', 'change' => '+$1,240', 'up' => true],
            ] as $stat)
            <div class="bg-zinc-900 rounded-xl p-4 border border-zinc-800">
                <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-white">{{ $stat['value'] }}</p>
                <p class="text-xs {{ $stat['up'] ? 'text-green-400' : 'text-red-400' }}">{{ $stat['change'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-zinc-900 rounded-xl border border-zinc-800 p-4">
                <h2 class="font-semibold text-white mb-4">BTC/USD Chart</h2>
                <div class="h-64 bg-zinc-800 rounded-lg flex items-center justify-center">
                    <svg class="w-full h-full p-4" viewBox="0 0 200 80">
                        <polyline fill="none" stroke="#22c55e" stroke-width="2" points="0,60 20,55 40,45 60,50 80,35 100,40 120,25 140,30 160,20 180,15 200,10"/>
                        <linearGradient id="chartGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#22c55e" stop-opacity="0.3"/>
                            <stop offset="100%" stop-color="#22c55e" stop-opacity="0"/>
                        </linearGradient>
                        <polygon fill="url(#chartGrad)" points="0,60 20,55 40,45 60,50 80,35 100,40 120,25 140,30 160,20 180,15 200,10 200,80 0,80"/>
                    </svg>
                </div>
            </div>

            <div class="bg-zinc-900 rounded-xl border border-zinc-800 p-4">
                <h2 class="font-semibold text-white mb-4">Order Book</h2>
                <div class="space-y-1 text-xs font-mono">
                    @foreach([
                        ['price' => '67,450', 'amount' => '0.45', 'type' => 'sell'],
                        ['price' => '67,445', 'amount' => '1.23', 'type' => 'sell'],
                        ['price' => '67,432', 'amount' => '0.89', 'type' => 'sell'],
                    ] as $order)
                    <div class="flex justify-between py-1 px-2 bg-red-900/20 rounded">
                        <span class="text-red-400">{{ $order['price'] }}</span>
                        <span class="text-zinc-400">{{ $order['amount'] }}</span>
                    </div>
                    @endforeach
                    <div class="flex justify-between py-2 px-2 bg-zinc-800 rounded my-2">
                        <span class="text-white font-bold">$67,432</span>
                        <span class="text-zinc-400">Last Price</span>
                    </div>
                    @foreach([
                        ['price' => '67,428', 'amount' => '0.67', 'type' => 'buy'],
                        ['price' => '67,420', 'amount' => '2.15', 'type' => 'buy'],
                        ['price' => '67,415', 'amount' => '0.92', 'type' => 'buy'],
                    ] as $order)
                    <div class="flex justify-between py-1 px-2 bg-green-900/20 rounded">
                        <span class="text-green-400">{{ $order['price'] }}</span>
                        <span class="text-zinc-400">{{ $order['amount'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
