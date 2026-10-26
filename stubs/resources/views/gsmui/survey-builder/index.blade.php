@props([
    'questions' => [],
    'class' => '',
])

<?php
$id = 'survey-builder-' . uniqid();
$questionTypes = [
    ['type' => 'text', 'label' => 'Short Text', 'icon' => 'pencil'],
    ['type' => 'textarea', 'label' => 'Long Text', 'icon' => 'document-text'],
    ['type' => 'radio', 'label' => 'Multiple Choice', 'icon' => 'circle-stack'],
    ['type' => 'checkbox', 'label' => 'Checkboxes', 'icon' => 'check-square'],
    ['type' => 'select', 'label' => 'Dropdown', 'icon' => 'chevron-down'],
    ['type' => 'rating', 'label' => 'Rating', 'icon' => 'star'],
    ['type' => 'nps', 'label' => 'NPS Score', 'icon' => 'heart'],
    ['type' => 'scale', 'label' => 'Linear Scale', 'icon' => 'slash'],
];
?>

<div 
    class="gsmui-survey-builder {{ $class }}"
    x-data="gsmuiSurveyBuilder({
        questions: @js($questions),
        questionTypes: @js($questionTypes),
    })"
    id="{{ $id }}"
>
    <div class="flex h-full bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <aside class="w-56 border-r border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex flex-col flex-shrink-0">
            <div class="p-3 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white text-sm">Question Types</h3>
            </div>
            <div class="flex-1 overflow-y-auto p-3 space-y-1.5">
                <template x-for="qt in questionTypes" :key="qt.type">
                    <div @click="addQuestion(qt.type)" class="flex items-center gap-2.5 px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors text-sm">
                        <span class="text-zinc-900 dark:text-white truncate" x-text="qt.label"></span>
                    </div>
                </template>
            </div>
        </aside>

        <div class="flex-1 overflow-y-auto p-6">
            <div class="max-w-2xl mx-auto space-y-4">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-center">
                    <input type="text" x-model="surveyTitle" class="text-xl font-bold text-center bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-primary rounded w-full text-zinc-900 dark:text-white" placeholder="Survey Title" />
                    <textarea x-model="surveyDescription" class="mt-2 text-sm text-center bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-primary rounded w-full text-zinc-500 dark:text-zinc-400 resize-none" placeholder="Survey description (optional)" rows="2"></textarea>
                </div>

                <template x-for="(q, index) in questions" :key="q.id">
                    <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800" :class="{ 'ring-2 ring-primary': selectedQuestion === q.id }">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-medium text-primary" x-text="'Q' + (index + 1)"></span>
                            <button @click="removeQuestion(index)" class="p-1 text-zinc-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg>
                            </button>
                        </div>
                        <input type="text" x-model="q.title" @click="selectedQuestion = q.id" class="w-full text-sm font-medium bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-primary rounded px-1 text-zinc-900 dark:text-white" placeholder="Enter your question..." />
                        
                        <template x-if="q.type === 'text'">
                            <input type="text" disabled class="mt-2 w-full px-3 py-2 border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-50 dark:bg-zinc-900 text-sm text-zinc-400" placeholder="Short answer text" />
                        </template>
                        <template x-if="q.type === 'textarea'">
                            <textarea disabled class="mt-2 w-full px-3 py-2 border border-zinc-200 dark:border-zinc-700 rounded-lg bg-zinc-50 dark:bg-zinc-900 text-sm text-zinc-400" placeholder="Long answer text" rows="3"></textarea>
                        </template>
                        <template x-if="['radio', 'select'].includes(q.type)">
                            <div class="mt-2 space-y-1">
                                <template x-for="(opt, oi) in q.options" :key="oi">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" disabled class="w-4 h-4 text-primary border-zinc-300" />
                                        <input type="text" x-model="opt.label" class="flex-1 px-2 py-1 text-sm border border-zinc-200 dark:border-zinc-700 rounded bg-transparent text-zinc-900 dark:text-white" placeholder="Option" />
                                        <button @click="q.options.splice(oi, 1)" class="p-0.5 text-zinc-400 hover:text-red-500"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                    </div>
                                </template>
                                <button @click="q.options.push({ label: '' })" class="text-sm text-primary hover:underline mt-1">+ Add option</button>
                            </div>
                        </template>
                        <template x-if="q.type === 'rating'">
                            <div class="flex items-center gap-1 mt-2">
                                <template x-for="i in 5" :key="i">
                                    <svg class="w-8 h-8 text-zinc-300 dark:text-zinc-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </template>
                            </div>
                        </template>
                        <template x-if="q.type === 'nps'">
                            <div class="mt-2">
                                <div class="flex justify-between text-xs text-zinc-400 mb-1"><span>Not likely</span><span>Extremely likely</span></div>
                                <div class="flex gap-1">
                                    <template x-for="i in 10" :key="i">
                                        <div class="w-8 h-8 flex items-center justify-center text-xs border border-zinc-200 dark:border-zinc-700 rounded bg-zinc-50 dark:bg-zinc-900 text-zinc-400">0</div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        <template x-if="q.type === 'scale'">
                            <div class="mt-2 flex items-center gap-2">
                                <input type="text" x-model="q.minLabel" class="w-24 px-2 py-1 text-xs border border-zinc-200 dark:border-zinc-700 rounded" placeholder="Min label" />
                                <div class="flex gap-0.5"><template x-for="i in 5" :key="i"><div class="w-8 h-8 flex items-center justify-center text-xs border border-zinc-200 dark:border-zinc-700 rounded bg-zinc-50 dark:bg-zinc-900 text-zinc-400" x-text="i"></div></template></div>
                                <input type="text" x-model="q.maxLabel" class="w-24 px-2 py-1 text-xs border border-zinc-200 dark:border-zinc-700 rounded" placeholder="Max label" />
                            </div>
                        </template>

                        <div class="mt-3 pt-2 border-t border-zinc-100 dark:border-zinc-700 flex items-center gap-3 text-xs text-zinc-500">
                            <label class="flex items-center gap-1"><input type="checkbox" x-model="q.required" class="w-3 h-3 text-primary rounded" /> Required</label>
                        </div>
                    </div>
                </template>

                <button @click="addQuestion('text')" class="w-full py-3 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-xl text-zinc-500 dark:text-zinc-400 hover:border-primary hover:text-primary transition-colors text-sm">
                    + Add Question
                </button>

                <div class="flex justify-between pt-4">
                    <button @click="exportSurvey" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700">Export JSON</button>
                    <button @click="previewSurvey" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Preview Survey</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiSurveyBuilder', (config) => ({
        questions: config.questions || [],
        questionTypes: config.questionTypes,
        surveyTitle: 'Untitled Survey',
        surveyDescription: '',
        selectedQuestion: null,
        qIdCounter: 0,

        addQuestion(type) {
            this.questions.push({
                id: ++this.qIdCounter,
                type: type,
                title: '',
                required: false,
                options: ['radio', 'select', 'checkbox'].includes(type) ? [{ label: 'Option 1' }] : [],
                minLabel: '',
                maxLabel: '',
            });
            this.selectedQuestion = this.qIdCounter;
        },

        removeQuestion(index) {
            this.questions.splice(index, 1);
        },

        exportSurvey() {
            const data = { title: this.surveyTitle, description: this.surveyDescription, questions: this.questions };
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'survey.json';
            a.click();
            URL.revokeObjectURL(url);
        },

        previewSurvey() {
            this.$dispatch('survey:preview', { survey: { title: this.surveyTitle, questions: this.questions } });
        },
    }));
});
</script>
