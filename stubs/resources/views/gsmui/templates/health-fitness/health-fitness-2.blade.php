@props([
    'title' => 'Serenity Spa',
    'subtitle' => 'Restore your mind, body, and spirit.',
    'services' => [
        ['icon' => 'sparkles', 'name' => 'Deep Tissue Massage', 'desc' => 'Release tension and restore mobility with targeted pressure.', 'price' => '$120', 'duration' => '60 min'],
        ['icon' => 'heart', 'name' => 'Facial Rejuvenation', 'desc' => 'Customized facial treatment for radiant, glowing skin.', 'price' => '$95', 'duration' => '45 min'],
        ['icon' => 'bolt', 'name' => 'Hot Stone Therapy', 'desc' => 'Heated basalt stones melt away stress and promote deep relaxation.', 'price' => '$140', 'duration' => '75 min'],
        ['icon' => 'star', 'name' => 'Aromatherapy Session', 'desc' => 'Essential oils and gentle techniques for total calm.', 'price' => '$85', 'duration' => '50 min'],
    ],
    'packages' => [
        ['name' => 'Refresh', 'price' => '$199', 'features' => ['1 massage', '1 facial', 'Herbal tea service']],
        ['name' => 'Renew', 'price' => '$349', 'features' => ['2 massages', '1 facial', 'Hot stone therapy', 'Lunch included']],
        ['name' => 'Restore', 'price' => '$549', 'features' => ['Full day access', 'All treatments', 'Private suite', 'Organic lunch']],
    ],
])

<div {{ $attributes->class(['min-h-screen bg-stone-50 dark:bg-zinc-900']) }}>
    <header class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <gsmui:brand name="{{ $title }}" href="#" />
        <gsmui:button variant="primary" size="sm" class="bg-emerald-600 hover:bg-emerald-700">{{ __('Book Now') }}</gsmui:button>
    </header>

    <section class="max-w-6xl mx-auto px-4 py-20 text-center">
        <gsmui:heading size="xl" level="1">{{ __('Relax & Rejuvenate') }}</gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-4 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-8">
            <gsmui:button variant="primary" size="default" class="bg-emerald-600 hover:bg-emerald-700" icon="sparkles">{{ __('Book Your Session') }}</gsmui:button>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Our Services') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($services as $service)
                <gsmui:card variant="default" class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                            <gsmui:icon name="{{ $service['icon'] }}" variant="outline" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <gsmui:text variant="strong">{{ $service['name'] }}</gsmui:text>
                                <gsmui:text variant="strong" class="text-emerald-600 dark:text-emerald-400">{{ $service['price'] }}</gsmui:text>
                            </div>
                            <gsmui:text variant="subtle" size="sm" class="mt-1">{{ $service['desc'] }}</gsmui:text>
                            <gsmui:text variant="subtle" size="sm" class="mt-1">
                                <gsmui:icon name="clock" variant="outline" class="inline w-3 h-3" />
                                {{ $service['duration'] }}
                            </gsmui:text>
                        </div>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <gsmui:divider />

    <section class="max-w-6xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Wellness Packages') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($packages as $index => $pkg)
                <gsmui:card variant="{{ $index === 1 ? 'elevated' : 'default' }}" class="p-6 text-center {{ $index === 1 ? 'ring-2 ring-emerald-500' : '' }}">
                    @if($index === 1)
                        <gsmui:badge color="emerald" variant="solid" rounded>{{ __('Best Value') }}</gsmui:badge>
                    @endif
                    <gsmui:heading size="default" level="3" class="mt-2">{{ $pkg['name'] }}</gsmui:heading>
                    <gsmui:heading size="lg" level="2" class="text-emerald-600 dark:text-emerald-400 mt-2">{{ $pkg['price'] }}</gsmui:heading>
                    <div class="mt-4 space-y-2 text-left">
                        @foreach($pkg['features'] as $feature)
                            <gsmui:text size="sm" class="text-zinc-600 dark:text-zinc-400">
                                <gsmui:icon name="check" variant="mini" class="inline w-4 h-4 text-emerald-500" />
                                {{ $feature }}
                            </gsmui:text>
                        @endforeach
                    </div>
                    <gsmui:button variant="{{ $index === 1 ? 'primary' : 'outline' }}" size="sm" class="mt-6 w-full {{ $index === 1 ? 'bg-emerald-600 hover:bg-emerald-700' : '' }}">{{ __('Book Package') }}</gsmui:button>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-emerald-50 dark:bg-emerald-900/10 py-16">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <gsmui:icon name="star" variant="mini" class="w-6 h-6 text-emerald-400 mx-auto" />
            <gsmui:text size="lg" class="mt-4 italic text-zinc-700 dark:text-zinc-300">{{ __('"The most relaxing experience I\'ve ever had. The hot stone therapy was absolutely transformative."') }}</gsmui:text>
            <gsmui:text variant="subtle" size="sm" class="mt-3">{{ __('— Jessica M., Regular Client') }}</gsmui:text>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
