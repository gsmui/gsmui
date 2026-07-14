@props([
    'badges' => [
        ['label' => 'Developer Friendly', 'color' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300'],
        ['label' => 'Design System', 'color' => 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300'],
        ['label' => 'Community Driven', 'color' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300'],
    ],
    'avatars' => [
        ['gradient' => 'from-blue-400 to-blue-600'],
        ['gradient' => 'from-violet-400 to-violet-600'],
        ['gradient' => 'from-emerald-400 to-emerald-600'],
    ],
    'testimonials' => [
        ['name' => 'Alex Chen', 'role' => 'Frontend Developer', 'gradient' => 'from-blue-100 to-blue-50 dark:from-blue-900/20 dark:to-blue-800/10'],
        ['name' => 'Sarah Kim', 'role' => 'UI Designer', 'gradient' => 'from-violet-100 to-violet-50 dark:from-violet-900/20 dark:to-violet-800/10', 'offset' => true],
        ['name' => 'Mike Johnson', 'role' => 'Product Manager', 'gradient' => 'from-emerald-100 to-emerald-50 dark:from-emerald-900/20 dark:to-emerald-800/10', 'spanFull' => true],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="flex flex-wrap gap-3 mb-6">
                    @foreach ($badges as $badge)
                        <span class="rounded-full {{ $badge['color'] }} px-3 py-1 text-xs font-medium">{{ $badge['label'] }}</span>
                    @endforeach
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Creative<br><span class="bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">Portfolio Showcase</span></h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Display your work in style with our premium portfolio templates. Built for creatives, designers, and developers who demand excellence.</p>
                <p class="mt-4 text-sm text-zinc-500">4.9/5 rating · Trusted by creative professionals</p>
                <div class="mt-10 flex items-center gap-6">
                    <div class="flex -space-x-2">
                        @foreach ($avatars as $avatar)
                            <div class="size-10 rounded-full border-2 border-white bg-gradient-to-br {{ $avatar['gradient'] }}" aria-hidden="true"></div>
                        @endforeach
                    </div>
                    <div class="text-sm"><span class="font-medium text-zinc-900 dark:text-white">AC</span><span class="text-zinc-500"> Alex Chen · Frontend Developer</span></div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($testimonials as $testimonial)
                    <div @class([
                        'rounded-2xl bg-gradient-to-br ' . $testimonial['gradient'] . ' p-6',
                        'col-span-2' => isset($testimonial['spanFull']) && $testimonial['spanFull'],
                        'mt-4' => isset($testimonial['offset']) && $testimonial['offset'],
                    ])>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $testimonial['name'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $testimonial['role'] }}</p>
                        <div class="mt-4 flex items-center gap-1 text-amber-400" aria-hidden="true">★★★★★</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
