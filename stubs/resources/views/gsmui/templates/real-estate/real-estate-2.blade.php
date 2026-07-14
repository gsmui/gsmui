@props([
    'property' => [
        'price' => '$2,450,000',
        'address' => '1200 Prestige Drive, Beverly Hills, CA 90210',
        'beds' => 5,
        'baths' => 4,
        'sqft' => '5,000',
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 text-white') }}>
    <section class="relative h-[500px] bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-transparent">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/30 via-zinc-800/50 to-zinc-950/80"></div>
        <div class="relative mx-auto flex h-full max-w-6xl items-end px-8 pb-12">
            <div>
                <p class="text-4xl font-bold">{{ $property['price'] }}</p>
                <p class="mt-2 text-zinc-300">{{ $property['address'] }}</p>
                <div class="mt-4 flex gap-6 text-sm text-zinc-400">
                    <span>{{ $property['beds'] }} {{ __('Beds') }}</span>
                    <span>{{ $property['baths'] }} {{ __('Baths') }}</span>
                    <span>{{ $property['sqft'] }} {{ __('sqft') }}</span>
                </div>
                <button class="mt-6 rounded-full bg-white px-8 py-3 text-sm font-semibold text-zinc-900 hover:bg-zinc-200 transition-colors">{{ __('Virtual Tour') }}</button>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-8 py-16">
        <h3 class="mb-8 text-2xl font-bold">{{ __('Property Details') }}</h3>
        <div class="grid gap-8 md:grid-cols-2">
            <div class="space-y-4">
                @foreach ([['Type', 'Single Family'], ['Year Built', '2021'], ['Lot Size', '0.45 acres'], ['Garage', '3-car attached'], ['Pool', 'Yes, infinity edge']] as [$label, $value])
                    <div class="flex justify-between border-b border-zinc-800 pb-3">
                        <span class="text-zinc-500">{{ __($label) }}</span>
                        <span class="font-medium">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
            <div class="aspect-video rounded-xl bg-zinc-800"></div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-8 py-12">
        <h3 class="mb-8 text-2xl font-bold">{{ __('Similar Properties') }}</h3>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([['$1,850,000', '4 bed · 3 bath · 3,800 sqft'], ['$3,100,000', '6 bed · 5 bath · 6,200 sqft'], ['$2,200,000', '5 bed · 4 bath · 4,500 sqft']] as [$price, $details])
                <div class="overflow-hidden rounded-xl bg-zinc-900">
                    <div class="aspect-video bg-zinc-800"></div>
                    <div class="p-4">
                        <p class="text-lg font-bold">{{ $price }}</p>
                        <p class="mt-1 text-sm text-zinc-500">{{ $details }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
