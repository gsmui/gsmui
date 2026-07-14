@blaze(fold: true)

@props([
    'style' => 'horizontal',
    'brand' => null,
    'number' => null,
    'holder' => null,
    'expiry' => null,
    'cvv' => null,
    'color' => null,
    'href' => null,
    'actionLabel' => null,
    'actionHref' => null,
    'maxDigits' => 4,
])

@php
$isLink = $href && !$attributes->has('as');
$tag = $attributes->has('as') ? $attributes->get('as') : ($isLink ? 'a' : 'div');

$lastFour = '****';
if ($number) {
    $numberDigits = preg_replace('/\D/', '', $number);
    $matches = [];
    preg_match('/(\d{4})$/', $numberDigits, $matches);
    $lastFour = $matches[1] ?? '****';
    $cardNumber = preg_replace('/(\d{4})(\d{4})(\d{4})(\d{4})/', '$1 $2 $3 ****', $number);
    $cardNumber = preg_replace('/\d{4}(\d{4})$/', '**** $1', $cardNumber);
} else {
    $cardNumber = '**** **** **** ****';
}

$brandColors = [
    'visa' => ['text' => '#1a1f71', 'bg' => '#f0f3ff', 'dark-bg' => '#1a1f71'],
    'mastercard' => ['text' => '#eb2e27', 'bg' => '#f8f0f2', 'dark-bg' => '#eb2e27'],
    'amex' => ['text' => '#0065b2', 'bg' => '#f0f5ff', 'dark-bg' => '#0065b2'],
    'discover' => ['text' => '#063d71', 'bg' => '#f0f4fb', 'dark-bg' => '#063d71'],
    'jcb' => ['text' => '#3c62b4', 'bg' => '#f0f2f8', 'dark-bg' => '#3c62b4'],
    'diners' => ['text' => '#2c1b33', 'bg' => '#f6f2f8', 'dark-bg' => '#2c1b33'],
];

$brandInfo = $brandColors[$brand] ?? null;

$brandIcon = match ($brand) {
    'visa' => '<path fill-rule="evenodd" d="M2.5 4A1.5 1.5 0 001 5.5V6h18v-.5A1.5 1.5 0 0017.5 4h-15zM19 8.5H1v6A1.5 1.5 0 002.5 16h15a1.5 1.5 0 001.5-1.5v-6zM3 13.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zm4.75-.75a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd"/>',
    'mastercard' => '<path fill-rule="evenodd" d="M10 3.75a6.25 6.25 0 016.25 6.25v.75a1.25 1.25 0 01-2.5 0v-.75A5 5 0 0010 5.25 5 5 0 003.75 11.5v.75a1.25 1.25 0 01-2.5 0v-.75A6.25 6.25 0 0110 3.75zM17.5 10.5a4 4 0 01-4 4h-3a4 4 0 01-4-4v-.75a4 4 0 014-4h3a4 4 0 014 4v.75z" clip-rule="evenodd"/>',
    'amex' => '<path fill-rule="evenodd" d="M10 3a7 7 0 00-7 7v.75a1.5 1.5 0 001.5 1.5h13a1.5 1.5 0 001.5-1.5v-.75A7 7 0 0010 3zm0 1.5a5.5 5.5 0 015.5 5.5v.75a.75.75 0 01-.75.75h-11a.75.75 0 01-.75-.75v-.75A5.5 5.5 0 0110 4.5z" clip-rule="evenodd"/>',
    'discover' => '<path fill-rule="evenodd" d="M10 2a8 8 0 00-8 8v1.5a.5.5 0 00.5.5h15a.5.5 0 00.5-.5v-1.5A8 8 0 0010 2zm0 1.5A6.5 6.5 0 0116.5 10H10V6.5z" clip-rule="evenodd"/>',
    'jcb' => '<path fill-rule="evenodd" d="M5.5 6a1 1 0 011-1h9a1 1 0 011 1v8a1 1 0 01-1 1h-9a1 1 0 01-1-1V6zm1 1v6h7V7H6.5z" clip-rule="evenodd"/>',
    'diners' => '<path fill-rule="evenodd" d="M6.5 3a.75.75 0 00-.75.75v12a.75.75 0 00.75.75h6a.75.75 0 00.75-.75v-4a.75.75 0 00-.75-.75h-1v-1h1a.75.75 0 00.75-.75V7.5a.75.75 0 00-.75-.75h-1V4.25a.75.75 0 00-.75-.75h-1z" clip-rule="evenodd"/>',
    default => '<path fill-rule="evenodd" d="M2.5 4A1.5 1.5 0 001 5.5V6h18v-.5A1.5 1.5 0 0017.5 4h-15zM19 8.5H1v6A1.5 1.5 0 002.5 16h15a1.5 1.5 0 001.5-1.5v-6zM3 13.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zm4.75-.75a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd"/>',
};

$classes = Gsmui::classes()
    ->add('rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-sm')
    ->add($style === 'overlay' ? 'relative overflow-hidden' : '')
    ->add($style === 'featured' ? 'ring-2 ring-blue-500/30 dark:ring-blue-400/20' : '')
    ->add($style === 'minimal' ? 'shadow-none border-transparent dark:border-transparent bg-zinc-50 dark:bg-zinc-800/50' : '');
@endphp

<{{ $tag }}
    @if ($isLink) href="{{ $href }}" aria-label="{{ $holder ?? 'Credit card' }}" @endif
    {{ $attributes->class($classes) }}
    data-gsmui-credit-card
    data-gsmui-credit-card-style="{{ $style }}"
>
    @switch($style)
        @case('minimal')
            <div class="flex items-center gap-2 p-3">
                @if ($brand && $brandInfo)
                    <gsmui:icon name="credit-card" class="text-[{{ $brandInfo['text'] }}] dark:text-white" />
                @else
                    <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                @endif
                <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100 tabular-nums">{{ $cardNumber }}</span>
            </div>
            @break

        @case('compact')
            <div class="flex items-center gap-2 p-3">
                <div class="flex items-center justify-center size-8 rounded-lg bg-zinc-100 dark:bg-zinc-800">
                    @if ($brand && $brandInfo)
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            {!! $brandIcon !!}
                        </svg>
                    @else
                        <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $holder ?? 'Cardholder' }}</div>
                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $cardNumber }}</div>
                </div>
            </div>
            @break

        @case('horizontal')
            <div class="flex items-center gap-4 p-4">
                <div class="flex items-center justify-center size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800">
                    @if ($brand && $brandInfo)
                        <svg class="size-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            {!! $brandIcon !!}
                        </svg>
                    @else
                        <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $holder ?? 'Cardholder' }}</div>
                    @if ($number)
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono tracking-wider tabular-nums">{{ $cardNumber }}</div>
                    @endif
                    @if ($expiry)
                        <div class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Expires {{ $expiry }}</div>
                    @endif
                </div>
                @if ($cvv)
                    <div class="text-xs text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-md font-mono tabular-nums">{{ $cvv }}</div>
                @endif
            </div>
            @break

        @case('vertical')
            <div class="flex flex-col items-center p-5 text-center">
                <div class="flex items-center justify-center size-12 rounded-lg bg-zinc-100 dark:bg-zinc-800 mb-3">
                    @if ($brand && $brandInfo)
                        <svg class="size-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            {!! $brandIcon !!}
                        </svg>
                    @else
                        <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                    @endif
                </div>
                <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $holder ?? 'Cardholder' }}</div>
                @if ($number)
                    <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono tracking-wider tabular-nums mt-1">{{ $cardNumber }}</div>
                @endif
                @if ($expiry)
                    <div class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Expires {{ $expiry }}</div>
                @endif
                @if ($cvv)
                    <div class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">CVV: {{ $cvv }}</div>
                @endif
                @if ($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" size="sm" class="mt-4">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
            @break

        @case('cover')
            @if ($color)
                <div class="w-full h-24 object-cover" style="background-color: {{ $color }};"></div>
            @else
                <div class="w-full h-24 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
            @endif
            <div class="flex flex-col items-center -mt-6 relative z-10 px-4 pb-4">
                <div class="flex items-center justify-center size-10 rounded-lg bg-white/90 dark:bg-zinc-800 mb-2">
                    @if ($brand && $brandInfo)
                        <svg class="size-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            {!! $brandIcon !!}
                        </svg>
                    @else
                        <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                    @endif
                </div>
                <div class="text-sm font-semibold text-white">{{ $holder ?? 'Cardholder' }}</div>
                @if ($number)
                    <div class="text-xs text-white/90 font-mono tracking-wider tabular-nums">{{ $cardNumber }}</div>
                @endif
                @if ($expiry)
                    <div class="text-xs text-white/80 mt-1">Expires {{ $expiry }}</div>
                @endif
                @if ($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" size="sm" class="mt-3">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
            @break

        @case('featured')
            <div class="p-5">
                <div class="flex items-start gap-4">
                    <div class="flex items-center justify-center size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 shrink-0">
                        @if ($brand && $brandInfo)
                            <svg class="size-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                {!! $brandIcon !!}
                            </svg>
                        @else
                            <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $holder ?? 'Cardholder' }}</div>
                        @if ($number)
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono tracking-wider tabular-nums mt-1">{{ $cardNumber }}</div>
                        @endif
                        @if ($expiry)
                            <div class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Expires {{ $expiry }}</div>
                        @endif
                    </div>
                </div>
                @if ($cvv)
                    <div class="mt-4 grid grid-cols-3 gap-3">
                        <div class="text-center p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <div class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 tabular-nums">{{ strlen($cvv) }}</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">CVV Digits</div>
                        </div>
                        @if ($number)
                            <div class="text-center p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                                <div class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 tabular-nums">{{ strlen(preg_replace('/\D/', '', $number)) }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">Digits</div>
                            </div>
                        @endif
                        @if ($expiry)
                            <div class="text-center p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('Expires') }}</div>
                            </div>
                        @endif
                    </div>
                @endif
                @if ($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" variant="primary" class="w-full mt-4">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
            @break

        @case('stats')
            <div class="p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 shrink-0">
                        @if ($brand && $brandInfo)
                            <svg class="size-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                {!! $brandIcon !!}
                            </svg>
                        @else
                            <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                        @endif
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $holder ?? 'Cardholder' }}</div>
                        @if ($number)
                            <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono tracking-wider tabular-nums">{{ $cardNumber }}</div>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <gsmui:stat label="Last 4" :value="$lastFour" size="sm" />
                    <gsmui:stat label="Type" :value="ucfirst($brand ?? 'Unknown')" size="sm" />
                    @if ($cvv)
                        <gsmui:stat label="CVV" :value="$cvv" size="sm" />
                    @else
                        <gsmui:stat label="Status" value="Active" size="sm" />
                    @endif
                </div>
            </div>
            @break

        @case('list')
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="flex items-center justify-center size-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 shrink-0">
                    @if ($brand && $brandInfo)
                        <svg class="size-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            {!! $brandIcon !!}
                        </svg>
                    @else
                        <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $holder ?? 'Cardholder' }}</div>
                    @if ($number)
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono tracking-wider tabular-nums truncate">{{ $cardNumber }}</div>
                    @endif
                </div>
                <gsmui:icon.chevron-right variant="micro" class="shrink-0 text-zinc-400" />
            </div>
            @break

        @case('grid')
            <div class="p-4">
                <div class="grid grid-cols-2 gap-1.5 mb-3">
                    <div class="flex items-center justify-center size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800">
                        @if ($brand && $brandInfo)
                            <svg class="size-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                {!! $brandIcon !!}
                            </svg>
                        @else
                            <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                        @endif
                    </div>
                    <div class="flex items-center justify-center size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800">
                        <gsmui:icon.credit-card class="text-zinc-400 dark:text-zinc-500" />
                    </div>
                </div>
                <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $holder ?? 'Cardholder' }}</div>
                @if ($number)
                    <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono tracking-wider tabular-nums truncate">{{ $cardNumber }}</div>
                @endif
                @if ($expiry)
                    <div class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Expires {{ $expiry }}</div>
                @endif
            </div>
            @break

        @case('overlay')
            @if ($color)
                <div class="absolute inset-0 w-full h-full" style="background-color: {{ $color }};"></div>
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-zinc-700 to-zinc-900"></div>
            @endif
            <div class="relative z-10 p-5 flex flex-col h-full min-h-[100px]">
                <div class="flex items-center justify-center size-10 rounded-lg bg-white/90 dark:bg-zinc-800 mb-3 self-start">
                    @if ($brand && $brandInfo)
                        <svg class="size-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            {!! $brandIcon !!}
                        </svg>
                    @else
                        <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                    @endif
                </div>
                <div class="text-lg font-semibold text-white">{{ $holder ?? 'Cardholder' }}</div>
                @if ($number)
                    <div class="text-sm text-white/90 font-mono tracking-wider tabular-nums mt-1">{{ $cardNumber }}</div>
                @endif
                @if ($expiry)
                    <div class="text-sm text-white/80 mt-1">Expires {{ $expiry }}</div>
                @endif
                @if ($cvv)
                    <div class="text-sm text-white/80 mt-1">CVV: {{ $cvv }}</div>
                @endif
                @if ($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" variant="primary" size="sm" class="mt-auto self-start">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
            @break

        @default
            <div class="flex items-center gap-4 p-4">
                <div class="flex items-center justify-center size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 shrink-0">
                    @if ($brand && $brandInfo)
                        <svg class="size-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            {!! $brandIcon !!}
                        </svg>
                    @else
                        <gsmui:icon.credit-card class="text-zinc-600 dark:text-zinc-400" />
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $holder ?? 'Cardholder' }}</div>
                    @if ($number)
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono tracking-wider tabular-nums">{{ $cardNumber }}</div>
                    @endif
                    @if ($expiry)
                        <div class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Expires {{ $expiry }}</div>
                    @endif
                </div>
                @if ($cvv)
                    <div class="text-xs text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-md font-mono tabular-nums">{{ $cvv }}</div>
                @endif
            </div>
    @endswitch
</{{ $tag }>