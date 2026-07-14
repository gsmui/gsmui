@props([
    'buttons' => [
        ['label' => 'Get Started Free', 'href' => '#', 'style' => 'primary'],
    ],
    'steps' => [
        ['num' => '1', 'title' => 'Create your workspace', 'desc' => 'Set up in minutes'],
        ['num' => '2', 'title' => 'Invite your team', 'desc' => 'Collaborate in real-time'],
        ['num' => '3', 'title' => 'Start shipping', 'desc' => 'Launch faster together'],
    ],
    'activities' => [
        ['dotColor' => 'bg-emerald-500', 'title' => 'Design system review', 'time' => '2h ago'],
        ['dotColor' => 'bg-blue-500', 'title' => 'API integration', 'time' => '3h ago'],
        ['dotColor' => 'bg-amber-500', 'title' => 'User testing feedback', 'time' => '5h ago'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Your <span class="text-blue-600 dark:text-blue-400">Productivity</span><br>Workspace</h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">All-in-one workspace for teams to collaborate, manage projects, and ship faster.</p>
                <div class="mt-8 space-y-4">
                    @foreach ($steps as $step)
                        <div class="flex items-center gap-4">
                            <span class="flex size-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-sm font-bold text-blue-700 dark:text-blue-300">{{ $step['num'] }}</span>
                            <div><p class="font-medium text-zinc-900 dark:text-white">{{ $step['title'] }}</p><p class="text-sm text-zinc-500">{{ $step['desc'] }}</p></div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-blue-600 px-8 py-3 text-sm font-semibold text-white hover:bg-blue-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-800/50 p-6">
                <div class="flex items-center gap-3 border-b border-zinc-200 dark:border-white/10 pb-4">
                    <div class="flex -space-x-1"><div class="size-7 rounded-full border-2 border-white dark:border-zinc-800 bg-gradient-to-br from-blue-400 to-blue-600" aria-hidden="true"></div><div class="size-7 rounded-full border-2 border-white dark:border-zinc-800 bg-gradient-to-br from-violet-400 to-violet-600" aria-hidden="true"></div><div class="size-7 rounded-full border-2 border-white dark:border-zinc-800 bg-gradient-to-br from-emerald-400 to-emerald-600" aria-hidden="true"></div></div>
                    <span class="text-sm text-zinc-500">3 online now</span>
                </div>
                <div class="mt-4 space-y-3">
                    @foreach ($activities as $activity)
                        <div class="flex items-center gap-3 rounded-lg bg-white dark:bg-zinc-800 p-3">
                            <span class="size-2 rounded-full {{ $activity['dotColor'] }}" aria-hidden="true"></span>
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $activity['title'] }}</span>
                            <span class="ml-auto text-xs text-zinc-400">{{ $activity['time'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
