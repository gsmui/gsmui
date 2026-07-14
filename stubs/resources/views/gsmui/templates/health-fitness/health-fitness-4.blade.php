@props([
    'title' => 'VitalSync',
    'subtitle' => 'Your all-in-one health companion. Track, analyze, and improve.',
    'features' => [
        ['icon' => 'fire', 'name' => 'Meal Tracking', 'desc' => 'Log meals with AI-powered food recognition and nutritional breakdowns.'],
        ['icon' => 'bolt', 'name' => 'Workout Plans', 'desc' => 'Adaptive training programs that evolve with your progress.'],
        ['icon' => 'clock', 'name' => 'Sleep Analysis', 'desc' => 'Monitor sleep quality with smart alarms and trend reports.'],
        ['icon' => 'heart', 'name' => 'Heart Health', 'desc' => 'Continuous heart rate monitoring with anomaly alerts.'],
        ['icon' => 'chart-bar', 'name' => 'Progress Dashboard', 'desc' => 'Visualize trends across all health metrics in one place.'],
        ['icon' => 'users', 'name' => 'Community', 'desc' => 'Join challenges and connect with others on similar journeys.'],
    ],
    'metrics' => [
        ['name' => 'Active Users', 'value' => '2.4M', 'change' => '+18%'],
        ['name' => 'Meals Logged', 'value' => '890K', 'change' => '+24%'],
        ['name' => 'Workouts Done', 'value' => '1.2M', 'change' => '+31%'],
        ['name' => 'Avg Sleep Score', 'value' => '82', 'change' => '+5%'],
    ],
])

<div {{ $attributes->class(['min-h-screen bg-white dark:bg-zinc-900']) }}>
    <header class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
        <gsmui:brand name="{{ $title }}" href="#" />
        <div class="flex gap-2">
            <gsmui:button variant="outline" size="sm">{{ __('Sign In') }}</gsmui:button>
            <gsmui:button variant="primary" size="sm" class="bg-teal-600 hover:bg-teal-700">{{ __('Download') }}</gsmui:button>
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-4 py-20 text-center">
        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-4 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-8 flex justify-center gap-3">
            <gsmui:button variant="primary" size="default" class="bg-teal-600 hover:bg-teal-700" icon="device-phone-mobile">{{ __('Download Free') }}</gsmui:button>
            <gsmui:button variant="outline" size="default" icon="play">{{ __('Watch Demo') }}</gsmui:button>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('Everything You Need') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($features as $feature)
                <gsmui:card variant="default" class="p-6">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center mb-4">
                        <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="w-5 h-5 text-teal-600 dark:text-teal-400" />
                    </div>
                    <gsmui:text variant="strong">{{ $feature['name'] }}</gsmui:text>
                    <gsmui:text variant="subtle" size="sm" class="mt-1">{{ $feature['desc'] }}</gsmui:text>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <gsmui:divider />

    <section class="bg-teal-50 dark:bg-teal-900/10 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <gsmui:heading size="lg" level="2" class="text-center mb-8">{{ __('By the Numbers') }}</gsmui:heading>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($metrics as $metric)
                    <gsmui:card variant="default" class="p-5 text-center">
                        <gsmui:heading size="lg" level="2" class="text-teal-600 dark:text-teal-400">{{ $metric['value'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" size="sm">{{ $metric['name'] }}</gsmui:text>
                        <gsmui:badge color="green" rounded class="mt-2">{{ $metric['change'] }}</gsmui:badge>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-16">
        <gsmui:heading size="default" level="2" class="text-center mb-6">{{ __('What Users Say') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <gsmui:card variant="default" class="p-6">
                <gsmui:icon name="star" variant="mini" class="w-5 h-5 text-amber-400" />
                <gsmui:text size="sm" class="mt-3 italic">"VitalSync completely changed how I approach my health. The meal tracking alone saved me hours each week."</gsmui:text>
                <gsmui:text variant="strong" size="sm" class="mt-3">— Rachel T.</gsmui:text>
            </gsmui:card>
            <gsmui:card variant="default" class="p-6">
                <gsmui:icon name="star" variant="mini" class="w-5 h-5 text-amber-400" />
                <gsmui:text size="sm" class="mt-3 italic">"The sleep analysis feature helped me fix my schedule. I'm sleeping better than I have in years."</gsmui:text>
                <gsmui:text variant="strong" size="sm" class="mt-3">— Michael P.</gsmui:text>
            </gsmui:card>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
