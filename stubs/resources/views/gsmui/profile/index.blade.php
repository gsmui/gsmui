@blaze(fold: true)

@props([
    'name' => null,
    'avatar' => null,
    'avatarName' => null,
    'avatarColor' => null,
    'avatarSize' => 'sm',
    'circle' => false,
    'initials' => null,
    'chevron' => true,
    'iconTrailing' => null,
    'iconVariant' => 'micro',
])

@php
$classes = Gsmui::classes()
    ->add('inline-flex items-center gap-3 rounded-lg px-3 py-2 transition-colors duration-150')
    ->add('text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-white/10 cursor-pointer')
    ;
@endphp

<button type="button" {{ $attributes->class($classes) }} data-gsmui-profile>
    <gsmui:avatar
        :src="$avatar"
        :name="$avatarName ?? $name"
        :initials="$initials"
        :color="$avatarColor"
        :circle="$circle"
        :size="$avatarSize"
    />

    @if ($name)
        <span class="text-sm font-medium truncate max-w-[10rem]">{{ $name }}</span>
    @endif

    <span class="flex-1"></span>

    @if ($iconTrailing)
        <gsmui:icon :name="$iconTrailing" :variant="$iconVariant" class="shrink-0 text-zinc-400" />
    @elseif ($chevron)
        <gsmui:icon.chevron-down :variant="$iconVariant" class="shrink-0 text-zinc-400" />
    @endif
</button>
