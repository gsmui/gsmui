@props([
    'buttons' => [
        ['label' => 'Start Learning', 'href' => '#', 'style' => 'primary'],
    ],
    'courses' => [
        ['title' => 'Web Development Bootcamp', 'instructor' => 'Dr. Sarah Miller', 'rating' => '4.9', 'gradient' => 'from-orange-200 to-amber-200 dark:from-orange-900/30 dark:to-amber-800/20'],
        ['title' => 'Advanced CSS & Tailwind', 'instructor' => 'Alex Rivera', 'rating' => '4.8', 'gradient' => 'from-blue-200 to-cyan-200 dark:from-blue-900/30 dark:to-cyan-800/20'],
        ['title' => 'React & Laravel Masterclass', 'instructor' => 'Emily Davis', 'rating' => '4.7', 'gradient' => 'from-violet-200 to-purple-200 dark:from-violet-900/30 dark:to-purple-800/20'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-orange-50 to-amber-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Learn Without<br><span class="bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent">Limits</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Access thousands of courses from expert instructors. Learn at your own pace with interactive content, quizzes, and certificates.</p>
                <div class="mt-8 flex items-center gap-4">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-orange-600 px-8 py-3 text-sm font-semibold text-white hover:bg-orange-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                    <a href="#" class="text-sm font-medium text-orange-600 dark:text-orange-400 hover:underline">Browse Courses →</a>
                </div>
                <div class="mt-10 flex items-center gap-8 text-sm"><span class="flex items-center gap-2"><span aria-hidden="true">📚</span> <strong>10k+</strong> Courses</span><span class="flex items-center gap-2"><span aria-hidden="true">👨‍🏫</span> <strong>2k+</strong> Instructors</span><span class="flex items-center gap-2"><span aria-hidden="true">🎓</span> <strong>500k+</strong> Students</span></div>
            </div>
            <div class="space-y-4">
                @foreach ($courses as $course)
                    <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-4 flex items-center gap-4">
                        <div class="size-16 rounded-xl bg-gradient-to-br {{ $course['gradient'] }} shrink-0" aria-hidden="true"></div>
                        <div>
                            <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $course['title'] }}</h3>
                            <p class="text-sm text-zinc-500">{{ $course['instructor'] }}</p>
                            <div class="flex items-center gap-1 mt-1 text-amber-400" aria-hidden="true">★★★★★ <span class="text-xs text-zinc-400 ml-1">({{ $course['rating'] }})</span></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
