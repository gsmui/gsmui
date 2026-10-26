@props([
    'item' => [],
    'showIcons' => true,
    'level' => 0,
])

<?php
$item = $item ?? [];
$id = $item['id'] ?? '';
$label = $item['label'] ?? '';
$icon = $item['icon'] ?? null;
$href = $item['href'] ?? null;
$disabled = $item['disabled'] ?? false;
$children = $item['children'] ?? [];
$badge = $item['badge'] ?? null;
$badgeColor = $item['badgeColor'] ?? 'default';
$selected = $item['selected'] ?? false;
$hasChildren = count($children) > 0;
$indent = $level * 1.5; // rem
?>

@if($href)
    <a 
        href="{{ $href }}"
        class="tree-item {{ $disabled ? 'disabled' : '' }} {{ $selected ? 'selected' : '' }}"
        style="--indent: {{ $indent }}rem;"
        role="treeitem"
        aria-expanded="{{ $hasChildren ? 'true' : 'false' }}"
        aria-selected="{{ $selected ? 'true' : 'false' }}"
        aria-disabled="{{ $disabled ? 'true' : 'false' }}"
        tabindex="{{ $selected ? '0' : '-1' }}"
        @click.prevent="$dispatch('tree:select', { id: '{$id}', item: @js($item) })"
        x-on:keydown="handleKeydown($event, @js($item))"
    >
        @if($showIcons && $icon)
            <x-gsmui:icon :name="$icon" class="tree-icon" aria-hidden="true" />
        @else
            <span class="tree-icon" aria-hidden="true"></span>
        @endif
        
        <span class="tree-label">{{ $label }}</span>
        
        @if($badge)
            <x-gsmui:badge :variant="$badgeColor" size="xs">{{ $badge }}</x-gsmui:badge>
        @endif
        
        @if($hasChildren)
            <x-gsmui:icon name="chevron-right" class="tree-chevron {{ $expanded ? 'expanded' : '' }}" aria-hidden="true" />
        @endif
    </a>
@else
    <button 
        type="button"
        class="tree-item w-full text-left {{ $disabled ? 'disabled' : '' }} {{ $selected ? 'selected' : '' }}"
        style="--indent: {{ $indent }}rem;"
        role="treeitem"
        aria-expanded="{{ $hasChildren ? 'true' : 'false' }}"
        aria-selected="{{ $selected ? 'true' : 'false' }}"
        aria-disabled="{{ $disabled ? 'true' : 'false' }}"
        tabindex="{{ $selected ? '0' : '-1' }}"
        @click="$dispatch('tree:toggle', { id: '{$id}', item: @js($item) })"
        x-on:keydown="handleKeydown($event, @js($item))"
    >
        @if($showIcons && $icon)
            <x-gsmui:icon :name="$icon" class="tree-icon" aria-hidden="true" />
        @else
            <span class="tree-icon" aria-hidden="true"></span>
        @endif
        
        <span class="tree-label">{{ $label }}</span>
        
        @if($badge)
            <x-gsmui:badge :variant="$badgeColor" size="xs">{{ $badge }}</x-gsmui:badge>
        @endif
        
        @if($hasChildren)
            <x-gsmui:icon name="chevron-right" class="tree-chevron {{ $expanded ? 'expanded' : '' }}" aria-hidden="true" />
        @endif
    </button>
@endif

@if($hasChildren)
    <div 
        class="tree-children"
        role="group"
        x-show="expanded.includes('{{ $id }}')"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform -translate-y-1"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-1"
        :hidden="!expanded.includes('{{ $id }}')"
    >
        <template x-for="child in @js($children)" :key="child.id">
            <x-gsmui:tree.item :item="child" :show-icons="true" :level="{{ $level + 1 }}" />
        </template>
    </div>
@endif