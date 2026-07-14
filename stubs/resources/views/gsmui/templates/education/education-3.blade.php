@props([
    'title' => 'CodeCamp',
    'subtitle' => __('Launch your tech career with intensive, hands-on training.'),
    'curriculum' => [],
    'outcomes' => [],
    'instructors' => [],
])

@php
$curriculum = count($curriculum) ? $curriculum : [
    ['week' => 'Weeks 1–2', 'topics' => ['HTML & CSS Fundamentals', 'Git & Version Control', 'Command Line Basics']],
    ['week' => 'Weeks 3–4', 'topics' => ['JavaScript Essentials', 'DOM Manipulation', 'Async Programming']],
    ['week' => 'Weeks 5–6', 'topics' => ['React & Component Architecture', 'State Management', 'API Integration']],
    ['week' => 'Weeks 7–8', 'topics' => ['Node.js & Express', 'Databases (SQL & NoSQL)', 'Authentication']],
    ['week' => 'Weeks 9–10', 'topics' => ['Testing & Deployment', 'CI/CD Pipelines', 'Final Capstone Project']],
];
$outcomes = count($outcomes) ? $outcomes : [
    ['stat' => '94%', 'label' => 'Job Placement Rate'],
    ['stat' => '$72k', 'label' => 'Avg Starting Salary'],
    ['stat' => '10', 'label' => 'Weeks to Career Ready'],
    ['stat' => '500+', 'label' => 'Hiring Partners'],
];
$instructors = count($instructors) ? $instructors : [
    ['name' => 'Alex Turner', 'role' => 'Lead Instructor — Frontend'],
    ['name' => 'Priya Sharma', 'role' => 'Lead Instructor — Backend'],
    ['name' => 'Marcus Lee', 'role' => 'Career Coach'],
];
@endphp

<div {{ $attributes->class('bg-zinc-900 text-white min-h-screen') }}>
    <header class="border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Curriculum') }}</a>
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Outcomes') }}</a>
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Instructors') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm" href="#">{{ __('Apply Now') }}</gsmui:button>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-2xl">
            <gsmui:heading size="xl" level="1">{{ __('Become a Full-Stack Developer in 10 Weeks') }}</gsmui:heading>
            <p class="mt-4 text-lg text-zinc-400">{{ $subtitle }}</p>
            <div class="mt-8 flex items-center gap-4">
                <gsmui:button variant="filled" href="#">{{ __('Start Your Application') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#">{{ __('View Syllabus') }} <gsmui:icon name="chevron-down" class="w-4 h-4 ml-1" /></gsmui:button>
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($outcomes as $outcome)
                    <gsmui:card variant="flat" class="text-center">
                        <gsmui:heading size="xl" level="3" class="text-emerald-400">{{ $outcome['stat'] }}</gsmui:heading>
                        <p class="mt-1 text-sm text-zinc-400">{{ $outcome['label'] }}</p>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2">{{ __('Curriculum') }}</gsmui:heading>
            <div class="mt-6">
                <gsmui:accordion>
                    @foreach($curriculum as $week)
                        <gsmui:accordion.item :heading="$week['week']">
                            <ul class="space-y-2">
                                @foreach($week['topics'] as $topic)
                                    <li class="flex items-center gap-2 text-sm text-zinc-400">
                                        <gsmui:icon name="check" class="w-4 h-4 text-emerald-400" />
                                        {{ $topic }}
                                    </li>
                                @endforeach
                            </ul>
                        </gsmui:accordion.item>
                    @endforeach
                </gsmui:accordion>
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2">{{ __('Your Instructors') }}</gsmui:heading>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($instructors as $instructor)
                    <gsmui:card variant="flat" class="text-center">
                        <gsmui:avatar :name="$instructor['name']" size="lg" circle />
                        <gsmui:text variant="strong" class="mt-3">{{ $instructor['name'] }}</gsmui:text>
                        <p class="text-sm text-emerald-400">{{ $instructor['role'] }}</p>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16 text-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2">{{ __('Ready to Change Your Career?') }}</gsmui:heading>
            <p class="mt-2 text-zinc-400">{{ __('Applications for the next cohort are now open. Limited seats available.') }}</p>
            <gsmui:button variant="filled" class="mt-6" href="#">{{ __('Apply Now') }}</gsmui:button>
        </div>
    </section>

    <footer class="border-t border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
