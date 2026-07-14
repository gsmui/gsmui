@props([
    'title' => 'IronForge Gym',
    'subtitle' => 'Where champions are made.',
    'classes' => [
        ['name' => 'HIIT Blast', 'time' => '6:00 AM', 'instructor' => 'Mike Torres', 'intensity' => 'High'],
        ['name' => 'Power Yoga', 'time' => '8:00 AM', 'instructor' => 'Sarah Lin', 'intensity' => 'Medium'],
        ['name' => 'Boxing Fundamentals', 'time' => '12:00 PM', 'instructor' => 'Jake Rivera', 'intensity' => 'High'],
        ['name' => 'Recovery Stretch', 'time' => '5:00 PM', 'instructor' => 'Emma Chen', 'intensity' => 'Low'],
    ],
    'plans' => [
        ['name' => 'Starter', 'price' => '$29', 'period' => '/month', 'features' => ['Gym access', 'Locker room', '1 class/week']],
        ['name' => 'Pro', 'price' => '$59', 'period' => '/month', 'features' => ['24/7 access', 'All classes', 'Sauna', 'Nutrition plan']],
        ['name' => 'Elite', 'price' => '$99', 'period' => '/month', 'features' => ['All Pro perks', 'Personal trainer', 'Recovery suite', 'Supplements']],
    ],
    'stats' => [
        ['value' => '15K+', 'label' => 'Members'],
        ['value' => '80+', 'label' => 'Classes/Week'],
        ['value' => '25', 'label' => 'Expert Trainers'],
    ],
])

<div {{ $attributes->class(['min-h-screen bg-zinc-900 text-white']) }}>
    <header class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <gsmui:brand name="{{ $title }}" href="#" class="text-white" />
        <nav class="hidden md:flex items-center gap-6">
            <gsmui:text size="sm" class="text-zinc-400">{{ __('Classes') }}</gsmui:text>
            <gsmui:text size="sm" class="text-zinc-400">{{ __('Plans') }}</gsmui:text>
            <gsmui:text size="sm" class="text-zinc-400">{{ __('Trainers') }}</gsmui:text>
        </nav>
        <gsmui:button variant="primary" size="sm" class="bg-red-500 hover:bg-red-600">{{ __('Join Now') }}</gsmui:button>
    </header>

    <section class="max-w-6xl mx-auto px-4 py-20 text-center">
        <gsmui:heading size="xl" level="1" class="text-white">{{ __('Transform Your Body') }}</gsmui:heading>
        <gsmui:text size="lg" class="text-zinc-400 mt-4 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-8 flex justify-center gap-3">
            <gsmui:button variant="primary" size="default" class="bg-red-500 hover:bg-red-600" icon="fire">{{ __('Start Free Trial') }}</gsmui:button>
            <gsmui:button variant="outline" size="default" class="border-zinc-700 text-zinc-300 hover:bg-zinc-800">{{ __('View Classes') }}</gsmui:button>
        </div>
    </section>

    <section class="bg-zinc-800/50 py-12">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-3 gap-6 text-center">
            @foreach($stats as $stat)
                <div>
                    <gsmui:heading size="lg" level="2" class="text-red-400">{{ $stat['value'] }}</gsmui:heading>
                    <gsmui:text variant="subtle" class="text-zinc-400">{{ $stat['label'] }}</gsmui:text>
                </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center text-white mb-8">{{ __('Today\'s Classes') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($classes as $class)
                <gsmui:card variant="ghost" class="bg-zinc-800 border-zinc-700 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <gsmui:text variant="strong" class="text-white">{{ $class['name'] }}</gsmui:text>
                            <gsmui:text variant="subtle" size="sm" class="text-zinc-400">{{ $class['instructor'] }} &middot; {{ $class['time'] }}</gsmui:text>
                        </div>
                        @php
                            $color = $class['intensity'] === 'High' ? 'red' : ($class['intensity'] === 'Medium' ? 'amber' : 'green');
                        @endphp
                        <gsmui:badge color="{{ $color }}" rounded>{{ $class['intensity'] }}</gsmui:badge>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <gsmui:divider />

    <section class="max-w-6xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center text-white mb-8">{{ __('Membership Plans') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($plans as $index => $plan)
                <gsmui:card variant="ghost" class="bg-zinc-800 {{ $index === 1 ? 'border-red-500' : 'border-zinc-700' }} p-6 text-center relative">
                    @if($index === 1)
                        <gsmui:badge color="red" variant="solid" rounded class="absolute -top-3 left-1/2 -translate-x-1/2">{{ __('Popular') }}</gsmui:badge>
                    @endif
                    <gsmui:heading size="default" level="3" class="text-white">{{ $plan['name'] }}</gsmui:heading>
                    <div class="mt-2">
                        <gsmui:heading size="lg" level="2" class="text-white">{{ $plan['price'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" size="sm" class="text-zinc-500">{{ $plan['period'] }}</gsmui:text>
                    </div>
                    <div class="mt-4 space-y-2 text-left">
                        @foreach($plan['features'] as $feature)
                            <gsmui:text size="sm" class="text-zinc-400">
                                <gsmui:icon name="check" variant="mini" class="inline w-4 h-4 text-red-400" />
                                {{ $feature }}
                            </gsmui:text>
                        @endforeach
                    </div>
                    <gsmui:button variant="{{ $index === 1 ? 'primary' : 'outline' }}" size="sm" class="mt-6 w-full {{ $index === 1 ? 'bg-red-500 hover:bg-red-600' : 'border-zinc-600 text-zinc-300 hover:bg-zinc-700' }}">{{ __('Get Started') }}</gsmui:button>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-800/50 py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <gsmui:heading size="lg" level="2" class="text-white">{{ __('Meet Our Trainers') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="text-zinc-400 mt-2 mb-8">{{ __('Certified professionals dedicated to your success.') }}</gsmui:text>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $trainers = [
                        ['name' => 'Mike Torres', 'specialty' => 'HIIT & Strength'],
                        ['name' => 'Sarah Lin', 'specialty' => 'Yoga & Flexibility'],
                        ['name' => 'Jake Rivera', 'specialty' => 'Boxing & MMA'],
                        ['name' => 'Emma Chen', 'specialty' => 'Pilates & Recovery'],
                    ];
                @endphp
                @foreach($trainers as $trainer)
                    <div class="text-center">
                        <gsmui:avatar name="{{ $trainer['name'] }}" size="xl" circle />
                        <gsmui:text variant="strong" size="sm" class="text-white mt-3">{{ $trainer['name'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm" class="text-zinc-500">{{ $trainer['specialty'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-800 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm" class="text-zinc-600">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
