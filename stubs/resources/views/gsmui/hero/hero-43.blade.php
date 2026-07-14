@props([
    'testimonials' => [
        ['quote' => '"Gsmui Pro has transformed how we build interfaces. The components are incredibly well-designed and easy to use."', 'name' => 'John Smith', 'role' => 'CTO, TechCorp', 'avatar' => 'from-blue-400 to-blue-600'],
        ['quote' => '"The quality of these components is outstanding. We\'ve cut our development time by 60% since switching to Gsmui Pro."', 'name' => 'Emily Davis', 'role' => 'Lead Developer, StartupX', 'avatar' => 'from-violet-400 to-violet-600'],
        ['quote' => '"Finally, a component library that gets it right. Dark mode, accessibility, and performance are all top-notch."', 'name' => 'Mike Chen', 'role' => 'Design Lead, WebFlow', 'avatar' => 'from-emerald-400 to-emerald-600'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Trusted by<br><span class="text-emerald-600 dark:text-emerald-400">Industry Leaders</span></h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg text-zinc-600 dark:text-zinc-400">Join thousands of companies that rely on Gsmui Pro to power their web applications.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($testimonials as $t)
                <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                    <div class="flex gap-1 text-amber-400 mb-4" aria-hidden="true">★★★★★</div>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $t['quote'] }}</p>
                    <div class="mt-4 flex items-center gap-3">
                        <div class="size-10 rounded-full bg-gradient-to-br {{ $t['avatar'] }}" aria-hidden="true"></div>
                        <div><p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $t['name'] }}</p><p class="text-xs text-zinc-500">{{ $t['role'] }}</p></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
