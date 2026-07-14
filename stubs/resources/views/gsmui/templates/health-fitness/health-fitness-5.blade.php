@props([
    'title' => 'Inner Light Yoga',
    'subtitle' => 'Find your balance through mindful movement and meditation.',
    'practices' => [
        ['name' => 'Vinyasa Flow', 'desc' => 'Dynamic sequences linking breath with movement for strength and flexibility.', 'duration' => '60 min', 'level' => 'All Levels', 'icon' => 'bolt'],
        ['name' => 'Restorative Yoga', 'desc' => 'Gentle, supported poses held for deep relaxation and stress relief.', 'duration' => '75 min', 'level' => 'Beginner', 'icon' => 'heart'],
        ['name' => 'Guided Meditation', 'desc' => 'Seated mindfulness practices for mental clarity and inner peace.', 'duration' => '30 min', 'level' => 'All Levels', 'icon' => 'sparkles'],
        ['name' => 'Power Yoga', 'desc' => 'Challenging, fitness-oriented practice to build strength and endurance.', 'duration' => '60 min', 'level' => 'Advanced', 'icon' => 'fire'],
    ],
    'schedule' => [
        ['day' => 'Monday', 'classes' => [
            ['time' => '7:00 AM', 'name' => 'Vinyasa Flow', 'instructor' => 'Maya S.'],
            ['time' => '12:00 PM', 'name' => 'Guided Meditation', 'instructor' => 'David L.'],
            ['time' => '6:00 PM', 'name' => 'Power Yoga', 'instructor' => 'Maya S.'],
        ]],
        ['day' => 'Tuesday', 'classes' => [
            ['time' => '8:00 AM', 'name' => 'Restorative Yoga', 'instructor' => 'Luna K.'],
            ['time' => '5:30 PM', 'name' => 'Vinyasa Flow', 'instructor' => 'Maya S.'],
        ]],
        ['day' => 'Wednesday', 'classes' => [
            ['time' => '7:00 AM', 'name' => 'Power Yoga', 'instructor' => 'Maya S.'],
            ['time' => '12:00 PM', 'name' => 'Guided Meditation', 'instructor' => 'David L.'],
        ]],
    ],
])

<div {{ $attributes->class(['min-h-screen bg-gradient-to-b from-violet-50 to-white dark:from-zinc-950 dark:to-zinc-900']) }}>
    <header class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <gsmui:brand name="{{ $title }}" href="#" />
        <gsmui:button variant="primary" size="sm" class="bg-violet-600 hover:bg-violet-700">{{ __('Book a Class') }}</gsmui:button>
    </header>

    <section class="max-w-6xl mx-auto px-4 py-20 text-center">
        <gsmui:heading size="xl" level="1">{{ __('Find Your Balance') }}</gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-4 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-8">
            <gsmui:button variant="primary" size="default" class="bg-violet-600 hover:bg-violet-700" icon="sparkles">{{ __('Explore Classes') }}</gsmui:button>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Our Practices') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($practices as $practice)
                <gsmui:card variant="default" class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center shrink-0">
                            <gsmui:icon name="{{ $practice['icon'] }}" variant="outline" class="w-5 h-5 text-violet-600 dark:text-violet-400" />
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <gsmui:text variant="strong">{{ $practice['name'] }}</gsmui:text>
                                <gsmui:badge color="violet" rounded>{{ $practice['level'] }}</gsmui:badge>
                            </div>
                            <gsmui:text variant="subtle" size="sm" class="mt-1">{{ $practice['desc'] }}</gsmui:text>
                            <gsmui:text variant="subtle" size="sm" class="mt-1">
                                <gsmui:icon name="clock" variant="outline" class="inline w-3 h-3" />
                                {{ $practice['duration'] }}
                            </gsmui:text>
                        </div>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <gsmui:divider />

    <section class="max-w-6xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Weekly Schedule') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($schedule as $day)
                <gsmui:card variant="default" class="p-5">
                    <gsmui:heading size="default" level="3" class="text-violet-600 dark:text-violet-400 mb-4">{{ $day['day'] }}</gsmui:heading>
                    <div class="space-y-3">
                        @foreach($day['classes'] as $class)
                            <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                                <div>
                                    <gsmui:text variant="strong" size="sm">{{ $class['name'] }}</gsmui:text>
                                    <gsmui:text variant="subtle" size="sm">{{ $class['instructor'] }}</gsmui:text>
                                </div>
                                <gsmui:badge color="purple" rounded>{{ $class['time'] }}</gsmui:badge>
                            </div>
                        @endforeach
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-violet-50 dark:bg-violet-900/10 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Our Instructors') }}</gsmui:heading>
            <div class="grid grid-cols-3 gap-6 max-w-2xl mx-auto">
                @php
                    $instructors = [
                        ['name' => 'Maya Sharma', 'specialty' => 'Vinyasa & Power'],
                        ['name' => 'Luna Kim', 'specialty' => 'Restorative'],
                        ['name' => 'David Lee', 'specialty' => 'Meditation'],
                    ];
                @endphp
                @foreach($instructors as $instructor)
                    <div class="text-center">
                        <gsmui:avatar name="{{ $instructor['name'] }}" size="lg" circle />
                        <gsmui:text variant="strong" size="sm" class="mt-3">{{ $instructor['name'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm">{{ $instructor['specialty'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
