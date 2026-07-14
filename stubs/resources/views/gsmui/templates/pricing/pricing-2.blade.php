@props([
    'title' => __('Compare all features'),
    'plans' => [__('Starter'), __('Pro'), __('Enterprise')],
    'prices' => ['$9/mo', '$29/mo', '$99/mo'],
    'categories' => [
        ['name' => __('Core'), 'features' => [
            ['name' => __('Users'), 'values' => ['5', '25', __('Unlimited')]],
            ['name' => __('Storage'), 'values' => ['10 GB', '100 GB', '1 TB']],
            ['name' => __('Projects'), 'values' => ['3', '25', __('Unlimited')]],
        ]],
        ['name' => __('Advanced'), 'features' => [
            ['name' => __('Custom Domain'), 'values' => [false, true, true]],
            ['name' => __('API Access'), 'values' => [true, true, true]],
            ['name' => __('SSO / SAML'), 'values' => [false, false, true]],
            ['name' => __('Audit Logs'), 'values' => [false, true, true]],
        ]],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="sticky top-0 bg-white dark:bg-zinc-900">
                    <tr class="border-b-2 border-zinc-200 dark:border-white/10">
                        <th class="py-4 text-left font-medium text-zinc-500 dark:text-zinc-400 w-1/3"></th>
                        @foreach ($plans as $i => $plan)
                            <th class="py-4 text-center">
                                <div class="font-semibold text-zinc-900 dark:text-white">{{ $plan }}</div>
                                <div class="text-xs text-zinc-500">{{ $prices[$i] }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td colspan="{{ count($plans) + 1 }}" class="pt-8 pb-2 text-xs font-semibold uppercase tracking-wider text-zinc-400">{{ $category['name'] }}</td>
                        </tr>
                        @foreach ($category['features'] as $feature)
                            <tr class="border-b border-zinc-100 dark:border-white/5">
                                <td class="py-3 text-zinc-700 dark:text-zinc-300">{{ $feature['name'] }}</td>
                                @foreach ($feature['values'] as $value)
                                    <td class="py-3 text-center">
                                        @if ($value === true)
                                            <x-gsmui:icon name="check" class="mx-auto h-5 w-5 text-green-500" />
                                        @elseif ($value === false)
                                            <x-gsmui:icon name="minus" class="mx-auto h-5 w-5 text-zinc-300 dark:text-zinc-600" />
                                        @else
                                            <span class="text-zinc-700 dark:text-zinc-300">{{ $value }}</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
