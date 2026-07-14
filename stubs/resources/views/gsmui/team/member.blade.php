@blaze(fold: true)

@props([
    'name' => null,
    'role' => null,
    'avatar' => null,
    'initials' => null,
    'color' => null,
    'circle' => true,
    'bio' => null,
    'status' => null,
    'href' => null,
    'actionLabel' => null,
    'actionHref' => null,
])

@php
$isLink = $href && !$attributes->has('as');
$tag = $attributes->has('as') ? $attributes->get('as') : ($isLink ? 'a' : 'div');

$badgeColor = match ($status) {
    'online' => 'green',
    'away' => 'amber',
    'offline' => 'zinc',
    default => null,
};

$classes = Gsmui::classes()
    ->add('rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-sm');
@endphp

<{{ $tag }}
    @if ($isLink) href="{{ $href }}" aria-label="{{ $name }}" @endif
    {{ $attributes->class($classes) }}
    data-gsmui-member
>
    <div class="flex items-center gap-4 p-4">
        <div class="shrink-0">
            <gsmui:avatar
                :src="$avatar"
                :name="$name"
                :initials="$initials"
                :color="$color"
                :circle="$circle"
                size="lg"
                :badge="$status ? '●' : null"
                :badgeColor="$badgeColor"
                :badgeCircle="true"
            />
        </div>
        <div class="flex-1 min-w-0">
            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $name }}</div>
            @if($role)
                <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $role }}</div>
            @endif
            @if($bio)
                <div class="text-sm text-zinc-400 dark:text-zinc-500 mt-1 line-clamp-2">{{ $bio }}</div>
            @endif
        </div>
        @if($actionLabel && $actionHref)
            <gsmui:button :href="$actionHref" variant="outline" size="sm" class="shrink-0">{{ $actionLabel }}</gsmui:button>
        @endif
    </div>
</{{ $tag }}>
