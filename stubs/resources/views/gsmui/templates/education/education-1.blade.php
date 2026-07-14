@props([
    'course' => 'Master Web Development',
    'instructor' => 'Alex Chen',
    'price' => '$199',
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <section class="bg-gradient-to-br from-indigo-600 to-purple-700 px-8 py-20 text-center text-white">
        <p class="text-xs uppercase tracking-widest text-indigo-200">{{ __('Online Course') }}</p>
        <h2 class="mt-2 text-4xl font-bold">{{ __($course) }}</h2>
        <p class="mx-auto mt-3 max-w-lg text-indigo-100">{{ __('From zero to full-stack developer in 8 weeks. Build real projects and land your dream job.') }}</p>
        <button class="mt-6 rounded-full bg-white px-8 py-3 text-sm font-bold text-indigo-700 hover:bg-indigo-50 transition-colors">{{ __('Enroll Now — ') }}{{ $price }}</button>
    </section>

    <section class="mx-auto max-w-4xl px-8 py-16">
        <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Course Modules') }}</h3>
        <div class="space-y-3">
            @foreach (['HTML & CSS Fundamentals', 'JavaScript Essentials', 'React & Component Design', 'Node.js & APIs', 'Database Design', 'Deployment & DevOps'] as $i => $module)
                <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white p-5 dark:bg-zinc-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-600 dark:bg-indigo-900 dark:text-indigo-300">{{ $i + 1 }}</span>
                            <span class="font-semibold text-zinc-900 dark:text-white">{{ __($module) }}</span>
                        </div>
                        <span class="text-sm text-zinc-500">{{ ($i + 1) * 2 }} {{ __('lessons') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-8 py-12">
        <h3 class="mb-6 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Your Instructor') }}</h3>
        <div class="flex items-start gap-6 rounded-xl bg-zinc-50 p-6 dark:bg-zinc-800">
            <div class="h-20 w-20 flex-shrink-0 rounded-full bg-zinc-200 dark:bg-zinc-700"></div>
            <div>
                <h4 class="font-bold text-zinc-900 dark:text-white">{{ __($instructor) }}</h4>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Senior Engineer with 10+ years of experience. Former lead at Google and Stripe. Passionate about teaching.') }}</p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-8 py-12">
        <h3 class="mb-6 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Student Reviews') }}</h3>
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ([['"Best course I\'ve ever taken. Clear explanations and real projects."', '5.0'], ['"Worth every penny. Got hired within a month of completing."', '5.0'], ['"Hands-on approach that actually works."', '4.8'], ['"Comprehensive and well-structured curriculum."', '4.9']] as [$review, $rating])
                <div class="rounded-xl bg-white p-5 shadow-sm dark:bg-zinc-800">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __($review) }}</p>
                    <p class="mt-2 text-xs font-semibold text-amber-500">★ {{ $rating }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="px-8 py-16 text-center">
        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Ready to Start?') }}</h3>
        <p class="mt-2 text-zinc-500">{{ __('Join 10,000+ students who transformed their careers.') }}</p>
        <button class="mt-6 rounded-full bg-indigo-600 px-10 py-3 text-sm font-bold text-white hover:bg-indigo-700 transition-colors">{{ __('Enroll Now — ') }}{{ $price }}</button>
    </section>
</div>
