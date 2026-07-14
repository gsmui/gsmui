@props([
    'title' => 'NovaPay',
    'subtitle' => 'The future of digital payments is almost here.',
    'launch_date' => '2026-12-01',
    'features' => [
        ['icon' => 'bolt', 'desc' => 'Instant transfers worldwide'],
        ['icon' => 'shield-check', 'desc' => 'Bank-grade security'],
        ['icon' => 'currency-dollar', 'desc' => 'Zero hidden fees'],
        ['icon' => 'globe', 'desc' => '150+ countries supported'],
    ],
])

<div {{ $attributes->class(['min-h-screen bg-gradient-to-br from-zinc-950 via-blue-950 to-zinc-950 text-white']) }} x-data="{ launchDate: '{{ $launch_date }}', days: 0, hours: 0, minutes: 0, seconds: 0, timer: null }" x-init="
    timer = setInterval(() => {
        const diff = new Date(launchDate) - new Date();
        if (diff <= 0) { clearInterval(timer); return; }
        days = Math.floor(diff / 86400000);
        hours = Math.floor((diff % 86400000) / 3600000);
        minutes = Math.floor((diff % 3600000) / 60000);
        seconds = Math.floor((diff % 60000) / 1000);
    }, 1000)
">
    <header class="max-w-4xl mx-auto px-4 py-6 text-center">
        <gsmui:brand name="{{ $title }}" href="#" class="text-white" />
    </header>

    <section class="max-w-4xl mx-auto px-4 py-16 text-center">
        <gsmui:heading size="xl" level="1" class="text-white">{{ $title }}</gsmui:heading>
        <gsmui:text size="lg" class="text-zinc-400 mt-4 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>

        <div class="mt-10 grid grid-cols-4 gap-3 max-w-md mx-auto">
            <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                <div class="text-2xl font-bold text-blue-400" x-text="String(days).padStart(2, '0')">00</div>
                <div class="text-xs text-zinc-500 mt-1">{{ __('Days') }}</div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                <div class="text-2xl font-bold text-blue-400" x-text="String(hours).padStart(2, '0')">00</div>
                <div class="text-xs text-zinc-500 mt-1">{{ __('Hours') }}</div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                <div class="text-2xl font-bold text-blue-400" x-text="String(minutes).padStart(2, '0')">00</div>
                <div class="text-xs text-zinc-500 mt-1">{{ __('Mins') }}</div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-xl p-3 text-center">
                <div class="text-2xl font-bold text-blue-400" x-text="String(seconds).padStart(2, '0')">00</div>
                <div class="text-xs text-zinc-500 mt-1">{{ __('Secs') }}</div>
            </div>
        </div>

        <div class="mt-10 max-w-md mx-auto flex gap-2">
            <gsmui:input type="email" placeholder="{{ __('Enter your email') }}" icon="envelope" class="flex-1" />
            <gsmui:button variant="primary" icon="megaphone">{{ __('Notify Me') }}</gsmui:button>
        </div>
        <gsmui:text variant="subtle" size="sm" class="mt-3">{{ __('Join 10,000+ others waiting for launch.') }}</gsmui:text>
    </section>

    <gsmui:divider />

    <section class="max-w-4xl mx-auto px-4 py-12">
        <gsmui:heading size="default" level="2" class="text-center text-white mb-8">{{ __('What\'s Coming') }}</gsmui:heading>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($features as $feature)
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/5 border border-white/10">
                    <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="w-6 h-6 text-blue-400 shrink-0" />
                    <gsmui:text class="text-zinc-300">{{ $feature['desc'] }}</gsmui:text>
                </div>
            @endforeach
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-4 py-12 text-center">
        <gsmui:heading size="default" level="3" class="text-white">{{ __('Why NovaPay?') }}</gsmui:heading>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                <gsmui:icon name="light-bulb" variant="outline" class="w-6 h-6 text-blue-400 mx-auto" />
                <gsmui:text variant="strong" size="sm" class="text-white mt-2">{{ __('Innovative') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500 mt-1">{{ __('Built with cutting-edge blockchain technology.') }}</gsmui:text>
            </div>
            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                <gsmui:icon name="shield-check" variant="outline" class="w-6 h-6 text-blue-400 mx-auto" />
                <gsmui:text variant="strong" size="sm" class="text-white mt-2">{{ __('Secure') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500 mt-1">{{ __('Military-grade encryption for every transaction.') }}</gsmui:text>
            </div>
            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                <gsmui:icon name="globe" variant="outline" class="w-6 h-6 text-blue-400 mx-auto" />
                <gsmui:text variant="strong" size="sm" class="text-white mt-2">{{ __('Global') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm" class="text-zinc-500 mt-1">{{ __('Send money to anyone, anywhere in the world.') }}</gsmui:text>
            </div>
        </div>
    </section>

    <footer class="border-t border-white/5 py-8 mt-12">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <div class="flex justify-center gap-4 mb-4">
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-white">
                    <gsmui:icon name="globe" variant="outline" class="w-5 h-5" />
                </gsmui:button>
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-white">
                    <gsmui:icon name="chat-bubble-left-right" variant="outline" class="w-5 h-5" />
                </gsmui:button>
                <gsmui:button variant="ghost" size="sm" class="text-zinc-500 hover:text-white">
                    <gsmui:icon name="envelope" variant="outline" class="w-5 h-5" />
                </gsmui:button>
            </div>
            <gsmui:text variant="subtle" size="sm" class="text-zinc-600">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
