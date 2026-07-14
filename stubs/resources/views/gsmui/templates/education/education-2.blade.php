@props([
    'name' => 'Westfield University',
    'tagline' => 'Shaping tomorrow\'s leaders since 1892',
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <section class="bg-gradient-to-b from-blue-900 to-blue-800 px-8 py-20 text-center text-white">
        <h2 class="text-5xl font-bold" style="font-family: Georgia, serif;">{{ __($name) }}</h2>
        <p class="mt-3 text-blue-200">{{ __($tagline) }}</p>
        <div class="mt-6 flex justify-center gap-4">
            <button class="rounded-full bg-white px-8 py-3 text-sm font-bold text-blue-900">{{ __('Apply Now') }}</button>
            <button class="rounded-full border border-white/30 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-colors">{{ __('Virtual Tour') }}</button>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-8 py-16">
        <h3 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Programs') }}</h3>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach (['Business & Management', 'Computer Science', 'Engineering', 'Health Sciences', 'Arts & Humanities', 'Education'] as $program)
                <div class="cursor-pointer rounded-xl bg-zinc-50 p-6 transition-all hover:shadow-md dark:bg-zinc-800">
                    <div class="h-12 w-12 rounded-lg bg-blue-100 dark:bg-blue-900"></div>
                    <h4 class="mt-4 font-bold text-zinc-900 dark:text-white">{{ __($program) }}</h4>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Explore undergraduate and graduate programs.') }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 px-8 py-16">
        <div class="mx-auto grid max-w-4xl grid-cols-2 gap-8 text-center md:grid-cols-4">
            @foreach ([['15,000+', 'Students'], ['200+', 'Programs'], ['95%', 'Employment'], ['50+', 'Countries']] as [$stat, $label])
                <div>
                    <p class="text-3xl font-bold text-blue-600">{{ $stat }}</p>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __($label) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-8 py-16">
        <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Upcoming Events') }}</h3>
        <div class="space-y-4">
            @foreach ([['Open Campus Day', 'March 15, 2026', 'Explore our campus and meet faculty'], ['Research Symposium', 'April 2, 2026', 'Annual showcase of student research'], ['Alumni Gala', 'May 10, 2026', 'Celebrating our graduates']] as [$event, $date, $desc])
                <div class="flex items-center justify-between rounded-xl bg-white p-5 shadow-sm dark:bg-zinc-800">
                    <div>
                        <h4 class="font-semibold text-zinc-900 dark:text-white">{{ __($event) }}</h4>
                        <p class="text-sm text-zinc-500">{{ __($desc) }}</p>
                    </div>
                    <span class="rounded-full bg-blue-50 px-4 py-1.5 text-xs font-semibold text-blue-700 dark:bg-blue-900 dark:text-blue-300">{{ $date }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-blue-600 px-8 py-16 text-center text-white">
        <h3 class="text-2xl font-bold">{{ __('Start Your Application') }}</h3>
        <p class="mt-2 text-blue-100">{{ __('Applications for Fall 2026 are now open.') }}</p>
        <button class="mt-6 rounded-full bg-white px-8 py-3 text-sm font-bold text-blue-700 hover:bg-blue-50 transition-colors">{{ __('Apply Today') }}</button>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 px-8 py-10">
        <div class="mx-auto grid max-w-6xl gap-8 md:grid-cols-4">
            @foreach ([['Academics', ['Programs', 'Departments', 'Libraries', 'Calendar']], ['Admissions', ['Apply', 'Financial Aid', 'Visits', 'FAQ']], ['Campus', ['Housing', 'Dining', 'Athletics', 'Health']], ['Connect', ['News', 'Events', 'Alumni', 'Giving']] as [$heading, $links])
                <div>
                    <h5 class="mb-3 font-semibold text-zinc-900 dark:text-white">{{ __($heading) }}</h5>
                    <ul class="space-y-1.5 text-sm text-zinc-500">
                        @foreach ($links as $link)
                            <li><a href="#" class="hover:text-blue-600 transition-colors">{{ __($link) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </footer>
</div>
