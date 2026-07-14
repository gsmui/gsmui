@props([
    'heading' => __('Ready to get started?'),
    'subtitle' => __('Join thousands of teams already using our platform to build better products faster.'),
    'primaryCta' => __('Start free trial'),
    'secondaryCta' => __('Talk to sales'),
])

<section {{ $attributes->class('relative overflow-hidden rounded-3xl bg-gradient-to-br from-zinc-900 via-purple-900 to-zinc-900 py-20 px-6') }}>
    <div class="absolute -left-20 -top-20 h-60 w-60 rounded-full bg-purple-500/20 blur-3xl"></div>
    <div class="absolute -bottom-20 -right-20 h-60 w-60 rounded-full bg-blue-500/20 blur-3xl"></div>
    <div class="relative mx-auto max-w-2xl text-center">
        <h2 class="text-3xl font-bold text-white lg:text-4xl">{{ $heading }}</h2>
        <p class="mt-4 text-lg text-zinc-300">{{ $subtitle }}</p>
        <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <gsmui:button size="lg">{{ $primaryCta }}</gsmui:button>
            <gsmui:button size="lg" variant="outline" class="border-white/20 text-white hover:bg-white/10">{{ $secondaryCta }}</gsmui:button>
        </div>
    </div>
</section>
