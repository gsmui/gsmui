@props([
    'title' => __('People-First Digital Agency'),
    'subtitle' => __('We believe great work starts with great values and a passionate team.'),
    'values' => [
        ['icon' => 'heart', 'name' => 'Empathy', 'desc' => 'We put users at the center of every decision we make.'],
        ['icon' => 'light-bulb', 'name' => 'Innovation', 'desc' => 'We explore new ideas and embrace creative problem-solving.'],
        ['icon' => 'trophy', 'name' => 'Excellence', 'desc' => 'We hold ourselves to the highest standards in everything we deliver.'],
    ],
    'team' => [
        ['name' => 'Olivia Martinez', 'role' => 'Founder & CEO', 'bio' => 'Former design lead at top agencies with 12 years of experience building brands.'],
        ['name' => 'Daniel Kim', 'role' => 'Head of Engineering', 'bio' => 'Full-stack architect passionate about scalable, elegant systems.'],
        ['name' => 'Priya Sharma', 'role' => 'Creative Director', 'bio' => 'Award-winning designer with a knack for visual storytelling.'],
        ['name' => 'Marcus Brown', 'role' => 'Strategy Lead', 'bio' => 'Data-driven strategist who bridges business goals and user needs.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="border-b border-zinc-200 dark:border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="Bloom" href="/" />
            <nav class="hidden md:flex items-center gap-8">
                <a href="#values" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Values') }}</a>
                <a href="#team" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Team') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm" class="bg-rose-600 hover:bg-rose-700 border-rose-600">{{ __('Hire Us') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-7xl px-6 py-24 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <gsmui:text variant="subtle" size="lg" class="mt-4">{{ $subtitle }}</gsmui:text>
            <div class="mt-8 flex gap-4">
                <gsmui:button variant="primary" size="default" class="bg-rose-600 hover:bg-rose-700 border-rose-600">{{ __('Work With Us') }}</gsmui:button>
                <gsmui:button variant="outline" size="default">{{ __('Our Story') }}</gsmui:button>
            </div>
        </div>
        <div class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-rose-100 to-pink-100 dark:from-rose-500/10 dark:to-pink-500/10 flex items-center justify-center">
            <gsmui:avatar.group>
                @foreach ($team as $member)
                    <gsmui:avatar name="{{ $member['name'] }}" size="lg" circle />
                @endforeach
            </gsmui:avatar.group>
        </div>
    </section>

    <section id="values" class="bg-zinc-50 dark:bg-white/5 py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="text-center mb-16">
                <gsmui:heading size="lg" level="2">{{ __('Our Values') }}</gsmui:heading>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($values as $value)
                    <div class="text-center">
                        <div class="flex items-center justify-center w-14 h-14 mx-auto rounded-full bg-rose-100 dark:bg-rose-500/10 mb-5">
                            <gsmui:icon name="{{ $value['icon'] }}" class="text-rose-600 dark:text-rose-400" />
                        </div>
                        <gsmui:heading size="default" level="3">{{ $value['name'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" size="sm" class="mt-2 max-w-xs mx-auto">{{ $value['desc'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="team" class="mx-auto max-w-7xl px-6 py-24">
        <div class="text-center mb-16">
            <gsmui:heading size="lg" level="2">{{ __('Our Team') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mt-3">{{ __('The people behind the work.') }}</gsmui:text>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($team as $member)
                <gsmui:card variant="outlined" size="sm">
                    <div class="p-6 text-center">
                        <gsmui:avatar name="{{ $member['name'] }}" size="xl" circle class="mx-auto" />
                        <gsmui:text variant="strong" size="sm" class="mt-4">{{ $member['name'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm">{{ $member['role'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm" class="mt-3">{{ $member['bio'] }}</gsmui:text>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-rose-600 py-20 text-center">
        <gsmui:heading size="lg" level="2" class="text-white">{{ __('Join Our Growing Team') }}</gsmui:heading>
        <gsmui:text size="default" class="mt-3 text-rose-100">{{ __('We\'re always looking for talented people.') }}</gsmui:text>
        <gsmui:button variant="outline" size="default" class="mt-8 border-white text-white hover:bg-white/10">{{ __('View Open Roles') }}</gsmui:button>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-12">
        <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <gsmui:brand name="Bloom" href="/" />
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} Bloom Agency. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
