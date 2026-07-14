@props([
    'title' => 'Maya Rodriguez',
    'subtitle' => 'Product Designer',
    'intro' => 'I transform complex problems into elegant, user-centered solutions through research-driven design and iterative prototyping.',
    'case_studies' => [
        [
            'title' => 'Banking App Redesign',
            'client' => 'FinanceHub',
            'role' => 'Lead Designer',
            'desc' => 'Completely reimagined the mobile banking experience, resulting in a 40% increase in daily active users and significantly improved customer satisfaction scores.',
            'tags' => ['Mobile', 'Fintech', 'UX Research'],
            'results' => [
                ['metric' => '+40%', 'label' => 'Daily Active Users'],
                ['metric' => '4.8★', 'label' => 'App Store Rating'],
                ['metric' => '-60%', 'label' => 'Support Tickets'],
            ],
        ],
        [
            'title' => 'Healthcare Portal',
            'client' => 'MedConnect',
            'role' => 'UX Designer',
            'desc' => 'Designed an accessible patient portal that simplified appointment booking and medical record management for users of all ages and abilities.',
            'tags' => ['Healthcare', 'Accessibility', 'Web'],
            'results' => [
                ['metric' => '+55%', 'label' => 'Online Bookings'],
                ['metric' => '98%', 'label' => 'Accessibility Score'],
                ['metric' => '-35%', 'label' => 'Task Completion Time'],
            ],
        ],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden items-center gap-6 text-sm text-zinc-600 dark:text-zinc-400 sm:flex">
                <a href="#work" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Work') }}</a>
                <a href="#process" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Process') }}</a>
                <a href="#contact" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Contact') }}</a>
            </nav>
            <gsmui:button variant="outline" size="sm" href="#contact">{{ __('Let\'s Talk') }}</gsmui:button>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6">
        <section class="py-24">
            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <gsmui:heading size="lg" level="2" class="mt-1 text-amber-600 dark:text-amber-400">{{ $subtitle }}</gsmui:heading>
            <gsmui:text size="lg" variant="subtle" class="mt-4 max-w-2xl">{{ $intro }}</gsmui:text>
        </section>

        <section id="work" class="pb-24">
            <gsmui:divider text="{{ __('Case Studies') }}" color="primary" />
            <div class="mt-12 space-y-24">
                @foreach ($case_studies as $index => $study)
                    <div class="grid gap-10 lg:grid-cols-2 {{ $index % 2 === 1 ? 'lg:direction-rtl' : '' }}">
                        <div class="{{ $index % 2 === 1 ? 'lg:order-2' : '' }}">
                            <div class="aspect-[4/3] rounded-xl bg-amber-100 dark:bg-amber-500/10 flex items-center justify-center">
                                <gsmui:icon name="photo" variant="outline" class="h-16 w-16 text-amber-300 dark:text-amber-500/30" />
                            </div>
                        </div>
                        <div class="flex flex-col justify-center {{ $index % 2 === 1 ? 'lg:order-1' : '' }}">
                            <gsmui:badge color="amber" class="mb-4 self-start">{{ $study['client'] }} · {{ $study['role'] }}</gsmui:badge>
                            <gsmui:heading size="default" level="3">{{ $study['title'] }}</gsmui:heading>
                            <gsmui:text variant="subtle" class="mt-3">{{ $study['desc'] }}</gsmui:text>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($study['tags'] as $tag)
                                    <gsmui:badge color="zinc">{{ $tag }}</gsmui:badge>
                                @endforeach
                            </div>
                            <div class="mt-8 grid grid-cols-3 gap-4">
                                @foreach ($study['results'] as $result)
                                    <gsmui:card variant="flat" size="sm" class="text-center">
                                        <gsmui:text variant="strong" size="lg" class="text-amber-600 dark:text-amber-400">{{ $result['metric'] }}</gsmui:text>
                                        <gsmui:text size="sm" variant="subtle" class="mt-1">{{ $result['label'] }}</gsmui:text>
                                    </gsmui:card>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="process" class="pb-24">
            <gsmui:divider text="{{ __('Design Process') }}" color="primary" />
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (['Discover', 'Define', 'Design', 'Deliver'] as $step => $name)
                    <div class="text-center">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-500/20 text-lg font-bold text-amber-600 dark:text-amber-400">{{ $step + 1 }}</div>
                        <gsmui:text variant="strong">{{ __($name) }}</gsmui:text>
                        <gsmui:text size="sm" variant="subtle" class="mt-2">
                            @switch($step)
                                @case(0) {{ __('Stakeholder interviews, user research, competitive analysis.') }} @break
                                @case(1) {{ __('Personas, journey maps, problem statements.') }} @break
                                @case(2) {{ __('Wireframes, prototypes, design systems.') }} @break
                                @case(3) {{ __('Handoff, QA, launch support, iteration.') }} @break
                            @endswitch
                        </gsmui:text>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="contact" class="border-t border-zinc-200 dark:border-white/10 py-24 text-center">
            <gsmui:heading size="lg" level="2">{{ __('Ready to collaborate?') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mt-3">{{ __('Let\'s discuss your next project and create exceptional user experiences together.') }}</gsmui:text>
            <gsmui:button variant="filled" class="mt-8" href="mailto:hello@example.com">{{ __('Get in Touch') }}</gsmui:button>
        </section>
    </main>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-8 text-center text-sm text-zinc-500">
        &copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}
    </footer>
</div>
