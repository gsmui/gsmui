@props([
    'title' => 'GreenStack',
    'subtitle' => 'Building the most comprehensive sustainability platform for modern businesses.',
    'progress_percent' => 73,
    'features' => [
        ['name' => 'Carbon Tracking', 'desc' => 'Real-time emissions monitoring and reporting'],
        ['name' => 'Supply Chain Audit', 'desc' => 'End-to-end sustainability scoring'],
        ['name' => 'Compliance Dashboard', 'desc' => 'Automated regulatory compliance checks'],
        ['name' => 'Impact Reports', 'desc' => 'Beautiful, shareable impact documentation'],
    ],
])

<div {{ $attributes->class(['min-h-screen bg-zinc-950 text-white']) }}>
    <header class="max-w-4xl mx-auto px-4 py-6 text-center">
        <gsmui:brand name="{{ $title }}" href="#" class="text-white" />
    </header>

    <section class="max-w-4xl mx-auto px-4 py-16 text-center">
        <gsmui:heading size="xl" level="1" class="text-white">{{ $title }}</gsmui:heading>
        <gsmui:text size="lg" class="text-zinc-400 mt-4 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>

        <div class="mt-10 max-w-lg mx-auto">
            <gsmui:progress value="{{ $progress_percent }}" color="green" label="{{ $progress_percent }}% {{ __('complete') }}" />
        </div>

        <div class="mt-8 max-w-md mx-auto flex gap-2">
            <gsmui:input type="email" placeholder="{{ __('Get early access') }}" icon="envelope" class="flex-1" />
            <gsmui:button variant="primary" class="bg-green-600 hover:bg-green-700">{{ __('Join Waitlist') }}</gsmui:button>
        </div>
        <gsmui:text variant="subtle" size="sm" class="mt-3 text-zinc-500">{{ __('Be the first to know when we launch.') }}</gsmui:text>
    </section>

    <gsmui:divider />

    <section class="max-w-4xl mx-auto px-4 py-12">
        <gsmui:heading size="default" level="2" class="text-center text-white mb-8">{{ __('Features in Development') }}</gsmui:heading>
        <div class="space-y-4">
            @foreach($features as $index => $feature)
                <div class="flex items-start gap-4 p-4 rounded-xl bg-zinc-900 border border-zinc-800">
                    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center shrink-0">
                        <gsmui:icon name="check" variant="mini" class="w-4 h-4 text-green-400" />
                    </div>
                    <div>
                        <gsmui:text variant="strong" class="text-white">{{ $feature['name'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm" class="text-zinc-400">{{ $feature['desc'] }}</gsmui:text>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-4 py-12">
        <gsmui:heading size="default" level="2" class="text-center text-white mb-6">{{ __('Our Mission') }}</gsmui:heading>
        <gsmui:card variant="ghost" class="bg-zinc-900 border-zinc-800 p-8 max-w-2xl mx-auto text-center">
            <gsmui:icon name="light-bulb" variant="outline" class="w-8 h-8 text-green-400 mx-auto" />
            <gsmui:text class="text-zinc-300 mt-4">{{ __('We believe every business can be sustainable. GreenStack makes it simple to measure, report, and improve your environmental impact — without the complexity.') }}</gsmui:text>
        </gsmui:card>
    </section>

    <section class="max-w-4xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
            <div class="p-4">
                <gsmui:heading size="lg" level="2" class="text-green-400">500+</gsmui:heading>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500">{{ __('Companies on waitlist') }}</gsmui:text>
            </div>
            <div class="p-4">
                <gsmui:heading size="lg" level="2" class="text-green-400">40+</gsmui:heading>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500">{{ __('Countries represented') }}</gsmui:text>
            </div>
            <div class="p-4">
                <gsmui:heading size="lg" level="2" class="text-green-400">12</gsmui:heading>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500">{{ __('Months in development') }}</gsmui:text>
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-800 py-8 mt-12">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="flex justify-center gap-3 mb-4">
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-green-400">
                    <gsmui:icon name="globe" variant="outline" class="w-5 h-5" />
                </gsmui:button>
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-green-400">
                    <gsmui:icon name="chat-bubble-left-right" variant="outline" class="w-5 h-5" />
                </gsmui:button>
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-green-400">
                    <gsmui:icon name="envelope" variant="outline" class="w-5 h-5" />
                </gsmui:button>
            </div>
            <gsmui:text variant="subtle" size="sm" class="text-zinc-600">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
