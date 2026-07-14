@props([
    'title' => 'Hope for Tomorrow Gala',
    'subtitle' => 'An Evening of Generosity and Impact',
    'date' => 'November 14, 2026',
    'venue' => 'The Grand Ballroom, Manhattan',
    'cause' => 'Providing clean water access to underserved communities worldwide.',
    'goal' => 500000,
    'raised' => 327000,
    'sponsors' => [
        ['name' => 'Apex Corp'],
        ['name' => 'Meridian Group'],
        ['name' => 'Pinnacle Trust'],
        ['name' => 'Horizon Foundation'],
    ],
    'auction' => [
        ['item' => 'Private Yacht Experience', 'value' => '$12,000'],
        ['item' => 'Signed Art Collection', 'value' => '$8,500'],
        ['item' => 'Wine Country Retreat', 'value' => '$5,000'],
    ],
])

@php
    $progressPercent = min(100, round(($raised / $goal) * 100));
@endphp

<div {{ $attributes->class(['min-h-screen bg-zinc-900 text-white']) }}>
    <header class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <gsmui:brand name="{{ $title }}" href="#" class="text-white" />
        <gsmui:button variant="outline" size="sm" class="border-amber-500/50 text-amber-400 hover:bg-amber-500/10">{{ __('Donate') }}</gsmui:button>
    </header>

    <section class="max-w-6xl mx-auto px-4 py-20 text-center">
        <gsmui:badge color="amber" variant="solid" rounded>{{ $date }}</gsmui:badge>
        <div class="mt-6">
            <gsmui:heading size="xl" level="1" class="text-white">{{ $title }}</gsmui:heading>
        </div>
        <gsmui:text size="lg" class="text-zinc-400 mt-3">{{ $subtitle }}</gsmui:text>
        <div class="mt-2 flex items-center justify-center gap-2">
            <gsmui:icon name="map-pin" variant="outline" class="w-4 h-4 text-zinc-500" />
            <gsmui:text variant="subtle" size="sm">{{ $venue }}</gsmui:text>
        </div>
        <div class="mt-8">
            <gsmui:button variant="primary" size="default" class="bg-amber-500 hover:bg-amber-600 text-zinc-900" icon="heart">{{ __('Donate Now') }}</gsmui:button>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-4 py-8">
        <gsmui:heading size="default" level="2" class="text-center text-amber-400 mb-2">{{ __('Our Cause') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="text-center text-zinc-400">{{ $cause }}</gsmui:text>
    </section>

    <section class="max-w-3xl mx-auto px-4 py-8">
        <gsmui:heading size="default" level="3" class="text-center text-white mb-4">{{ __('Fundraising Goal') }}</gsmui:heading>
        <gsmui:progress value="{{ $progressPercent }}" color="amber" label="${{ number_format($raised) }} of ${{ number_format($goal) }}" />
        <gsmui:text variant="subtle" size="sm" class="text-center mt-2 text-zinc-500">{{ $progressPercent }}% {{ __('of our goal reached') }}</gsmui:text>
    </section>

    <gsmui:divider />

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="default" level="2" class="text-center text-white mb-6">{{ __('Our Sponsors') }}</gsmui:heading>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($sponsors as $sponsor)
                <div class="px-6 py-3 border border-zinc-700 rounded-lg">
                    <gsmui:text variant="strong" class="text-zinc-300">{{ $sponsor['name'] }}</gsmui:text>
                </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="default" level="2" class="text-center text-white mb-8">{{ __('Silent Auction Preview') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($auction as $lot)
                <gsmui:card variant="ghost" class="bg-zinc-800 border-zinc-700 p-6">
                    <div class="aspect-video bg-zinc-700 rounded-lg flex items-center justify-center mb-4">
                        <gsmui:icon name="gift" variant="outline" class="w-10 h-10 text-zinc-500" />
                    </div>
                    <gsmui:text variant="strong" class="text-white">{{ $lot['item'] }}</gsmui:text>
                    <gsmui:text variant="subtle" size="sm" class="text-amber-400 mt-1">{{ __('Value: ') }}{{ $lot['value'] }}</gsmui:text>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-800 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <gsmui:heading size="lg" level="2" class="text-center text-white mb-8">{{ __('Reserve Your Table') }}</gsmui:heading>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $tickets = [
                        ['name' => 'Individual', 'price' => '$500', 'features' => ['Dinner & drinks', 'Auction access', 'Entertainment']],
                        ['name' => 'Table of 8', 'price' => '$3,500', 'features' => ['Premium seating', 'Dinner & drinks', 'Auction access', 'Recognition']],
                        ['name' => 'Patron Table', 'price' => '$10,000', 'features' => ['VIP seating', 'Premium dinner', 'Private reception', 'Name on program']],
                    ];
                @endphp
                @foreach($tickets as $tier)
                    <gsmui:card variant="ghost" class="bg-zinc-900 border-zinc-700 p-6 text-center">
                        <gsmui:heading size="default" level="3" class="text-white">{{ $tier['name'] }}</gsmui:heading>
                        <gsmui:heading size="lg" level="2" class="text-amber-400 mt-2">{{ $tier['price'] }}</gsmui:heading>
                        <div class="mt-4 space-y-2">
                            @foreach($tier['features'] as $feature)
                                <gsmui:text size="sm" class="text-zinc-400">
                                    <gsmui:icon name="check" variant="mini" class="inline w-4 h-4 text-amber-400" />
                                    {{ $feature }}
                                </gsmui:text>
                            @endforeach
                        </div>
                        <gsmui:button variant="outline" size="sm" class="mt-6 w-full border-amber-500/50 text-amber-400 hover:bg-amber-500/10">{{ __('Reserve') }}</gsmui:button>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-800 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm" class="text-zinc-600">&copy; {{ date('Y') }} {{ $title }}. {{ __('All proceeds go directly to our clean water initiatives.') }}</gsmui:text>
        </div>
    </footer>
</div>
