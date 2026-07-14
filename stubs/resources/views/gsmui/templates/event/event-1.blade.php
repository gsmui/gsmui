@props([
    'title' => 'Tech Summit 2026',
    'subtitle' => 'Where Innovation Meets Opportunity',
    'event_date' => 'September 15-17, 2026',
    'event_location' => 'San Francisco Convention Center',
    'speakers' => [
        ['name' => 'Sarah Chen', 'role' => 'CTO, FutureTech', 'topic' => 'AI in Enterprise'],
        ['name' => 'Marcus Williams', 'role' => 'VP Engineering, CloudScale', 'topic' => 'Cloud Architecture'],
        ['name' => 'Dr. Aisha Patel', 'role' => 'Research Lead, DataVision', 'topic' => 'Machine Learning'],
    ],
    'schedule' => [
        ['time' => '9:00 AM', 'title' => 'Opening Keynote', 'speaker' => 'Sarah Chen'],
        ['time' => '10:30 AM', 'title' => 'Cloud-Native Patterns', 'speaker' => 'Marcus Williams'],
        ['time' => '1:00 PM', 'title' => 'ML in Production', 'speaker' => 'Dr. Aisha Patel'],
        ['time' => '3:00 PM', 'title' => 'Panel Discussion', 'speaker' => 'All Speakers'],
    ],
    'stats' => [
        ['value' => '2,500+', 'label' => 'Attendees'],
        ['value' => '50+', 'label' => 'Speakers'],
        ['value' => '3', 'label' => 'Days'],
    ],
])

<div {{ $attributes->class(['bg-white dark:bg-zinc-900 min-h-screen']) }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <gsmui:brand name="{{ $title }}" href="#" />
            <gsmui:button variant="primary" size="sm">{{ __('Register Now') }}</gsmui:button>
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-4 py-16 text-center">
        <gsmui:badge color="blue" variant="solid" rounded>{{ $event_date }}</gsmui:badge>
        <div class="mt-4">
            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        </div>
        <gsmui:text variant="subtle" size="lg">{{ $subtitle }}</gsmui:text>
        <div class="mt-2">
            <gsmui:badge color="indigo">{{ $event_location }}</gsmui:badge>
        </div>
        <div class="mt-8 flex justify-center gap-3">
            <gsmui:button variant="primary" size="default" icon="ticket">{{ __('Get Your Ticket') }}</gsmui:button>
            <gsmui:button variant="outline" size="default">{{ __('View Schedule') }}</gsmui:button>
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-12">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-3 gap-6 text-center">
            @foreach($stats as $stat)
                <div>
                    <gsmui:heading size="lg" level="2" class="text-blue-600 dark:text-blue-400">{{ $stat['value'] }}</gsmui:heading>
                    <gsmui:text variant="subtle">{{ $stat['label'] }}</gsmui:text>
                </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Featured Speakers') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($speakers as $speaker)
                <gsmui:card variant="default" class="text-center p-6">
                    <gsmui:avatar name="{{ $speaker['name'] }}" size="xl" circle />
                    <div class="mt-4">
                        <gsmui:text variant="strong">{{ $speaker['name'] }}</gsmui:text>
                    </div>
                    <gsmui:text variant="subtle" size="sm">{{ $speaker['role'] }}</gsmui:text>
                    <div class="mt-3">
                        <gsmui:badge color="blue" rounded>{{ $speaker['topic'] }}</gsmui:badge>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <gsmui:divider />

    <section class="max-w-6xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Schedule') }}</gsmui:heading>
        <div class="space-y-4 max-w-2xl mx-auto">
            @foreach($schedule as $item)
                <div class="flex items-start gap-4 p-4 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <gsmui:badge color="indigo" variant="solid">{{ $item['time'] }}</gsmui:badge>
                    <div>
                        <gsmui:text variant="strong">{{ $item['title'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm">{{ $item['speaker'] }}</gsmui:text>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="default" level="2" class="text-center mb-6">{{ __('Venue') }}</gsmui:heading>
        <gsmui:card variant="default" class="p-6 max-w-2xl mx-auto text-center">
            <gsmui:icon name="map-pin" variant="outline" class="w-8 h-8 text-blue-500 mx-auto" />
            <gsmui:text variant="strong" class="mt-3">{{ $event_location }}</gsmui:text>
            <gsmui:text variant="subtle" size="sm" class="mt-1">{{ __('State-of-the-art facilities with easy access to public transit and parking.') }}</gsmui:text>
        </gsmui:card>
    </section>

    <section class="bg-blue-600 dark:bg-blue-700 py-16 text-center">
        <div class="max-w-6xl mx-auto px-4">
            <gsmui:heading size="lg" level="2" class="text-white">{{ __('Ready to Join?') }}</gsmui:heading>
            <gsmui:text size="lg" class="text-blue-100 mt-2">{{ __('Secure your spot at the biggest tech event of the year.') }}</gsmui:text>
            <gsmui:button variant="filled" size="default" class="mt-6 bg-white text-blue-600 hover:bg-blue-50">{{ __('Register Now') }}</gsmui:button>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
