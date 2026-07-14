@blaze(fold: true)

@props([
    'language' => null,
    'copyable' => true,
    'copyText' => null,
    'filename' => null,
])

@php
$hasHeader = $filename || $copyable;
$hasCopyBtn = $copyable && $copyText !== false;

$headerClasses = Gsmui::classes()
    ->add('flex items-center justify-between px-4 py-2 border-b border-zinc-700')
    ->add('bg-zinc-800/50 text-zinc-400 text-xs')
    ;
@endphp

<div {{ $attributes->class('relative w-full overflow-hidden rounded-xl border border-zinc-700 bg-zinc-900 shadow-xl') }} data-gsmui-code-block>
    @if ($hasHeader)
        <div class="{{ $headerClasses }}">
            <span class="font-medium truncate">
                @if ($filename)
                    <span class="text-zinc-300">{{ $filename }}</span>
                @elseif ($language)
                    <span class="text-zinc-500">{{ $language }}</span>
                @endif
            </span>

            @if ($hasCopyBtn)
                <gsmui:button
                    variant="subtle"
                    size="xs"
                    square
                    data-gsmui-code-copy
                    x-data="{ copied: false }"
                    @click="
                        navigator.clipboard.writeText('{{ $copyText ?? addslashes(trim(strip_tags((string)$slot))) }}');
                        copied = true;
                        setTimeout(() => copied = false, 2000);
                    "
                    aria-label="{{ __('Copy code') }}"
                >
                    <template x-if="!copied">
                        <gsmui:icon name="clipboard" variant="mini" class="size-3.5" />
                    </template>
                    <template x-if="copied">
                        <gsmui:icon name="check" variant="mini" class="size-3.5 text-green-400" />
                    </template>
                </gsmui:button>
            @endif
        </div>
    @endif

    <div class="relative overflow-x-auto">
        <pre class="font-mono text-sm leading-relaxed p-4 text-zinc-100 overflow-x-auto"><code>{{ $slot }}</code></pre>
    </div>
</div>
