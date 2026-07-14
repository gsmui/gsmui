@props([
    'heading' => __('Welcome to the future'),
    'subtitle' => __('A new way to build, create, and innovate.'),
    'cta' => __('Get started'),
])

<section {{ $attributes->class('relative overflow-hidden py-32 px-6 bg-zinc-950') }}>
    <div class="absolute -left-40 -top-40 h-80 w-80 animate-pulse rounded-full bg-purple-500/30 blur-3xl"></div>
    <div class="absolute -bottom-40 -right-40 h-80 w-80 animate-pulse rounded-full bg-blue-500/30 blur-3xl" style="animation-delay: 1s"></div>
    <div class="absolute left-1/2 top-1/2 h-60 w-60 -translate-x-1/2 -translate-y-1/2 animate-ping rounded-full bg-cyan-500/10 blur-2xl" style="animation-duration: 3s"></div>
    <div class="relative mx-auto max-w-3xl text-center">
        <h1 class="text-4xl font-bold tracking-tight text-white lg:text-6xl">{{ $heading }}</h1>
        <p class="mt-6 text-lg text-zinc-400">{{ $subtitle }}</p>
        <gsmui:button class="mt-10" size="lg">{{ $cta }}</gsmui:button>
    </div>
</section>
