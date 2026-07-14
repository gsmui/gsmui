@blaze(fold: true)

@props([
    'user' => null,
    'avatar' => null,
    'email' => null,
    'sticky' => true,
    'actions' => true,
    'variant' => null,
])

@php
$hasUserSlot = ($slot?->user ?? false) !== false;
$hasAvatarSlot = ($slot?->avatar ?? false) !== false;
$hasActionsSlot = ($slot?->actions ?? false) !== false;

$classes = Gsmui::classes()
    ->add('px-4 py-3 border-t border-zinc-200 dark:border-zinc-800')
    ->add($sticky ? 'sticky bottom-0 bg-inherit' : '')
    ->add(match ($variant) {
        'elevated' => 'shadow-[0_-2px_8px_rgba(0,0,0,0.04)] dark:shadow-[0_-2px_8px_rgba(0,0,0,0.2)]',
        default => '',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-sidebar-footer>
    {{-- User profile section --}}
    @if ($user || $avatar || $hasUserSlot || $hasAvatarSlot)
        <div class="flex items-center gap-3">
            {{-- Avatar --}}
            @if ($hasAvatarSlot)
                <div class="size-8 shrink-0">{{ $slot->avatar }}</div>
            @elseif ($avatar)
                <img class="size-8 rounded-full shrink-0" src="{{ $avatar }}" alt="{{ $user ?? '' }}" />
            @endif

            {{-- User info --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">{{ $user ?? $slot->user ?? '' }}</p>
                @if ($email)
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $email }}</p>
                @endif
            </div>

            {{-- Actions --}}
            @if ($actions)
                <div class="flex items-center gap-1 shrink-0">
                    @if ($hasActionsSlot)
                        {{ $slot->actions }}
                    @else
                        <gsmui:button variant="subtle" size="xs" square aria-label="{{ __('Settings') }}">
                            <gsmui:icon name="cog" variant="mini" class="size-4" />
                        </gsmui:button>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
