@props([
    'schema' => [],
    'availableFields' => [],
    'settings' => [],
    'layoutOptions' => ['single', 'two-column', 'three-column', 'grid'],
    'class' => '',
])

<?php
$id = 'form-builder-' . uniqid();
$availableFields = $availableFields ?: [
    ['type' => 'text', 'label' => 'Text', 'icon' => 'pencil'],
    ['type' => 'textarea', 'label' => 'Textarea', 'icon' => 'document-text'],
    ['type' => 'email', 'label' => 'Email', 'icon' => 'at-symbol'],
    ['type' => 'password', 'label' => 'Password', 'icon' => 'key'],
    ['type' => 'number', 'label' => 'Number', 'icon' => 'hashtag'],
    ['type' => 'tel', 'label' => 'Phone', 'icon' => 'phone'],
    ['type' => 'url', 'label' => 'URL', 'icon' => 'link'],
    ['type' => 'select', 'label' => 'Select', 'icon' => 'chevron-down'],
    ['type' => 'multiselect', 'label' => 'Multi Select', 'icon' => 'list-bullet'],
    ['type' => 'radio', 'label' => 'Radio Group', 'icon' => 'circle-stack'],
    ['type' => 'checkbox', 'label' => 'Checkbox', 'icon' => 'check-square'],
    ['type' => 'switch', 'label' => 'Switch', 'icon' => 'toggle-left'],
    ['type' => 'date', 'label' => 'Date', 'icon' => 'calendar-days'],
    ['type' => 'datetime', 'label' => 'DateTime', 'icon' => 'clock'],
    ['type' => 'file', 'label' => 'File Upload', 'icon' => 'arrow-up-tray'],
    ['type' => 'richtext', 'label' => 'Rich Text', 'icon' => 'pencil-square'],
    ['type' => 'section', 'label' => 'Section', 'icon' => 'square-2-stack'],
    ['type' => 'divider', 'label' => 'Divider', 'icon' => 'minus'],
    ['type' => 'html', 'label' => 'HTML', 'icon' => 'code-bracket'],
];
?>

<div 
    class="gsmui-form-builder {{ $class }}"
    x-data="gsmuiFormBuilder({
        schema: @js($schema),
        availableFields: @js($availableFields),
        settings: @js($settings),
        layoutOptions: @js($layoutOptions),
    })"
    id="{{ $id }}"
>

    <div class="flex h-full bg-zinc-50 dark:bg-zinc-900">
        
        <!-- Sidebar: Field Palette -->
        <aside class="w-64 border-r border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex flex-col overflow-hidden">
            <div class="p-3 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Fields</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Drag fields to canvas</p>
            </div>
            
            <div class="flex-1 overflow-y-auto p-3 space-y-2">
                <template x-for="category in categorizedFields" :key="category.name">
                    <div class="field-category">
                        <h4 class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-2 px-2" x-text="category.name"></h4>
                        <div class="space-y-1.5">
                            <template x-for="field in category.fields" :key="field.type">
                                <div 
                                    class="field-palette-item flex items-center gap-2 px-3 py-2 rounded-lg bg-zinc-50 dark:bg-zinc-700/50 border border-zinc-200 dark:border-zinc-700 cursor-grab hover:bg-zinc-100 dark:hover:bg-zinc-700/50 transition-colors"
                                    draggable="true"
                                    @dragstart="dragField($event, field)"
                                    @dragend="dragEnd"
                                    data-field-type="field.type"
                                >
                                    <x-gsmui:icon :name="field.icon" class="w-5 h-5 text-zinc-600 dark:text-zinc-400 flex-shrink-0" />
                                    <span class="text-sm font-medium text-zinc-900 dark:text-white truncate" x-text="field.label"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </aside>
        
        <!-- Canvas Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Canvas Toolbar -->
            <div class="p-3 border-b border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <label class="text-sm text-zinc-600 dark:text-zinc-400">Layout:</label>
                    <select 
                        x-model="canvasLayout"
                        @change="updateLayout($event.target.value)"
                        class="px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary"
                    >
                        <template x-for="opt in layoutOptions" :key="opt">
                            <option :value="opt" x-text="opt.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase())"></option>
                        </template>
                    </select>
                </div>
                
                <div class="flex-1"></div>
                
                <div class="flex items-center gap-2">
                    <button 
                        type="button"
                        @click="togglePreview"
                        :class="previewMode ? 'bg-primary text-white' : 'bg-white dark:bg-zinc-700'"
                        class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded transition-colors"
                    >
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Preview
                    </button>
                    
                    <button 
                        type="button"
                        @click="exportSchema"
                        class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                    >
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export
                    </button>
                    
                    <button 
                        type="button"
                        @click="importSchema"
                        class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                    >
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        Import
                    </button>
                    
                    <input type="file" accept=".json" style="display: none" @change="handleImport($event)" x-ref="fileInput" />
                </div>
            </div>
            
            <!-- Form Canvas -->
            <div class="flex-1 overflow-auto p-6 relative" 
                 @dragover.prevent="dragOverCanvas($event)"
                 @drop="dropOnCanvas($event)"
                 @dragleave="dragLeaveCanvas"
                 :class="{ 'canvas-drag-over': canvasDragOver }"
            >
                <!-- Empty State -->
                <template x-if="schema.pages[0].sections.length === 0 && !previewMode">
                    <div class="flex-1 flex flex-col items-center justify-center text-center">
                        <svg class="w-24 h-24 text-zinc-300 dark:text-zinc-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">Empty Form</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-xs">Drag fields from the sidebar to start building your form</p>
                        <button 
                            type="button"
                            @click="addSection()"
                            class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
                        >
                            Add First Section
                        </button>
                    </div>
                </template>
                
                <!-- Form Sections -->
                <template x-if="schema.pages[0].sections.length > 0 || previewMode">
                    <div class="form-canvas max-w-4xl mx-auto" :class="canvasLayout">
                        <template x-for="(section, sIndex) in schema.pages[0].sections" :key="section.id">
                            <div class="form-section mb-6 relative" :class="{ 'section-selected': selectedSectionId === section.id }">
                                <div class="section-header flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button"
                                            @click="toggleSection(section)"
                                            class="p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                                            :aria-expanded="!section.collapsed"
                                        >
                                            <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="section.collapsed ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'"/>
                                            </svg>
                                        </button>
                                        <input 
                                            type="text" 
                                            x-model="section.label"
                                            @blur="updateSection(section)"
                                            class="text-lg font-semibold text-zinc-900 dark:text-white bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-primary rounded px-1"
                                            placeholder="Section Title"
                                        >
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button 
                                            type="button"
                                            @click="duplicateSection(section)"
                                            class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                                            title="Duplicate Section"
                                        >
                                            <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        </button>
                                        <button 
                                            type="button"
                                            @click="removeSection(section)"
                                            class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors text-red-600"
                                            title="Delete Section"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <template x-if="!section.collapsed">
                                    <div class="section-fields space-y-3 min-h-[100px]" 
                                         @dragover.prevent="dragOverSection($event, section)"
                                         @drop="dropOnSection($event, section)"
                                         @dragleave="dragLeaveSection"
                                         :class="{ 'section-drag-over': section.dragOver }"
                                    >
                                        <template x-if="section.fields.length === 0">
                                            <div class="section-empty text-center py-8 px-4 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg">
                                                <svg class="w-12 h-12 mx-auto text-zinc-400 dark:text-zinc-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Drop fields here</p>
                                            </div>
                                        </template>
                                        
                                        <template x-for="(field, fIndex) in section.fields" :key="field.id">
                                            <div class="form-field relative group" :class="{ 'field-selected': selectedFieldId === field.id }">
                                                <div class="field-header flex items-center justify-between mb-1">
                                                    <div class="flex items-center gap-2">
                                                        <button 
                                                            type="button"
                                                            @click="selectField(field)"
                                                            class="p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                                                        >
                                                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                                        </button>
                                                        <x-gsmui:icon :name="getFieldIcon(field)" class="w-5 h-5 text-zinc-500" />
                                                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300" x-text="field.label"></span>
                                                        <template x-if="field.required">
                                                            <span class="text-red-500 text-sm">*</span>
                                                        </template>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <button 
                                                            type="button"
                                                            @click="duplicateField(field, section)"
                                                            class="p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                                                            title="Duplicate"
                                                        >
                                                            <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                        </button>
                                                        <button 
                                                            type="button"
                                                            @click="removeField(field, section)"
                                                            class="p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors text-red-500"
                                                            title="Delete"
                                                        >
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <!-- Field Preview -->
                                                <div class="field-preview" x-html="renderFieldPreview(field)"></div>
                                            </div>
                                        </template>
                                    </div>
                                    
                                    <button 
                                        type="button"
                                        @click="addFieldToSection(section)"
                                        class="w-full mt-2 py-2 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg text-zinc-500 dark:text-zinc-400 hover:border-primary hover:text-primary transition-colors"
                                    >
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
        
        <!-- Properties Panel -->
        <aside class="w-80 border-l border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex flex-col overflow-hidden" x-show="selectedField || selectedSectionId">
            <div class="p-3 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <h3 class="font-semibold text-zinc-900 dark:text-white" x-text="selectedField ? 'Field Properties' : 'Section Properties'"></h3>
                <button 
                    type="button"
                    @click="selectedField = null; selectedSectionId = null"
                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-3 space-y-4">
                <template x-if="selectedField">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Label</label>
                            <input type="text" x-model="selectedField.label" @input="updateField(selectedField)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Name (key)</label>
                                <input type="text" x-model="selectedField.name" @input="updateField(selectedField)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary font-mono text-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Type</label>
                                <select x-model="selectedField.type" @change="changeFieldType(selectedField, $event.target.value)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary">
                                    <template x-for="f in availableFields" :key="f.type">
                                        <option :value="f.type" x-text="f.label"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <input type="checkbox" x-model="selectedField.required" @change="updateField(selectedField)" id="field-required" class="w-4 h-4 text-primary border-zinc-300 rounded focus:ring-primary" />
                            <label for="field-required" class="text-sm text-zinc-700 dark:text-zinc-300">Required</label>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <input type="checkbox" x-model="selectedField.unique" @change="updateField(selectedField)" id="field-unique" class="w-4 h-4 text-primary border-zinc-300 rounded focus:ring-primary" />
                            <label for="field-unique" class="text-sm text-zinc-700 dark:text-zinc-300">Unique</label>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Placeholder</label>
                            <input type="text" x-model="selectedField.placeholder" @input="updateField(selectedField)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Help Text</label>
                            <textarea x-model="selectedField.helpText" @input="updateField(selectedField)" rows="2" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary text-sm"></textarea>
                        </div>
                        
                        <template x-if="['select', 'multiselect', 'radio'].includes(selectedField.type)">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2 flex items-center justify-between">
                                    Options
                                    <button type="button" @click="addOption(selectedField)" class="text-xs text-primary hover:underline">+ Add</button>
                                </label>
                                <div class="space-y-1">
                                    <template x-for="(opt, oIndex) in selectedField.options" :key="opt.value">
                                        <div class="flex items-center gap-2">
                                            <input type="text" x-model="opt.label" @input="updateField(selectedField)" placeholder="Label" class="flex-1 px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700" />
                                            <input type="text" x-model="opt.value" @input="updateField(selectedField)" placeholder="Value" class="flex-1 px-2 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700" />
                                            <button type="button" @click="removeOption(selectedField, oIndex)" class="p-1 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="['text', 'textarea', 'email', 'password', 'url', 'tel'].includes(selectedField.type)">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Min Length</label>
                                    <input type="number" x-model.number="selectedField.minLength" @input="updateField(selectedField)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Max Length</label>
                                    <input type="number" x-model.number="selectedField.maxLength" @input="updateField(selectedField)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="['number'].includes(selectedField.type)">
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Min</label>
                                    <input type="number" step="any" x-model.number="selectedField.min" @input="updateField(selectedField)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Max</label>
                                    <input type="number" step="any" x-model.number="selectedField.max" @input="updateField(selectedField)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="['file'].includes(selectedField.type)">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Accepted Types (comma separated)</label>
                                <input type="text" x-model="selectedField.accept" @input="updateField(selectedField)" placeholder="image/*,.pdf,.doc" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Max Size (MB)</label>
                                <input type="number" x-model.number="selectedField.maxSize" @input="updateField(selectedField)" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                            </div>
                        </template>
                        
                        <div class="pt-2 border-t border-zinc-200 dark:border-zinc-700">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Validation Rules (JSON)</label>
                            <textarea x-model="selectedField.validation" @input="updateField(selectedField)" rows="4" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary text-sm font-mono" placeholder='{"email": true, "min": 5}'></textarea>
                        </div>
                    </div>
                </template>
                
                <template x-if="selectedSectionId && !selectedField">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Section Title</label>
                            <input type="text" x-model="getSection(selectedSectionId).label" @input="updateSection(getSection(selectedSectionId))" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                            <textarea x-model="getSection(selectedSectionId).description" @input="updateSection(getSection(selectedSectionId))" rows="2" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary text-sm"></textarea>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <input type="checkbox" x-model="getSection(selectedSectionId).collapsible" @change="updateSection(getSection(selectedSectionId))" id="section-collapsible" class="w-4 h-4 text-primary border-zinc-300 rounded focus:ring-primary" />
                            <label for="section-collapsible" class="text-sm text-zinc-700 dark:text-zinc-300">Collapsible</label>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <input type="checkbox" x-model="getSection(selectedSectionId).collapsed" @change="updateSection(getSection(selectedSectionId))" id="section-collapsed" class="w-4 h-4 text-primary border-zinc-300 rounded focus:ring-primary" />
                            <label for="section-collapsed" class="text-sm text-zinc-700 dark:text-zinc-300">Collapsed by Default</label>
                        </div>
                        
                        <div class="pt-2 border-t border-zinc-200 dark:border-zinc-700">
                            <button type="button" @click="removeSection(getSection(selectedSectionId))" class="w-full px-3 py-2 text-red-600 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">Delete Section</button>
                        </div>
                    </div>
                </template>
            </div>
        </aside>
        
        <!-- Preview Modal -->
        <template x-if="previewMode">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="togglePreview">
                <div class="bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                    <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">Form Preview</h3>
                        <button @click="togglePreview" class="p-2 rounded hover:bg-zinc-100 dark:hover:bg-zinc-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="flex-1 overflow-auto p-6">
                        <form class="space-y-6" x-html="renderFullPreview()"></form>
                    </div>
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                        <button @click="togglePreview" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700">Close</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiFormBuilder', (config) => ({
        schema: config.schema || { pages: [{ id: 'page-1', label: 'Page 1', sections: [] }] },
        availableFields: config.availableFields,
        settings: config.settings || {},
        layoutOptions: config.layoutOptions,
        
        canvasLayout: 'single',
        previewMode: false,
        canvasDragOver: false,
        selectedField: null,
        selectedSectionId: null,
        fieldIdCounter: 0,
        sectionIdCounter: 0,
        
        get categorizedFields() {
            const categories = {
                'Input Fields': ['text', 'email', 'password', 'number', 'tel', 'url'],
                'Text Fields': ['textarea', 'richtext'],
                'Selection Fields': ['select', 'multiselect', 'radio', 'checkbox', 'switch'],
                'Date & Time': ['date', 'datetime'],
                'Media & Files': ['file'],
                'Layout': ['section', 'divider', 'html'],
            };
            
            return Object.entries(categories).map(([name, types]) => ({
                name,
                fields: this.availableFields.filter(f => types.includes(f.type))
            })).filter(c => c.fields.length > 0);
        },
        
        init() {
            this.fieldIdCounter = Math.max(0, ...this.schema.pages.flatMap(p => p.sections.flatMap(s => s.fields.map(f => parseInt(f.id?.split('-')[1] || 0)))));
            this.sectionIdCounter = Math.max(0, ...this.schema.pages.flatMap(p => p.sections.map(s => parseInt(s.id?.split('-')[1] || 0))));
            
            if (this.schema.pages[0].sections.length === 0) {
                this.addSection();
            }
            
            // Make globally accessible for Livewire
            window.formBuilder = this;
        },
        
        // Section Methods
        addSection() {
            const section = {
                id: 'section-' + (++this.sectionIdCounter),
                label: 'Untitled Section',
                description: '',
                collapsible: false,
                collapsed: false,
                fields: []
            };
            this.schema.pages[0].sections.push(section);
            this.selectedSectionId = section.id;
        },
        
        removeSection(section) {
            if (confirm('Delete this section and all its fields?')) {
                this.schema.pages[0].sections = this.schema.pages[0].sections.filter(s => s.id !== section.id);
                if (this.selectedSectionId === section.id) this.selectedSectionId = null;
            }
        },
        
        duplicateSection(section) {
            const newSection = {
                ...JSON.parse(JSON.stringify(section)),
                id: 'section-' + (++this.sectionIdCounter),
                label: section.label + ' (Copy)',
                fields: section.fields.map(f => ({ ...f, id: 'field-' + (++this.fieldIdCounter) }))
            };
            const idx = this.schema.pages[0].sections.indexOf(section);
            this.schema.pages[0].sections.splice(idx + 1, 0, newSection);
        },
        
        toggleSection(section) {
            section.collapsed = !section.collapsed;
        },
        
        updateSection(section) {
            // Reactive update
        },
        
        getSection(id) {
            return this.schema.pages[0].sections.find(s => s.id === id);
        },
        
        selectSection(section) {
            this.selectedSectionId = section.id;
            this.selectedField = null;
        },
        
        // Field Methods
        addFieldToSection(section) {
            const field = this.createField('text');
            section.fields.push(field);
            this.selectedField = field;
        },
        
        createField(type) {
            const fieldDef = this.availableFields.find(f => f.type === type) || this.availableFields[0];
            return {
                id: 'field-' + (++this.fieldIdCounter),
                type: type,
                label: fieldDef.label,
                name: type + '_' + this.fieldIdCounter,
                required: false,
                unique: false,
                placeholder: '',
                helpText: '',
                options: type === 'select' || type === 'multiselect' || type === 'radio' ? [{ label: 'Option 1', value: 'option_1' }] : [],
                validation: {},
                minLength: null,
                maxLength: null,
                min: null,
                max: null,
                accept: '',
                maxSize: 10,
            };
        },
        
        removeField(field, section) {
            section.fields = section.fields.filter(f => f.id !== field.id);
            if (this.selectedField === field) this.selectedField = null;
        },
        
        duplicateField(field, section) {
            const newField = { ...JSON.parse(JSON.stringify(field)), id: 'field-' + (++this.fieldIdCounter), name: field.name + '_copy' };
            const idx = section.fields.indexOf(field);
            section.fields.splice(idx + 1, 0, newField);
            this.selectedField = newField;
        },
        
        selectField(field) {
            this.selectedField = field;
            this.selectedSectionId = null;
        },
        
        updateField(field) {
            // Reactive
        },
        
        changeFieldType(field, newType) {
            const oldOptions = field.options;
            Object.assign(field, this.createField(newType));
            field.id = field.id; // Keep same ID
            if (['select', 'multiselect', 'radio'].includes(newType) && oldOptions.length) {
                field.options = oldOptions;
            }
        },
        
        addOption(field) {
            field.options.push({ label: 'New Option', value: 'option_' + Date.now() });
        },
        
        removeOption(field, index) {
            field.options.splice(index, 1);
        },
        
        getFieldIcon(field) {
            const def = this.availableFields.find(f => f.type === field.type);
            return def?.icon || 'pencil';
        },
        
        renderFieldPreview(field) {
            const required = field.required ? '<span class="text-red-500 ml-1">*</span>' : '';
            const helpText = field.helpText ? `<p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">${field.helpText}</p>` : '';
            
            let input = '';
            switch(field.type) {
                case 'textarea':
                    input = `<textarea class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-sm" placeholder="${field.placeholder}" ${field.required ? 'required' : ''}></textarea>`;
                    break;
                case 'select':
                    input = `<select class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700">${field.options.map(o => `<option value="${o.value}">${o.label}</option>`).join('')}</select>`;
                    break;
                case 'radio':
                    input = `<div class="flex flex-wrap gap-4">${field.options.map(o => `<label class="flex items-center gap-1"><input type="radio" name="${field.name}" value="${o.value}" class="w-4 h-4 text-primary"> ${o.label}</label>`).join('')}</div>`;
                    break;
                case 'checkbox':
                    input = `<label class="flex items-center gap-2"><input type="checkbox" class="w-4 h-4 text-primary rounded border-zinc-300"> ${field.label}</label>`;
                    break;
                case 'switch':
                    input = `<label class="relative inline-flex items-center cursor-pointer"><input type="checkbox" class="sr-only peer"><div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/30 dark:peer-focus:ring-primary/50 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-600 peer-checked:bg-primary"></div></label>`;
                    break;
                case 'file':
                    input = `<div class="border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg p-6 text-center"><svg class="w-8 h-8 mx-auto text-zinc-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3 3m0 0l-3-3m3 3V4"/></svg><p class="text-sm text-zinc-500">Drop files or click to upload</p></div>`;
                    break;
                case 'richtext':
                    input = `<div class="border border-zinc-300 dark:border-zinc-600 rounded p-3 min-h-[100px] bg-white dark:bg-zinc-700" contenteditable="true" style="outline:none"><p>Rich text editor preview...</p></div>`;
                    break;
                case 'divider':
                    input = `<hr class="border-zinc-300 dark:border-zinc-600 my-2">`;
                    break;
                case 'html':
                    input = `<div class="p-3 bg-zinc-100 dark:bg-zinc-800 rounded text-sm text-zinc-600 dark:text-zinc-400">[HTML Content]</div>`;
                    break;
                default:
                    input = `<input type="${field.type}" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 text-sm" placeholder="${field.placeholder}" ${field.required ? 'required' : ''}>`;
            }
            
            if (['divider', 'html'].includes(field.type)) {
                return input;
            }
            
            return `
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">${field.label}${required}</label>
                    ${input}
                    ${helpText}
                </div>
            `;
        },
        
        renderFullPreview() {
            const page = this.schema.pages[0];
            let html = '';
            
            page.sections.forEach(section => {
                if (section.collapsed) return;
                
                html += `<fieldset class="space-y-6"><legend class="text-lg font-semibold text-zinc-900 dark:text-white mb-4 pb-2 border-b border-zinc-200 dark:border-zinc-700">${section.label}</legend>`;
                
                if (section.description) {
                    html += `<p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">${section.description}</p>`;
                }
                
                section.fields.forEach(field => {
                    html += this.renderFieldPreview(field);
                });
                
                html += `</fieldset>`;
            });
            
            return html;
        },
        
        // Drag & Drop
        dragField(event, field) {
            event.dataTransfer.setData('application/json', JSON.stringify({ type: 'new_field', fieldType: field.type }));
            event.dataTransfer.effectAllowed = 'copy';
        },
        
        dragEnd(event) {},
        
        dragOverCanvas(event) {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'copy';
            this.canvasDragOver = true;
        },
        
        dragLeaveCanvas() {
            this.canvasDragOver = false;
        },
        
        dropOnCanvas(event) {
            event.preventDefault();
            this.canvasDragOver = false;
            
            const data = JSON.parse(event.dataTransfer.getData('application/json'));
            if (data.type === 'new_field') {
                const section = this.addSection();
                const field = this.createField(data.fieldType);
                section.fields.push(field);
            }
        },
        
        dragOverSection(event, section) {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';
            section.dragOver = true;
        },
        
        dragLeaveSection(section) {
            section.dragOver = false;
        },
        
        dropOnSection(event, section) {
            event.preventDefault();
            section.dragOver = false;
            
            const data = JSON.parse(event.dataTransfer.getData('application/json'));
            if (data.type === 'new_field') {
                const field = this.createField(data.fieldType);
                section.fields.push(field);
            }
        },
        
        // Layout
        updateLayout(layout) {
            this.canvasLayout = layout;
        },
        
        // Preview
        togglePreview() {
            this.previewMode = !this.previewMode;
        },
        
        // Export/Import
        exportSchema() {
            const output = {
                schema: this.schema,
                settings: this.settings,
                exportedAt: new Date().toISOString()
            };
            const blob = new Blob([JSON.stringify(output, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'form-schema.json';
            a.click();
            URL.revokeObjectURL(url);
        },
        
        importSchema() {
            this.$refs.fileInput.click();
        },
        
        handleImport(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                try {
                    const data = JSON.parse(e.target.result);
                    if (data.schema) {
                        this.schema = data.schema;
                        this.settings = data.settings || this.settings;
                        this.fieldIdCounter = Math.max(0, ...this.schema.pages.flatMap(p => p.sections.flatMap(s => s.fields.map(f => parseInt(f.id?.split('-')[1] || 0)))));
                        this.sectionIdCounter = Math.max(0, ...this.schema.pages.flatMap(p => p.sections.map(s => parseInt(s.id?.split('-')[1] || 0))));
                    }
                } catch (err) {
                    alert('Invalid JSON file');
                }
            };
            reader.readAsText(file);
            event.target.value = '';
        },
        
        // Emit to Livewire
        getSchema() {
            return this.schema;
        }
    }));
});
</script>

<style>
.gsmui-form-builder {
    @apply h-full;
}

.gsmui-form-builder .field-palette-item {
    @apply select-none;
}

.gsmui-form-builder .field-palette-item:active {
    @apply cursor-grabbing;
}

.gsmui-form-builder .form-section {
    @apply transition-all duration-200;
}

.gsmui-form-builder .form-field {
    @apply transition-all duration-150;
}

.gsmui-form-builder .form-field.field-selected {
    @apply ring-2 ring-primary ring-offset-2 ring-offset-white dark:ring-offset-zinc-800;
}

.gsmui-form-builder .section-drag-over {
    @apply bg-primary/5 border-2 border-dashed border-primary;
}

.gsmui-form-builder .section-empty {
    @apply transition-colors;
}

.gsmui-form-builder .canvas-drag-over {
    @apply bg-primary/5;
}

/* Layout variants */
.gsmui-form-builder .form-canvas.two-column {
    @apply grid grid-cols-1 md:grid-cols-2 gap-4;
}

.gsmui-form-builder .form-canvas.three-column {
    @apply grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4;
}

.gsmui-form-builder .form-canvas.grid {
    @apply grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4;
}

@media (max-width: 768px) {
    .gsmui-form-builder .form-canvas.two-column,
    .gsmui-form-builder .form-canvas.three-column,
    .gsmui-form-builder .form-canvas.grid {
        @apply grid-cols-1;
    }
}
</style>