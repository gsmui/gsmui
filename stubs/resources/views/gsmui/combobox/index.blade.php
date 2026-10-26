@props([
    'options' => [],
    'value' => null,
    'placeholder' => 'Search...',
    'searchable' => true,
    'clearable' => false,
    'allowCustom' => false,
    'maxSelected' => null,
    'multiple' => false,
    'loading' => false,
    'disabled' => false,
    'required' => false,
    'invalid' => false,
    'errorMessage' => null,
    'label' => null,
    'description' => null,
    'name' => null,
    'id' => null,
    'wireModel' => null,
    'size' => 'md',
    'variant' => 'outline',
    'optionValue' => 'value',
    'optionLabel' => 'label',
    'optionGroup' => 'children',
    'debounce' => 150,
    'minChars' => 0,
    'maxSuggestions' => 10,
])

<?php
$id = $id ?? 'combobox-' . uniqid();
$inputId = $id . '-input';
$listboxId = $id . '-listbox';
$selectedId = $id . '-selected';

$sizeClasses = match($size) {
    'xs' => 'h-8 px-2.5 text-xs',
    'sm' => 'h-9 px-3 text-sm',
    'md' => 'h-10 px-3.5 text-sm',
    'lg' => 'h-11 px-4 text-base',
    default => 'h-10 px-3.5 text-sm',
};

$variantClasses = match($variant) {
    'filled' => 'bg-zinc-100 dark:bg-zinc-800 border-transparent focus:bg-white dark:focus:bg-zinc-700',
    'underlined' => 'border-0 border-b-2 border-zinc-300 dark:border-zinc-600 rounded-none focus:border-primary focus:ring-0',
    'flushed' => 'border-0 bg-transparent focus:ring-0 focus:bg-zinc-100 dark:focus:bg-zinc-800',
    default => 'bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600',
};

$invalidClasses = $invalid ? 'border-red-500 focus:border-red-500 focus:ring-red-500/20' : '';
?>

<div class="w-full" data-gsmui-combobox>
    @if($label)
        <label 
            for="{{ $inputId }}"
            class="block text-sm font-medium text-zinc-900 dark:text-white mb-1.5"
        >
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <div class="relative" role="combobox" aria-haspopup="listbox" aria-expanded="false" aria-controls="{{ $listboxId }}" aria-labelledby="{{ $label ? $inputId . '-label' : '' }}">
        
        <div class="relative">
            <input
                type="text"
                id="{{ $inputId }}"
                name="{{ $name }}"
                value="{{ is_array($value) ? implode(', ', array_column((array)$value, $optionLabel)) : ($value[$optionLabel] ?? $value ?? '') }}"
                placeholder="{{ $placeholder }}"
                class="w-full {{ $sizeClasses }} {{ $variantClasses }} {{ $invalidClasses }} rounded-lg border shadow-xs transition-all duration-150
                    placeholder:text-zinc-400 dark:placeholder:text-zinc-500
                    disabled:opacity-50 disabled:cursor-not-allowed
                    focus:outline-none focus:ring-2 focus:ring-primary/20
                    pr-10"
                @if($disabled) disabled @endif
                @if($required) required @endif
                @if($wireModel) wire:model.debounce.{{ $debounce }}ms="{{ $wireModel }}" @endif
                autocomplete="off"
                autocorrect="off"
                autocapitalize="off"
                spellcheck="false"
                role="textbox"
                aria-autocomplete="list"
                aria-activedescendant=""
                x-ref="input"
                x-on:focus="open()"
                x-on:keydown.escape="close()"
                x-on:keydown.down="highlightNext()"
                x-on:keydown.up="highlightPrev()"
                x-on:keydown.enter="selectHighlighted()"
                x-on:keydown.tab="close()"
                x-on:blur.debounce.200="close()"
                x-on:input="filterOptions($event.target.value)"
            >

            @if($clearable && $value)
                <button
                    type="button"
                    class="absolute inset-y-0 right-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors"
                    x-on:click.prevent="clear()"
                    aria-label="Clear selection"
                >
                    <x-gsmui:icon name="x-mark" class="w-4 h-4" aria-hidden="true" />
                </button>
            @endif

            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <x-gsmui:icon name="chevron-down" class="w-4 h-4 text-zinc-400 transition-transform duration-150" :class="open ? 'rotate-180' : ''" aria-hidden="true" />
            </div>
        </div>

        <div
            id="{{ $listboxId }}"
            class="absolute z-50 w-full mt-1 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-lg max-h-60 overflow-auto hidden"
            role="listbox"
            aria-label="{{ $placeholder }}"
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 transform -translate-y-1"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-1"
            x-on:click.outside="close()"
            x-ref="listbox"
        >
            @if($searchable && $minChars > 0 && (($filteredOptions?.count() ?? 0) == 0) && $searchQuery.length < $minChars)
                <div class="px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                    Type at least {{ $minChars }} characters to search...
                </div>
            @elseif($loading)
                <div class="px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400 text-center flex items-center justify-center gap-2">
                    <x-gsmui:spinner size="sm" />
                    Loading...
                </div>
            @elseif(($filteredOptions?.count() ?? 0) > 0)
                <template x-for="option in filteredOptions" :key="option.{{ $optionValue }}">
                    <div
                        role="option"
                        class="px-3 py-2 text-sm cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-700 flex items-center gap-2
                            {{ option.selected ? 'bg-primary/10 text-primary dark:bg-primary/20' : 'text-zinc-900 dark:text-white' }}"
                        x-on:click="select(option)"
                        x-on:mouseenter="highlight(option)"
                        :aria-selected="option.selected"
                        :data-value="option.{{ $optionValue }}"
                    >
                        @if($multiple)
                            <x-gsmui:checkbox 
                                :checked="option.selected" 
                                class="shrink-0" 
                                :size="'sm'" 
                                aria-hidden="true"
                            />
                        @endif
                        <span class="flex-1 truncate">{{ option.{{ $optionLabel }} }}</span>
                        @if($multiple && option.selected)
                            <x-gsmui:icon name="check" class="w-4 h-4 text-primary shrink-0" aria-hidden="true" />
                        @endif
                    </div>
                </template>
            @else
                <div class="px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400 text-center">
                    @if($allowCustom && $searchQuery)
                        <button
                            type="button"
                            class="text-primary hover:underline"
                            x-on:click="createCustom($searchQuery)"
                        >
                            Create "{{ $searchQuery }}"
                        </button>
                    @else
                        No options found
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if($description)
        <p id="{{ $inputId }}-description" class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
    @endif

    @if($invalid && $errorMessage)
        <p id="{{ $inputId }}-error" class="mt-1.5 text-sm text-red-600 dark:text-red-400" role="alert">{{ $errorMessage }}</p>
    @endif

    @if($wireModel && $multiple)
        <input type="hidden" name="{{ $name }}_values" wire:model="{{ $wireModel }}" />
    @endif
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('combobox', () => ({
        open: false,
        searchQuery: '',
        highlightedIndex: -1,
        filteredOptions: @js($options),
        options: @js($options),
        value: @js($value),
        multiple: @js($multiple),
        allowCustom: @js($allowCustom),
        optionValue: '{{ $optionValue }}',
        optionLabel: '{{ $optionLabel }}',
        maxSelected: @js($maxSelected),
        debounce: @js($debounce),
        minChars: @js($minChars),
        maxSuggestions: @js($maxSuggestions),
        
        init() {
            this.filteredOptions = this.options;
            this.$watch('searchQuery', this.debouncedFilter);
        },
        
        debouncedFilter: _.debounce(function(value) {
            this.filterOptions(value);
        }, this.debounce),
        
        filterOptions(query) {
            this.searchQuery = query;
            this.highlightedIndex = -1;
            
            if (this.minChars && query.length < this.minChars) {
                this.filteredOptions = [];
                return;
            }
            
            const lowerQuery = query.toLowerCase();
            this.filteredOptions = this.options.filter(opt => 
                opt[this.optionLabel].toLowerCase().includes(lowerQuery)
            ).slice(0, this.maxSuggestions);
        },
        
        open() {
            if (!this.$refs.input.disabled) {
                this.open = true;
                this.highlightedIndex = -1;
                this.$nextTick(() => {
                    this.scrollToHighlighted();
                });
            }
        },
        
        close() {
            this.open = false;
            this.searchQuery = '';
            this.filteredOptions = this.options;
            this.highlightedIndex = -1;
        },
        
        select(option) {
            if (this.multiple) {
                const idx = this.value.findIndex(v => v[this.optionValue] === option[this.optionValue]);
                if (idx >= 0) {
                    this.value.splice(idx, 1);
                } else {
                    if (this.maxSelected && this.value.length >= this.maxSelected) return;
                    this.value.push(option);
                }
                option.selected = !option.selected;
            } else {
                this.value = option;
                this.options.forEach(o => o.selected = o[this.optionValue] === option[this.optionValue]);
                this.close();
            }
            this.$dispatch('input', this.value);
            this.$dispatch('change', this.value);
        },
        
        clear() {
            if (this.multiple) {
                this.value = [];
                this.options.forEach(o => o.selected = false);
            } else {
                this.value = null;
                this.options.forEach(o => o.selected = false);
            }
            this.$dispatch('input', this.value);
            this.$dispatch('change', this.value);
            this.$refs.input.focus();
        },
        
        createCustom(query) {
            const newOption = {
                [this.optionValue]: query,
                [this.optionLabel]: query,
                __custom: true
            };
            this.options.unshift(newOption);
            this.select(newOption);
        },
        
        highlightNext() {
            if (this.filteredOptions.length === 0) return;
            this.highlightedIndex = Math.min(this.highlightedIndex + 1, this.filteredOptions.length - 1);
            this.scrollToHighlighted();
        },
        
        highlightPrev() {
            if (this.filteredOptions.length === 0) return;
            this.highlightedIndex = Math.max(this.highlightedIndex - 1, 0);
            this.scrollToHighlighted();
        },
        
        highlight(option) {
            this.highlightedIndex = this.filteredOptions.findIndex(o => o[this.optionValue] === option[this.optionValue]);
        },
        
        selectHighlighted() {
            if (this.highlightedIndex >= 0 && this.highlightedIndex < this.filteredOptions.length) {
                this.select(this.filteredOptions[this.highlightedIndex]);
            } else if (this.allowCustom && this.searchQuery) {
                this.createCustom(this.searchQuery);
            }
        },
        
        scrollToHighlighted() {
            const optionEl = this.$refs.listbox?.querySelector('[role="option"]:nth-child(' + (this.highlightedIndex + 1) + ')');
            if (optionEl) {
                optionEl.scrollIntoView({ block: 'nearest' });
            }
        },
        
        handleKeydown(e) {
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    this.highlightNext();
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    this.highlightPrev();
                    break;
                case 'Enter':
                    e.preventDefault();
                    this.selectHighlighted();
                    break;
                case 'Escape':
                    this.close();
                    break;
            }
        }
    }));
});
</script>

@push('gsmui-styles')
<style>
[data-gsmui-combobox] [role="listbox"] {
    scrollbar-width: thin;
    scrollbar-color: var(--gsmui-border-primary) transparent;
}

[data-gsmui-combobox] [role="listbox"]::-webkit-scrollbar {
    width: 6px;
}

[data-gsmui-combobox] [role="listbox"]::-webkit-scrollbar-track {
    background: transparent;
}

[data-gsmui-combobox] [role="listbox"]::-webkit-scrollbar-thumb {
    background-color: var(--gsmui-border-primary);
    border-radius: 3px;
    border: 2px solid transparent;
    background-clip: content-box;
}
</style>
@endpush