@props([
    'title' => 'Coach Alex Rivera',
    'subtitle' => 'Certified personal trainer helping you reach your peak performance.',
    'trainer' => [
        'name' => 'Alex Rivera',
        'specialties' => ['Strength Training', 'Weight Loss', 'Sports Performance'],
        'certifications' => ['NASM-CPT', 'ACE Certified', 'Precision Nutrition L2'],
    ],
    'programs' => [
        ['name' => 'Strength Foundations', 'desc' => 'Build a solid base with progressive overload training designed for beginners and intermediates.', 'duration' => '12 weeks', 'level' => 'Beginner'],
        ['name' => 'Shred Protocol', 'desc' => 'High-intensity program combining resistance training and cardio for maximum fat loss.', 'duration' => '8 weeks', 'level' => 'Intermediate'],
        ['name' => 'Athletic Performance', 'desc' => 'Sport-specific training to improve speed, power, and agility for competitive athletes.', 'duration' => '16 weeks', 'level' => 'Advanced'],
    ],
    'testimonials' => [
        ['quote' => 'Lost 30 lbs and gained confidence I never thought possible.', 'author' => 'David K.', 'result' => '-30 lbs in 4 months'],
        ['quote' => 'Alex helped me deadlift 400 lbs. The programming is world-class.', 'author' => 'Maria S.', 'result' => '400 lb deadlift'],
        ['quote' => 'Ran my first marathon after just 6 months of training.', 'author' => 'Tom R.', 'result' => 'First marathon'],
    ],
])

<div {{ $attributes->class(['min-h-screen bg-white dark:bg-zinc-900']) }}>
    <header class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
        <gsmui:brand name="{{ $trainer['name'] }}" href="#" />
        <gsmui:button variant="primary" size="sm" class="bg-orange-500 hover:bg-orange-600">{{ __('Book a Session') }}</gsmui:button>
    </header>

    <section class="max-w-5xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <gsmui:heading size="xl" level="1">{{ $trainer['name'] }}</gsmui:heading>
                <gsmui:text variant="subtle" size="lg" class="mt-3">{{ $subtitle }}</gsmui:text>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($trainer['specialties'] as $spec)
                        <gsmui:badge color="orange" rounded>{{ $spec }}</gsmui:badge>
                    @endforeach
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach($trainer['certifications'] as $cert)
                        <gsmui:badge color="blue" variant="solid" rounded>{{ $cert }}</gsmui:badge>
                    @endforeach
                </div>
                <div class="mt-8 flex gap-3">
                    <gsmui:button variant="primary" class="bg-orange-500 hover:bg-orange-600" icon="calendar">{{ __('Free Consultation') }}</gsmui:button>
                    <gsmui:button variant="outline">{{ __('View Programs') }}</gsmui:button>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="w-64 h-80 bg-zinc-100 dark:bg-zinc-800 rounded-2xl flex items-center justify-center">
                    <gsmui:icon name="user" variant="outline" class="w-20 h-20 text-zinc-300 dark:text-zinc-600" />
                </div>
            </div>
        </div>
    </section>

    <gsmui:divider />

    <section class="max-w-5xl mx-auto px-4 py-16">
        <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Training Programs') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($programs as $program)
                <gsmui:card variant="default" class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <gsmui:heading size="default" level="3">{{ $program['name'] }}</gsmui:heading>
                        @php
                            $levelColor = $program['level'] === 'Beginner' ? 'green' : ($program['level'] === 'Intermediate' ? 'amber' : 'red');
                        @endphp
                        <gsmui:badge color="{{ $levelColor }}" rounded>{{ $program['level'] }}</gsmui:badge>
                    </div>
                    <gsmui:text variant="subtle" size="sm">{{ $program['desc'] }}</gsmui:text>
                    <gsmui:text variant="subtle" size="sm" class="mt-3">
                        <gsmui:icon name="clock" variant="outline" class="inline w-3 h-3" />
                        {{ $program['duration'] }}
                    </gsmui:text>
                    <gsmui:button variant="outline" size="sm" class="mt-4 w-full">{{ __('Learn More') }}</gsmui:button>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-orange-50 dark:bg-orange-900/10 py-16">
        <div class="max-w-5xl mx-auto px-4">
            <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Client Results') }}</gsmui:heading>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($testimonials as $testimonial)
                    <gsmui:card variant="default" class="p-6">
                        <gsmui:badge color="orange" variant="solid" rounded class="mb-3">{{ $testimonial['result'] }}</gsmui:badge>
                        <gsmui:text size="sm" class="italic text-zinc-600 dark:text-zinc-400">"{{ $testimonial['quote'] }}"</gsmui:text>
                        <gsmui:text variant="strong" size="sm" class="mt-3">— {{ $testimonial['author'] }}</gsmui:text>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 py-16 text-center">
        <gsmui:heading size="lg" level="2">{{ __('Ready to Start?') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-2">{{ __('Book a free 30-minute consultation to discuss your goals.') }}</gsmui:text>
        <div class="mt-6 flex justify-center gap-3">
            <gsmui:button variant="primary" class="bg-orange-500 hover:bg-orange-600" icon="calendar">{{ __('Book Consultation') }}</gsmui:button>
            <gsmui:button variant="outline" icon="envelope">{{ __('Send Message') }}</gsmui:button>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $trainer['name'] }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
