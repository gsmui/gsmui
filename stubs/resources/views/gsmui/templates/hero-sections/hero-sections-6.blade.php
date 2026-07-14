@props([
    'heading' => __('Take it with you'),
    'subtitle' => __('Download our app for iOS and Android. Stay connected wherever you are.'),
    'features' => [__('Offline mode'), __('Push notifications'), __('Biometric login')],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="text-center lg:text-left">
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white lg:text-5xl">{{ $heading }}</h1>
                <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
                <div class="mt-8 flex flex-col items-center gap-4 sm:flex-row lg:justify-start">
                    <div class="h-12 w-36 rounded-lg bg-zinc-900 dark:bg-white"></div>
                    <div class="h-12 w-36 rounded-lg bg-zinc-900 dark:bg-white"></div>
                </div>
                <ul class="mt-8 flex flex-col items-center gap-3 lg:items-start">
                    @foreach ($features as $feature)
                        <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                            <x-gsmui:icon name="check" class="h-4 w-4 text-green-500" />
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mx-auto w-64">
                <div class="aspect-[9/16] rounded-3xl border-4 border-zinc-200 dark:border-white/10 bg-zinc-100 dark:bg-white/5"></div>
            </div>
        </div>
    </div>
</section>
