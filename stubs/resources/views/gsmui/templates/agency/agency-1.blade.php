@props([
    'title' => __('We Build Digital Experiences'),
    'subtitle' => __('A full-service digital agency crafting innovative solutions for brands worldwide.'),
    'services' => [
        ['icon' => 'code-bracket', 'name' => 'Web Development', 'desc' => 'Custom web applications built with modern technologies.'],
        ['icon' => 'device-phone-mobile', 'name' => 'Mobile Apps', 'desc' => 'Native and cross-platform mobile experiences.'],
        ['icon' => 'sparkles', 'name' => 'UI/UX Design', 'desc' => 'User-centered design that drives engagement.'],
        ['icon' => 'chart-bar', 'name' => 'Analytics', 'desc' => 'Data-driven insights to grow your business.'],
        ['icon' => 'megaphone', 'name' => 'Marketing', 'desc' => 'Strategic campaigns that reach your audience.'],
        ['icon' => 'shield-check', 'name' => 'Cybersecurity', 'desc' => 'Protecting your digital assets and data.'],
    ],
    'stats' => [
        ['value' => '200+', 'label' => __('Projects Delivered')],
        ['value' => '50+', 'label' => __('Happy Clients')],
        ['value' => '15+', 'label' => __('Team Members')],
        ['value' => '8+', 'label' => __('Years Experience')],
    ],
    'team' => [
        ['name' => 'Sarah Johnson', 'role' => 'CEO & Founder'],
        ['name' => 'Michael Chen', 'role' => 'Lead Designer'],
        ['name' => 'Emily Davis', 'role' => 'Tech Lead'],
        ['name' => 'James Wilson', 'role' => 'Marketing Director'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="border-b border-zinc-200 dark:border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="AgencyPro" href="/" />
            <nav class="hidden md:flex items-center gap-8">
                <a href="#services" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Services') }}</a>
                <a href="#team" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Team') }}</a>
                <a href="#stats" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Results') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm">{{ __('Contact Us') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-7xl px-6 py-24 text-center">
        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-4 max-w-2xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-8 flex justify-center gap-4">
            <gsmui:button variant="primary" size="default">{{ __('Get Started') }}</gsmui:button>
            <gsmui:button variant="outline" size="default">{{ __('View Portfolio') }}</gsmui:button>
        </div>
    </section>

    <section id="stats" class="bg-zinc-50 dark:bg-white/5 py-16">
        <div class="mx-auto max-w-7xl px-6 grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($stats as $stat)
                <div class="text-center">
                    <gsmui:heading size="lg" level="2" class="text-blue-600 dark:text-blue-400">{{ $stat['value'] }}</gsmui:heading>
                    <gsmui:text variant="subtle" size="sm" class="mt-1">{{ $stat['label'] }}</gsmui:text>
                </div>
            @endforeach
        </div>
    </section>

    <section id="services" class="mx-auto max-w-7xl px-6 py-24">
        <div class="text-center mb-16">
            <gsmui:heading size="lg" level="2">{{ __('Our Services') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mt-3 max-w-xl mx-auto">{{ __('Comprehensive digital solutions tailored to your business needs.') }}</gsmui:text>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <gsmui:card variant="outlined" size="lg">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-500/10 mb-4">
                            <gsmui:icon name="{{ $service['icon'] }}" class="text-blue-600 dark:text-blue-400" />
                        </div>
                        <gsmui:heading size="default" level="3">{{ $service['name'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" size="sm" class="mt-2">{{ $service['desc'] }}</gsmui:text>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section id="team" class="bg-zinc-50 dark:bg-white/5 py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="text-center mb-16">
                <gsmui:heading size="lg" level="2">{{ __('Meet Our Team') }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mt-3">{{ __('Passionate experts dedicated to your success.') }}</gsmui:text>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach ($team as $member)
                    <div class="text-center">
                        <gsmui:avatar name="{{ $member['name'] }}" size="xl" circle class="mx-auto" />
                        <gsmui:text variant="strong" size="sm" class="mt-4">{{ $member['name'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm">{{ $member['role'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-12">
        <div class="mx-auto max-w-7xl px-6 grid md:grid-cols-4 gap-8">
            <div>
                <gsmui:brand name="AgencyPro" href="/" />
                <gsmui:text variant="subtle" size="sm" class="mt-4">{{ __('Building digital experiences since 2016.') }}</gsmui:text>
            </div>
            <div>
                <gsmui:text variant="strong" size="sm">{{ __('Services') }}</gsmui:text>
                <div class="mt-3 space-y-2">
                    <gsmui:text variant="subtle" size="sm"><a href="#">{{ __('Web Development') }}</a></gsmui:text>
                    <gsmui:text variant="subtle" size="sm"><a href="#">{{ __('Mobile Apps') }}</a></gsmui:text>
                    <gsmui:text variant="subtle" size="sm"><a href="#">{{ __('Design') }}</a></gsmui:text>
                </div>
            </div>
            <div>
                <gsmui:text variant="strong" size="sm">{{ __('Company') }}</gsmui:text>
                <div class="mt-3 space-y-2">
                    <gsmui:text variant="subtle" size="sm"><a href="#">{{ __('About') }}</a></gsmui:text>
                    <gsmui:text variant="subtle" size="sm"><a href="#">{{ __('Careers') }}</a></gsmui:text>
                    <gsmui:text variant="subtle" size="sm"><a href="#">{{ __('Blog') }}</a></gsmui:text>
                </div>
            </div>
            <div>
                <gsmui:text variant="strong" size="sm">{{ __('Contact') }}</gsmui:text>
                <div class="mt-3 space-y-2">
                    <gsmui:text variant="subtle" size="sm">hello@agencypro.com</gsmui:text>
                    <gsmui:text variant="subtle" size="sm">+1 (555) 123-4567</gsmui:text>
                </div>
            </div>
        </div>
        <div class="mx-auto max-w-7xl px-6 mt-12 pt-8 border-t border-zinc-200 dark:border-white/10">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} AgencyPro. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
