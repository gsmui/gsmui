@props([
    'items' => [],
    'expanded' => [],
    'selected' => null,
    'multiple' => false,
    'showIcons' => true,
    'lazy' => false,
    'class' => '',
])

<?php
$expanded = is_array($expanded) ? $expanded : (array)$expanded;
$expandedIds = collect($expanded)->pluck('id')->toArray();
?>

<div 
    class="gsmui-tree {{ $class }}"
    role="tree"
    aria-label="Navigation tree"
    x-data="gsmuiTree({ 
        expanded: @js($expandedIds), 
        selected: @js($selected), 
        multiple: @js($multiple),
        lazy: @js($lazy)
    })"
>
    @foreach ($items as $item)
        <x-gsmui:tree.item :item="$item" :show-icons="$showIcons" :level="0" />
    @endforeach
</div>

<script>
function gsmuiTree({ expanded = [], selected = null, multiple = false, lazy = false }) {
    return {
        expanded,
        selected,
        multiple,
        lazy,
        
        toggle(item) {
            if (item.disabled) return;
            
            if (item.children && item.children.length > 0) {
                this.expanded = this.expanded.includes(item.id) 
                    ? this.expanded.filter(id => id !== item.id)
                    : [...this.expanded, item.id];
                    
                if (this.lazy && !item.loaded) {
                    this.$dispatch('tree:load-children', { itemId: item.id });
                }
            } else {
                this.select(item);
            }
        },
        
        select(item) {
            if (item.disabled) return;
            
            if (this.multiple) {
                this.selected = this.selected.includes(item.id)
                    ? this.selected.filter(id => id !== item.id)
                    : [...this.selected, item.id];
            } else {
                this.selected = item.id;
            }
            
            this.$dispatch('tree:select', { id: item.id, item });
        },
        
        isExpanded(item) {
            return this.expanded.includes(item.id);
        },
        
        isSelected(item) {
            return Array.isArray(this.selected) 
                ? this.selected.includes(item.id)
                : this.selected === item.id;
        },
        
        handleKeydown(event, item) {
            switch(event.key) {
                case 'ArrowRight':
                    event.preventDefault();
                    if (item.children?.length && !this.isExpanded(item)) {
                        this.toggle(item);
                    }
                    break;
                case 'ArrowLeft':
                    event.preventDefault();
                    if (item.children?.length && this.isExpanded(item)) {
                        this.toggle(item);
                    } else if (item.parentId) {
                        // Focus parent
                        this.$dispatch('tree:focus-parent', { parentId: item.parentId });
                    }
                    break;
                case 'ArrowDown':
                    event.preventDefault();
                    this.$dispatch('tree:focus-next', { currentId: item.id });
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    this.$dispatch('tree:focus-prev', { currentId: item.id });
                    break;
                case 'Home':
                    event.preventDefault();
                    this.$dispatch('tree:focus-first');
                    break;
                case 'End':
                    event.preventDefault();
                    this.$dispatch('tree:focus-last');
                    break;
                case 'Enter':
                case ' ':
                    event.preventDefault();
                    this.select(item);
                    break;
            }
        }
    }
}
</script>

<style>
.gsmui-tree {
    @apply text-sm;
}

.gsmui-tree .tree-item {
    @apply flex items-center gap-2 py-1.5 px-2 rounded-lg;
    @apply hover:bg-zinc-100 dark:hover:bg-zinc-800;
    @apply focus:outline-none focus-visible:ring-2 focus-visible:ring-primary;
    @apply transition-colors duration-150;
    @apply cursor-pointer select-none;
}

.gsmui-tree .tree-item.disabled {
    @apply opacity-50 cursor-not-allowed;
}

.gsmui-tree .tree-item.selected {
    @apply bg-primary/10 text-primary dark:bg-primary/20;
}

.gsmui-tree .tree-item .tree-icon {
    @apply w-5 h-5 flex-shrink-0;
}

.gsmui-tree .tree-item .tree-label {
    @apply flex-1 truncate;
}

.gsmui-tree .tree-item .tree-chevron {
    @apply w-4 h-4 flex-shrink-0 text-zinc-400 transition-transform duration-150;
}

.gsmui-tree .tree-item .tree-chevron.expanded {
    @apply rotate-90;
}

.gsmui-tree .tree-children {
    @apply pl-6 border-l border-zinc-200 dark:border-zinc-700;
    @apply animate-in fade-in slide-in-from-top-2 duration-150;
}

.gsmui-tree .tree-children[hidden] {
    display: none;
}

.gsmui-tree .tree-loading {
    @apply flex items-center gap-2 py-2 px-2 text-zinc-500 text-xs;
}
</style>