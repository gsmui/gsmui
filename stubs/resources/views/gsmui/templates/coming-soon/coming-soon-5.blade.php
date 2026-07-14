@props([
    'title' => 'Lumina',
    'subtitle' => 'AI-powered creative suite for the next generation of makers.',
    'teaser_features' => [
        ['icon' => 'sparkles', 'name' => 'AI Generation'],
        ['icon' => 'pencil', 'name' => 'Smart Editing'],
        ['icon' => 'photo', 'name' => 'Asset Library'],
        ['icon' => 'users', 'name' => 'Team Collab'],
    ],
    'launch_date' => '2026-11-01',
])

<div {{ $attributes->class(['min-h-screen bg-zinc-950 text-white overflow-hidden']) }} x-data="{ launchDate: '{{ $launch_date }}', days: 0, hours: 0, minutes: 0, seconds: 0 }" x-init="
    setInterval(() => {
        const diff = new Date(launchDate) - new Date();
        if (diff <= 0) return;
        days = Math.floor(diff / 86400000);
        hours = Math.floor((diff % 86400000) / 3600000);
        minutes = Math.floor((diff % 3600000) / 60000);
        seconds = Math.floor((diff % 60000) / 1000);
    }, 1000)
">
    <div class="absolute inset-0 bg-gradient-to-br from-violet-900/30 via-transparent to-pink-900/20 pointer-events-none"></div>

    <header class="relative max-w-4xl mx-auto px-4 py-6 text-center">
        <gsmui:brand name="{{ $title }}" href="#" class="text-white" />
    </header>

    <section class="relative max-w-4xl mx-auto px-4 py-20 text-center">
        <gsmui:heading size="xl" level="1" class="bg-gradient-to-r from-violet-400 via-pink-400 to-violet-400 bg-clip-text text-transparent">{{ $title }}</gsmui:heading>
        <gsmui:text size="lg" class="text-zinc-400 mt-4 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>

        <div class="mt-10 grid grid-cols-4 gap-3 max-w-sm mx-auto">
            <div class="bg-white/5 border border-violet-500/20 rounded-xl p-3 text-center">
                <div class="text-2xl font-bold text-violet-400" x-text="String(days).padStart(2, '0')">00</div>
                <div class="text-xs text-zinc-500 mt-1">{{ __('Days') }}</div>
            </div>
            <div class="bg-white/5 border border-violet-500/20 rounded-xl p-3 text-center">
                <div class="text-2xl font-bold text-pink-400" x-text="String(hours).padStart(2, '0')">00</div>
                <div class="text-xs text-zinc-500 mt-1">{{ __('Hours') }}</div>
            </div>
            <div class="bg-white/5 border border-violet-500/20 rounded-xl p-3 text-center">
                <div class="text-2xl font-bold text-violet-400" x-text="String(minutes).padStart(2, '0')">00</div>
                <div class="text-xs text-zinc-500 mt-1">{{ __('Mins') }}</div>
            </div>
            <div class="bg-white/5 border border-violet-500/20 rounded-xl p-3 text-center">
                <div class="text-2xl font-bold text-pink-400" x-text="String(seconds).padStart(2, '0')">00</div>
                <div class="text-xs text-zinc-500 mt-1">{{ __('Secs') }}</div>
            </div>
        </div>

        <div class="mt-10 max-w-md mx-auto flex gap-2">
            <gsmui:input type="email" placeholder="{{ __('Enter your email') }}" icon="envelope" class="flex-1" />
            <gsmui:button variant="primary" class="bg-violet-600 hover:bg-violet-700">{{ __('Get Early Access') }}</gsmui:button>
        </div>
        <gsmui:text variant="subtle" size="sm" class="mt-3 text-zinc-500">{{ __('Limited beta spots available.') }}</gsmui:text>
    </section>

    <section class="relative max-w-4xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($teaser_features as $feature)
                <gsmui:card variant="ghost" class="bg-white/5 border-white/10 p-6 text-center">
                    <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="w-8 h-8 text-violet-400 mx-auto" />
                    <gsmui:text variant="strong" size="sm" class="text-white mt-3">{{ $feature['name'] }}</gsmui:text>
                    <gsmui:badge color="violet" rounded class="mt-2">{{ __('Coming Soon') }}</gsmui:badge>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="relative max-w-4xl mx-auto px-4 py-12 text-center">
        <gsmui:heading size="default" level="3" class="text-white">{{ __('Why Lumina?') }}</gsmui:heading>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                <gsmui:icon name="sparkles" variant="outline" class="w-6 h-6 text-violet-400 mx-auto" />
                <gsmui:text variant="strong" size="sm" class="text-white mt-2">{{ __('AI-Powered') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500 mt-1">{{ __('Generate, edit, and enhance with state-of-the-art AI models.') }}</gsmui:text>
            </div>
            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                <gsmui:icon name="bolt" variant="outline" class="w-6 h-6 text-pink-400 mx-auto" />
                <gsmui:text variant="strong" size="sm" class="text-white mt-2">{{ __('Lightning Fast') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500 mt-1">{{ __('Optimized rendering engine for real-time creative workflows.') }}</gsmui:text>
            </div>
            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                <gsmui:icon name="users" variant="outline" class="w-6 h-6 text-violet-400 mx-auto" />
                <gsmui:text variant="strong" size="sm" class="text-white mt-2">{{ __('Collaborative') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500 mt-1">{{ __('Work together in real-time with your entire team.') }}</gsmui:text>
            </div>
        </div>
    </section>

    <footer class="relative border-t border-white/5 py-8 mt-12">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="flex justify-center gap-4 mb-4">
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-violet-400">
                    <gsmui:icon name="globe" variant="outline" class="w-5 h-5" />
                </gsmui:button>
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-violet-400">
                    <gsmui:icon name="chat-bubble-left-right" variant="outline" class="w-5 h-5" />
                </gsmui:button>
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-violet-400">
                    <gsmui:icon name="envelope" variant="outline" class="w-5 h-5" />
                </gsmui:button>
            </div>
            <gsmui:text variant="subtle" size="sm" class="text-zinc-600">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
