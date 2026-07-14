@props([
    'title' => __('Meet our team'),
    'subtitle' => __('The people behind the product.'),
    'members' => [
        ['name' => 'Sarah Chen', 'role' => 'CEO & Co-founder', 'bio' => __('Former VP at Google. 15 years building products that scale.')],
        ['name' => 'Marcus Johnson', 'role' => 'CTO', 'bio' => __('Ex-Meta engineer. Passionate about distributed systems.')],
        ['name' => 'Emily Rodriguez', 'role' => 'Head of Design', 'bio' => __('Award-winning designer. Previously at Apple and Figma.')],
        ['name' => 'David Kim', 'role' => 'VP Engineering', 'bio' => __('Built platforms serving 100M+ users at Netflix.')],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        </div>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($members as $member)
                <div class="group relative overflow-hidden rounded-2xl">
                    <div class="aspect-[3/4] bg-zinc-200 dark:bg-white/10"></div>
                    <div class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-black/80 to-transparent p-6 opacity-0 transition-opacity group-hover:opacity-100">
                        <p class="text-sm text-white/80">{{ $member['bio'] }}</p>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                        <div class="font-semibold text-white">{{ $member['name'] }}</div>
                        <div class="text-sm text-white/70">{{ $member['role'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
