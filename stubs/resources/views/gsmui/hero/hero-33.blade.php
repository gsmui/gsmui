@props([
    'buttons' => [
        ['label' => 'Get Started', 'href' => '#', 'style' => 'primary'],
    ],
    'stats' => [
        ['value' => '24/7', 'label' => 'Care Access'],
        ['value' => '500+', 'label' => 'Specialists'],
        ['value' => '98%', 'label' => 'Satisfaction'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-4 py-1.5 text-sm font-medium text-emerald-700 dark:text-emerald-300"><span aria-hidden="true">✅</span> HIPAA Compliant</div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Your Health,<br><span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Reimagined</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Connect with top healthcare professionals, monitor your vitals in real-time, and take control of your wellness journey with our AI-powered platform.</p>
                <div class="mt-8 flex gap-8">
                    @foreach ($stats as $stat)
                        <div><p class="text-2xl font-bold text-emerald-600">{{ $stat['value'] }}</p><p class="text-xs text-zinc-500">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-emerald-600 px-8 py-3 text-sm font-semibold text-white hover:bg-emerald-500 transition-all">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                <div class="flex items-center justify-between border-b border-zinc-200 dark:border-white/10 pb-4"><span class="text-sm font-medium text-zinc-900 dark:text-white">Health Dashboard</span><span class="flex items-center gap-1.5 text-xs text-emerald-600"><span class="size-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span> Live</span></div>
                <div class="mt-6 grid grid-cols-2 gap-4"><div><p class="text-xs text-zinc-500">Heart Rate</p><p class="text-2xl font-bold text-zinc-900 dark:text-white">72</p><p class="text-xs text-emerald-600">bpm</p></div><div><p class="text-xs text-zinc-500">Steps Today</p><p class="text-2xl font-bold text-zinc-900 dark:text-white">8,543</p></div></div>
                <div class="mt-4"><div class="flex items-center justify-between mb-2"><span class="text-xs text-zinc-500">Weekly Fitness Goal</span><span class="text-xs font-medium">85%</span></div><div class="h-2 rounded-full bg-zinc-200 dark:bg-zinc-700"><div class="h-2 w-[85%] rounded-full bg-emerald-500"></div></div></div>
                <div class="mt-4 border-t border-zinc-200 dark:border-white/10 pt-4"><div class="flex items-center justify-between"><span class="text-sm text-zinc-500">Next Appointment</span><span class="text-sm font-medium text-zinc-900 dark:text-white">Tomorrow</span></div><p class="text-xs text-zinc-400">Dr. Smith - Cardiology</p></div>
            </div>
        </div>
    </div>
</div>
