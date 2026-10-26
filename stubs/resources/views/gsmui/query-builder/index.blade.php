@props([
    'fields' => [],
    'value' => null,
    'wireModel' => null,
    'combinators' => ['and', 'or'],
    'defaultCombinator' => 'and',
    'allowGroups' => true,
    'maxDepth' => 3,
    'valueSources' => ['value', 'field'],
    'class' => '',
])

<?php
$id = 'query-builder-' . uniqid();
?>

<div 
    class="gsmui-query-builder {{ $class }}"
    x-data="gsmuiQueryBuilder({
        fields: @js($fields),
        value: @js($value),
        combinators: @js($combinators),
        defaultCombinator: '{{ $defaultCombinator }}',
        allowGroups: @js($allowGroups),
        maxDepth: @js($maxDepth),
        valueSources: @js($valueSources),
        wireModel: '{{ $wireModel }}'
    })"
    id="{{ $id }}"
>

    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        
        <!-- Toolbar -->
        <div class="p-3 border-b border-zinc-200 dark:border-zinc-700 flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Combinator:</span>
                <select 
                    x-model="root.combinator"
                    @change="updateCombinator($event.target.value)"
                    class="px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary"
                >
                    <template x-for="c in combinators" :key="c">
                        <option :value="c" x-text="c.toUpperCase()"></option>
                    </template>
                </select>
            </div>
            
            <div class="flex-1"></div>
            
            <div class="flex items-center gap-2">
                <button 
                    type="button"
                    @click="addRule(root)"
                    class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                >
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Rule
                </button>
                
                <template x-if="allowGroups">
                    <button 
                        type="button"
                        @click="addGroup(root)"
                        class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                    >
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Group
                    </button>
                </template>
                
                <button 
                    type="button"
                    @click="exportQuery()"
                    class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                >
                    Export JSON
                </button>
            </div>
        </div>
        
        <!-- Query Tree -->
        <div class="p-3">
            <template x-if="root">
                <div x-data="{ node: root, depth: 0 }" x-init="renderNode(node, depth)">
                    <template x-if="node.type === 'group'">
                        <div class="qb-group" :class="{ 'qb-group-root': depth === 0 }" :style="{ marginLeft: depth > 0 ? (depth * 24) + 'px' : '0' }">
                            <div class="qb-group-header flex items-center gap-2 mb-2">
                                <div class="qb-group-combinator flex items-center gap-1">
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Combinator:</span>
                                    <select 
                                        x-model="node.combinator"
                                        @change="updateCombinator(node, $event.target.value)"
                                        class="px-2 py-1 text-xs border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary"
                                    >
                                        <template x-for="c in combinators" :key="c">
                                            <option :value="c" x-text="c.toUpperCase()"></option>
                                        </template>
                                    </select>
                                </div>
                                
                                <template x-if="depth > 0">
                                    <button 
                                        type="button"
                                        @click="removeGroup(node)"
                                        class="ml-auto px-2 py-1 text-xs text-red-600 hover:text-red-700 dark:hover:text-red-400 transition-colors"
                                    >
                                        Remove Group
                                    </button>
                                </template>
                            </div>
                            
                            <div class="qb-group-rules space-y-2 pl-4 border-l border-zinc-200 dark:border-zinc-700">
                                <template x-for="(rule, index) in node.rules" :key="rule.id">
                                    <div x-data="{ rule: rule, ruleIndex: index }" x-init="renderRule(rule, node, ruleIndex)">
                                        <!-- Rule rendered by renderRule -->
                                    </div>
                                </template>
                            </div>
                            
                            <div class="qb-group-actions mt-2 flex gap-2">
                                <button 
                                    type="button"
                                    @click="addRule(node)"
                                    class="px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                                >
                                    + Add Rule
                                </button>
                                <template x-if="allowGroups && depth < maxDepth">
                                    <button 
                                        type="button"
                                        @click="addGroup(node)"
                                        class="px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                                    >
                                        + Add Group
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
            
            <template x-if="!root">
                <div class="text-center py-12 text-zinc-500 dark:text-zinc-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <p>No rules defined. Click "Add Rule" to start building your query.</p>
                </div>
            </template>
        </div>
        
        <!-- JSON Output (collapsible) -->
        <div class="border-t border-zinc-200 dark:border-zinc-700 p-3 bg-zinc-50 dark:bg-zinc-900/50">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Generated Query</span>
                <button 
                    type="button"
                    @click="showJson = !showJson"
                    class="text-xs text-primary hover:underline"
                >
                    <span x-text="showJson ? 'Hide' : 'Show'"></span> JSON
                </button>
            </div>
            
            <template x-if="showJson">
                <pre class="bg-zinc-100 dark:bg-zinc-900 p-3 rounded text-xs overflow-auto max-h-64"><code x-text="JSON.stringify(getQuery(), null, 2)"></code></pre>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiQueryBuilder', (config) => ({
        fields: config.fields,
        combinators: config.combinators,
        defaultCombinator: config.defaultCombinator,
        allowGroups: config.allowGroups,
        maxDepth: config.maxDepth,
        valueSources: config.valueSources,
        wireModel: config.wireModel,
        
        root: null,
        showJson: false,
        ruleIdCounter: 0,
        groupIdCounter: 0,
        
        operators: {
            string: ['=', '!=', 'contains', 'not_contains', 'starts_with', 'ends_with', 'in', 'not_in', 'is_null', 'is_not_null', 'is_empty', 'is_not_empty'],
            number: ['=', '!=', '>', '>=', '<', '<=', 'between', 'not_between', 'is_null', 'is_not_null'],
            boolean: ['=', '!=', 'is_null', 'is_not_null'],
            date: ['=', '!=', '>', '>=', '<', '<=', 'between', 'not_between', 'is_null', 'is_not_null', 'today', 'this_week', 'this_month', 'this_year'],
            datetime: ['=', '!=', '>', '>=', '<', '<=', 'between', 'not_between', 'is_null', 'is_not_null'],
            select: ['=', '!=', 'in', 'not_in', 'is_null', 'is_not_null'],
            multiselect: ['contains', 'not_contains', 'in', 'not_in'],
        },
        
        init() {
            this.root = this.createGroup(this.defaultCombinator);
            if (this.value) {
                this.loadQuery(this.value);
            }
            this.$watch('root', () => this.emitQuery(), { deep: true });
        },
        
        createGroup(combinator = null) {
            return {
                id: 'grp-' + (++this.groupIdCounter),
                type: 'group',
                combinator: combinator || this.defaultCombinator,
                rules: [],
                parent: null
            };
        },
        
        createRule() {
            const field = this.fields[0];
            return {
                id: 'rule-' + (++this.ruleIdCounter),
                type: 'rule',
                field: field ? field.name : '',
                operator: field ? this.getDefaultOperator(field.type) : '=',
                value: '',
                valueSource: 'value',
                parent: null
            };
        },
        
        getDefaultOperator(type) {
            const ops = this.operators[type] || this.operators.string;
            return ops[0];
        },
        
        getField(name) {
            return this.fields.find(f => f.name === name);
        },
        
        getOperatorsForField(fieldName) {
            const field = this.getField(fieldName);
            if (!field) return this.operators.string;
            return this.operators[field.type] || this.operators.string;
        },
        
        renderNode(node, depth) {
            if (node.type === 'group') {
                // Group is rendered by template
                node.rules.forEach((rule, index) => {
                    this.renderRule(rule, node, index);
                });
            }
        },
        
        renderRule(rule, parent, index) {
            const field = this.getField(rule.field);
            const operators = field ? this.getOperatorsForField(rule.field) : this.operators.string;
            
            const ruleEl = document.createElement('div');
            ruleEl.className = 'qb-rule flex items-center gap-2 flex-wrap';
            ruleEl.innerHTML = `
                <button type="button" class="qb-rule-delete p-1 text-zinc-400 hover:text-red-500 transition-colors" title="Remove rule">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                
                <select class="qb-rule-field px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary min-w-[150px]">
                    <option value="">-- Select Field --</option>
                    <template x-for="f in $root.fields" :key="f.name">
                        <option :value="f.name" :selected="f.name === rule.field" x-text="f.label"></option>
                    </template>
                </select>
                
                <select class="qb-rule-operator px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary min-w-[130px]">
                    <template x-for="op in operators" :key="op">
                        <option :value="op" :selected="op === rule.operator" x-text="operatorLabel(op)"></option>
                    </template>
                </select>
                
                <div class="qb-rule-value flex-1 min-w-[150px] flex items-center gap-1">
                    <select class="qb-rule-value-source px-2 py-1 text-xs border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" x-show="valueSources.length > 1">
                        <template x-for="vs in $root.valueSources" :key="vs">
                            <option :value="vs" :selected="vs === rule.valueSource" x-text="vs === 'value' ? 'Value' : 'Field'"></option>
                        </template>
                    </select>
                    
                    <template x-if="rule.valueSource === 'value'">
                        <input 
                            type="text" 
                            class="qb-rule-value-input flex-1 px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary"
                            :value="rule.value"
                            @input="updateRuleValue(rule, $event.target.value)"
                            @keydown.enter.prevent
                            placeholder="Enter value..."
                        />
                    </template>
                    
                    <template x-if="rule.valueSource === 'field'">
                        <select class="qb-rule-value-field flex-1 px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary">
                            <option value="">-- Select Field --</option>
                            <template x-for="f in $root.fields" :key="f.name">
                                <option :value="f.name" :selected="f.name === rule.value" x-text="f.label"></option>
                            </template>
                        </select>
                    </template>
                </div>
            `;
            
            // Attach event listeners
            ruleEl.querySelector('.qb-rule-delete').addEventListener('click', () => this.removeRule(parent, rule));
            ruleEl.querySelector('.qb-rule-field').addEventListener('change', (e) => this.updateRuleField(rule, parent, e.target.value));
            ruleEl.querySelector('.qb-rule-operator').addEventListener('change', (e) => this.updateRuleOperator(rule, e.target.value));
            
            const valueSourceSelect = ruleEl.querySelector('.qb-rule-value-source');
            if (valueSourceSelect) {
                valueSourceSelect.addEventListener('change', (e) => this.updateRuleValueSource(rule, e.target.value));
            }
            
            const valueFieldSelect = ruleEl.querySelector('.qb-rule-value-field');
            if (valueFieldSelect) {
                valueFieldSelect.addEventListener('change', (e) => this.updateRuleValue(rule, e.target.value));
            }
            
            // Replace the template element
            const template = parent.querySelector(`[x-data*="ruleIndex: ${index}"]`);
            if (template) {
                template.parentNode.replaceChild(ruleEl, template);
            }
        },
        
        operatorLabel(op) {
            const labels = {
                '=': 'Equals',
                '!=': 'Not Equals',
                'contains': 'Contains',
                'not_contains': 'Not Contains',
                'starts_with': 'Starts With',
                'ends_with': 'Ends With',
                'in': 'In',
                'not_in': 'Not In',
                'is_null': 'Is Null',
                'is_not_null': 'Is Not Null',
                'is_empty': 'Is Empty',
                'is_not_empty': 'Is Not Empty',
                '>': 'Greater Than',
                '>=': 'Greater Than Or Equal',
                '<': 'Less Than',
                '<=': 'Less Than Or Equal',
                'between': 'Between',
                'not_between': 'Not Between',
                'today': 'Today',
                'this_week': 'This Week',
                'this_month': 'This Month',
                'this_year': 'This Year',
            };
            return labels[op] || op;
        },
        
        addRule(group) {
            if (!group.rules) group.rules = [];
            const rule = this.createRule();
            rule.parent = group;
            group.rules.push(rule);
            this.$nextTick(() => {
                this.renderRule(rule, group, group.rules.length - 1);
            });
        },
        
        addGroup(parentGroup) {
            const group = this.createGroup(this.defaultCombinator);
            group.parent = parentGroup;
            if (!parentGroup.rules) parentGroup.rules = [];
            parentGroup.rules.push(group);
            // Group will be rendered by template
        },
        
        removeRule(group, rule) {
            group.rules = group.rules.filter(r => r.id !== rule.id);
        },
        
        removeGroup(group) {
            if (group.parent) {
                group.parent.rules = group.parent.rules.filter(r => r.id !== group.id);
            }
        },
        
        updateCombinator(group, combinator) {
            group.combinator = combinator;
        },
        
        updateRuleField(rule, parent, fieldName) {
            rule.field = fieldName;
            const field = this.getField(fieldName);
            rule.operator = this.getDefaultOperator(field?.type);
            rule.value = '';
            
            // Re-render rule
            const index = parent.rules.indexOf(rule);
            this.$nextTick(() => this.renderRule(rule, parent, index));
        },
        
        updateRuleOperator(rule, operator) {
            rule.operator = operator;
            // Clear value for null/empty operators
            if (['is_null', 'is_not_null', 'is_empty', 'is_not_empty', 'today', 'this_week', 'this_month', 'this_year'].includes(operator)) {
                rule.value = '';
            }
        },
        
        updateRuleValueSource(rule, source) {
            rule.valueSource = source;
            rule.value = '';
        },
        
        updateRuleValue(rule, value) {
            rule.value = value;
        },
        
        getQuery() {
            if (!this.root) return null;
            return this.serializeGroup(this.root);
        },
        
        serializeGroup(group) {
            return {
                combinator: group.combinator,
                rules: group.rules.map(rule => {
                    if (rule.type === 'group') {
                        return this.serializeGroup(rule);
                    }
                    return {
                        field: rule.field,
                        operator: rule.operator,
                        value: rule.value,
                        valueSource: rule.valueSource
                    };
                }).filter(r => r.field && (r.operator !== 'is_null' && r.operator !== 'is_not_null' && r.operator !== 'is_empty' && r.operator !== 'is_not_empty' || true))
            };
        },
        
        loadQuery(query) {
            if (!query) return;
            this.root = this.deserializeGroup(query);
        },
        
        deserializeGroup(query) {
            const group = this.createGroup(query.combinator);
            group.rules = (query.rules || []).map(rule => {
                if (rule.combinator) {
                    return this.deserializeGroup(rule);
                }
                return {
                    ...this.createRule(),
                    ...rule,
                    parent: group
                };
            });
            return group;
        },
        
        emitQuery() {
            const query = this.getQuery();
            if (this.wireModel && window.Livewire) {
                window.Livewire.dispatch('query-builder:changed', { query });
            }
            this.$dispatch('query-builder:changed', { query });
        },
        
        exportQuery() {
            const query = this.getQuery();
            const blob = new Blob([JSON.stringify(query, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'query.json';
            a.click();
            URL.revokeObjectURL(url);
        },
    }));
});
</script>

<style>
.gsmui-query-builder {
    @apply font-sans;
}

.gsmui-query-builder .qb-group {
    @apply relative;
}

.gsmui-query-builder .qb-group-root {
    @apply border-l-0 pl-0;
}

.gsmui-query-builder .qb-group-header {
    @apply flex items-center gap-2;
}

.gsmui-query-builder .qb-group-combinator {
    @apply flex items-center gap-1;
}

.gsmui-query-builder .qb-group-rules {
    @apply space-y-2;
}

.gsmui-query-builder .qb-rule {
    @apply flex items-center gap-2 flex-wrap;
}

.gsmui-query-builder .qb-rule-delete {
    @apply p-1 text-zinc-400 hover:text-red-500 transition-colors;
}

.gsmui-query-builder .qb-rule-field,
.gsmui-query-builder .qb-rule-operator,
.gsmui-query-builder .qb-rule-value-input,
.gsmui-query-builder .qb-rule-value-field,
.gsmui-query-builder .qb-rule-value-source {
    @apply transition-colors;
}

.gsmui-query-builder .qb-rule-value {
    @apply flex-1 min-w-[150px] flex items-center gap-1;
}

@media (max-width: 640px) {
    .gsmui-query-builder .qb-rule {
        @apply flex-col items-stretch gap-2;
    }
    
    .gsmui-query-builder .qb-rule-value {
        @apply w-full;
    }
}
</style>