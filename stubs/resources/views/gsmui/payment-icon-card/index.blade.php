@blaze(fold: true)

@props([
    'type' => 'paypal',
    'href' => null,
    'size' => 'md',
    'disabled' => false,
    'label' => null,
])

@php
$classes = Gsmui::classes()
    ->add('inline-flex items-center gap-2 transition-opacity')
    ->add(match ($size) {
        'sm' => 'h-8 px-3 text-sm',
        'lg' => 'h-12 px-5 text-base',
        default => 'h-10 px-4 text-sm',
    })
    ->add('rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-xs')
    ->add($disabled ? 'opacity-50 pointer-events-none' : 'hover:opacity-80')
    ;

$tag = $href ? 'a' : 'div';

$paymentLabel = $label ?? match ($type) {
    'paypal' => 'PayPal',
    'stripe' => 'Stripe',
    'apple-pay' => 'Apple Pay',
    'google-pay' => 'Google Pay',
    'venmo' => 'Venmo',
    'bitcoin' => 'Bitcoin',
    'ethereum' => 'Ethereum',
    'coinbase' => 'Coinbase',
    'binance' => 'Binance',
    'cash-app' => 'Cash App',
    'shopify' => 'Shopify',
    'square' => 'Square',
    'amazon-pay' => 'Amazon Pay',
    'klarna' => 'Klarna',
    'afterpay' => 'Afterpay',
    'affirm' => 'Affirm',
    'crypto-com' => 'Crypto.com',
    'meta' => 'Meta Pay',
    'wise' => 'Wise',
    'yahoo-pay' => 'Yahoo Pay',
    default => ucfirst($type),
};

$iconName = $type;
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    @if ($disabled) aria-disabled="true" @endif
    {{ $attributes->class($classes) }}
    data-gsmui-payment-icon-card
>
    <gsmui:icon :name="$iconName" class="shrink-0" />

    <span class="font-medium tabular-nums">{{ $paymentLabel }}</span>
</{{ $tag }}>