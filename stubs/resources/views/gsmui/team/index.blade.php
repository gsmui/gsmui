@blaze(fold: true)

@props([
    'style' => 'horizontal',
    'name' => null,
    'description' => null,
    'members' => [],
    'memberCount' => null,
    'category' => null,
    'cover' => null,
    'href' => null,
    'actionLabel' => null,
    'actionHref' => null,
    'maxAvatars' => 4,
    'leads' => null,
    'active' => null,
])

@php
$isLink = $href && !$attributes->has('as');
$tag = $attributes->has('as') ? $attributes->get('as') : ($isLink ? 'a' : 'div');

$count = $memberCount ?? count($members);

$visibleMembers = array_slice($members, 0, $maxAvatars);
$overflowCount = $count - count($visibleMembers);

$classes = Gsmui::classes()
    ->add('rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-sm')
    ->add($style === 'overlay' ? 'relative overflow-hidden' : '')
    ->add($style === 'featured' ? 'ring-2 ring-blue-500/30 dark:ring-blue-400/20' : '')
    ->add($style === 'minimal' ? 'shadow-none border-transparent dark:border-transparent bg-zinc-50 dark:bg-zinc-800/50' : '');
@endphp

<{{ $tag }}
    @if ($isLink) href="{{ $href }}" aria-label="{{ $name }}" @endif
    {{ $attributes->class($classes) }}
    data-gsmui-team
    data-gsmui-team-style="{{ $style }}"
>
    @switch($style)
        @case('minimal')
            <div class="flex items-center gap-3 p-3">
                <div class="flex -space-x-2">
                    @foreach($visibleMembers as $member)
                        <gsmui:avatar
                            :src="$member['src'] ?? null"
                            :name="$member['name'] ?? null"
                            :initials="$member['initials'] ?? null"
                            :color="$member['color'] ?? null"
                            size="sm"
                        />
                    @endforeach
                    @if($overflowCount > 0)
                        <gsmui:avatar color="zinc" size="sm">+{{ $overflowCount }}</gsmui:avatar>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $name }}</div>
                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $count }} {{ __('members') }}</div>
                </div>
            </div>
            @break

        @case('horizontal')
            <div class="flex items-center gap-4 p-4">
                <div class="flex -space-x-2 shrink-0">
                    @foreach($visibleMembers as $member)
                        <gsmui:avatar
                            :src="$member['src'] ?? null"
                            :name="$member['name'] ?? null"
                            :initials="$member['initials'] ?? null"
                            :color="$member['color'] ?? null"
                            size="md"
                        />
                    @endforeach
                    @if($overflowCount > 0)
                        <gsmui:avatar color="zinc" size="md">+{{ $overflowCount }}</gsmui:avatar>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $name }}</div>
                    @if($description)
                        <div class="text-sm text-zinc-500 dark:text-zinc-400 truncate">{{ $description }}</div>
                    @endif
                </div>
                @if($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" variant="outline" size="sm" class="shrink-0">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
            @break

        @case('vertical')
            <div class="flex flex-col items-center p-5 text-center">
                <div class="flex -space-x-2 mb-3">
                    @foreach($visibleMembers as $member)
                        <gsmui:avatar
                            :src="$member['src'] ?? null"
                            :name="$member['name'] ?? null"
                            :initials="$member['initials'] ?? null"
                            :color="$member['color'] ?? null"
                            size="md"
                        />
                    @endforeach
                    @if($overflowCount > 0)
                        <gsmui:avatar color="zinc" size="md">+{{ $overflowCount }}</gsmui:avatar>
                    @endif
                </div>
                <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $name }}</div>
                @if($description)
                    <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2">{{ $description }}</div>
                @endif
                <div class="flex items-center gap-3 mt-4">
                    @if($actionLabel && $actionHref)
                        <gsmui:button :href="$actionHref" size="sm">{{ $actionLabel }}</gsmui:button>
                    @endif
                    <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ $count }} {{ __('members') }}</span>
                </div>
            </div>
            @break

        @case('compact')
            <div class="flex items-center gap-2 px-3 py-2">
                <div class="flex -space-x-1.5 shrink-0">
                    @foreach($visibleMembers as $member)
                        <gsmui:avatar
                            :src="$member['src'] ?? null"
                            :name="$member['name'] ?? null"
                            :initials="$member['initials'] ?? null"
                            :color="$member['color'] ?? null"
                            size="xs"
                        />
                    @endforeach
                    @if($overflowCount > 0)
                        <gsmui:avatar color="zinc" size="xs">+{{ $overflowCount }}</gsmui:avatar>
                    @endif
                </div>
                <span class="text-sm text-zinc-600 dark:text-zinc-400 truncate">{{ $name }}</span>
                <span class="text-xs text-zinc-400 dark:text-zinc-500 shrink-0">{{ $count }} {{ __('members') }}</span>
            </div>
            @break

        @case('cover')
            @if($cover)
                <img class="w-full h-24 object-cover" src="{{ $cover }}" alt="" />
            @else
                <div class="w-full h-24 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
            @endif
            <div class="flex flex-col items-center -mt-6 relative z-10 px-4 pb-4">
                <div class="flex -space-x-2 mb-2">
                    @foreach($visibleMembers as $member)
                        <gsmui:avatar
                            :src="$member['src'] ?? null"
                            :name="$member['name'] ?? null"
                            :initials="$member['initials'] ?? null"
                            :color="$member['color'] ?? null"
                            size="md"
                        />
                    @endforeach
                    @if($overflowCount > 0)
                        <gsmui:avatar color="zinc" size="md">+{{ $overflowCount }}</gsmui:avatar>
                    @endif
                </div>
                <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $name }}</div>
                @if($category)
                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $category }}</div>
                @endif
                @if($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" size="sm" class="mt-3">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
            @break

        @case('featured')
            <div class="p-5">
                <div class="flex items-start gap-4">
                    <div class="flex -space-x-2 shrink-0">
                        @foreach($visibleMembers as $member)
                            <gsmui:avatar
                                :src="$member['src'] ?? null"
                                :name="$member['name'] ?? null"
                                :initials="$member['initials'] ?? null"
                                :color="$member['color'] ?? null"
                                size="md"
                            />
                        @endforeach
                        @if($overflowCount > 0)
                            <gsmui:avatar color="zinc" size="md">+{{ $overflowCount }}</gsmui:avatar>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $name }}</div>
                        @if($description)
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2">{{ $description }}</div>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3 mt-4">
                    <div class="text-center p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                        <div class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 tabular-nums">{{ $count }}</div>
                        <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('members') }}</div>
                    </div>
                    @if($leads !== null)
                        <div class="text-center p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <div class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 tabular-nums">{{ $leads }}</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('leads') }}</div>
                        </div>
                    @endif
                    @if($active !== null)
                        <div class="text-center p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <div class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 tabular-nums">{{ $active }}</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('active') }}</div>
                        </div>
                    @endif
                </div>
                @if($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" variant="primary" class="w-full mt-4">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
            @break

        @case('stats')
            <div class="p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex -space-x-2 shrink-0">
                        @foreach($visibleMembers as $member)
                            <gsmui:avatar
                                :src="$member['src'] ?? null"
                                :name="$member['name'] ?? null"
                                :initials="$member['initials'] ?? null"
                                :color="$member['color'] ?? null"
                                size="sm"
                            />
                        @endforeach
                        @if($overflowCount > 0)
                            <gsmui:avatar color="zinc" size="sm">+{{ $overflowCount }}</gsmui:avatar>
                        @endif
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $name }}</div>
                        @if($category)
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $category }}</div>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <gsmui:stat label="{{ __('members') }}" :value="$count" size="sm" />
                    @if($leads !== null)
                        <gsmui:stat label="{{ __('leads') }}" :value="$leads" size="sm" />
                    @endif
                    @if($active !== null)
                        <gsmui:stat label="{{ __('active') }}" :value="$active" changeType="positive" size="sm" />
                    @endif
                </div>
            </div>
            @break

        @case('list')
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="flex -space-x-2 shrink-0">
                    @foreach($visibleMembers as $member)
                        <gsmui:avatar
                            :src="$member['src'] ?? null"
                            :name="$member['name'] ?? null"
                            :initials="$member['initials'] ?? null"
                            :color="$member['color'] ?? null"
                            size="sm"
                        />
                    @endforeach
                    @if($overflowCount > 0)
                        <gsmui:avatar color="zinc" size="sm">+{{ $overflowCount }}</gsmui:avatar>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $name }}</div>
                    @if($category)
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $category }}</div>
                    @endif
                </div>
                <gsmui:icon.chevron-right variant="micro" class="shrink-0 text-zinc-400" />
            </div>
            @break

        @case('grid')
            <div class="p-4">
                <div class="grid grid-cols-2 gap-1.5 mb-3">
                    @foreach($visibleMembers as $member)
                        <gsmui:avatar
                            :src="$member['src'] ?? null"
                            :name="$member['name'] ?? null"
                            :initials="$member['initials'] ?? null"
                            :color="$member['color'] ?? null"
                            size="lg"
                        />
                    @endforeach
                    @if($overflowCount > 0)
                        <div class="flex items-center justify-center size-12 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-xs font-medium text-zinc-600 dark:text-zinc-400">+{{ $overflowCount }}</div>
                    @endif
                </div>
                <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $name }}</div>
                @if($description)
                    <div class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $description }}</div>
                @endif
            </div>
            @break

        @case('overlay')
            @if($cover)
                <img class="absolute inset-0 w-full h-full object-cover" src="{{ $cover }}" alt="" />
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-zinc-700 to-zinc-900"></div>
            @endif
            <div class="relative z-10 p-5 flex flex-col h-full min-h-[120px]">
                @if($category)
                    <div class="text-xs font-medium text-white/70 mb-1">{{ $category }}</div>
                @endif
                <div class="text-lg font-semibold text-white">{{ $name }}</div>
                <div class="text-sm text-white/70 mt-1">{{ $count }} {{ __('members') }}</div>
                @if($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" variant="primary" size="sm" class="mt-auto self-start">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
            @break

        @default
            <div class="flex items-center gap-4 p-4">
                <div class="flex -space-x-2 shrink-0">
                    @foreach($visibleMembers as $member)
                        <gsmui:avatar
                            :src="$member['src'] ?? null"
                            :name="$member['name'] ?? null"
                            :initials="$member['initials'] ?? null"
                            :color="$member['color'] ?? null"
                            size="md"
                        />
                    @endforeach
                    @if($overflowCount > 0)
                        <gsmui:avatar color="zinc" size="md">+{{ $overflowCount }}</gsmui:avatar>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $name }}</div>
                    @if($description)
                        <div class="text-sm text-zinc-500 dark:text-zinc-400 truncate">{{ $description }}</div>
                    @endif
                </div>
                @if($actionLabel && $actionHref)
                    <gsmui:button :href="$actionHref" variant="outline" size="sm" class="shrink-0">{{ $actionLabel }}</gsmui:button>
                @endif
            </div>
    @endswitch
</{{ $tag }}>
