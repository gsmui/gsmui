@props([
    'title' => __('Join Our Growing Community'),
    'subtitle' => __('Connect with developers, share ideas, and build the future together.'),
    'channels' => [
        ['name' => 'Discord', 'members' => '12,500+', 'icon' => 'chat'],
        ['name' => 'GitHub', 'members' => '8,200+', 'icon' => 'code-bracket'],
        ['name' => 'Forum', 'members' => '5,800+', 'icon' => 'users'],
        ['name' => 'Twitter', 'members' => '20,000+', 'icon' => 'globe'],
    ],
    'resources' => [
        ['name' => __('Getting Started Guide'), 'type' => __('Documentation')],
        ['name' => __('API Reference'), 'type' => __('Documentation')],
        ['name' => __('Video Tutorials'), 'type' => __('Video')],
        ['name' => __('Community Plugins'), 'type' => __('Open Source')],
        ['name' => __('Best Practices'), 'type' => __('Guide')],
        ['name' => __('Migration Guide'), 'type' => __('Documentation')],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 text-white') }}>
    <header class="border-b border-white/5">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="DevHub" href="/" />
            <gsmui:button variant="outline" size="sm" class="border-teal-500/30 text-teal-400 hover:bg-teal-500/10">{{ __('Join Community') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-4xl px-6 py-32 text-center">
        <gsmui:heading size="xl" level="1" class="max-w-2xl mx-auto">
            <span class="bg-gradient-to-r from-teal-400 to-cyan-400 bg-clip-text text-transparent">{{ $title }}</span>
        </gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-5 text-zinc-400 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-8 flex justify-center gap-4 flex-wrap">
            <gsmui:button variant="filled" size="default" class="bg-teal-500 hover:bg-teal-600 text-zinc-950 border-0">{{ __('Join Discord') }}</gsmui:button>
            <gsmui:button variant="outline" size="default" class="border-white/20 text-zinc-300 hover:text-white hover:bg-white/5">{{ __('Star on GitHub') }}</gsmui:button>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-6 py-24">
        <gsmui:heading size="lg" level="2" class="text-center">{{ __('Community Channels') }}</gsmui:heading>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12">
            @foreach ($channels as $channel)
                <gsmui:card variant="ghost" class="bg-white/[0.03] border border-white/5 hover:border-teal-500/20 transition-colors text-center">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-xl bg-teal-500/10 mb-4">
                            <gsmui:icon name="{{ $channel['icon'] }}" class="text-teal-400" />
                        </div>
                        <gsmui:text variant="strong" size="sm">{{ $channel['name'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm" class="mt-1 text-zinc-500">{{ $channel['members'] }} {{ __('members') }}</gsmui:text>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-white/[0.02] py-24">
        <div class="mx-auto max-w-5xl px-6">
            <gsmui:heading size="lg" level="2" class="text-center">{{ __('Resources') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mt-3 text-center text-zinc-400">{{ __('Everything you need to get started and go further.') }}</gsmui:text>
            <div class="mt-12 space-y-4">
                @foreach ($resources as $resource)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-teal-500/20 transition-colors">
                        <div class="flex items-center gap-3">
                            <gsmui:icon name="document" variant="outline" class="text-zinc-500" />
                            <gsmui:text variant="strong" size="sm">{{ $resource['name'] }}</gsmui:text>
                        </div>
                        <gsmui:badge color="cyan" variant="solid" rounded>{{ $resource['type'] }}</gsmui:badge>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-6 py-24">
        <gsmui:heading size="lg" level="2" class="text-center">{{ __('Upcoming Events') }}</gsmui:heading>
        <div class="grid md:grid-cols-2 gap-6 mt-12">
            <gsmui:card variant="ghost" class="bg-white/[0.03] border border-white/5">
                <div class="p-6">
                    <gsmui:badge color="teal" variant="solid" rounded>{{ __('Virtual') }}</gsmui:badge>
                    <gsmui:heading size="default" level="3" class="mt-3">{{ __('Community Meetup #24') }}</gsmui:heading>
                    <gsmui:text variant="subtle" size="sm" class="mt-2 text-zinc-400">{{ __('Monthly community call with lightning talks and Q&A.') }}</gsmui:text>
                    <div class="flex items-center gap-2 mt-4">
                        <gsmui:icon name="calendar" variant="mini" class="text-zinc-500" />
                        <gsmui:text variant="subtle" size="sm" class="text-zinc-500">{{ __('July 25, 2026 — 5:00 PM UTC') }}</gsmui:text>
                    </div>
                </div>
            </gsmui:card>
            <gsmui:card variant="ghost" class="bg-white/[0.03] border border-white/5">
                <div class="p-6">
                    <gsmui:badge color="violet" variant="solid" rounded>{{ __('In-Person') }}</gsmui:badge>
                    <gsmui:heading size="default" level="3" class="mt-3">{{ __('DevHub Conf 2026') }}</gsmui:heading>
                    <gsmui:text variant="subtle" size="sm" class="mt-2 text-zinc-400">{{ __('Our annual conference with workshops, talks, and networking.') }}</gsmui:text>
                    <div class="flex items-center gap-2 mt-4">
                        <gsmui:icon name="map-pin" variant="mini" class="text-zinc-500" />
                        <gsmui:text variant="subtle" size="sm" class="text-zinc-500">{{ __('San Francisco — October 15-16, 2026') }}</gsmui:text>
                    </div>
                </div>
            </gsmui:card>
        </div>
    </section>

    <footer class="border-t border-white/5 py-12">
        <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <gsmui:brand name="DevHub" href="/" />
            <gsmui:text variant="subtle" size="sm" class="text-zinc-600">&copy; {{ date('Y') }} DevHub. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
