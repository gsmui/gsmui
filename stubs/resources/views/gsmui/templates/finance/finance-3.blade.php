@props([
    'title' => 'CryptoVault',
    'subtitle' => __('Trade crypto with confidence. Low fees, deep liquidity, instant execution.'),
    'coins' => [],
    'features' => [],
])

@php
$coins = count($coins) ? $coins : [
    ['name' => 'Bitcoin', 'symbol' => 'BTC', 'price' => '$67,245.80', 'change_24h' => '+3.24%', 'market_cap' => '$1.32T'],
    ['name' => 'Ethereum', 'symbol' => 'ETH', 'price' => '$3,521.15', 'change_24h' => '+1.87%', 'market_cap' => '$423B'],
    ['name' => 'Solana', 'symbol' => 'SOL', 'price' => '$178.40', 'change_24h' => '-2.15%', 'market_cap' => '$78B'],
    ['name' => 'Cardano', 'symbol' => 'ADA', 'price' => '$0.62', 'change_24h' => '+5.42%', 'market_cap' => '$22B'],
    ['name' => 'Polygon', 'symbol' => 'MATIC', 'price' => '$0.85', 'change_24h' => '-0.93%', 'market_cap' => '$8.5B'],
];
$features = count($features) ? $features : [
    ['icon' => 'shield-check', 'name' => 'Cold Storage'],
    ['icon' => 'chart-bar', 'name' => 'Advanced Charts'],
    ['icon' => 'device-phone-mobile', 'name' => 'Mobile Trading'],
    ['icon' => 'currency-dollar', 'name' => 'Low Fees (0.1%)'],
    ['icon' => 'globe', 'name' => '200+ Coins'],
    ['icon' => 'clock', 'name' => '24/7 Support'],
];
@endphp

<div {{ $attributes->class('bg-zinc-950 text-white min-h-screen') }}>
    <header class="border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Markets') }}</a>
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Trade') }}</a>
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Earn') }}</a>
            </nav>
            <div class="flex items-center gap-3">
                <gsmui:button variant="ghost" size="sm">{{ __('Login') }}</gsmui:button>
                <gsmui:button variant="primary" size="sm">{{ __('Sign Up') }}</gsmui:button>
            </div>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <gsmui:heading size="xl" level="1">{{ __('Trade Crypto with Confidence') }}</gsmui:heading>
        <p class="mt-4 text-lg text-zinc-400 max-w-2xl mx-auto">{{ $subtitle }}</p>
        <div class="mt-8 flex items-center justify-center gap-4">
            <gsmui:button variant="filled" href="#">{{ __('Start Trading') }}</gsmui:button>
            <gsmui:button variant="ghost" href="#">{{ __('View Markets') }}</gsmui:button>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <gsmui:heading size="lg" level="2">{{ __('Top Coins') }}</gsmui:heading>
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-zinc-800 text-xs text-zinc-500 uppercase">
                        <th class="pb-3 pr-4">{{ __('Name') }}</th>
                        <th class="pb-3 pr-4">{{ __('Price') }}</th>
                        <th class="pb-3 pr-4">{{ __('24h Change') }}</th>
                        <th class="pb-3">{{ __('Market Cap') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coins as $coin)
                        @php $isUp = str_starts_with($coin['change_24h'], '+'); @endphp
                        <tr class="border-b border-zinc-800/50">
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-zinc-800 flex items-center justify-center text-xs font-bold text-zinc-400">{{ substr($coin['symbol'], 0, 2) }}</div>
                                    <div>
                                        <gsmui:text variant="strong" size="sm">{{ $coin['name'] }}</gsmui:text>
                                        <p class="text-xs text-zinc-500">{{ $coin['symbol'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 pr-4 text-sm font-medium tabular-nums">{{ $coin['price'] }}</td>
                            <td class="py-4 pr-4">
                                <span @class([
                                    'text-sm font-medium tabular-nums flex items-center gap-1',
                                    'text-emerald-400' => $isUp,
                                    'text-red-400' => !$isUp,
                                ])>
                                    <gsmui:icon :name="$isUp ? 'arrow-trending-up' : 'arrow-trending-down'" class="w-3.5 h-3.5" />
                                    {{ $coin['change_24h'] }}
                                </span>
                            </td>
                            <td class="py-4 text-sm text-zinc-400 tabular-nums">{{ $coin['market_cap'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <gsmui:heading size="lg" level="2">{{ __('Why :title', ['title' => $title]) }}</gsmui:heading>
            </div>
            <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($features as $feature)
                    <div class="text-center">
                        <div class="w-12 h-12 mx-auto rounded-xl bg-zinc-800 flex items-center justify-center">
                            <gsmui:icon :name="$feature['icon']" class="w-6 h-6 text-cyan-400" />
                        </div>
                        <p class="mt-2 text-sm text-zinc-300">{{ $feature['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16 text-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2">{{ __('Ready to Trade?') }}</gsmui:heading>
            <p class="mt-2 text-zinc-400">{{ __('Create an account in minutes and start trading 200+ cryptocurrencies.') }}</p>
            <gsmui:button variant="filled" class="mt-6" href="#">{{ __('Get Started Free') }}</gsmui:button>
        </div>
    </section>

    <footer class="border-t border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
