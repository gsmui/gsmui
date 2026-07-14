@props([
    'title' => 'Neon Beats Festival',
    'subtitle' => 'Three Days of Pure Musical Magic',
    'dates' => 'August 8-10, 2026',
    'location' => 'Desert Valley Arena, Las Vegas',
    'lineup' => [
        ['name' => 'Aurora Wave', 'genre' => 'Electronic', 'time' => 'Fri 9:00 PM'],
        ['name' => 'The Midnight Echo', 'genre' => 'Indie Rock', 'time' => 'Sat 8:00 PM'],
        ['name' => 'DJ Solaris', 'genre' => 'House', 'time' => 'Sat 11:00 PM'],
        ['name' => 'Velvet Storm', 'genre' => 'Pop', 'time' => 'Sun 9:00 PM'],
    ],
    'stages' => ['Main Stage', 'Sunset Arena', 'Electric Tent', 'Acoustic Grove'],
])

<div {{ $attributes->class(['min-h-screen bg-gradient-to-br from-purple-900 via-pink-800 to-orange-600 text-white']) }}>
    <header class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <gsmui:brand name="{{ $title }}" href="#" class="text-white" />
        <gsmui:button variant="outline" size="sm" class="border-white/30 text-white hover:bg-white/10">{{ __('Buy Tickets') }}</gsmui:button>
    </header>

    <section class="max-w-6xl mx-auto px-4 py-20 text-center">
        <gsmui:badge color="amber" variant="solid" rounded>{{ $dates }}</gsmui:badge>
        <div class="mt-6">
            <gsmui:heading size="xl" level="1" class="text-white">{{ $title }}</gsmui:heading>
        </div>
        <gsmui:text size="lg" class="text-white/80 mt-3">{{ $subtitle }}</gsmui:text>
        <div class="mt-2">
            <gsmui:icon name="map-pin" variant="outline" class="inline w-4 h-4 text-white/60" />
            <gsmui:text size="sm" class="text-white/60">{{ $location }}</gsmui:text>
        </div>
        <div class="mt-8">
            <gsmui:button variant="filled" size="default" class="bg-white text-purple-900 hover:bg-white/90" icon="ticket">{{ __('Get Tickets') }}</gsmui:button>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="lg" level="2" class="text-center text-white mb-4">{{ __('Stages') }}</gsmui:heading>
        <div class="flex flex-wrap justify-center gap-2">
            @foreach($stages as $stage)
                <gsmui:badge color="pink" variant="solid" rounded>{{ $stage }}</gsmui:badge>
            @endforeach
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="lg" level="2" class="text-center text-white mb-8">{{ __('Lineup') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($lineup as $artist)
                <gsmui:card variant="ghost" class="bg-white/10 backdrop-blur-sm border-white/10 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <gsmui:text variant="strong" size="lg" class="text-white">{{ $artist['name'] }}</gsmui:text>
                            <div class="mt-1 flex gap-2">
                                <gsmui:badge color="violet" rounded>{{ $artist['genre'] }}</gsmui:badge>
                            </div>
                        </div>
                        <div class="text-right">
                            <gsmui:icon name="clock" variant="outline" class="inline w-4 h-4 text-white/60" />
                            <gsmui:text size="sm" class="text-white/60">{{ $artist['time'] }}</gsmui:text>
                        </div>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="lg" level="2" class="text-center text-white mb-6">{{ __('Festival Map') }}</gsmui:heading>
        <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 h-64 flex items-center justify-center">
            <div class="text-center">
                <gsmui:icon name="map-pin" variant="outline" class="w-12 h-12 text-white/40 mx-auto" />
                <gsmui:text class="text-white/40 mt-2">{{ __('Interactive map coming soon') }}</gsmui:text>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center text-white mb-8">{{ __('Tickets') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $tiers = [
                    ['name' => 'General', 'price' => '$149', 'features' => ['3-day access', 'All stages', 'Food court access']],
                    ['name' => 'VIP', 'price' => '$349', 'features' => ['3-day access', 'VIP lounge', 'Meet & greet', 'Free drinks']],
                    ['name' => 'Platinum', 'price' => '$699', 'features' => ['All VIP perks', 'Backstage access', 'Private viewing', 'Afterparty']],
                ];
            @endphp
            @foreach($tiers as $tier)
                <gsmui:card variant="ghost" class="bg-white/10 backdrop-blur-sm border-white/10 p-6 text-center">
                    <gsmui:heading size="default" level="3" class="text-white">{{ $tier['name'] }}</gsmui:heading>
                    <gsmui:heading size="lg" level="2" class="text-amber-400 mt-2">{{ $tier['price'] }}</gsmui:heading>
                    <div class="mt-4 space-y-2">
                        @foreach($tier['features'] as $feature)
                            <gsmui:text size="sm" class="text-white/70">
                                <gsmui:icon name="check" variant="mini" class="inline w-4 h-4 text-amber-400" />
                                {{ $feature }}
                            </gsmui:text>
                        @endforeach
                    </div>
                    <gsmui:button variant="outline" size="sm" class="mt-6 w-full border-white/30 text-white hover:bg-white/10">{{ __('Select') }}</gsmui:button>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <footer class="border-t border-white/10 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <gsmui:text size="sm" class="text-white/50">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
