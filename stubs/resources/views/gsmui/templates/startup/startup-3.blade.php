@props([
    'title' => __('Ship Products Your Users Love'),
    'subtitle' => __('An end-to-end product development platform with built-in user research, prototyping, and analytics.'),
    'features' => [
        ['name' => 'Rapid Prototyping', 'desc' => 'Go from wireframe to interactive prototype in minutes, not days.', 'icon' => 'pencil'],
        ['name' => 'User Testing', 'desc' => 'Recruit participants and gather feedback with integrated testing tools.', 'icon' => 'users'],
        ['name' => 'Analytics Dashboard', 'desc' => 'Track every metric that matters with real-time, visual dashboards.', 'icon' => 'chart-bar'],
        ['name' => 'Version Control', 'desc' => 'Branch, compare, and merge design changes with full history.', 'icon' => 'code-bracket'],
    ],
    'benefits' => [
        __('Reduce time-to-market by 60%'),
        __('Built-in A/B testing for every feature'),
        __('Collaborate in real-time with your team'),
        __('Integrates with Figma, Slack, and Jira'),
        __('SOC 2 Type II certified'),
        __('Dedicated customer success manager'),
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="border-b border-zinc-200 dark:border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="Greenbuild" href="/" />
            <nav class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Features') }}</a>
                <a href="#benefits" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Benefits') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm" class="bg-emerald-600 hover:bg-emerald-700 border-emerald-600">{{ __('Start Free Trial') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-7xl px-6 py-24 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <gsmui:text variant="subtle" size="lg" class="mt-4">{{ $subtitle }}</gsmui:text>
            <div class="mt-8 flex gap-4">
                <gsmui:button variant="primary" size="default" class="bg-emerald-600 hover:bg-emerald-700 border-emerald-600">{{ __('Start Free Trial') }}</gsmui:button>
                <gsmui:button variant="outline" size="default">{{ __('Watch Demo') }}</gsmui:button>
            </div>
        </div>
        <div class="aspect-video rounded-2xl bg-gradient-to-br from-emerald-100 to-green-100 dark:from-emerald-500/10 dark:to-green-500/10 border border-emerald-200 dark:border-emerald-500/20 flex items-center justify-center">
            <div class="w-20 h-20 rounded-full bg-emerald-500/20 flex items-center justify-center">
                <gsmui:icon name="play" class="text-emerald-600 dark:text-emerald-400 w-10 h-10" />
            </div>
        </div>
    </section>

    <section id="features" class="bg-zinc-50 dark:bg-white/5 py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="text-center mb-16">
                <gsmui:heading size="lg" level="2">{{ __('Powerful Features') }}</gsmui:heading>
            </div>
            <div class="space-y-20">
                @foreach ($features as $index => $feature)
                    <div class="flex flex-col md:flex-row {{ $index % 2 === 1 ? 'md:flex-row-reverse' : '' }} items-center gap-12">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-500/10">
                                    <gsmui:icon name="{{ $feature['icon'] }}" class="text-emerald-600 dark:text-emerald-400" />
                                </div>
                                <gsmui:heading size="default" level="3">{{ $feature['name'] }}</gsmui:heading>
                            </div>
                            <gsmui:text variant="subtle" class="mt-2">{{ $feature['desc'] }}</gsmui:text>
                        </div>
                        <div class="flex-1 aspect-video rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                            <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="text-zinc-300 dark:text-zinc-700 w-16 h-16" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="benefits" class="mx-auto max-w-7xl px-6 py-24">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div>
                <gsmui:heading size="lg" level="2">{{ __('Why Teams Choose Us') }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mt-3">{{ __('Benefits that make a real difference.') }}</gsmui:text>
            </div>
            <ul class="space-y-4">
                @foreach ($benefits as $benefit)
                    <li class="flex items-start gap-3">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-500/10 shrink-0 mt-0.5">
                            <gsmui:icon name="check" variant="mini" class="text-emerald-600 dark:text-emerald-400" />
                        </div>
                        <gsmui:text size="default">{{ $benefit }}</gsmui:text>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="bg-emerald-600 py-20 text-center">
        <gsmui:heading size="lg" level="2" class="text-white">{{ __('Start Building Today') }}</gsmui:heading>
        <gsmui:text size="default" class="mt-3 text-emerald-100">{{ __('14-day free trial. No credit card required.') }}</gsmui:text>
        <gsmui:button variant="outline" size="default" class="mt-8 border-white text-white hover:bg-white/10">{{ __('Start Free Trial') }}</gsmui:button>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-12">
        <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <gsmui:brand name="Greenbuild" href="/" />
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} Greenbuild. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
