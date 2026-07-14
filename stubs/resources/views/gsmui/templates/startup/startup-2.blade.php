@props([
    'title' => __('Something Amazing Is Coming'),
    'subtitle' => __('Join thousands of others waiting for the next big thing. Be first in line.'),
    'features' => [
        ['icon' => 'light-bulb', 'desc' => __('AI-powered insights that learn and adapt to your workflow.')],
        ['icon' => 'rocket-launch', 'desc' => __('Blazing fast performance built on cutting-edge infrastructure.')],
        ['icon' => 'shield-check', 'desc' => __('Privacy-first architecture with zero-knowledge encryption.')],
    ],
    'launch_date' => 'Q2 2027',
])

<div {{ $attributes->class('min-h-screen bg-gradient-to-br from-zinc-950 via-purple-950/20 to-zinc-950 text-white') }}>
    <header class="border-b border-white/5">
        <div class="mx-auto max-w-5xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="Soon" href="/" />
            <gsmui:badge color="purple" variant="solid" rounded>{{ __('Launching :date', ['date' => $launch_date]) }}</gsmui:badge>
        </div>
    </header>

    <section class="mx-auto max-w-3xl px-6 py-32 text-center">
        <gsmui:badge color="purple" variant="solid" rounded class="mb-8">{{ __('Coming Soon') }}</gsmui:badge>
        <gsmui:heading size="xl" level="1" class="max-w-2xl mx-auto">
            <span class="bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent">{{ $title }}</span>
        </gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-5 text-zinc-400 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-10 max-w-md mx-auto flex gap-3">
            <gsmui:input type="email" placeholder="{{ __('Enter your email') }}" icon="envelope" class="flex-1 bg-white/5 border-white/10 text-white placeholder:text-zinc-500" />
            <gsmui:button variant="primary" size="default" class="bg-purple-600 hover:bg-purple-700 border-purple-600 shrink-0">{{ __('Join Waitlist') }}</gsmui:button>
        </div>
        <gsmui:text variant="subtle" size="sm" class="mt-4 text-zinc-500">{{ __('No spam. Unsubscribe anytime.') }}</gsmui:text>
    </section>

    <section class="mx-auto max-w-5xl px-6 py-24">
        <gsmui:heading size="lg" level="2" class="text-center text-white">{{ __('What\'s Coming') }}</gsmui:heading>
        <div class="grid md:grid-cols-3 gap-8 mt-12">
            @foreach ($features as $feature)
                <div class="text-center p-8 rounded-2xl bg-white/[0.03] border border-white/5">
                    <div class="flex items-center justify-center w-14 h-14 mx-auto rounded-full bg-purple-500/10 mb-5">
                        <gsmui:icon name="{{ $feature['icon'] }}" class="text-purple-400" />
                    </div>
                    <gsmui:text variant="subtle" class="text-zinc-300">{{ $feature['desc'] }}</gsmui:text>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-6 py-16 text-center">
        <gsmui:avatar.group class="justify-center">
            <gsmui:avatar name="Alex M." size="sm" circle />
            <gsmui:avatar name="Jordan K." size="sm" circle />
            <gsmui:avatar name="Sam R." size="sm" circle />
            <gsmui:avatar name="Taylor W." size="sm" circle />
        </gsmui:avatar.group>
        <gsmui:text variant="subtle" size="sm" class="mt-4 text-zinc-400">{{ __('Join 2,500+ people on the waitlist') }}</gsmui:text>
    </section>

    <footer class="border-t border-white/5 py-8">
        <div class="mx-auto max-w-5xl px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <gsmui:brand name="Soon" href="/" />
            <gsmui:text variant="subtle" size="sm" class="text-zinc-600">&copy; {{ date('Y') }} Soon Inc. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
