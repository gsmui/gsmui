<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">NFT Marketplace</h1>
            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium">Connect Wallet</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Portfolio Value', 'value' => '12.4 ETH', 'change' => '+2.1 ETH'],
                ['label' => 'Items Owned', 'value' => '47'],
                ['label' => 'Active Listings', 'value' => '12'],
                ['label' => 'Total Sales', 'value' => '89 ETH'],
            ] as $stat)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-white">{{ $stat['value'] }}</p>
                @isset($stat['change'])
                <p class="text-xs text-green-400">{{ $stat['change'] }}</p>
                @endisset
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Featured NFTs</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach([
                        ['name' => 'Crypto Punk #4521', 'price' => '2.5 ETH', 'icon' => '🖼️'],
                        ['name' => 'Bored Ape #8901', 'price' => '15.2 ETH', 'icon' => '🐵'],
                        ['name' => 'Art Block #1234', 'price' => '1.8 ETH', 'icon' => '🎨'],
                        ['name' => 'Doodle #5678', 'price' => '3.4 ETH', 'icon' => '✏️'],
                    ] as $nft)
                    <div class="bg-zinc-700/50 rounded-lg p-3 hover:bg-zinc-700 cursor-pointer">
                        <div class="aspect-square bg-zinc-600 rounded-lg flex items-center justify-center text-4xl mb-2">{{ $nft['icon'] }}</div>
                        <p class="text-sm font-medium text-white">{{ $nft['name'] }}</p>
                        <p class="text-xs text-purple-400">{{ $nft['price'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Recent Activity</h2>
                <div class="space-y-3">
                    @foreach([
                        ['action' => 'Bought', 'item' => 'Crypto Punk #4521', 'price' => '2.5 ETH', 'time' => '2h ago'],
                        ['action' => 'Listed', 'item' => 'Doodle #5678', 'price' => '3.4 ETH', 'time' => '5h ago'],
                        ['action' => 'Bid', 'item' => 'Bored Ape #8901', 'price' => '14.8 ETH', 'time' => '1d ago'],
                    ] as $activity)
                    <div class="flex items-center gap-3 p-3 bg-zinc-700/50 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-purple-900/50 flex items-center justify-center text-xs font-bold text-purple-400">
                            {{ strtoupper(substr($activity['action'], 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-white">{{ $activity['action'] }} <span class="text-zinc-400">{{ $activity['item'] }}</span></p>
                            <p class="text-xs text-zinc-500">{{ $activity['time'] }}</p>
                        </div>
                        <span class="text-sm font-medium text-purple-400">{{ $activity['price'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
