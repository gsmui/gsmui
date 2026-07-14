@props([
    'heading' => __('Experience the future'),
    'subtitle' => __('Watch how teams are transforming their workflow with our platform.'),
])

<section {{ $attributes->class('relative py-32 px-6 bg-zinc-900') }}>
    <div class="absolute inset-0 bg-zinc-900/70"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-zinc-900/50 to-zinc-900"></div>
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="aspect-video w-full max-w-4xl rounded-2xl bg-zinc-800"></div>
    </div>
    <div class="relative mx-auto max-w-3xl text-center">
        <h1 class="text-4xl font-bold tracking-tight text-white lg:text-6xl">{{ $heading }}</h1>
        <p class="mt-6 text-lg text-zinc-300">{{ $subtitle }}</p>
        <button class="mt-10 inline-flex h-16 w-16 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm transition hover:bg-white/30">
            <x-gsmui:icon name="play" class="h-7 w-7 text-white" />
        </button>
    </div>
</section>
