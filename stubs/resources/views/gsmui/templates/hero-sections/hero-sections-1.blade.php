@props([
    'heading' => __('Build something extraordinary'),
    'subtitle' => __('The modern platform for teams that ship fast. Collaborate, automate, and scale with confidence.'),
    'primaryCta' => __('Get started free'),
    'secondaryCta' => __('Learn more'),
])

<section {{ $attributes->class('relative overflow-hidden bg-gradient-to-br from-zinc-900 via-purple-900 to-zinc-900 py-24 px-6') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(120,119,198,0.3),transparent_50%)]"></div>
    <div class="relative mx-auto max-w-3xl text-center">
        <h1 class="text-4xl font-bold tracking-tight text-white lg:text-6xl">{{ $heading }}</h1>
        <p class="mt-6 text-lg text-zinc-300 lg:text-xl">{{ $subtitle }}</p>
        <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <gsmui:button size="lg">{{ $primaryCta }}</gsmui:button>
            <gsmui:button size="lg" variant="outline" class="border-white/20 text-white hover:bg-white/10">{{ $secondaryCta }}</gsmui:button>
        </div>
    </div>
</section>
