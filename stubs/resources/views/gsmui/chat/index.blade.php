@blaze(fold: true)

@props([
    'align' => 'start',
    'avatar' => null,
    'avatarAlt' => null,
    'name' => null,
    'time' => null,
    'status' => null,
    'color' => null,
    'bubble' => null,
])

@php
$alignEnd = $align === 'end' || $align === 'right';

$classes = Gsmui::classes()
    ->add('flex gap-3 items-start')
    ->add($alignEnd ? 'flex-row-reverse' : 'flex-row')
    ;

$avatarClasses = Gsmui::classes()
    ->add('shrink-0')
    ;

$bodyClasses = Gsmui::classes()
    ->add('flex flex-col max-w-[75%]')
    ->add($alignEnd ? 'items-end' : 'items-start')
    ;

$headerClasses = Gsmui::classes()
    ->add('flex items-center gap-2 px-1 mb-0.5')
    ->add($alignEnd ? 'flex-row-reverse' : 'flex-row')
    ;

$nameClasses = Gsmui::classes()
    ->add('text-xs font-medium text-zinc-600 dark:text-zinc-400')
    ;

$timeClasses = Gsmui::classes()
    ->add('text-[10px] text-zinc-400 dark:text-zinc-500')
    ;

$footerClasses = Gsmui::classes()
    ->add('text-[10px] text-zinc-400 dark:text-zinc-500 px-1 mt-0.5')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-chat>
    {{-- Avatar --}}
    @if ($avatar || ($slot?->avatar ?? false))
        <div class="{{ $avatarClasses }}">
            @if ($slot?->avatar ?? false)
                {{ $slot->avatar }}
            @elseif ($avatar)
                <div class="size-8 rounded-full overflow-hidden bg-zinc-200 dark:bg-zinc-700 shrink-0">
                    <img class="w-full h-full object-cover" src="{{ $avatar }}" alt="{{ $avatarAlt ?? '' }}" />
                </div>
            @endif
        </div>
    @endif

    {{-- Message body: header + bubble + footer --}}
    <div class="{{ $bodyClasses }}">
        {{-- Header: name + time --}}
        @if ($name || $time || ($slot?->header ?? false))
            <div class="{{ $headerClasses }}">
                {{ $slot->header ?? '' }}

                @if ($name && !($slot?->header ?? false))
                    <span class="{{ $nameClasses }}">{{ $name }}</span>
                @endif

                @if ($time && !($slot?->header ?? false))
                    <time class="{{ $timeClasses }}">{{ $time }}</time>
                @endif
            </div>
        @endif

        {{-- Bubble --}}
        <gsmui:chat.bubble :$color :end="$alignEnd">
            @if ($bubble)
                {{ $bubble }}
            @else
                {{ $slot }}
            @endif
        </gsmui:chat.bubble>

        {{-- Footer: status --}}
        @if ($status || ($slot?->footer ?? false))
            <div class="{{ $footerClasses }}">
                {{ $slot->footer ?? $status }}
            </div>
        @endif
    </div>
</div>
